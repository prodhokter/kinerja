@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-xl space-y-6">
        <div class="space-y-1">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Akses &amp; Pantau Tiket Laporan Warga
            </h1>
            <p class="text-xs text-slate-500">
                Masukkan nomor tiket dan kode rahasia 12 karakter yang Anda dapatkan saat mengirimkan laporan.
            </p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-xl p-3.5 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="starline-card p-6 sm:p-8 rounded-2xl shadow-xs">
            <form action="{{ route('ticket.access') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="lookup-ticket-code" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Nomor Tiket Laporan <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="lookup-ticket-code"
                        name="ticket_code"
                        value="{{ old('ticket_code') }}"
                        placeholder="Contoh: HWT-2026-7K3M9Q"
                        required
                        autofocus
                        class="input-starline w-full font-mono uppercase text-xs sm:text-sm"
                    >
                </div>

                <div>
                    <label for="lookup-secret-code" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Kode Rahasia Tiket <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="lookup-secret-code"
                        name="secret_code"
                        placeholder="Contoh: 4HX7-9K2M-P8Q3"
                        required
                        class="input-starline w-full font-mono uppercase text-xs sm:text-sm"
                    >
                    <p class="text-[11px] text-slate-500 mt-1">12 karakter huruf dan angka dengan tanda hubung.</p>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="btn-starline-primary w-full text-center text-xs font-bold"
                    >
                        Buka Rincian &amp; Tindak Lanjut Tiket &rarr;
                    </button>
                </div>
            </form>
        </div>

        {{-- Lost Secret Reassurance --}}
        <div class="starline-card p-4 rounded-xl text-xs text-slate-600 space-y-1">
            <p class="font-bold text-slate-900">Bagaimana jika kode rahasia hilang?</p>
            <p class="text-[11px] leading-relaxed">
                Demi prinsip privasi zero-knowledge, sistem tidak dapat memulihkan kode rahasia yang hilang. Anda tetap dapat melihat status kemajuan publik tanpa membaca isi aduan, atau mengirimkan laporan baru jika diperlukan.
            </p>
        </div>
    </div>
</div>
@endsection
