<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    {{-- Google Analytics (gtag.js) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4ZSEEXLMBN"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-4ZSEEXLMBN');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - Kinerja' : 'Masuk Akun - Kinerja' }}</title>
    <meta name="description" content="Masuk ke platform Kinerja: Transparansi Bantuan Sosial Indonesia untuk Masyarakat dan Administrator.">
    <meta name="robots" content="index, follow">
    <meta name="application-name" content="Kinerja">
    <meta name="apple-mobile-web-app-title" content="Kinerja">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ isset($title) ? $title . ' - Kinerja' : 'Masuk Akun - Kinerja' }}">
    <meta property="og:description" content="Masuk ke platform Kinerja untuk memantau resi bansos, sanggah penerima, dan kawal transparansi publik.">
    <meta property="og:image" content="{{ asset('og-image.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="Kinerja - Platform Transparansi Bantuan Sosial Indonesia">
    <meta property="og:site_name" content="Kinerja">
    <meta property="og:locale" content="id_ID">

    <meta name="theme-color" content="#0f172a">
    <meta name="msapplication-TileColor" content="#0f172a">

    <link rel="icon" href="/favicon.ico?v=3" sizes="48x48">
    <link rel="icon" href="/favicon.svg?v=3" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png?v=3">
    <link rel="manifest" href="/site.webmanifest?v=3">

    {{-- Primary Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Geist+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full bg-slate-50 text-slate-900 antialiased font-sans selection:bg-[#e6ff94] selection:text-slate-900">
    {{-- Main Content without App Sidebar --}}
    <main id="main-content" class="min-h-screen w-full flex flex-col">
        @yield('content')
    </main>

    {{-- Global Toast Component --}}
    <div id="hw-toast" class="fixed bottom-5 right-5 z-50 transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none bg-slate-900 text-white px-4 py-2.5 rounded-full shadow-lg text-xs font-semibold flex items-center gap-2 border border-slate-800">
        <span id="hw-toast-icon" class="text-[#e6ff94] font-bold">&check;</span>
        <span id="hw-toast-msg">Notifikasi</span>
    </div>

    <script>
        window.hwToast = (message, isError = false) => {
            const toast = document.getElementById('hw-toast');
            const msg = document.getElementById('hw-toast-msg');
            const icon = document.getElementById('hw-toast-icon');
            if (!toast || !msg) return;

            msg.textContent = message;
            if (isError) {
                icon.textContent = '✕';
                icon.className = 'text-rose-400 font-bold';
            } else {
                icon.textContent = '✓';
                icon.className = 'text-[#e6ff94] font-bold';
            }

            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            }, 3000);
        };
    </script>
    @stack('scripts')
</body>
</html>