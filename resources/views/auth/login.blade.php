@extends('layouts.auth', ['title' => 'Masuk Akun'])

@section('content')
<div class="min-h-screen w-full grid lg:grid-cols-2 bg-white">

    {{-- KIRI: formulir masuk --}}
    <div class="flex flex-col gap-8 lg:justify-between px-6 py-8 sm:px-10 lg:px-14 xl:px-16">
        <header>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2.5 rounded focus-ring">
                <span class="w-8 h-8 rounded-lg bg-[#0f172a] text-[#e6ff94] flex items-center justify-center">
                    <svg viewBox="0 0 256 256" class="w-4 h-4" fill="none" aria-hidden="true">
                        <path fill="currentColor" fill-rule="evenodd" d="M68 55C61.37 55 56 60.37 56 67V211C56 217.63 61.37 223 68 223H92C98.63 223 104 217.63 104 211V163L152 211C156.69 215.69 163.31 215.69 168 211L196 183C200.69 178.31 200.69 171.69 196 167L152 123L196 79C200.69 74.31 200.69 67.69 196 63L168 35C163.31 30.31 156.69 30.31 152 35L104 83V67C104 60.37 98.63 55 92 55H68ZM126 125A14 14 0 1 0 126 153A14 14 0 1 0 126 125Z"/>
                    </svg>
                </span>
                <span class="text-base font-bold tracking-tight">Kinerja</span>
            </a>
        </header>

        <div class="w-full max-w-[22rem] mx-auto py-2 lg:py-10" x-data="{ role: 'warga', showPass: false, showOther: false }">
            <h1 class="text-[1.75rem] leading-tight font-bold tracking-tight">Masuk akun</h1>
            <p class="mt-1.5 text-sm text-slate-500">Pilih peran, lalu masukkan data akun.</p>

            @if(session('error'))
                <p class="mt-4 px-3 py-2 rounded-lg bg-rose-50 border border-rose-200 text-[13px] text-rose-800" role="alert">{{ session('error') }}</p>
            @endif
            @if(session('success'))
                <p class="mt-4 px-3 py-2 rounded-lg bg-emerald-50 border border-emerald-200 text-[13px] text-emerald-800" role="status">{{ session('success') }}</p>
            @endif

            <div class="mt-6 grid grid-cols-2 gap-1 rounded-lg bg-slate-100 p-1" role="tablist" aria-label="Peran akun">
                <button type="button" role="tab" @click="role = 'warga'"
                        :aria-selected="role === 'warga' ? 'true' : 'false'"
                        :class="role === 'warga' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600'"
                        class="min-h-11 rounded-md text-[13px] font-semibold transition-colors focus-ring">
                    Masyarakat
                </button>
                <button type="button" role="tab" @click="role = 'admin'"
                        :aria-selected="role === 'admin' ? 'true' : 'false'"
                        :class="role === 'admin' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600'"
                        class="min-h-11 rounded-md text-[13px] font-semibold transition-colors focus-ring">
                    Administrator
                </button>
            </div>

            {{-- Masyarakat --}}
            <form x-show="role === 'warga'" action="{{ route('auth.nik') }}" method="POST" class="mt-5 space-y-4" x-ref="nikForm">
                @csrf
                <div>
                    <label for="nik" class="block text-[13px] font-semibold text-slate-800 mb-1.5">NIK</label>
                    <input type="text" id="nik" name="nik" x-ref="nikInput" value="{{ old('nik') }}" maxlength="16"
                           inputmode="numeric" autocomplete="username" required
                           aria-describedby="nik-hint @error('nik') nik-error @enderror"
                           placeholder="16 digit"
                           class="w-full min-h-11 px-3 rounded-lg border border-slate-300 bg-white text-sm font-mono
                                  placeholder:font-sans placeholder:text-slate-500
                                  focus:outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                    @error('nik')
                        <p id="nik-error" class="mt-1.5 text-[13px] text-rose-700">{{ $message }}</p>
                    @enderror
                    <p id="nik-hint" class="mt-1.5 text-[12px] text-slate-500">NIK tidak disimpan. Sistem hanya menyimpan hash-nya.</p>
                </div>

                <button type="submit"
                        class="w-full min-h-11 rounded-lg bg-[#0f172a] text-[#e6ff94] text-sm font-bold
                               hover:bg-slate-800 transition-colors focus-ring">
                    Masuk sebagai masyarakat
                </button>

                <p class="text-[12px] text-slate-500">
                    Coba data demo:
                    <button type="button" @click="$refs.nikInput.value = '3302112001990001'"
                            class="underline underline-offset-2 hover:text-slate-800 focus-ring rounded">
                        NIK penerima PKH
                    </button>
                </p>
            </form>

            {{-- Administrator --}}
            <form x-show="role === 'admin'" x-cloak action="{{ route('auth.admin') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label for="username" class="block text-[13px] font-semibold text-slate-800 mb-1.5">Nama pengguna</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                           autocomplete="username" required
                           class="w-full min-h-11 px-3 rounded-lg border border-slate-300 bg-white text-sm
                                  placeholder:text-slate-500 focus:outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                    @error('username')
                        <p class="mt-1.5 text-[13px] text-rose-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[13px] font-semibold text-slate-800 mb-1.5">Kata sandi</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" id="password" name="password"
                               autocomplete="current-password" required
                               class="w-full min-h-11 px-3 pr-11 rounded-lg border border-slate-300 bg-white text-sm
                                      focus:outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                        <button type="button" @click="showPass = !showPass"
                                :aria-label="showPass ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                class="absolute right-1 top-1/2 -translate-y-1/2 min-h-9 min-w-9 grid place-items-center
                                       rounded text-slate-500 hover:text-slate-800 focus-ring">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-[13px] text-rose-700">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full min-h-11 rounded-lg bg-[#0f172a] text-[#e6ff94] text-sm font-bold
                               hover:bg-slate-800 transition-colors focus-ring">
                    Masuk sebagai administrator
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-200 space-y-3">
                <a href="{{ route('auth.guest') }}"
                   class="w-full min-h-11 grid place-items-center rounded-lg border border-slate-300 text-sm font-semibold
                          text-slate-800 hover:bg-slate-50 transition-colors focus-ring">
                    Lanjut tanpa akun
                </a>

                <button type="button" @click="showOther = !showOther" :aria-expanded="showOther ? 'true' : 'false'"
                        class="w-full text-[13px] text-slate-600 hover:text-slate-900 transition-colors focus-ring rounded">
                    <span x-text="showOther ? 'Tutup jalur lain' : 'Jalur masuk lain'"></span>
                </button>

                <div x-show="showOther" x-cloak class="space-y-2">
                    <a href="{{ route('auth.google') }}"
                       class="w-full min-h-11 flex items-center justify-center gap-2 rounded-lg border border-slate-300
                              text-sm font-medium text-slate-800 hover:bg-slate-50 transition-colors focus-ring">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        Masuk dengan Google
                    </a>

                    <form action="{{ route('auth.otp.send') }}" method="POST" class="flex gap-2">
                        @csrf
                        <label for="email" class="sr-only">Alamat surel</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@domain.com"
                               class="flex-1 min-h-11 px-3 rounded-lg border border-slate-300 bg-white text-sm
                                      placeholder:text-slate-500 focus:outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                        <button type="submit"
                                class="min-h-11 px-4 rounded-lg border border-slate-300 text-sm font-semibold
                                       text-slate-800 hover:bg-slate-50 transition-colors focus-ring">
                            Kirim kode
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <footer class="text-[12px] text-slate-500 lg:mt-0 mt-auto pt-8">
            &copy; {{ date('Y') }} Kinerja. Data penerima pada sistem ini adalah data simulasi.
        </footer>
    </div>

    {{-- KANAN: wilayah pilot --}}
    <aside class="hidden lg:flex flex-col justify-center bg-slate-50 border-l border-slate-200 px-12 xl:px-16"
           x-data="{
               hovered: null,
               regions: {
                   cilacap:      { nama: 'Kabupaten Cilacap',      kuota: '12.000', rel: '0,43x', status: 'potensi defisit kuota' },
                   banyumas:     { nama: 'Kabupaten Banyumas',     kuota: '30.000', rel: '1,00x', status: 'alokasi proporsional' },
                   purbalingga:  { nama: 'Kabupaten Purbalingga',  kuota: '45.000', rel: '2,22x', status: 'potensi kelebihan kuota' },
                   banjarnegara: { nama: 'Kabupaten Banjarnegara', kuota: '20.500', rel: '1,01x', status: 'alokasi proporsional' },
                   kebumen:      { nama: 'Kabupaten Kebumen',      kuota: '29.000', rel: '0,99x', status: 'alokasi proporsional' }
               },
               get active() { return this.hovered ? this.regions[this.hovered] : null; }
           }">
        <div class="max-w-md w-full mx-auto">
            <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-500">Wilayah pilot</p>
            <p class="mt-2 text-[15px] leading-relaxed text-slate-700">
                Lima kabupaten di Jawa Tengah. Angka di bawah adalah rasio kuota bantuan terhadap estimasi penduduk miskin.
            </p>

            <div class="mt-6 rounded-xl bg-white border border-slate-200 p-4">
                <svg viewBox="0 0 560 300" class="w-full h-auto" role="img"
                     aria-label="Peta lima kabupaten pilot di Jawa Tengah">
                    @include('auth.partials.pilot-map')
                </svg>

                <div class="mt-3 pt-3 border-t border-slate-200 min-h-[3.5rem]" aria-live="polite">
                    <template x-if="active">
                        <div>
                            <p class="text-[13px] font-bold" x-text="active.nama"></p>
                            <p class="text-[12px] text-slate-600 mt-0.5">
                                Kuota <span class="font-mono tabular-nums" x-text="active.kuota"></span>
                                &middot; rasio <span class="font-mono tabular-nums" x-text="active.rel"></span>
                                &middot; <span x-text="active.status"></span>
                            </p>
                        </div>
                    </template>
                    <template x-if="!active">
                        <p class="text-[12px] text-slate-500">Arahkan kursor ke salah satu wilayah untuk melihat angkanya.</p>
                    </template>
                </div>

                <ul class="mt-3 pt-3 border-t border-slate-200 flex flex-wrap gap-x-4 gap-y-1.5 text-[11px] text-slate-600">
                    <li class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm border" style="background:rgba(180,83,9,0.22);border-color:#b45309"></span>
                        di bawah 0,8x
                    </li>
                    <li class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm border" style="background:rgba(21,128,61,0.22);border-color:#15803d"></span>
                        0,8x sampai 1,2x
                    </li>
                    <li class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm border" style="background:rgba(109,40,217,0.22);border-color:#6d28d9"></span>
                        di atas 1,2x
                    </li>
                </ul>
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-[1fr_auto_auto] gap-3 px-1 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <span>Kabupaten</span>
                    <span class="text-right">Kuota</span>
                    <span class="text-right">Rasio</span>
                </div>
                <ul class="divide-y divide-slate-200">
                    @include('auth.partials.pilot-list')
                </ul>
                <p class="mt-3 text-[11px] leading-relaxed text-slate-500">
                    Indikator ini untuk ditelaah, bukan putusan pelanggaran. Seluruh data penerima bersifat simulasi.
                </p>
            </div>
        </div>
    </aside>
</div>
@endsection
