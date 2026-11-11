@extends('layouts.app', ['title' => 'Verifikasi Kode'])

@section('content')
<div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 py-12 sm:py-16 w-full">
    <div class="max-w-md">
    <div class="starline-card p-6 sm:p-8 bg-white/95 backdrop-blur-xl border border-slate-200/90 shadow-sm rounded-3xl"
         x-data="{
             digits: ['', '', '', '', '', ''],
             cooldown: 60,
             init() {
                 this.$nextTick(() => {
                     const first = document.getElementById('digit-0');
                     if (first) first.focus();
                 });
                 const timer = setInterval(() => {
                     if (this.cooldown > 0) {
                         this.cooldown--;
                     } else {
                         clearInterval(timer);
                     }
                 }, 1000);
             },
             handleInput(index, event) {
                 const val = event.target.value.replace(/[^0-9]/g, '');
                 this.digits[index] = val ? val.slice(-1) : '';
                 if (this.digits[index] && index < 5) {
                     const next = document.getElementById('digit-' + (index + 1));
                     if (next) next.focus();
                 }
                 if (this.digits.every(d => d !== '')) {
                     this.$refs.otpForm.submit();
                 }
             },
             handleKeydown(index, event) {
                 if (event.key === 'Backspace' && !this.digits[index] && index > 0) {
                     const prev = document.getElementById('digit-' + (index - 1));
                     if (prev) {
                         prev.focus();
                         this.digits[index - 1] = '';
                     }
                 }
             },
             handlePaste(event) {
                 event.preventDefault();
                 const text = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                 if (text) {
                     for (let i = 0; i < 6; i++) {
                         this.digits[i] = text[i] || '';
                     }
                     const focusIdx = Math.min(text.length, 5);
                     const el = document.getElementById('digit-' + focusIdx);
                     if (el) el.focus();
                     if (this.digits.every(d => d !== '')) {
                         this.$refs.otpForm.submit();
                     }
                 }
             }
         }">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-[#0f172a] text-[#e6ff94] mb-3 shadow-xs">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-display tracking-tight">Verifikasi Kode</h1>
            <div class="mt-2 flex flex-col items-center justify-center gap-1.5 text-xs text-slate-500">
                <span>Kode verifikasi telah dikirim ke</span>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-800 font-mono font-medium text-[11px]">
                    <span class="truncate max-w-[220px]">{{ $email }}</span>
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-slate-900 transition-colors font-sans text-[10px] font-bold underline" title="Ganti alamat surel">
                        Ganti
                    </a>
                </div>
            </div>
        </div>

        {{-- Error message if verification fails --}}
        @if(session('error'))
            <div class="mb-5 p-3 rounded-2xl bg-rose-50 border border-rose-200/80 text-xs text-rose-700 font-medium flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Local development debug helper --}}
        @if(session('dev_otp'))
            <div class="mb-5 p-3 rounded-2xl bg-[#e6ff94]/60 border border-[#c2e050] text-xs text-slate-900 font-mono text-center">
                Kode OTP lokal: <strong>{{ session('dev_otp') }}</strong>
            </div>
        @endif

        {{-- Verification Form --}}
        <form x-ref="otpForm" action="{{ route('auth.otp.check') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="otp" :value="digits.join('')">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-3 text-center uppercase tracking-wider font-mono">
                    Masukkan 6 Digit
                </label>

                {{-- 6-Box Segmented Inputs (Horizontal Flex Row) --}}
                <div class="flex items-center justify-center gap-2 sm:gap-2.5 max-w-xs mx-auto" @paste="handlePaste($event)">
                    @for($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            id="digit-{{ $i }}"
                            inputmode="numeric"
                            maxlength="1"
                            x-model="digits[{{ $i }}]"
                            @input="handleInput({{ $i }}, $event)"
                            @keydown="handleKeydown({{ $i }}, $event)"
                            class="text-center font-mono text-xl sm:text-2xl font-extrabold text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-slate-900 focus:bg-white focus:ring-2 focus:ring-slate-900/10 transition-all select-all shadow-2xs shrink-0"
                            style="width: 42px; height: 52px;"
                        >
                    @endfor
                </div>

                @error('otp')
                    <p class="text-[11px] text-rose-600 mt-2 font-medium text-center">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full btn-starline-primary text-xs font-bold py-3.5"
            >
                Verifikasi &amp; Masuk
            </button>
        </form>

        {{-- Resend Footer with Countdown Timer --}}
        <div class="mt-8 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            <template x-if="cooldown > 0">
                <p class="text-slate-400 font-mono text-[11px]">
                    Kirim ulang kode dalam <span class="font-bold text-slate-700 tabular-nums" x-text="cooldown"></span> detik
                </p>
            </template>
            <template x-if="cooldown === 0">
                <form action="{{ route('auth.otp.send') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" class="font-bold text-slate-800 hover:text-slate-950 underline cursor-pointer text-xs transition-colors">
                        Kirim ulang kode OTP
                    </button>
                </form>
            </template>
        </div>
    </div>
</div>
    </div>
@endsection
