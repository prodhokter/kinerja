@extends('layouts.app', ['title' => 'Ketentuan Layanan'])

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-4xl space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Ketentuan Layanan Kinerja
        </h1>
        <p class="text-xs text-slate-500">
            Pedoman Hak, Kewajiban, dan Penggunaan Platform Akuntabilitas Publik.
        </p>
    </div>

    <div class="starline-card p-6 sm:p-8 rounded-2xl space-y-6 bg-white/95 backdrop-blur-xl border border-slate-200/80">
        <div>
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider mb-2">1. Prinsip Penggunaan</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Platform Kinerja disediakan untuk transparansi bantuan sosial dan pemenuhan hak warga. Pengguna berhak mengakses pelacakan resi, peta anomali wilayah, dan pengawasan scorecard instansi secara terbuka dan bertanggung jawab.
            </p>
        </div>

        <div class="border-t border-slate-100 pt-5">
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider mb-2">2. Integritas Laporan dan Sanggah</h2>
            <p class="text-xs text-slate-600 leading-relaxed mb-2">
                Setiap laporan dugaan pungutan liar (pungli) atau sanggahan kelayakan kuota bansos wajib didasarkan pada kejadian nyata dan iktikad baik:
            </p>
            <ul class="list-disc pl-5 space-y-1 text-xs text-slate-600">
                <li>Dilarang mengirimkan laporan palsu, fitnah, atau muatan yang melanggar hukum.</li>
                <li>Identitas pelapor pungli dijaga secara anonim tanpa pencatatan alamat IP sesuai UU PDP.</li>
                <li>Kode tiket dan kode verifikasi rahasia adalah tanggung jawab pemilik tiket.</li>
            </ul>
        </div>

        <div class="border-t border-slate-100 pt-5">
            <h2 class="text-sm font-bold text-slate-900 font-display uppercase tracking-wider mb-2">3. Batasan Tanggung Jawab</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Data penyaluran dan statistik anomali disajikan berdasarkan agregasi data publik terbuka untuk tujuan pengawasan sosial masyarakat. Kinerja beroperasi sebagai platform transparansi independen mandiri.
            </p>
        </div>
    </div>
</div>
    </div>
@endsection
