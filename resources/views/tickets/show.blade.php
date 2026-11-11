@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('ticket.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-700 dark:text-slate-300 hover:underline font-semibold">
            &larr; Cari nomor tiket lain
        </a>
        @if($isAuthorized)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800 text-xs font-bold font-mono">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                Sesi Pelapor Terverifikasi
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold">
                Tampilan Status Publik
            </span>
        @endif
    </div>

    @if(!$report)
        <div class="starline-card p-8 sm:p-10 text-center space-y-4 rounded-2xl">
            <h1 class="text-xl font-bold text-slate-900 dark:text-white font-display">Tiket Tidak Ditemukan</h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                Nomor tiket <span class="font-mono font-bold">{{ $ticket }}</span> tidak terdaftar dalam sistem.
            </p>
            <div class="pt-2">
                <a href="{{ route('ticket.index') }}" class="btn-starline-primary text-xs font-bold">
                    Coba Nomor Tiket Lain
                </a>
            </div>
        </div>
    @else
        {{-- Status Header Card --}}
        <div class="starline-card p-6 rounded-2xl space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200/50 dark:border-slate-800 pb-4">
                <div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Nomor Tiket Aduan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white font-mono tracking-tight mt-0.5">
                        {{ $report->ticket_code }}
                    </h1>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-full px-3.5 py-1 text-xs font-bold border {{ $report->status->badgeClass() }}">
                        Status: {{ $report->status->label() }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs sm:text-sm">
                <div>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Jenis Laporan</span>
                    <span class="font-bold text-slate-900 dark:text-white">{{ $report->type->label() }}</span>
                </div>
                <div>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Wilayah Kejadian</span>
                    <span class="font-bold text-slate-900 dark:text-white">{{ $report->region->name }}</span>
                </div>
                <div>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Waktu Pengiriman</span>
                    <span class="font-bold text-slate-900 dark:text-white">{{ $report->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                </div>
            </div>
        </div>

        @if($isAuthorized)
            {{-- Authorized Full View --}}
            <div class="space-y-6">
                {{-- Detail Isi Aduan --}}
                <div class="starline-card p-6 rounded-2xl space-y-4">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Rincian Laporan Anda</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm bg-slate-50 dark:bg-slate-900/60 p-4 rounded-xl border border-slate-200/80 dark:border-slate-800">
                        <div>
                            <dt class="text-[11px] text-slate-500 dark:text-slate-400">Kategori</dt>
                            <dd class="font-bold text-slate-900 dark:text-white mt-0.5">{{ $report->category }}</dd>
                        </div>
                        @if($report->amount_claimed)
                        <div>
                            <dt class="text-[11px] text-slate-500 dark:text-slate-400">Nominal Pemotongan</dt>
                            <dd class="font-mono font-bold text-slate-900 dark:text-white mt-0.5 tabular-nums">{{ \App\Support\Money::format($report->amount_claimed) }}</dd>
                        </div>
                        @endif
                    </dl>
                    <div>
                        <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Uraian Kejadian:</h3>
                        <div class="rounded-xl bg-slate-50 dark:bg-slate-900/60 p-4 border border-slate-200/80 dark:border-slate-800 text-xs sm:text-sm text-slate-800 dark:text-slate-200 whitespace-pre-line leading-relaxed">
                            {{ $report->description }}
                        </div>
                    </div>
                </div>

                {{-- Riwayat Tindak Lanjut & Audit Trail --}}
                <div class="starline-card p-6 rounded-2xl space-y-4">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Riwayat Tindak Lanjut &amp; Tanggapan Staf</h2>
                    <div class="space-y-3">
                        @forelse($report->updates as $update)
                            <div class="border-l-2 border-slate-900 dark:border-[#e6ff94] pl-4 py-1 space-y-1">
                                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $update->status->label() }}</span>
                                    <span class="font-mono">{{ $update->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed">{{ $update->message }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 italic">Belum ada pembaruan dari petugas penelaah.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Form Kirim Tanggapan Tambahan --}}
                <div class="starline-card p-6 rounded-2xl space-y-4">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Kirim Tanggapan atau Bukti Tambahan</h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        Anda dapat menambahkan informasi susulan atau mengklarifikasi tanggapan staf melalui form di bawah ini.
                    </p>

                    @if(session('success'))
                        <div class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 shadow-2xs text-xs">
                            <div class="w-5 h-5 rounded-md bg-[#0f172a] text-[#e6ff94] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-medium text-slate-800 flex-1 leading-snug">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('ticket.reply', ['ticket' => $report->ticket_code]) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <textarea
                                name="message"
                                rows="3"
                                required
                                placeholder="Tuliskan keterangan tambahan atau jawaban atas tindak lanjut staf..."
                                class="input-starline w-full"
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="btn-starline-primary text-xs font-bold"
                        >
                            Kirim Keterangan Tambahan &rarr;
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Unauthorized: Secret Code Required --}}
            <div class="starline-card p-6 sm:p-8 space-y-5 rounded-2xl border-2 border-amber-300/80 dark:border-amber-700/80">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 flex items-center justify-center font-bold text-sm shrink-0">
                        !
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Buka Rincian Isi Laporan dengan Kode Rahasia</h2>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Demi melindungi data pelapor, isi aduan dan tanggapan lengkap dirahasiakan dari publik. Masukkan kode rahasia 12 karakter Anda untuk membuka interaksi penuh.
                        </p>
                    </div>
                </div>

                @if($errors->has('auth'))
                    <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-900 dark:text-rose-200 rounded-xl p-3.5 text-xs font-semibold">
                        {{ $errors->first('auth') }}
                    </div>
                @endif

                <form action="{{ route('ticket.access') }}" method="POST" class="flex flex-col sm:flex-row gap-2 pt-2">
                    @csrf
                    <input type="hidden" name="ticket_code" value="{{ $report->ticket_code }}">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="secret_code"
                            placeholder="Masukkan Kode Rahasia (Contoh: 4HX7-9K2M-P8Q3)"
                            required
                            class="input-starline w-full font-mono uppercase text-xs sm:text-sm"
                        >
                    </div>
                    <button
                        type="submit"
                        class="btn-starline-primary shrink-0 text-xs font-bold"
                    >
                        Buka Laporan
                    </button>
                </form>
            </div>
        @endif
    @endif
</div>
    </div>
@endsection
