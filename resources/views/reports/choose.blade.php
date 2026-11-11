@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-10 w-full">
    <div class="max-w-4xl space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Pilih Jalur
        </h1>
        <p class="text-xs text-slate-500">
            Kanal Pengaduan. Privasi Terjamin.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
        {{-- Card 1: Lapor Pungli --}}
        <div class="starline-card starline-card-hover p-5 sm:p-6 flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#e6ff94] text-slate-950 text-[11px] font-bold font-mono">
                        100% Anonim
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">Tanpa Identitas</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900 font-display">
                        Lapor Pungutan Liar &amp; Pemotongan Bansos
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Aduan Pemotongan
                    </p>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100">
                <a href="{{ route('report.extortion.create') }}" class="btn-starline-primary w-full text-center text-xs font-bold">
                    Lapor Pungli &rarr;
                </a>
            </div>
        </div>

        {{-- Card 2: Sanggah Penerima --}}
        <div class="starline-card starline-card-hover p-5 sm:p-6 flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-900 text-white text-[11px] font-bold font-mono">
                        Sanggah Data
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">Kelayakan Kuota</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900 font-display">
                        Sanggah Penerima Tidak Tepat Sasaran
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Sanggah Kelayakan
                    </p>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100">
                <a href="{{ route('report.dispute.create') }}" class="btn-starline-secondary w-full text-center text-xs font-bold">
                    Sanggah Penerima &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Already Have Ticket --}}
    <div class="starline-card p-4 rounded-xl text-center text-xs">
        <span class="text-slate-500">Punya nomor tiket?</span>
        <a href="{{ route('ticket.index') }}" class="font-bold text-slate-900 hover:underline ml-1">
            Cek Status &rarr;
        </a>
    </div>
</div>
    </div>
@endsection
