@extends('layouts.auth', ['title' => 'Masuk Akun'])

@section('content')
<div class="min-h-screen w-full flex flex-col lg:flex-row bg-slate-50">
    {{-- SISI KIRI: FORM LOGIN (Sesuai Referensi Untitled UI / Peppo) --}}
    <div class="w-full lg:w-1/2 min-h-screen bg-white flex flex-col justify-between p-6 sm:p-10 lg:p-14 xl:p-16 z-10 shadow-sm lg:shadow-xl">
        {{-- Brand Logo Header --}}
        <div class="flex items-center justify-between">
            <div class="inline-flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-[#0f172a] text-[#e6ff94] flex items-center justify-center shadow-xs">
                    <svg viewBox="0 0 256 256" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M68 55C61.37 55 56 60.37 56 67V211C56 217.63 61.37 223 68 223H92C98.63 223 104 217.63 104 211V163L152 211C156.69 215.69 163.31 215.69 168 211L196 183C200.69 178.31 200.69 171.69 196 167L152 123L196 79C200.69 74.31 200.69 67.69 196 63L168 35C163.31 30.31 156.69 30.31 152 35L104 83V67C104 60.37 98.63 55 92 55H68ZM126 125A14 14 0 1 0 126 153A14 14 0 1 0 126 125Z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold text-slate-900 font-display tracking-tight leading-tight">Kinerja</span>
                    <span class="text-[11px] font-semibold text-slate-500 tracking-wide">Transparansi Bantuan Sosial</span>
                </div>
            </div>

            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200/80">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Aktif
            </span>
        </div>

        {{-- Center Form Container --}}
        <div class="w-full max-w-md mx-auto my-auto py-8 sm:py-10" x-data="{
            role: 'warga',
            nik: '{{ old('nik', '') }}',
            adminUser: '{{ old('username', '') }}',
            adminPass: '',
            showAdminPass: false,
            showOtherMethods: false
        }">
            {{-- Form Title & Description --}}
            <div class="mb-7">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display tracking-tight">Masuk Akun</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5 font-sans leading-relaxed">
                    Pilih peran akses Anda untuk membuka platform Kinerja
                </p>
            </div>

            {{-- Role Segmented Switcher --}}
            <div class="grid grid-cols-2 gap-1.5 p-1.5 bg-slate-100 rounded-2xl mb-6 border border-slate-200/80">
                <button
                    type="button"
                    @click="role = 'warga'"
                    :class="role === 'warga' ? 'bg-white text-slate-950 shadow-sm font-bold border border-slate-200/60' : 'text-slate-600 hover:text-slate-900 font-semibold'"
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
                    :class="role === 'admin' ? 'bg-[#0f172a] text-[#e6ff94] shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                    class="py-2.5 px-3 rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Administrator</span>
                </button>
            </div>

            {{-- Alert Flash Notif --}}
            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
                    <div class="w-5 h-5 rounded-md bg-rose-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <span class="font-medium flex-1 leading-snug">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
                    <div class="w-5 h-5 rounded-md bg-[#0f172a] text-[#e6ff94] flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="font-medium flex-1 leading-snug">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 1. TAB MASYARAKAT (NIK SAJA) --}}
            <div x-show="role === 'warga'" x-cloak class="space-y-4">
                <form action="{{ route('auth.nik') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="nik" class="block text-xs font-bold text-slate-800">
                                Nomor Induk Kependudukan (NIK)
                            </label>
                            <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                Tanpa Kata Sandi
                            </span>
                        </div>
                        <div class="relative">
                            <input
                                type="text"
                                id="nik"
                                name="nik"
                                x-model="nik"
                                maxlength="16"
                                inputmode="numeric"
                                placeholder="Masukkan 16 digit NIK Anda"
                                required
                                class="w-full text-sm font-mono tracking-wider px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a] focus:border-transparent transition-all shadow-2xs"
                            >
                        </div>
                        @error('nik')
                            <p class="text-[11px] text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Demo Quick Click Chips --}}
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/70 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Demo Penerima Bansos</span>
                            <span class="text-[10px] text-slate-400">Klik untuk isi</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <button
                                type="button"
                                @click="nik = '3302112001990001'"
                                class="text-[11px] font-mono bg-white hover:bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 transition-colors cursor-pointer shadow-2xs"
                                title="Klik untuk autofill NIK 3302112001990001"
                            >
                                3302112001990001 <span class="text-emerald-600 font-semibold text-[10px]">(PKH)</span>
                            </button>
                            <button
                                type="button"
                                @click="nik = '3302112001990002'"
                                class="text-[11px] font-mono bg-white hover:bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 transition-colors cursor-pointer shadow-2xs"
                                title="Klik untuk autofill NIK 3302112001990002"
                            >
                                3302112001990002 <span class="text-blue-600 font-semibold text-[10px]">(BPNT)</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#0f172a] hover:bg-slate-800 text-[#e6ff94] font-bold text-sm py-3.5 px-4 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                        <span>Masuk sebagai Warga</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2.5 leading-relaxed">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span><strong>Jaminan Perlindungan PDP:</strong> NIK Anda dilindungi enkripsi satu arah ber-pepper kriptografis. Nama lengkap disamarkan untuk menjamin privasi.</span>
                </div>
            </div>

            {{-- 2. TAB ADMINISTRATOR (admin & admin123) --}}
            <div x-show="role === 'admin'" x-cloak class="space-y-4">
                <form action="{{ route('auth.admin') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-800 mb-1.5">
                            Username / Surel Admin
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            x-model="adminUser"
                            placeholder="admin"
                            required
                            class="w-full text-sm px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a] focus:border-transparent transition-all shadow-2xs font-medium"
                        >
                        @error('username')
                            <p class="text-[11px] text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-800 mb-1.5">
                            Kata Sandi Admin
                        </label>
                        <div class="relative">
                            <input
                                :type="showAdminPass ? 'text' : 'password'"
                                id="password"
                                name="password"
                                x-model="adminPass"
                                placeholder="admin123"
                                required
                                class="w-full text-sm px-4 py-3 pr-10 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a] focus:border-transparent transition-all shadow-2xs font-medium"
                            >
                            <button
                                type="button"
                                @click="showAdminPass = !showAdminPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer"
                                aria-label="Lihat kata sandi"
                            >
                                <svg x-show="!showAdminPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showAdminPass" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[11px] text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Admin Quick Click Chip --}}
                    <div class="pt-1">
                        <button
                            type="button"
                            @click="adminUser = 'admin'; adminPass = 'admin123'"
                            class="text-[11px] font-mono bg-amber-50 hover:bg-amber-100 text-amber-950 border border-amber-200 px-3 py-1.5 rounded-xl transition-colors cursor-pointer inline-flex items-center gap-1.5 shadow-2xs"
                        >
                            <span>🔑</span>
                            <span>Isi Kredensial: <strong>admin</strong> / <strong>admin123</strong></span>
                        </button>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-3.5 px-4 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                        <span>Masuk sebagai Administrator</span>
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Akses khusus staf verifikator, auditor pemantauan SLA instansi, dan manajemen master data bansos.</span>
                </div>
            </div>

            {{-- Guest Mode Button --}}
            <div class="pt-5 mt-5 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-500 mb-2 font-medium">Ingin melihat ringkasan tanpa login akun?</p>
                <a href="{{ route('auth.guest') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200/80 border border-slate-200 transition-colors w-full sm:w-auto">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Jelajah sebagai Tamu
                </a>
            </div>

            {{-- Alternative Methods (Google & OTP) --}}
            <div class="pt-4 text-center">
                <button
                    type="button"
                    @click="showOtherMethods = !showOtherMethods"
                    class="text-[11px] font-semibold text-slate-400 hover:text-slate-600 inline-flex items-center gap-1 cursor-pointer"
                >
                    <span x-text="showOtherMethods ? 'Sembunyikan Metode Lain' : 'Opsi Masuk Lainnya (Google / OTP)'"></span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="showOtherMethods ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="showOtherMethods" x-cloak class="mt-4 pt-4 border-t border-slate-100 space-y-3.5 text-left">
                    {{-- Google OAuth Button --}}
                    <a href="{{ route('auth.google') }}"
                       class="w-full flex items-center justify-center gap-3 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold transition-all shadow-2xs hover:border-slate-300">
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
                                class="w-full text-xs font-medium px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a]"
                            >
                        </div>
                        <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold py-2.5 rounded-xl transition-colors cursor-pointer">
                            Kirim Kode OTP
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2">
            <span>&copy; {{ date('Y') }} Kinerja • Hak Cipta Dilindungi</span>
            <div class="flex items-center gap-3">
                <a href="{{ route('terms') }}" class="hover:text-slate-600 transition-colors">Ketentuan &amp; PDP</a>
                <span>&bull;</span>
                <a href="{{ route('about') }}" class="hover:text-slate-600 transition-colors">Tentang Platform</a>
            </div>
        </div>
    </div>

    {{-- SISI KANAN: SHOWCASE & ILUSTRASI MODERN (Sesuai Referensi Visual) --}}
    <div class="hidden lg:flex lg:w-1/2 min-h-screen bg-gradient-to-br from-[#070d18] via-[#0f172a] to-[#15233c] text-white p-12 xl:p-16 flex-col justify-between relative overflow-hidden">
        {{-- Background Ambient Orbs --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#e6ff94]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Decorative Grid Lines --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>

        {{-- Top Badge --}}
        <div class="relative z-10 flex items-center justify-between">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-md text-[#e6ff94] border border-white/10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Transparansi &amp; Akuntabilitas Terbuka
            </span>
            <span class="text-xs text-slate-400 font-mono">v1.0.0</span>
        </div>

        {{-- Center Cards & Typography Showcase --}}
        <div class="relative z-10 max-w-lg my-auto py-10 space-y-8">
            <div class="space-y-3">
                <h2 class="text-3xl xl:text-4xl font-extrabold font-display tracking-tight text-white leading-tight">
                    Kawal Bansos,<br>
                    <span class="text-[#e6ff94]">Lindungi Hak Warga</span>
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Sistem pemantauan real-time untuk menjamin bantuan sosial tepat sasaran, bebas pemotongan pungli, dan terverifikasi secara objektif.
                </p>
            </div>

            {{-- 3 Floating Feature Cards --}}
            <div class="space-y-3.5">
                {{-- Card 1: Resi Tracker --}}
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-lg transform transition-transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-mono font-bold text-xs border border-emerald-400/30">
                                📦
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white font-mono tracking-wider">HWR-2026-BDG01</p>
                                <p class="text-[10px] text-slate-300">Penyaluran Beras 10kg &amp; BLT Tunai</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                            Tersalurkan 100%
                        </span>
                    </div>
                    <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-400 to-[#e6ff94] h-full w-full rounded-full"></div>
                    </div>
                </div>

                {{-- Card 2: Anonimitas & UU PDP --}}
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-lg transform transition-transform hover:-translate-y-1">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center font-bold text-xs shrink-0 border border-blue-400/30">
                            🛡️
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-white">Anonimitas Mutlak Pelapor</p>
                            <p class="text-[11px] text-slate-300 mt-0.5 leading-relaxed">
                                Laporan pungutan liar dan sanggahan diverifikasi dengan kode rahasia unik tanpa membuka data pribadi pelapor ke publik.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Scorecard SLA --}}
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-lg transform transition-transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center font-bold text-xs shrink-0 border border-amber-400/30">
                                ⚡
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Scorecard SLA Instansi</p>
                                <p class="text-[11px] text-slate-300">Respon cepat rata-rata &lt; 24 jam</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-black text-[#e6ff94] font-display">Grade A</span>
                            <p class="text-[10px] text-slate-400">Peringkat 1 Nasional</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Quote / Citation --}}
        <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
            <span>Inisiatif Pengawasan Kolaboratif Warga &amp; Pemerintah</span>
            <div class="flex items-center gap-1.5 text-slate-300 font-medium">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Standar Keterbukaan Informasi Publik</span>
            </div>
        </div>
    </div>
</div>
@endsection
