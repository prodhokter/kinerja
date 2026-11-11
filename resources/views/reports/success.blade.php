@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-10 sm:py-16 w-full flex justify-center">
    <div class="w-full max-w-xl mx-auto space-y-6">
        <div class="starline-card p-6 sm:p-10 text-center space-y-6 rounded-3xl shadow-sm border border-slate-200/80 bg-white">
            {{-- Top Icon --}}
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#e6ff94] text-slate-950 shadow-sm border border-[#c2e050] mx-auto">
                <svg class="w-8 h-8 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- Heading & Subtitle --}}
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-display">
                    Laporan Anda Berhasil Dicatat
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto leading-relaxed">
                    Terima kasih atas partisipasi Anda mengawal transparansi bansos. Laporan telah masuk ke antrean verifikasi petugas.
                </p>
            </div>

            {{-- Credentials Box --}}
            <div class="bg-slate-900 text-white rounded-2xl p-6 sm:p-7 border border-slate-800 shadow-md text-left space-y-5" x-data="{ copiedTicket: false, copiedSecret: false }">
                {{-- Ticket Code --}}
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-mono">Nomor Tiket Publik</span>
                        <span class="text-[10px] text-slate-400 font-mono px-2 py-0.5 rounded bg-slate-800 border border-slate-700">Untuk Pantau Status</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-2">
                        <span class="text-2xl sm:text-3xl font-black font-mono text-white tracking-wider select-all">
                            {{ $ticketCode }}
                        </span>
                        <button
                            type="button"
                            @click="navigator.clipboard.writeText('{{ $ticketCode }}'); copiedTicket = true; window.hwToast('Nomor tiket disalin!'); setTimeout(() => copiedTicket = false, 2500)"
                            class="cursor-pointer inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-full bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 hover:border-slate-600 transition-all shadow-2xs w-fit"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span x-show="!copiedTicket">Salin Nomor Tiket</span>
                            <span x-show="copiedTicket" x-cloak class="text-[#e6ff94] font-bold">&check; Tersalin!</span>
                        </button>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-800/80"></div>

                {{-- Secret Code --}}
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-200 uppercase tracking-wider font-mono flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            Kode Rahasia Akses Tiket (Hanya Tampil Sekali)
                        </span>
                        <span class="text-[10px] font-bold text-amber-300 font-mono px-2 py-0.5 rounded bg-amber-950/80 border border-amber-800/80">Rahasia</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-2.5">
                        <span class="text-xl sm:text-2xl font-black font-mono text-slate-950 tracking-widest bg-[#e6ff94] px-4 py-2 rounded-xl border-2 border-[#c2e050] select-all shadow-inner">
                            {{ $secretCode }}
                        </span>
                        <button
                            type="button"
                            @click="navigator.clipboard.writeText('{{ $secretCode }}'); copiedSecret = true; window.hwToast('Kode rahasia disalin!'); setTimeout(() => copiedSecret = false, 2500)"
                            class="cursor-pointer inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs font-bold rounded-full bg-[#e6ff94] hover:bg-[#d8f578] text-slate-950 transition-all shadow-xs w-fit"
                        >
                            <svg class="w-3.5 h-3.5 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span x-show="!copiedSecret">Salin Kode Rahasia</span>
                            <span x-show="copiedSecret" x-cloak class="text-slate-950 font-black">&check; Tersalin!</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Safety Notice --}}
            <div class="rounded-2xl bg-amber-50/90 border border-amber-200/90 p-4 sm:p-5 text-left text-xs space-y-1.5 shadow-2xs">
                <div class="flex items-center gap-2 font-bold text-amber-950">
                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>PENTING: Simpan atau Catat Kode Rahasia Ini Sekarang</span>
                </div>
                <p class="text-amber-900 leading-relaxed pl-6">
                    Demi perlindungan privasi dan anonimitas mutlak Anda, sistem tidak menyimpan kode rahasia dalam bentuk teks terbaca. Jika kode ini hilang, rincian aduan dan balasan staf verifikator tidak dapat dibuka kembali.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <a
                    href="{{ route('ticket.show', ['ticket' => $ticketCode]) }}"
                    class="btn-starline-primary flex-1 text-sm font-bold shadow-xs py-3"
                >
                    Buka &amp; Pantau Tiket Sekarang &rarr;
                </a>
                <a
                    href="{{ route('home') }}"
                    class="btn-starline-ghost flex-1 sm:flex-none text-sm font-semibold py-3"
                >
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
