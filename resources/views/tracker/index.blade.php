@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-3xl space-y-6">
        <div class="space-y-1">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Lacak Resi Penyaluran Bantuan Sosial
            </h1>
            <p class="text-xs text-slate-500">
                Gunakan nomor resi penyaluran resmi untuk melihat status distribusi terkini, instansi pelaksana, dan rincian hak bantuan Anda.
            </p>
        </div>

        {{-- Search Form Box --}}
        <div class="starline-card p-6 sm:p-8 rounded-2xl shadow-xs">
            <form action="{{ route('tracker.index') }}" method="GET" class="space-y-4">
                <div>
                    <label for="receipt-code-input" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">
                        Nomor Resi Penyaluran
                    </label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input
                            type="text"
                            id="receipt-code-input"
                            name="code"
                            placeholder="Contoh: HWR-PKH-2610-DEMO01"
                            required
                            autofocus
                            class="input-starline w-full font-mono uppercase text-xs sm:text-sm"
                        >
                        <button
                            type="submit"
                            class="btn-starline-primary shrink-0 text-xs font-bold"
                        >
                            <svg class="w-4 h-4 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Periksa Resi
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-2">
                        Kombinasi huruf dan angka kapital sesuai surat pemberitahuan dari dinas sosial atau PT Pos Indonesia.
                    </p>
                </div>
            </form>

            {{-- Demo Options --}}
            <div class="pt-6 mt-6 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-700 block mb-2.5">Pilih Data Simulasi untuk Menguji:</span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']) }}" class="p-3.5 rounded-xl border border-slate-200/80 bg-white/60 hover:bg-[#e6ff94] hover:text-slate-950 text-left transition-all group shadow-2xs">
                        <span class="block text-xs font-mono font-bold text-slate-900 group-hover:text-slate-950">HWR-PKH-2610-DEMO01</span>
                        <span class="block text-[11px] text-slate-500 group-hover:text-slate-800 mt-0.5">PKH &bull; Dalam Pengiriman</span>
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-BPNT-2610-DEMO02']) }}" class="p-3.5 rounded-xl border border-slate-200/80 bg-white/60 hover:bg-[#e6ff94] hover:text-slate-950 text-left transition-all group shadow-2xs">
                        <span class="block text-xs font-mono font-bold text-slate-900 group-hover:text-slate-950">HWR-BPNT-2610-DEMO02</span>
                        <span class="block text-[11px] text-slate-500 group-hover:text-slate-800 mt-0.5">BPNT &bull; Penjadwalan</span>
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO03']) }}" class="p-3.5 rounded-xl border border-slate-200/80 bg-white/60 hover:bg-[#e6ff94] hover:text-slate-950 text-left transition-all group shadow-2xs">
                        <span class="block text-xs font-mono font-bold text-slate-900 group-hover:text-slate-950">HWR-PKH-2610-DEMO03</span>
                        <span class="block text-[11px] text-slate-500 group-hover:text-slate-800 mt-0.5">PKH &bull; Selesai Diterima</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Privacy Notice --}}
        <div class="starline-card p-4 rounded-xl text-xs text-slate-600 space-y-1">
            <p class="font-bold text-slate-900">Kebijakan Privasi Nomor Induk Kependudukan (NIK)</p>
            <p class="text-[11px] leading-relaxed">
                Platform Kinerja tidak menyediakan fitur pencarian menggunakan NIK mentah secara terbuka. Hal ini bertujuan mencegah kebocoran informasi finansial dan profiling sepihak terhadap warga penerima bantuan sosial.
            </p>
        </div>
    </div>
</div>
@endsection
