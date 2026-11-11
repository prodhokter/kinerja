@extends('layouts.app')

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-8 w-full">
    <div class="max-w-2xl space-y-6">
        <div class="space-y-1">
            <a href="{{ route('report.choose') }}" class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-slate-900 font-semibold mb-1">
                &larr; Kembali
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Form Laporan Pungutan Liar &amp; Pemotongan Bansos
            </h1>
            <p class="text-xs text-slate-500">
                Anonim Mutlak. Tanpa IP.
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

        @if(isset($prefillResi) && $prefillResi)
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex items-start gap-3 text-xs text-emerald-950 shadow-2xs">
                <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                    &check;
                </div>
                <div class="space-y-0.5 flex-1">
                    <span class="font-bold text-emerald-900 block">Laporan Terhubung dengan Resi Bansos: <code class="font-mono bg-white px-2 py-0.5 rounded border border-emerald-300">{{ $prefillResi }}</code></span>
                    <p class="text-emerald-800 text-[11px] leading-relaxed">
                        @if(isset($shipment) && $shipment)
                            Program: <strong>{{ $shipment->program->name }}</strong> &bull; Wilayah: <strong>{{ $shipment->beneficiary->region->name ?? 'Wilayah Terkait' }}</strong> &bull; Instansi: <strong>{{ $shipment->agency->name }}</strong>
                        @else
                            Nomor resi otomatis dicatat dalam rujukan laporan aduan Anda.
                        @endif
                    </p>
                </div>
            </div>
        @endif

        {{-- Multi-Step Wizard Form Container --}}
        <div class="starline-card p-5 sm:p-7 shadow-xs"
             x-data="{
                 currentStep: 1,
                 regionId: '{{ old('region_id', $prefillRegionId ?? '') }}',
                 regionName: '',
                 category: '{{ old('category', '') }}',
                 categoryName: '',
                 amount: '{{ old('amount_claimed', '') }}',
                 description: '{{ old('description', isset($prefillResi) && $prefillResi ? 'Laporan resi ' . $prefillResi . ': ' : '') }}',
                 init() {
                     const saved = sessionStorage.getItem('hw_draft_extortion');
                     if (saved && !this.description) {
                         this.description = saved;
                     }
                 },
                 updateDraft() {
                     sessionStorage.setItem('hw_draft_extortion', this.description);
                 },
                 goToStep2() {
                     if (!this.regionId) {
                         window.hwToast('Pilih wilayah kejadian.', true);
                         return;
                     }
                     if (!this.category) {
                         window.hwToast('Pilih bentuk pungutan.', true);
                         return;
                     }
                     const regEl = document.getElementById('region-select');
                     this.regionName = regEl.options[regEl.selectedIndex]?.text || '';
                     const catEl = document.getElementById('category-select');
                     this.categoryName = catEl.options[catEl.selectedIndex]?.text || '';
                     this.currentStep = 2;
                 },
                 goToStep3() {
                     if (!this.description || this.description.trim().length < 20) {
                         window.hwToast('Uraian minimal 20 karakter.', true);
                         return;
                     }
                     this.currentStep = 3;
                 }
             }">

            {{-- Wizard Progress Bar --}}
            <div class="mb-6 border-b border-slate-100 pb-4">
                <div class="flex items-center justify-between text-xs font-semibold">
                    <div class="flex items-center gap-1.5" :class="currentStep >= 1 ? 'text-slate-900 font-bold' : 'text-slate-400'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-mono"
                              :class="currentStep >= 1 ? 'bg-[#0f172a] text-[#e6ff94]' : 'bg-slate-200 text-slate-600'">1</span>
                        <span>Wilayah</span>
                    </div>
                    <div class="h-0.5 flex-1 mx-2 bg-slate-200" :class="currentStep >= 2 ? 'bg-slate-900' : ''"></div>
                    <div class="flex items-center gap-1.5" :class="currentStep >= 2 ? 'text-slate-900 font-bold' : 'text-slate-400'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-mono"
                              :class="currentStep >= 2 ? 'bg-[#0f172a] text-[#e6ff94]' : 'bg-slate-200 text-slate-600'">2</span>
                        <span>Uraian</span>
                    </div>
                    <div class="h-0.5 flex-1 mx-2 bg-slate-200" :class="currentStep >= 3 ? 'bg-slate-900' : ''"></div>
                    <div class="flex items-center gap-1.5" :class="currentStep === 3 ? 'text-slate-900 font-bold' : 'text-slate-400'">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-mono"
                              :class="currentStep === 3 ? 'bg-[#0f172a] text-[#e6ff94]' : 'bg-slate-200 text-slate-600'">3</span>
                        <span>Kirim</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('report.extortion.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="hidden" aria-hidden="true">
                    <label for="honeypot-field">Bot Field</label>
                    <input type="text" id="honeypot-field" name="honeypot" tabindex="-1" autocomplete="off">
                </div>

                {{-- STEP 1: Wilayah & Kategori Pungli --}}
                <div x-show="currentStep === 1" class="space-y-4">
                    <div>
                        <label for="region-select" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                            Wilayah Kejadian <span class="text-rose-600">*</span>
                        </label>
                        <select id="region-select" name="region_id" x-model="regionId" required class="input-starline w-full text-xs">
                            <option value="">Pilih Wilayah</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">
                                    {{ $region->name }} ({{ $region->level->label() }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="category-select" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                            Bentuk Pungli <span class="text-rose-600">*</span>
                        </label>
                        <select id="category-select" name="category" x-model="category" required class="input-starline w-full text-xs">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->value }}">
                                    {{ $category->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="button" @click="goToStep2()" class="btn-starline-primary text-xs font-bold">
                            Lanjut &rarr;
                        </button>
                    </div>
                </div>

                {{-- STEP 2: Nominal & Kronologi --}}
                <div x-show="currentStep === 2" x-cloak class="space-y-4">
                    <div>
                        <label for="amount-input" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                            Nominal Potongan (Rupiah, Opsional)
                        </label>
                        <input
                            type="number"
                            id="amount-input"
                            name="amount_claimed"
                            x-model="amount"
                            placeholder="Contoh: 50000"
                            min="0"
                            step="1000"
                            class="input-starline w-full font-mono text-xs"
                        >
                    </div>

                    <div>
                        <label for="description-input" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                            Uraian Kejadian <span class="text-rose-600">*</span>
                        </label>
                        <textarea
                            id="description-input"
                            name="description"
                            x-model="description"
                            @input="updateDraft()"
                            rows="5"
                            required
                            placeholder="Tuliskan uraian kejadian secara jelas..."
                            class="input-starline w-full text-xs"
                        ></textarea>
                        <div class="flex items-center justify-between text-[11px] text-slate-500 mt-1">
                            <span>Min. 20 karakter &bull; Terketik: <strong x-text="description.length"></strong></span>
                            <span class="text-emerald-700 font-semibold">&check; NIK &amp; HP disensor otomatis</span>
                        </div>
                    </div>

                    <div class="pt-2 flex items-center justify-between">
                        <button type="button" @click="currentStep = 1" class="btn-starline-ghost text-xs">
                            &larr; Kembali
                        </button>
                        <button type="button" @click="goToStep3()" class="btn-starline-primary text-xs font-bold">
                            Tinjau &rarr;
                        </button>
                    </div>
                </div>

                {{-- STEP 3: Konfirmasi & Kirim --}}
                <div x-show="currentStep === 3" x-cloak class="space-y-4">
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 space-y-2 text-xs">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Ringkasan Laporan</span>
                        <div class="space-y-1.5">
                            <div class="flex justify-between border-b border-slate-200 pb-1">
                                <span class="text-slate-500">Wilayah:</span>
                                <span class="font-bold text-slate-900" x-text="regionName"></span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200 pb-1">
                                <span class="text-slate-500">Bentuk Pungli:</span>
                                <span class="font-bold text-slate-900" x-text="categoryName"></span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200 pb-1" x-show="amount">
                                <span class="text-slate-500">Nominal:</span>
                                <span class="font-mono font-bold text-slate-900" x-text="'Rp' + Number(amount || 0).toLocaleString('id-ID')"></span>
                            </div>
                            <div class="pt-1">
                                <span class="text-slate-500 block mb-1">Uraian:</span>
                                <p class="text-slate-800 font-mono text-[11px] bg-white p-2.5 rounded-lg border border-slate-200" x-text="description"></p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex items-center justify-between">
                        <button type="button" @click="currentStep = 2" class="btn-starline-ghost text-xs">
                            &larr; Ubah
                        </button>
                        <button
                            type="submit"
                            class="btn-starline-primary text-xs font-bold"
                        >
                            Kirim Laporan &rarr;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
