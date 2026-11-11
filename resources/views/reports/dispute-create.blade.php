@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-2xl space-y-6">
        <div class="space-y-1">
            <a href="{{ route('report.choose') }}" class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-slate-900 font-semibold mb-1">
                &larr; Kembali
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Form Sanggah Kelayakan Penerima Bantuan Sosial
            </h1>
            <p class="text-xs text-slate-500">
                Sanggah Kelayakan. Verifikasi Data.
            </p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-xl p-3.5 text-xs space-y-1">
                <p class="font-bold">Periksa Kembali:</p>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="starline-card p-5 sm:p-7 shadow-xs"
             x-data="{
                 desc: '{{ old('description', '') }}',
                 init() {
                     const draft = sessionStorage.getItem('hw_draft_dispute');
                     if (draft && !this.desc) this.desc = draft;
                 },
                 saveDraft() {
                     sessionStorage.setItem('hw_draft_dispute', this.desc);
                 }
             }">
            <form action="{{ route('report.dispute.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Honeypot anti-bot --}}
                <div class="hidden" aria-hidden="true">
                    <label for="honeypot-dispute">Bot Field</label>
                    <input type="text" id="honeypot-dispute" name="honeypot" tabindex="-1" autocomplete="off">
                </div>

                {{-- Wilayah --}}
                <div>
                    <label for="region-select-dispute" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Wilayah Penerima <span class="text-rose-600">*</span>
                    </label>
                    <select id="region-select-dispute" name="region_id" required class="input-starline w-full text-xs">
                        <option value="">Pilih Kelurahan/Desa</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }} ({{ $region->level->label() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Program Bansos --}}
                <div>
                    <label for="program-select" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Program Bansos <span class="text-rose-600">*</span>
                    </label>
                    <select id="program-select" name="program_id" required class="input-starline w-full text-xs">
                        <option value="">Pilih Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->name }} ({{ $program->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alasan Sanggah --}}
                <div>
                    <label for="category-select-dispute" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Alasan Sanggah <span class="text-rose-600">*</span>
                    </label>
                    <select id="category-select-dispute" name="category" required class="input-starline w-full text-xs">
                        <option value="">Pilih Alasan</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->value }}" {{ old('category') == $category->value ? 'selected' : '' }}>
                                {{ $category->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Pihak yang Disanggah --}}
                <div>
                    <label for="target-name-input" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Nama Warga yang Disanggah <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="target-name-input"
                        name="target_beneficiary_name"
                        value="{{ old('target_beneficiary_name') }}"
                        placeholder="Contoh: Budi Santoso"
                        required
                        class="input-starline w-full text-xs"
                    >
                </div>

                {{-- Uraian Sanggahan --}}
                <div>
                    <label for="dispute-description-input" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                        Uraian Fakta <span class="text-rose-600">*</span>
                    </label>
                    <textarea
                        id="dispute-description-input"
                        name="description"
                        x-model="desc"
                        @input="saveDraft()"
                        rows="4"
                        required
                        placeholder="Tuliskan uraian kondisi ekonomi atau alasan sanggahan..."
                        class="input-starline w-full text-xs"
                    ></textarea>
                    <div class="flex items-center justify-between text-[11px] text-slate-500 mt-1">
                        <span>Min. 20 karakter &bull; Terketik: <strong x-text="desc.length"></strong></span>
                        <span class="text-emerald-700 font-semibold">&check; NIK &amp; HP disensor</span>
                    </div>
                </div>

                {{-- Submit CTA --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        class="btn-starline-primary w-full text-center text-xs font-bold"
                    >
                        Kirim Sanggahan &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
