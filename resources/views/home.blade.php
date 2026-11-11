@extends('layouts.app')

@section('content')
<div class="space-y-8 py-6 sm:py-8 px-4 sm:px-6 lg:px-8 xl:px-10 max-w-[1680px] mx-auto w-full">
    {{-- Hero Section: Functional Command Center --}}
    <section>
        <div class="starline-card p-6 sm:p-8 rounded-2xl space-y-6">
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 font-display tracking-tight">
                    Bansos Adalah Hak Warga. Pastikan Sampai Utuh Tanpa Potongan.
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Transparansi Publik. Pengawasan Mandiri.
                </p>
            </div>

            {{-- Resi Search Box --}}
            <div x-data="{
                     receipt: '',
                     fillDemo(code) {
                         this.receipt = code;
                         $nextTick(() => { $refs.homeSearchForm.submit(); });
                     }
                 }">
                <form x-ref="homeSearchForm" action="{{ route('tracker.index') }}" method="GET" class="space-y-3">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                name="code"
                                x-model="receipt"
                                @input="receipt = receipt.toUpperCase()"
                                placeholder="Masukkan nomor resi resmi (contoh: HWR-PKH-2610-DEMO01)"
                                required
                                class="input-starline w-full font-mono uppercase text-xs sm:text-sm"
                            >
                        </div>
                        <button
                            type="submit"
                            class="btn-starline-primary text-xs font-bold"
                        >
                            <svg class="w-4 h-4 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Lacak Resi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Live Metric Strip --}}
    <section>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="starline-card p-4">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider font-mono block">Wilayah Pilot</span>
                <div class="text-2xl font-extrabold font-mono text-slate-900 mt-1 tabular-nums">{{ $stats['total_regions'] ?? 5 }}</div>
                <span class="text-[11px] text-slate-500">Jawa Tengah</span>
            </div>
            <div class="starline-card p-4">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider font-mono block">Penyaluran Aktif</span>
                <div class="text-2xl font-extrabold font-mono text-slate-900 mt-1 tabular-nums">{{ $stats['total_shipments'] ?? 3 }}</div>
                <span class="text-[11px] text-slate-500">Resi Tercatat</span>
            </div>
            <div class="starline-card p-4">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider font-mono block">Target SLA</span>
                <div class="text-2xl font-extrabold font-mono text-slate-900 mt-1 tabular-nums">72</div>
                <span class="text-[11px] text-slate-500">Jam Respon</span>
            </div>
            <div class="starline-card p-4">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider font-mono block">Jaminan Privasi</span>
                <div class="text-2xl font-extrabold font-mono text-emerald-800 mt-1 tabular-nums">100%</div>
                <span class="text-[11px] text-slate-500">Anonim Mutlak</span>
            </div>
        </div>
    </section>

    {{-- Live Data Modules: Anomali & Scorecard Side-by-Side --}}
    <section>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Widget 1: Anomali Wilayah Terkini --}}
            <div class="starline-card p-5 sm:p-6 rounded-2xl flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="text-[10px] font-mono font-bold text-slate-400 uppercase">Modul B</span>
                            <h2 class="text-base font-bold text-slate-900 font-display">Peta Anomali</h2>
                        </div>
                        <a href="{{ route('map.index') }}" class="text-xs font-bold text-slate-900 hover:underline">
                            Buka Peta &rarr;
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs">
                        @foreach($topAnomalies as $item)
                            <div class="py-2.5 flex items-center justify-between font-mono">
                                <div>
                                    <span class="font-sans font-bold text-slate-900">{{ $item->region_name }}</span>
                                    <span class="text-[11px] text-slate-400 block font-mono">Kuota: {{ number_format($item->quota_recipients, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-extrabold text-slate-900 block">{{ round((float) $item->relative_ratio, 2) }}x</span>
                                    <span class="text-[9px] font-bold font-sans px-2 py-0.5 rounded-full {{ $item->flag->badgeClass() }}">
                                        {{ $item->flag->value === 'under_coverage' ? 'Defisit' : ($item->flag->value === 'over_coverage' ? 'Surplus' : 'Normal') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-mono">
                    <span>Standar: Rasio vs Median</span>
                    <a href="{{ route('map.index') }}" class="font-bold text-slate-900 hover:underline">Selengkapnya</a>
                </div>
            </div>

            {{-- Widget 2: Scorecard SLA Terkini --}}
            <div class="starline-card p-5 sm:p-6 rounded-2xl flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="text-[10px] font-mono font-bold text-slate-400 uppercase">Modul D</span>
                            <h2 class="text-base font-bold text-slate-900 font-display">Scorecard SLA</h2>
                        </div>
                        <a href="{{ route('scorecard.index') }}" class="text-xs font-bold text-slate-900 hover:underline">
                            Leaderboard &rarr;
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs">
                        @foreach($topAgencies as $index => $agency)
                            <div class="py-2.5 flex items-center justify-between font-mono">
                                <div>
                                    <span class="font-sans font-bold text-slate-900">{{ $agency['agency_name'] }}</span>
                                    <span class="text-[11px] text-slate-400 block font-mono">Respon: {{ $agency['response_rate'] }}%</span>
                                </div>
                                <div class="text-right flex items-center gap-2">
                                    <span class="text-sm font-extrabold text-slate-900">{{ $agency['final_score'] }}</span>
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-bold text-[10px] border border-slate-300 bg-white font-sans">
                                        {{ $agency['grade'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-mono">
                    <span>Standar: 50% Respon + 50% Selesai</span>
                    <a href="{{ route('scorecard.index') }}" class="font-bold text-slate-900 hover:underline">Selengkapnya</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Quick Action Tiles --}}
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <a href="{{ route('tracker.index') }}" class="starline-card p-4 rounded-xl flex flex-col justify-between hover:border-slate-900 transition-all">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Lacak</span>
                    <h3 class="text-sm font-bold text-slate-900">Resi Bansos</h3>
                    <p class="text-xs text-slate-500">Cek Status Penyaluran</p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                    <span>Akses</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <a href="{{ route('map.index') }}" class="starline-card p-4 rounded-xl flex flex-col justify-between hover:border-slate-900 transition-all">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Peta</span>
                    <h3 class="text-sm font-bold text-slate-900">Peta Anomali</h3>
                    <p class="text-xs text-slate-500">Analisis Kuota Wilayah</p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                    <span>Akses</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <a href="{{ route('report.choose') }}" class="starline-card p-4 rounded-xl flex flex-col justify-between hover:border-slate-900 transition-all">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Lapor</span>
                    <h3 class="text-sm font-bold text-slate-900">Lapor Pungli</h3>
                    <p class="text-xs text-slate-500">100% Anonim Tanpa IP</p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                    <span>Akses</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <a href="{{ route('data.index') }}" class="starline-card p-4 rounded-xl flex flex-col justify-between hover:border-slate-900 transition-all">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Data</span>
                    <h3 class="text-sm font-bold text-slate-900">Data Terbuka</h3>
                    <p class="text-xs text-slate-500">Unduh Dataset CSV</p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                    <span>Akses</span>
                    <span>&rarr;</span>
                </div>
            </a>
        </div>
    </section>
</div>
@endsection
