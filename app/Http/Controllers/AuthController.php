<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Beneficiary;
use App\Models\User;
use App\Services\NikHasher;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function loginNik(Request $request, NikHasher $nikHasher): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'regex:/^\d{16}$/'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.regex' => 'NIK harus berupa 16 digit angka.',
        ]);

        $nik = trim($validated['nik']);

        try {
            $nikHash = $nikHasher->hash($nik);
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Format NIK tidak valid.');
        }

        $maskedNik = substr($nik, 0, 6).'******'.substr($nik, -4);
        $beneficiary = Beneficiary::where('nik_hash', $nikHash)->first();

        $displayName = $beneficiary
            ? $beneficiary->masked_name.' (Warga Bansos)'
            : 'Warga ('.$maskedNik.')';

        $user = User::where('nik_hash', $nikHash)->first();

        if (! $user) {
            $user = User::create([
                'name' => $displayName,
                'email' => 'nik_'.substr($nikHash, 0, 12).'@warga.hakwarga.id',
                'nik_hash' => $nikHash,
                'role' => UserRole::Citizen,
                'email_verified_at' => now(),
            ]);
        } else {
            if ($beneficiary && str_contains($user->name, '******')) {
                $user->update(['name' => $displayName]);
            }
        }

        Auth::login($user, true);
        session()->forget('is_guest');

        return redirect()->route('home')->with('success', 'Selamat datang! Anda berhasil masuk sebagai Warga.');
    }

    public function loginAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username atau email admin wajib diisi.',
            'password.required' => 'Password admin wajib diisi.',
        ]);

        $username = trim($validated['username']);
        $password = $validated['password'];

        $user = User::where(function ($query) use ($username) {
            $query->where('email', $username)
                ->orWhere('name', $username);

            if (strtolower($username) === 'admin') {
                $query->orWhere('email', 'admin@hakwarga.test');
            }
        })->first();

        if (! $user) {
            return back()->withInput()->with('error', 'Kredensial Admin salah. Silakan periksa kembali username dan password.');
        }

        $isValid = Hash::check($password, $user->password);

        if (! $isValid) {
            return back()->withInput()->with('error', 'Kredensial Admin salah. Silakan periksa kembali username dan password.');
        }

        Auth::login($user, true);
        session()->forget('is_guest');

        return redirect()->route('home')->with('success', 'Selamat datang, '.$user->name.'! Anda berhasil masuk sebagai Administrator.');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return back()->with('error', 'Kredensial Google OAuth belum dikonfigurasi di file .env.');
        }

        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');

        return $driver->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            /** @var GoogleProvider $driver */
            $driver = Socialite::driver('google');
            $googleUser = $driver->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', 'Gagal memproses autentikasi Google: '.$e->getMessage());
        }

        $email = $googleUser->getEmail();
        if (empty($email)) {
            return redirect()->route('login')->with('error', 'Surel tidak ditemukan dari respon Google.');
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?? explode('@', $email)[0],
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => UserRole::Citizen,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);
        session()->forget('is_guest');

        return redirect()->route('home')->with('success', 'Berhasil masuk dengan akun Google.');
    }

    public function sendOtp(Request $request, OtpService $otpService): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
        ], [
            'email.required' => 'Alamat surel wajib diisi.',
            'email.email' => 'Format alamat surel tidak valid.',
        ]);

        $email = strtolower(trim($validated['email']));

        $rateKey = 'send-otp:'.$email;
        if (RateLimiter::tooManyAttempts($rateKey, 4)) {
            $seconds = RateLimiter::availableIn($rateKey);

            return back()->withInput()->with('error', "Terlalu banyak permintaan OTP. Silakan tunggu {$seconds} detik lagi.");
        }
        RateLimiter::hit($rateKey, 300);

        try {
            $otp = $otpService->generateAndSend($email);
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal mengirim email OTP: '.$e->getMessage());
        }

        // Flash dev OTP if in local environment without Resend key
        if (app()->environment('local') && empty(config('services.resend.key'))) {
            session()->flash('dev_otp', $otp);
        }

        return redirect()->route('auth.otp.verify', ['email' => $email]);
    }

    public function showVerifyOtp(Request $request): View|RedirectResponse
    {
        $email = $request->query('email');
        if (empty($email) || ! is_string($email)) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp', [
            'email' => strtolower(trim($email)),
        ]);
    }

    public function verifyOtp(Request $request, OtpService $otpService): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'email.required' => 'Alamat surel wajib diisi.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $email = strtolower(trim($validated['email']));
        $otp = trim($validated['otp']);

        $rateKey = 'verify-otp:'.$email;
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $seconds = RateLimiter::availableIn($rateKey);

            return back()->withInput()->with('error', "Terlalu banyak percobaan salah. Coba lagi dalam {$seconds} detik.");
        }

        $isValid = $otpService->verify($email, $otp);

        if (! $isValid) {
            RateLimiter::hit($rateKey, 300);

            return back()->withInput()->with('error', 'Kode OTP salah atau telah kadaluarsa.');
        }

        RateLimiter::clear($rateKey);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => explode('@', $email)[0],
                'role' => UserRole::Citizen,
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);
        session()->forget('is_guest');

        return redirect()->route('home')->with('success', 'Berhasil masuk ke akun Anda.');
    }

    public function guest(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        $request->session()->put('is_guest', true);

        return redirect()->route('home')->with('success', 'Melanjutkan penjelajahan dalam Mode Tamu.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari akun.');
    }
}
