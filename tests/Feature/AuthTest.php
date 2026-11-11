<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

test('login page renders successfully with 3 login pathways', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200)
        ->assertSee('Masuk akun')
        ->assertSee('Masuk dengan Google')
        ->assertSee('Kirim kode')
        ->assertSee('Lanjut tanpa akun');
});

test('guest mode sets session and redirects to home', function () {
    $response = $this->get(route('auth.guest'));

    $response->assertRedirect(route('home'));
    $this->assertTrue(session('is_guest'));
    $this->assertFalse(Auth::check());
});

test('user can request otp code via email', function () {
    $response = $this->post(route('auth.otp.send'), [
        'email' => 'warga.test@example.com',
    ]);

    $response->assertRedirect(route('auth.otp.verify', ['email' => 'warga.test@example.com']));

    $this->assertDatabaseHas('email_otps', [
        'email' => 'warga.test@example.com',
    ]);
});

test('user can verify otp and gets authenticated', function () {
    $email = 'warga.penerima@example.com';
    $plainOtp = '654321';

    EmailOtp::create([
        'email' => $email,
        'otp_hash' => Hash::make($plainOtp),
        'expires_at' => now()->addMinutes(10),
        'attempts' => 0,
    ]);

    $response = $this->post(route('auth.otp.check'), [
        'email' => $email,
        'otp' => $plainOtp,
    ]);

    $response->assertRedirect(route('home'));
    $this->assertTrue(Auth::check());
    $this->assertSame($email, Auth::user()->email);
    $this->assertSame(UserRole::Citizen, Auth::user()->role);

    // Verify token was cleared after successful login
    $this->assertDatabaseMissing('email_otps', ['email' => $email]);
});

test('invalid otp increments attempts and rejects login', function () {
    $email = 'warga.salah@example.com';

    EmailOtp::create([
        'email' => $email,
        'otp_hash' => Hash::make('123456'),
        'expires_at' => now()->addMinutes(10),
        'attempts' => 0,
    ]);

    $response = $this->post(route('auth.otp.check'), [
        'email' => $email,
        'otp' => '999999',
    ]);

    $response->assertSessionHas('error');
    $this->assertFalse(Auth::check());

    $record = EmailOtp::where('email', $email)->first();
    $this->assertNotNull($record);
    $this->assertSame(1, $record->attempts);
});

test('authenticated user can logout', function () {
    $user = User::factory()->create([
        'role' => UserRole::Citizen,
    ]);

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('login'));
    $this->assertFalse(Auth::check());
});

test('warga can login with valid NIK and gets authenticated as citizen', function () {
    $nik = '3302112001990001';

    $response = $this->post(route('auth.nik'), [
        'nik' => $nik,
    ]);

    $response->assertRedirect(route('home'));
    $this->assertTrue(Auth::check());
    $this->assertSame(UserRole::Citizen, Auth::user()->role);
    $this->assertNotNull(Auth::user()->nik_hash);
});

test('warga login rejects invalid NIK', function () {
    $response = $this->post(route('auth.nik'), [
        'nik' => '12345',
    ]);

    $response->assertSessionHasErrors(['nik']);
    $this->assertFalse(Auth::check());
});

test('admin can login with username admin and password admin123', function () {
    User::updateOrCreate(
        ['email' => 'admin@hakwarga.test'],
        [
            'name' => 'Administrator Utama',
            'password' => Hash::make('admin123'),
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]
    );

    $response = $this->post(route('auth.admin'), [
        'username' => 'admin',
        'password' => 'admin123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertTrue(Auth::check());
    $this->assertSame(UserRole::SuperAdmin, Auth::user()->role);
});

test('admin login rejects invalid password', function () {
    $response = $this->post(route('auth.admin'), [
        'username' => 'admin',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHas('error');
    $this->assertFalse(Auth::check());
});

test('citizen user sees public navigation but no admin panel link', function () {
    $user = User::factory()->create([
        'role' => UserRole::Citizen,
    ]);

    $response = $this->actingAs($user)->get(route('tracker.index'));

    // Map, scorecard, and data are public transparency pages; every role sees them.
    $response->assertStatus(200)
        ->assertSee(route('tracker.index'))
        ->assertSee(route('report.extortion.create'))
        ->assertSee(route('report.dispute.create'))
        ->assertSee(route('ticket.index'))
        ->assertSee(route('map.index'))
        ->assertSee(route('scorecard.index'))
        ->assertSee(route('data.index'))
        ->assertDontSee('Buka Panel Admin');
});

test('admin user sees full navigation menus including auditor and panel link', function () {
    $admin = User::where('role', UserRole::SuperAdmin)->first() ?? User::factory()->create([
        'role' => UserRole::SuperAdmin,
    ]);

    $response = $this->actingAs($admin)->get(route('tracker.index'));

    $response->assertStatus(200)
        ->assertSee(route('tracker.index'))
        ->assertSee(route('report.extortion.create'))
        ->assertSee(route('report.dispute.create'))
        ->assertSee(route('ticket.index'))
        ->assertSee(route('map.index'))
        ->assertSee(route('scorecard.index'))
        ->assertSee(route('data.index'))
        ->assertSee('Buka Panel Admin');
});

test('unauthenticated visitor entering root is redirected to login page', function () {
    $this->flushSession();
    $response = $this->get(route('home'));

    $response->assertRedirect(route('login'));
});

test('unauthenticated visitor entering protected route is redirected to login page', function () {
    $this->flushSession();
    $response = $this->get(route('tracker.index'));

    $response->assertRedirect(route('login'));
});
