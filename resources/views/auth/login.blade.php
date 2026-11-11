@extends('layouts.auth', ['title' => 'Masuk Akun'])

@section('content')
<div class="min-h-screen w-full flex flex-col lg:flex-row bg-white">
    {{-- SISI KIRI: FORM LOGIN BERSIH & SELARAS TEMA KINERJA --}}
    <div class="w-full lg:w-1/2 min-h-screen flex flex-col justify-between p-6 sm:p-10 lg:p-14 xl:p-16">
        {{-- Brand Logo Header --}}
        <div>
            <div class="inline-flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#0f172a] text-[#e6ff94] flex items-center justify-center shadow-xs">
                    <svg viewBox="0 0 256 256" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M68 55C61.37 55 56 60.37 56 67V211C56 217.63 61.37 223 68 223H92C98.63 223 104 217.63 104 211V163L152 211C156.69 215.69 163.31 215.69 168 211L196 183C200.69 178.31 200.69 171.69 196 167L152 123L196 79C200.69 74.31 200.69 67.69 196 63L168 35C163.31 30.31 156.69 30.31 152 35L104 83V67C104 60.37 98.63 55 92 55H68ZM126 125A14 14 0 1 0 126 153A14 14 0 1 0 126 125Z"/>
                    </svg>
                </div>
                <span class="text-base font-bold text-slate-900 font-display tracking-tight">Kinerja</span>
            </div>
        </div>

        {{-- Center Form Container --}}
        <div class="w-full max-w-sm mx-auto my-auto py-8" x-data="{
            role: 'warga',
            nik: '{{ old('nik', '') }}',
            adminUser: '{{ old('username', '') }}',
            adminPass: '',
            showAdminPass: false,
            showOtherMethods: false
        }">
            {{-- Title & Subtitle --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight font-display">Masuk Akun</h1>
                <p class="text-sm text-slate-500 mt-1">Silakan masukkan data akun Anda.</p>
            </div>

            {{-- Role Switcher Pills (Sesuai Tema Navigasi Kinerja) --}}
            <div class="flex gap-1.5 p-1 bg-slate-100 rounded-xl mb-5 text-xs font-semibold">
                <button
                    type="button"
                    @click="role = 'warga'"
                    :class="role === 'warga' ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                    class="flex-1 py-2 px-3 rounded-lg transition-all text-center cursor-pointer"
                >
                    Masyarakat (NIK)
                </button>
                <button
                    type="button"
                    @click="role = 'admin'"
                    :class="role === 'admin' ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                    class="flex-1 py-2 px-3 rounded-lg transition-all text-center cursor-pointer"
                >
                    Administrator
                </button>
            </div>

            {{-- Flash Alert --}}
            @if(session('error'))
                <div class="mb-4 px-3.5 py-2.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 px-3.5 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 1. TAB MASYARAKAT --}}
            <div x-show="role === 'warga'" x-cloak class="space-y-4">
                <form action="{{ route('auth.nik') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nomor Induk Kependudukan (NIK)
                        </label>
                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            x-model="nik"
                            maxlength="16"
                            inputmode="numeric"
                            placeholder="Masukkan 16 digit NIK"
                            required
                            class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a]/10 focus:border-[#0f172a] transition-all font-mono"
                        >
                        @error('nik')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-slate-500">
                        <span>Contoh NIK demo:</span>
                        <div class="flex gap-2">
                            <button type="button" @click="nik = '3302112001990001'" class="hover:text-slate-900 underline cursor-pointer font-mono">
                                PKH (330211...)
                            </button>
                            <span>&bull;</span>
                            <button type="button" @click="nik = '3302112001990002'" class="hover:text-slate-900 underline cursor-pointer font-mono">
                                BPNT
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#0f172a] hover:bg-slate-800 text-[#e6ff94] font-bold text-sm py-2.5 px-4 rounded-xl shadow-xs transition-all cursor-pointer"
                    >
                        Masuk
                    </button>
                </form>
            </div>

            {{-- 2. TAB ADMINISTRATOR --}}
            <div x-show="role === 'admin'" x-cloak class="space-y-4">
                <form action="{{ route('auth.admin') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            x-model="adminUser"
                            placeholder="admin"
                            required
                            class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a]/10 focus:border-[#0f172a] transition-all"
                        >
                        @error('username')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input
                                :type="showAdminPass ? 'text' : 'password'"
                                id="password"
                                name="password"
                                x-model="adminPass"
                                placeholder="••••••••"
                                required
                                class="w-full text-sm px-3.5 py-2.5 pr-9 rounded-xl border border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0f172a]/10 focus:border-[#0f172a] transition-all"
                            >
                            <button
                                type="button"
                                @click="showAdminPass = !showAdminPass"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer"
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
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-slate-500">
                        <span>Kredensial demo:</span>
                        <button type="button" @click="adminUser = 'admin'; adminPass = 'admin123'" class="hover:text-slate-900 underline cursor-pointer font-mono">
                            admin / admin123
                        </button>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#0f172a] hover:bg-slate-800 text-[#e6ff94] font-bold text-sm py-2.5 px-4 rounded-xl shadow-xs transition-all cursor-pointer"
                    >
                        Masuk
                    </button>
                </form>
            </div>

            {{-- Secondary Actions: Guest & Other Methods --}}
            <div class="mt-6 pt-5 border-t border-slate-100 space-y-3 text-center">
                <a href="{{ route('auth.guest') }}"
                   class="w-full inline-flex items-center justify-center py-2 px-3 rounded-xl text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors">
                    Jelajah sebagai Tamu
                </a>

                <div>
                    <button
                        type="button"
                        @click="showOtherMethods = !showOtherMethods"
                        class="text-xs text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center gap-1 cursor-pointer"
                    >
                        <span x-text="showOtherMethods ? 'Sembunyikan opsi lain' : 'Opsi Masuk Lainnya (Google / OTP)'"></span>
                    </button>

                    <div x-show="showOtherMethods" x-cloak class="mt-3 space-y-2 text-left">
                        {{-- Google Sign-in --}}
                        <a href="{{ route('auth.google') }}"
                           class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            <span>Masuk dengan Akun Google</span>
                        </a>

                        {{-- OTP Form --}}
                        <form action="{{ route('auth.otp.send') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@domain.com"
                                class="flex-1 text-xs px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-[#0f172a]"
                            >
                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold cursor-pointer">
                                Kirim Kode OTP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div>
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Kinerja</p>
        </div>
    </div>

    {{-- SISI KANAN: KOMPOSISI MINIMALIS BERWARNA KANVAS KINERJA (#f0f4f8) --}}
    <div class="hidden lg:flex lg:w-1/2 min-h-screen bg-[#f0f4f8] items-center justify-center p-12 relative overflow-hidden select-none border-l border-slate-200/60">
        {{-- Layered Smooth Marble Ribbon & Sphere (Tema Kanvas Slate & Aksen Lime Kinerja) --}}
        <svg class="w-full max-w-lg h-auto" viewBox="0 0 600 600" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
                {{-- Drop Shadows menggunakan tinta slate #0f172a --}}
                <filter id="sculpture-shadow" x="-20%" y="-20%" width="140%" height="140%" filterUnits="userSpaceOnUse">
                    <feDropShadow dx="0" dy="16" stdDeviation="20" flood-color="#0f172a" flood-opacity="0.10" />
                </filter>
                <filter id="sphere-shadow" x="-50%" y="-50%" width="200%" height="200%" filterUnits="userSpaceOnUse">
                    <feDropShadow dx="6" dy="12" stdDeviation="10" flood-color="#0f172a" flood-opacity="0.16" />
                </filter>

                {{-- Track Gradients dalam palet Starline / Slate --}}
                <linearGradient id="track-surface" x1="100" y1="100" x2="500" y2="500" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95" />
                    <stop offset="50%" stop-color="#f8fafc" />
                    <stop offset="100%" stop-color="#e2e8f0" />
                </linearGradient>

                <linearGradient id="track-depth" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#cbd5e1" />
                    <stop offset="100%" stop-color="#94a3b8" />
                </linearGradient>

                <linearGradient id="sphere-lighting" x1="20%" y1="20%" x2="80%" y2="80%">
                    <stop offset="0%" stop-color="#ffffff" />
                    <stop offset="60%" stop-color="#f8fafc" />
                    <stop offset="100%" stop-color="#cbd5e1" />
                </linearGradient>
            </defs>

            {{-- Background Subtle Curving Guide Line --}}
            <path
                d="M 50,450 C 180,450 180,260 300,260 C 420,260 420,100 550,100"
                stroke="#cbd5e1"
                stroke-width="1.5"
                stroke-dasharray="4 6"
                fill="none"
            />

            {{-- Continuous Minimalist Architectural Marble Track --}}
            <g filter="url(#sculpture-shadow)">
                {{-- Depth Extrusion Wall --}}
                <path
                    d="M 40,430 C 180,430 180,240 300,240 C 420,240 420,80 560,80
                       L 560,115
                       C 420,115 420,275 300,275
                       C 180,275 180,465 40,465 Z"
                    fill="url(#track-depth)"
                />

                {{-- Top Track Channel Surface --}}
                <path
                    d="M 40,410 C 180,410 180,220 300,220 C 420,220 420,60 560,60
                       L 560,95
                       C 420,95 420,255 300,255
                       C 180,255 180,445 40,445 Z"
                    fill="url(#track-surface)"
                    stroke="#ffffff"
                    stroke-width="1"
                />

                {{-- Inner Track Grooves / Segments --}}
                <path
                    d="M 50,427 C 180,427 180,237 300,237 C 420,237 420,77 550,77"
                    stroke="#94a3b8"
                    stroke-width="2"
                    fill="none"
                    opacity="0.5"
                />

                {{-- Subtle Segment Seams (Architectural Blocks) --}}
                <line x1="120" y1="418" x2="120" y2="438" stroke="#94a3b8" stroke-width="1.5" opacity="0.4" />
                <line x1="210" y1="330" x2="225" y2="345" stroke="#94a3b8" stroke-width="1.5" opacity="0.4" />
                <line x1="300" y1="228" x2="300" y2="248" stroke="#94a3b8" stroke-width="1.5" opacity="0.4" />
                <line x1="390" y1="130" x2="405" y2="145" stroke="#94a3b8" stroke-width="1.5" opacity="0.4" />
                <line x1="480" y1="68" x2="480" y2="88" stroke="#94a3b8" stroke-width="1.5" opacity="0.4" />
            </g>

            {{-- Pure White Sphere (Resting in the Curve) with subtle Lime Hue Accent --}}
            <g filter="url(#sphere-shadow)">
                <circle cx="395" cy="148" r="24" fill="url(#sphere-lighting)" />
                {{-- Specular highlight --}}
                <ellipse cx="388" cy="139" rx="7" ry="4" fill="#ffffff" opacity="0.9" transform="rotate(-30 388 139)" />
                {{-- Subtle ambient bounce of Kinerja lime #e6ff94 --}}
                <ellipse cx="406" cy="158" rx="8" ry="4" fill="#e6ff94" opacity="0.35" transform="rotate(20 406 158)" />
            </g>
        </svg>
    </div>
</div>
@endsection
