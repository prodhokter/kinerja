@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 space-y-8 w-full"
     x-data="{
         searchQuery: '',
         typeFilter: 'all',
         expandedRow: null,
         sortBy: 'score',
         sortDir: 'desc',
         toggleExpand(id) {
             this.expandedRow = this.expandedRow === id ? null : id;
         }
     }">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Scorecard SLA Instansi Penyalur Bansos
            </h1>
            <p class="text-xs text-slate-500">
                Peringkat Kepatuhan. Standar 72 Jam &amp; 14 Hari.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('data.export', ['dataset' => 'sla']) }}" class="btn-starline-ghost text-xs font-bold">
                <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh CSV
            </a>
        </div>
    </div>

    {{-- Top Summary Cards --}}
    @php
        $avgScore = $scorecard->count() > 0 ? round($scorecard->avg('final_score'), 1) : 0;
        $bestAgency = $scorecard->first();
        $attentionAgency = $scorecard->last();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Rata-rata Skor</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1 tabular-nums">{{ $avgScore }}</div>
            <span class="text-[10px] text-slate-400">Standar 50:50</span>
        </div>

        @if($bestAgency)
        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Peringkat 1</span>
            <div class="text-sm font-bold text-slate-900 mt-1 line-clamp-1 font-display">{{ $bestAgency['agency_name'] }}</div>
            <span class="text-[10px] font-mono text-slate-600 font-semibold">Skor: {{ $bestAgency['final_score'] }} (Nilai {{ $bestAgency['grade'] }})</span>
        </div>
        @endif

        @if($attentionAgency)
        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Perlu Perhatian</span>
            <div class="text-sm font-bold text-slate-900 mt-1 line-clamp-1 font-display">{{ $attentionAgency['agency_name'] }}</div>
            <span class="text-[10px] font-mono text-slate-600 font-semibold">Respon: {{ $attentionAgency['response_rate'] }}%</span>
        </div>
        @endif
    </div>

    {{-- Interactive Benchmark Chart --}}
    <div class="starline-card p-5 sm:p-6 shadow-xs space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-xs font-bold text-slate-900 font-display uppercase tracking-wider">Benchmark SLA</h2>
                <span class="text-[11px] text-slate-500">Target Standar 100%</span>
            </div>
        </div>
        <div class="h-[260px] w-full pt-1">
            <canvas id="sla-benchmark-chart"></canvas>
        </div>
    </div>

    {{-- Filter & Search Controls --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-xs">
            <input
                type="text"
                x-model="searchQuery"
                placeholder="Cari instansi..."
                class="input-starline w-full text-xs"
            >
        </div>

        <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-full border border-slate-200">
            <button
                type="button"
                @click="typeFilter = 'all'"
                :class="typeFilter === 'all' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
            >
                Semua Tipe
            </button>
            <button
                type="button"
                @click="typeFilter = 'Dinas Sosial'"
                :class="typeFilter === 'Dinas Sosial' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
            >
                Dinas Sosial
            </button>
            <button
                type="button"
                @click="typeFilter = 'Penyalur'"
                :class="typeFilter === 'Penyalur' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
            >
                Penyalur Resmi
            </button>
        </div>
    </div>

    {{-- Scorecard Table --}}
    <div class="starline-card rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider font-mono">
                        <th class="py-3 px-3 w-16 text-center">Pos</th>
                        <th class="py-3 px-3">Instansi Penyalur</th>
                        <th class="py-3 px-3">Wilayah</th>
                        <th class="py-3 px-3 text-center">Respon 72j</th>
                        <th class="py-3 px-3 text-center">Selesai 14h</th>
                        <th class="py-3 px-3 text-center">Skor SLA</th>
                        <th class="py-3 px-3 text-center">Mutu</th>
                        <th class="py-3 px-3 text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($scorecard as $index => $row)
                        @php
                            $gradeBadge = match($row['grade']) {
                                'A' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                                'B' => 'bg-blue-100 text-blue-900 border-blue-300',
                                'C' => 'bg-amber-100 text-amber-900 border-amber-300',
                                default => 'bg-rose-100 text-rose-900 border-rose-300',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors"
                            x-show="(typeFilter === 'all' || '{{ $row['agency_type'] }}'.includes(typeFilter)) && ('{{ strtolower($row['agency_name']) }}'.includes(searchQuery.toLowerCase()))">
                            <td class="py-3 px-3 font-bold text-center text-slate-900">
                                #{{ $index + 1 }}
                            </td>
                            <td class="py-3 px-3 font-sans font-bold text-slate-900">
                                <a href="{{ route('scorecard.show', ['agency' => $row['agency_slug']]) }}" class="hover:underline">
                                    {{ $row['agency_name'] }}
                                </a>
                            </td>
                            <td class="py-3 px-3 font-sans text-slate-600">
                                {{ $row['region_name'] }}
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="font-bold {{ $row['response_rate'] >= 80 ? 'text-emerald-800' : 'text-slate-700' }}">
                                    {{ $row['response_rate'] }}%
                                </span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="font-bold {{ $row['resolve_rate'] >= 80 ? 'text-emerald-800' : 'text-slate-700' }}">
                                    {{ $row['resolve_rate'] }}%
                                </span>
                            </td>
                            <td class="py-3 px-3 text-center font-extrabold text-sm text-slate-900 tabular-nums">
                                {{ $row['final_score'] }}
                            </td>
                            <td class="py-3 px-3 text-center font-sans">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-bold text-xs border {{ $gradeBadge }}">
                                    {{ $row['grade'] }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right font-sans">
                                <button type="button" @click="toggleExpand({{ $row['agency_id'] }})" class="text-xs font-semibold text-slate-700 hover:text-slate-950 underline cursor-pointer">
                                    <span x-text="expandedRow === {{ $row['agency_id'] }} ? 'Tutup' : 'Rumus'"></span>
                                </button>
                            </td>
                        </tr>

                        <tr x-show="expandedRow === {{ $row['agency_id'] }}" x-cloak class="bg-slate-50 border-t border-b border-slate-200">
                            <td colspan="8" class="p-3 font-mono text-[11px] text-slate-600 space-y-1">
                                <div>Formula: (50% &times; Respon {{ $row['response_rate'] }}%) + (50% &times; Selesai {{ $row['resolve_rate'] }}%) = <strong class="text-slate-900">{{ $row['final_score'] }}</strong></div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 text-center text-slate-400 font-sans">
                                Belum Ada Data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Methodology Explanation Callout --}}
    <div class="starline-card p-5 rounded-2xl space-y-2">
        <h2 class="text-xs font-bold text-slate-900 font-display uppercase tracking-wider">Target 72 Jam Respon Awal</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs text-slate-600">
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                <p class="font-bold text-slate-900 mb-0.5">Respon 72 Jam (50%)</p>
                <p class="text-[11px]">Tindak Lanjut Cepat</p>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                <p class="font-bold text-slate-900 mb-0.5">Selesai 14 Hari (50%)</p>
                <p class="text-[11px]">Penanganan Tuntas</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.hwSlaData = [
        @foreach($scorecard as $row)
        {
            name: "{{ addslashes($row['agency_name']) }}",
            responseRate: {{ $row['response_rate'] }},
            resolveRate: {{ $row['resolve_rate'] }}
        },
        @endforeach
    ];
</script>
@vite(['resources/js/charts.js'])
@endpush
@endsection
