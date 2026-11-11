@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-4xl space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Tentang Platform Kinerja
        </h1>
        <p class="text-xs text-slate-500">
            Perlindungan Data Pribadi. Kedaulatan Sistem.
        </p>
    </div>

    <div class="starline-card p-6 sm:p-8 rounded-2xl space-y-6">
        <div>
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider mb-2">1. Latar Belakang</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Bantuan sosial adalah hak warga negara. Kinerja menyediakan instrumen pelacakan resi, deteksi anomali kuota, dan kanal aduan mandiri bebas pungli.
            </p>
        </div>

        <div class="border-t border-slate-100 pt-5">
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider mb-2">2. Kepatuhan Privasi UU PDP</h2>
            <p class="text-xs text-slate-600 leading-relaxed mb-2">
                Sesuai amanat Undang-Undang Nomor 27 Tahun 2022:
            </p>
            <ul class="list-disc pl-5 space-y-1 text-xs text-slate-600">
                <li>Sistem tidak pernah mencatat atau menampilkan NIK mentah.</li>
                <li>Verifikasi menggunakan enkripsi satu arah HMAC-SHA256 ber-pepper rahasia.</li>
                <li>Nama dan alamat penerima disamarkan secara otomatis.</li>
                <li>Laporan aduan pungli beroperasi 100% anonim tanpa pencatatan IP.</li>
            </ul>
        </div>

        <div class="border-t border-slate-100 pt-5">
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider mb-2">3. Arsitektur Mandiri</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Sistem 100% independen tanpa vendor lock-in, berjalan di server mandiri Ubuntu VPS dengan basis data PostgreSQL 16.
            </p>
        </div>
    </div>
</div>
    </div>
@endsection
