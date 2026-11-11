@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 space-y-8 w-full">
    {{-- Header: Ultra Concise --}}
    <div class="space-y-1">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Metodologi &amp; Dataset Publik Kinerja
        </h1>
        <p class="text-xs text-slate-500">
            Keterbukaan Data. Formula Matematis.
        </p>
    </div>

    {{-- Interactive Calculators (Alpine.js) --}}
    <section class="starline-card p-6 rounded-2xl space-y-4">
        <div>
            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">
                Simulator Interaktif
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Calculator 1: Anomali Wilayah --}}
            <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50 space-y-3"
                 x-data="{
                     population: 1800000,
                     povertyPct: 12.84,
                     quota: 30000,
                     medianRatio: 0.13,
                     get poorEstimate() {
                         return Math.round((this.population * this.povertyPct) / 100);
                     },
                     get targetingRatio() {
                         return this.poorEstimate > 0 ? (this.quota / this.poorEstimate).toFixed(3) : 0;
                     },
                     get relativeRatio() {
                         return this.medianRatio > 0 ? (this.targetingRatio / this.medianRatio).toFixed(2) : 0;
                     },
                     get flag() {
                         const r = parseFloat(this.relativeRatio);
                         if (r < 0.5) return { label: 'Defisit Kuota', class: 'bg-amber-100 text-amber-900 border-amber-300' };
                         if (r > 1.5) return { label: 'Surplus Kuota', class: 'bg-indigo-100 text-indigo-900 border-indigo-300' };
                         return { label: 'Normal', class: 'bg-emerald-100 text-emerald-900 border-emerald-300' };
                     }
                 }">
                <div class="border-b border-slate-200 pb-2">
                    <h3 class="text-xs font-bold text-slate-900 font-display uppercase tracking-wider">Kalkulator Anomali</h3>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Populasi</label>
                        <input type="number" x-model.number="population" class="input-starline w-full text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kemiskinan (%)</label>
                        <input type="number" step="0.01" x-model.number="povertyPct" class="input-starline w-full text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kuota Bansos</label>
                        <input type="number" x-model.number="quota" class="input-starline w-full text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Median Rasio</label>
                        <input type="number" step="0.01" x-model.number="medianRatio" class="input-starline w-full text-xs font-mono">
                    </div>
                </div>

                <div class="bg-white p-3 rounded-lg border border-slate-200 space-y-1.5 text-xs font-mono">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Estimasi Miskin:</span>
                        <span class="font-bold text-slate-900" x-text="Number(poorEstimate).toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Rasio Sasaran:</span>
                        <span class="font-bold text-slate-900" x-text="targetingRatio"></span>
                    </div>
                    <div class="flex justify-between border-t border-slate-100 pt-1.5">
                        <span class="text-slate-500">Rasio Relatif:</span>
                        <span class="font-extrabold text-slate-900" x-text="relativeRatio + 'x'"></span>
                    </div>
                    <div class="pt-1 flex items-center justify-between font-sans">
                        <span class="text-[10px] text-slate-400">Status:</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border" :class="flag.class" x-text="flag.label"></span>
                    </div>
                </div>
            </div>

            {{-- Calculator 2: Skor SLA Instansi --}}
            <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50 space-y-3"
                 x-data="{
                     responseRate: 100,
                     resolveRate: 80,
                     get score() {
                         return ((0.5 * this.responseRate) + (0.5 * this.resolveRate)).toFixed(1);
                     },
                     get grade() {
                         const s = parseFloat(this.score);
                         if (s >= 85) return { grade: 'A', label: 'Sangat Baik', class: 'bg-emerald-100 text-emerald-900 border-emerald-300' };
                         if (s >= 70) return { grade: 'B', label: 'Baik', class: 'bg-blue-100 text-blue-900 border-blue-300' };
                         if (s >= 55) return { grade: 'C', label: 'Cukup', class: 'bg-amber-100 text-amber-900 border-amber-300' };
                         return { grade: 'D', label: 'Perlu Perhatian', class: 'bg-rose-100 text-rose-900 border-rose-300' };
                     }
                 }">
                <div class="border-b border-slate-200 pb-2">
                    <h3 class="text-xs font-bold text-slate-900 font-display uppercase tracking-wider">Kalkulator SLA</h3>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="font-semibold text-slate-700">Respon 72j</label>
                            <span class="font-mono font-bold" x-text="responseRate + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" step="1" x-model.number="responseRate" class="w-full accent-slate-900">
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="font-semibold text-slate-700">Selesai 14h</label>
                            <span class="font-mono font-bold" x-text="resolveRate + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" step="1" x-model.number="resolveRate" class="w-full accent-slate-900">
                    </div>
                </div>

                <div class="bg-white p-3 rounded-lg border border-slate-200 space-y-1.5 text-xs font-mono">
                    <div class="flex justify-between border-t border-slate-100 pt-1.5 items-center">
                        <span class="font-bold text-slate-900 font-sans">Skor Komposit:</span>
                        <span class="font-extrabold text-sm text-slate-900" x-text="score + ' / 100'"></span>
                    </div>
                    <div class="pt-1 flex items-center justify-between font-sans">
                        <span class="text-[10px] text-slate-400">Mutu:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border" :class="grade.class" x-text="'Nilai ' + grade.grade"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Dataset 01: Scorecard SLA --}}
    <section class="starline-card p-6 rounded-2xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase">Dataset 01</span>
                <h2 class="text-base font-bold text-slate-900 font-display">Scorecard SLA</h2>
            </div>
            <div>
                <a href="{{ route('data.export', ['dataset' => 'sla']) }}" class="btn-starline-primary text-xs font-bold">
                    Unduh CSV Scorecard SLA
                </a>
            </div>
        </div>

        {{-- Preview Table --}}
        <div>
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold font-mono text-[11px]">
                            <th class="py-2 px-3">Instansi</th>
                            <th class="py-2 px-3">Wilayah</th>
                            <th class="py-2 px-3 text-center">Total</th>
                            <th class="py-2 px-3 text-center">Respon</th>
                            <th class="py-2 px-3 text-center">Selesai</th>
                            <th class="py-2 px-3 text-center">Skor</th>
                            <th class="py-2 px-3 text-center">Mutu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono">
                        @foreach($slaPreview as $row)
                            <tr class="hover:bg-slate-50">
                                <td class="py-2 px-3 font-sans font-bold text-slate-900">{{ $row['agency_name'] }}</td>
                                <td class="py-2 px-3 font-sans text-slate-600">{{ $row['region_name'] }}</td>
                                <td class="py-2 px-3 text-center">{{ $row['total_reports'] }}</td>
                                <td class="py-2 px-3 text-center">{{ $row['response_rate'] }}%</td>
                                <td class="py-2 px-3 text-center">{{ $row['resolve_rate'] }}%</td>
                                <td class="py-2 px-3 text-center font-bold text-slate-900">{{ $row['final_score'] }}</td>
                                <td class="py-2 px-3 text-center font-bold">{{ $row['grade'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Dataset 02: Anomali Wilayah --}}
    <section class="starline-card p-6 rounded-2xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase">Dataset 02</span>
                <h2 class="text-base font-bold text-slate-900 font-display">Anomali Wilayah</h2>
            </div>
            <div>
                <a href="{{ route('data.export', ['dataset' => 'anomali']) }}" class="btn-starline-primary text-xs font-bold">
                    Unduh CSV Anomali Wilayah
                </a>
            </div>
        </div>

        {{-- Preview Table --}}
        <div>
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold font-mono text-[11px]">
                            <th class="py-2 px-3">Kode BPS</th>
                            <th class="py-2 px-3">Nama Wilayah</th>
                            <th class="py-2 px-3">Program</th>
                            <th class="py-2 px-3 text-right">Kuota</th>
                            <th class="py-2 px-3 text-right">Miskin</th>
                            <th class="py-2 px-3 text-right">Rasio</th>
                            <th class="py-2 px-3 text-right">Relatif</th>
                            <th class="py-2 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono">
                        @foreach($anomaliPreview as $row)
                            <tr class="hover:bg-slate-50">
                                <td class="py-2 px-3">{{ $row->bps_code }}</td>
                                <td class="py-2 px-3 font-sans font-bold text-slate-900">{{ $row->region_name }}</td>
                                <td class="py-2 px-3 font-sans">{{ $row->program_code }}</td>
                                <td class="py-2 px-3 text-right">{{ number_format($row->quota_recipients, 0, ',', '.') }}</td>
                                <td class="py-2 px-3 text-right">{{ number_format((int) $row->poor_estimate, 0, ',', '.') }}</td>
                                <td class="py-2 px-3 text-right">{{ round((float) $row->targeting_ratio, 3) }}</td>
                                <td class="py-2 px-3 text-right font-bold text-slate-900">{{ round((float) $row->relative_ratio, 2) }}x</td>
                                <td class="py-2 px-3 font-sans font-bold">{{ $row->flag->label() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Methodology Explanation --}}
    <section class="starline-card p-6 rounded-2xl space-y-3">
        <div>
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider">
                Rumus Analisis Anomali
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 font-mono text-xs text-slate-700 space-y-1">
                <p>poor_estimate = population &times; poverty_percent / 100</p>
                <p>targeting_ratio = quota_recipients &divide; poor_estimate</p>
                <p>relative_ratio = targeting_ratio &divide; median_ratio</p>
            </div>

            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 font-mono text-xs text-slate-700 space-y-1">
                <p>response_ok = (first_response_at - created_at) &le; 72 jam</p>
                <p>resolve_ok = (resolved_at - created_at) &le; 14 hari</p>
                <p class="font-bold text-slate-900">skor = (50% &times; response) + (50% &times; resolve)</p>
            </div>
        </div>
    </section>
</div>
@endsection
