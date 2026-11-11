@extends('layouts.app', ['title' => 'Masuk Akun'])

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-10 sm:py-16 w-full flex justify-center">
    <div class="w-full max-w-md mx-auto" x-data="{
        role: 'warga',
        nik: '{{ old('nik', '') }}',
        adminUser: '{{ old('username', '') }}',
        adminPass: '',
        showOtherMethods: false
    }">
        <div class="starline-card p-6 sm:p-8 bg-white border border-slate-200/90 shadow-sm rounded-3xl">
            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-[#0f172a] text-[#e6ff94] mb-3 shadow-xs">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 font-display tracking-tight">Masuk Akun</h1>
                <p class="text-xs text-slate-500 mt-1 font-sans">Pilih peran akses Anda untuk melanjutkan ke platform Kinerja</p>
            </div>

            {{-- Role Segmented Control --}}
            <div class="grid grid-cols-2 gap-1.5 p-1 bg-slate-100 rounded-2xl mb-6">
                <button
                    type="button"
                    @click="role = 'warga'"
                    :class="role === 'warga' ? 'bg-white text-slate-950 shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                    class="py-2.5 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Masyarakat (NIK)</span>
                </button>
                <button
                    type="button"
                    @click="role = 'admin'"
                    :class="role === 'admin' ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                    class="py-2.5 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Administrator</span>
                </button>
            </div>

            {{-- Alert Flash --}}
            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-white border border-rose-200/90 shadow-2xs text-xs">
                    <div class="w-5 h-5 rounded-md bg-rose-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="font-medium text-rose-800 flex-1 leading-snug">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 shadow-2xs text-xs">
                    <div class="w-5 h-5 rounded-md bg-[#0f172a] text-[#e6ff94] flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-800 flex-1 leading-snug">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 1. TAB MASYARAKAT (NIK SAJA) --}}
            <div x-show="role === 'warga'" x-cloak class="space-y-4">
                <form action="{{ route('auth.nik') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="nik" class="block text-xs font-bold text-slate-800">
                                Nomor Induk Kependudukan (NIK)
                            </label>
                            <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded">
                                Tanpa Kata Sandi
                            </span>
                        </div>
                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            x-model="nik"
                            maxlength="16"
                            inputmode="numeric"
                            placeholder="Masukkan 16 digit NIK Anda"
                            required
                            class="input-starline w-full text-sm font-mono tracking-wider"
                        >
                        @error('nik')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Demo Quick Click Chips --}}
                    <div class="space-y-1.5 pt-1">
                        <span class="text-[10px] text-slate-500 font-medium block">Contoh NIK Penerima Bansos (Klik untuk Isi):</span>
                        <div class="flex flex-wrap gap-1.5">
                            <button
                                type="button"
                                @click="nik = '3302112001990001'"
                                class="text-[11px] font-mono bg-slate-100 hover:bg-slate-200 text-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 transition-colors cursor-pointer"
                                title="Klik untuk autofill NIK 3302112001990001"
                            >
                                3302112001990001 <span class="text-slate-500 text-[10px]">(PKH)</span>
                            </button>
                            <button
                                type="button"
                                @click="nik = '3302112001990002'"
                                class="text-[11px] font-mono bg-slate-100 hover:bg-slate-200 text-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 transition-colors cursor-pointer"
                                title="Klik untuk autofill NIK 3302112001990002"
                            >
                                3302112001990002 <span class="text-slate-500 text-[10px]">(BPNT)</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-starline-primary text-xs font-bold py-3 mt-3 cursor-pointer">
                        Masuk sebagai Warga &rarr;
                    </button>
                </form>

                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span><strong>Jaminan Privasi:</strong> NIK Anda dilindungi dengan enkripsi HMAC-SHA256 ber-pepper untuk mencegah kebocoran data identitas.</span>
                </div>
            </div>

            {{-- 2. TAB ADMINISTRATOR (admin & admin123) --}}
            <div x-show="role === 'admin'" x-cloak class="space-y-4">
                <form action="{{ route('auth.admin') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-800 mb-1">
                            Username / Surel Admin
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            x-model="adminUser"
                            placeholder="admin"
                            required
                            class="input-starline w-full text-xs font-medium"
                        >
                        @error('username')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-800 mb-1">
                            Kata Sandi Admin
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            x-model="adminPass"
                            placeholder="admin123"
                            required
                            class="input-starline w-full text-xs font-medium"
                        >
                        @error('password')
                            <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Admin Quick Click Chip --}}
                    <div class="pt-1">
                        <button
                            type="button"
                            @click="adminUser = 'admin'; adminPass = 'admin123'"
                            class="text-[11px] font-mono bg-amber-50 hover:bg-amber-100 text-amber-950 border border-amber-200 px-3 py-1 rounded-lg transition-colors cursor-pointer inline-flex items-center gap-1.5"
                        >
                            <span>🔑</span>
                            <span>Isi Kredensial: <strong>admin</strong> / <strong>admin123</strong></span>
                        </button>
                    </div>

                    <button type="submit" class="w-full btn-starline-secondary text-xs font-bold py-3 mt-3 cursor-pointer">
                        Masuk sebagai Administrator &rarr;
                    </button>
                </form>

                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Memberikan akses verifikasi tiket laporan, inspeksi anomali bansos, dan manajemen data.</span>
                </div>
            </div>

            {{-- Guest Mode Button --}}
            <div class="pt-5 mt-5 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-500 mb-2">Ingin melihat tanpa login?</p>
                <a href="{{ route('auth.guest') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Jelajah sebagai Tamu
                </a>
            </div>

            {{-- Collapsible Alternative Methods (Google & OTP) --}}
            <div class="pt-4 text-center">
                <button
                    type="button"
                    @click="showOtherMethods = !showOtherMethods"
                    class="text-[11px] font-medium text-slate-400 hover:text-slate-600 inline-flex items-center gap-1 cursor-pointer"
                >
                    <span x-text="showOtherMethods ? 'Sembunyikan Metode Lain' : 'Opsi Masuk Lainnya (Google / OTP)'"></span>
                    <svg class="w-3.5 h-3.5 transition-transform" :class="showOtherMethods ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="showOtherMethods" x-cloak class="mt-4 pt-4 border-t border-slate-100 space-y-4 text-left">
                    {{-- Google OAuth Button --}}
                    <a href="{{ route('auth.google') }}"
                       class="w-full flex items-center justify-center gap-3 px-4 py-2.5 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold transition-all shadow-2xs hover:border-slate-300">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        Masuk dengan Akun Google
                    </a>

                    {{-- Email OTP Form --}}
                    <form action="{{ route('auth.otp.send') }}" method="POST" class="space-y-2.5">
                        @csrf
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Alamat Surel OTP</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@domain.com"
                                class="input-starline w-full text-xs font-medium"
                            >
                        </div>
                        <button type="submit" class="w-full btn-starline-ghost text-xs font-semibold py-2">
                            Kirim Kode OTP
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
