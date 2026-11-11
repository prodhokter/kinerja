@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 space-y-6 w-full">
    <div>
        <a href="{{ route('scorecard.index') }}" class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-slate-900 font-semibold mb-2">
            &larr; Kembali
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs text-slate-400 font-medium">{{ $details['agency_type'] }} &bull; {{ $details['region_name'] }}</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display mt-0.5">
                    {{ $details['agency_name'] }}
                </h1>
            </div>
            <div>
                @php
                    $gradeBadge = match($details['grade']) {
                        'A' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                        'B' => 'bg-blue-100 text-blue-900 border-blue-300',
                        'C' => 'bg-amber-100 text-amber-900 border-amber-300',
                        default => 'bg-rose-100 text-rose-900 border-rose-300',
                    };
                @endphp
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold border {{ $gradeBadge }} font-mono">
                    Nilai Mutu {{ $details['grade'] }} (Skor: {{ $details['final_score'] }})
                </span>
            </div>
        </div>
    </div>

    {{-- Performance Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Aduan Terdistribusi</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1 tabular-nums">{{ $details['total_reports'] }}</div>
            <span class="text-[10px] text-slate-400">{{ $details['due_response_count'] }} Jatuh Tempo</span>
        </div>

        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kepatuhan Respon Awal</span>
            <div class="text-2xl font-bold font-mono text-emerald-800 mt-1 tabular-nums">{{ $details['response_rate'] }}%</div>
            <span class="text-[10px] text-slate-400">{{ $details['response_ok_count'] }} Tepat Waktu</span>
        </div>

        <div class="starline-card p-4">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kepatuhan Selesai</span>
            <div class="text-2xl font-bold font-mono text-emerald-800 mt-1 tabular-nums">{{ $details['resolve_rate'] }}%</div>
            <span class="text-[10px] text-slate-400">{{ $details['resolve_ok_count'] }} Tuntas</span>
        </div>
    </div>

    {{-- Recent Reports Audit --}}
    <div class="starline-card p-5 rounded-2xl shadow-xs space-y-3">
        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">Daftar Aduan</h2>
        <div class="divide-y divide-slate-100 font-mono text-xs">
            @forelse($reports as $report)
                <div class="py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-900">{{ $report->ticket_code }}</span>
                            <span class="text-slate-400 font-sans">&bull; {{ $report->category }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 font-sans">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $report->status->badgeClass() }}">
                            {{ $report->status->label() }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-3 text-center font-sans">Belum ada aduan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
