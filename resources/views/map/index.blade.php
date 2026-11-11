@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 space-y-8 w-full">
    {{-- Header: Ultra Concise --}}
    <div class="space-y-1">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Peta Anomali &amp; Rasio Alokasi Bantuan Sosial
        </h1>
        <p class="text-xs text-slate-500">
            Analisis Spasial Kuota Bansos
        </p>
    </div>

    {{-- Metric Strip: Concise --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Wilayah Terpantau</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1 tabular-nums">{{ $anomalies->count() }}</div>
            <span class="text-[10px] text-slate-400">Wilayah Pilot</span>
        </div>

        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Potensi Defisit (Under-Coverage)</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1 tabular-nums">{{ $underCount }}</div>
            <span class="text-[10px] text-slate-400">Defisit Kuota</span>
        </div>

        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Potensi Kelebihan Kuota (Over-Coverage)</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1 tabular-nums">{{ $overCount }}</div>
            <span class="text-[10px] text-slate-400">Surplus Kuota</span>
        </div>

        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Alokasi Proporsional</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1 tabular-nums">{{ $normalCount }}</div>
            <span class="text-[10px] text-slate-400">Normal</span>
        </div>
    </div>

    {{-- Interactive Map & Doughnut Section --}}
    <div class="starline-card p-5 sm:p-6 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider">Peta Interaktif</h2>
                <span class="text-[11px] text-slate-500">Pilih Wilayah</span>
            </div>

            {{-- Segmented Control Filter --}}
            <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-full border border-slate-200" x-data="{ activeFilter: 'all' }">
                <button
                    type="button"
                    @click="activeFilter = 'all'; if (window.hwFilterMap) window.hwFilterMap('all')"
                    :class="activeFilter === 'all' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                    class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
                >
                    Semua
                </button>
                <button
                    type="button"
                    @click="activeFilter = 'under_coverage'; if (window.hwFilterMap) window.hwFilterMap('under_coverage')"
                    :class="activeFilter === 'under_coverage' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                    class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
                >
                    Defisit ({{ $underCount }})
                </button>
                <button
                    type="button"
                    @click="activeFilter = 'over_coverage'; if (window.hwFilterMap) window.hwFilterMap('over_coverage')"
                    :class="activeFilter === 'over_coverage' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                    class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
                >
                    Surplus ({{ $overCount }})
                </button>
                <button
                    type="button"
                    @click="activeFilter = 'normal'; if (window.hwFilterMap) window.hwFilterMap('normal')"
                    :class="activeFilter === 'normal' ? 'bg-[#0f172a] text-[#e6ff94] font-bold shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                    class="px-3 py-1 text-xs rounded-full transition-all cursor-pointer"
                >
                    Normal ({{ $normalCount }})
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- MapLibre Container --}}
            <div class="lg:col-span-2 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 relative min-h-[380px]">
                <div id="maplibre-container" class="w-full h-[380px]"></div>
                <div class="absolute bottom-2 left-2 bg-white/90 px-2.5 py-1 rounded-md text-[10px] font-mono text-slate-500 border border-slate-200 pointer-events-none">
                    MapLibre Offline &bull; GeoJSON Mandiri
                </div>
            </div>

            {{-- Doughnut Chart & Legend --}}
            <div class="flex flex-col justify-between border border-slate-200 rounded-xl p-4 bg-slate-50/50">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2 font-display">
                        Proporsi Anomali
                    </h3>
                    <div class="h-[220px] relative">
                        <canvas id="anomaly-doughnut-chart"></canvas>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-3 text-[11px] space-y-1.5 text-slate-600">
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Defisit Kuota:</span>
                        <span class="font-bold font-mono">{{ $underCount }} Wilayah</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Surplus Kuota:</span>
                        <span class="font-bold font-mono">{{ $overCount }} Wilayah</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Proporsional:</span>
                        <span class="font-bold font-mono">{{ $normalCount }} Wilayah</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Regional Cards Strip --}}
    <div class="space-y-3">
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Daftar Wilayah</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach($anomalies as $anomaly)
                <div id="region-card-{{ $anomaly->bps_code }}"
                     data-flag="{{ $anomaly->flag->value }}"
                     class="hw-region-item starline-card p-3.5 flex flex-col justify-between space-y-2.5 border-slate-200 bg-white cursor-pointer hover:border-slate-900 transition-all"
                     onclick="if (window.hwFocusRegion) window.hwFocusRegion('{{ $anomaly->bps_code }}')">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-mono text-slate-400">{{ $anomaly->bps_code }}</span>
                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full {{ $anomaly->flag->badgeClass() }}">
                                {{ $anomaly->flag->value === 'under_coverage' ? 'Defisit' : ($anomaly->flag->value === 'over_coverage' ? 'Surplus' : 'Normal') }}
                            </span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900 font-display mt-1">{{ $anomaly->region_name }}</h3>
                    </div>

                    <div class="space-y-1 text-[11px] border-t border-slate-200/60 pt-2 font-mono">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kuota:</span>
                            <span class="font-bold text-slate-900">{{ number_format($anomaly->quota_recipients, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Miskin:</span>
                            <span class="font-bold text-slate-900">{{ number_format((int) $anomaly->poor_estimate, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between pt-1 text-[10px] border-t border-slate-100">
                            <span class="text-slate-400">Rasio Relatif:</span>
                            <span class="font-extrabold text-slate-900">{{ round((float) $anomaly->relative_ratio, 2) }}x</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Accessible Red-Flag Table (Mandatory Alternative) --}}
    <div class="starline-card p-6 shadow-xs space-y-3">
        <div>
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider">Tabel Rincian Anomali Wilayah</h2>
            <p class="text-[11px] text-slate-500">
                Alternatif Aksesibel
            </p>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-[11px] text-slate-500 uppercase tracking-wider bg-slate-50 font-semibold font-mono">
                        <th class="py-2.5 px-3">Kode BPS</th>
                        <th class="py-2.5 px-3">Nama Wilayah</th>
                        <th class="py-2.5 px-3">Program</th>
                        <th class="py-2.5 px-3 text-right">Kuota Bansos</th>
                        <th class="py-2.5 px-3 text-right">Estimasi Miskin</th>
                        <th class="py-2.5 px-3 text-right">Rasio Sasaran</th>
                        <th class="py-2.5 px-3 text-right">Rasio Relatif</th>
                        <th class="py-2.5 px-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @foreach($anomalies as $row)
                        <tr id="region-row-{{ $row->bps_code }}"
                            data-flag="{{ $row->flag->value }}"
                            class="hw-table-row hover:bg-slate-50 transition-colors cursor-pointer"
                            onclick="if (window.hwFocusRegion) window.hwFocusRegion('{{ $row->bps_code }}')">
                            <td class="py-2.5 px-3 text-slate-500">{{ $row->bps_code }}</td>
                            <td class="py-2.5 px-3 font-sans font-bold text-slate-900">{{ $row->region_name }}</td>
                            <td class="py-2.5 px-3 font-sans text-slate-700">{{ $row->program_code }}</td>
                            <td class="py-2.5 px-3 text-right text-slate-800">{{ number_format($row->quota_recipients, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-3 text-right text-slate-800">{{ number_format((int) $row->poor_estimate, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-3 text-right font-bold text-slate-900">{{ round((float) $row->targeting_ratio, 3) }}</td>
                            <td class="py-2.5 px-3 text-right font-extrabold text-slate-900">{{ round((float) $row->relative_ratio, 2) }}x</td>
                            <td class="py-2.5 px-3 font-sans">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $row->flag->badgeClass() }}">
                                    {{ $row->flag->label() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.hwAnomalyCounts = {
        under: {{ $underCount }},
        normal: {{ $normalCount }},
        over: {{ $overCount }}
    };
</script>
@vite(['resources/js/map.js', 'resources/js/charts.js'])
@endpush
@endsection
