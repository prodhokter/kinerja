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
    <title>{{ isset($title) ? $title . ' - Kinerja' : 'Kinerja - Transparansi Bantuan Sosial' }}</title>
    <meta name="description" content="Platform transparansi pemenuhan hak bantuan sosial: Lacak Resi, Peta Anomali, Lapor Pungli, dan Scorecard SLA.">
    <meta name="robots" content="index, follow">
    <meta name="application-name" content="Kinerja">
    <meta name="apple-mobile-web-app-title" content="Kinerja">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ isset($title) ? $title . ' - Kinerja' : 'Kinerja - Transparansi Bantuan Sosial' }}">
    <meta property="og:description" content="Platform transparansi publik: Resi Tracker, Peta Anomali, Lapor Pungli, dan Scorecard SLA.">
    <meta property="og:image" content="{{ asset('og-image.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="Kinerja - Platform Transparansi Bantuan Sosial Indonesia">
    <meta property="og:site_name" content="Kinerja">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ isset($title) ? $title . ' - Kinerja' : 'Kinerja - Transparansi Bantuan Sosial' }}">
    <meta name="twitter:description" content="Platform transparansi publik: Resi Tracker, Peta Anomali, Lapor Pungli, dan Scorecard SLA.">
    <meta name="twitter:image" content="{{ asset('og-image.png') }}">
    <meta name="twitter:image:alt" content="Kinerja - Platform Transparansi Bantuan Sosial Indonesia">

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
@php
    $isAdmin = auth()->check() && in_array(auth()->user()->role, [\App\Enums\UserRole::SuperAdmin, \App\Enums\UserRole::Moderator, \App\Enums\UserRole::AgencyOfficer], true);
@endphp
<body class="min-h-full bg-[#f0f4f8] text-[#1e293b] antialiased font-sans flex flex-col md:flex-row pb-20 md:pb-0"
      x-data="{
          sidebarCollapsed: localStorage.getItem('hw_sidebar_collapsed') === 'true',
          mobileSidebarOpen: false,
          moreNavOpen: false,
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('hw_sidebar_collapsed', this.sidebarCollapsed);
          }
      }">

    {{-- Accessibility Skip Link --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-full focus:bg-[#0f172a] focus:text-[#e6ff94] focus:px-4 focus:py-2 text-xs font-bold shadow-lg">
        Lompat Konten
    </a>

    {{-- Mobile Top Bar with Hamburger --}}
    <div class="md:hidden sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 py-3 flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2">
            <button type="button" @click="mobileSidebarOpen = true" class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 min-h-[44px] min-w-[44px] flex items-center justify-center cursor-pointer" aria-label="Buka Menu">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <svg viewBox="0 0 256 256" class="w-5 h-5 shrink-0" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="#0f172a" fill-rule="evenodd" d="M68 55C61.37 55 56 60.37 56 67V211C56 217.63 61.37 223 68 223H92C98.63 223 104 217.63 104 211V163L152 211C156.69 215.69 163.31 215.69 168 211L196 183C200.69 178.31 200.69 171.69 196 167L152 123L196 79C200.69 74.31 200.69 67.69 196 63L168 35C163.31 30.31 156.69 30.31 152 35L104 83V67C104 60.37 98.63 55 92 55H68ZM126 125A14 14 0 1 0 126 153A14 14 0 1 0 126 125Z"/>
                </svg>
                <span class="text-sm font-extrabold text-slate-900 font-display">Kinerja</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @auth
                <span class="text-xs font-bold text-slate-800 truncate max-w-[100px]">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[11px] font-bold text-rose-600 hover:text-rose-800">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-900 bg-slate-100 px-3 py-1.5 rounded-full hover:bg-slate-200">
                    Masuk
                </a>
            @endauth
        </div>
    </div>

    {{-- Collapsible Left Sidebar (Leaner: md:w-60 when expanded, md:w-20 when collapsed) --}}
    <aside
        :class="sidebarCollapsed ? 'md:w-20' : 'md:w-60'"
        class="hidden md:flex flex-col sticky top-0 h-screen bg-white/80 backdrop-blur-md border-r border-slate-200/80 transition-all duration-300 z-30 shrink-0">

        {{-- Sidebar Header & Custom Collapse Toggle Button --}}
        <div class="h-16 flex items-center px-4 border-b border-slate-100" :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">
            <div x-show="!sidebarCollapsed" x-cloak class="flex items-center gap-2.5">
                <svg viewBox="0 0 256 256" class="w-6 h-6 shrink-0" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path fill="#0f172a" fill-rule="evenodd" d="M68 55C61.37 55 56 60.37 56 67V211C56 217.63 61.37 223 68 223H92C98.63 223 104 217.63 104 211V163L152 211C156.69 215.69 163.31 215.69 168 211L196 183C200.69 178.31 200.69 171.69 196 167L152 123L196 79C200.69 74.31 200.69 67.69 196 63L168 35C163.31 30.31 156.69 30.31 152 35L104 83V67C104 60.37 98.63 55 92 55H68ZM126 125A14 14 0 1 0 126 153A14 14 0 1 0 126 125Z"/>
                </svg>
                <span class="text-sm font-extrabold tracking-tight text-slate-900 font-display">
                    Kinerja
                </span>
            </div>
            <button
                type="button"
                @click="toggleSidebar()"
                class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer"
                :title="sidebarCollapsed ? 'Buka Sidebar' : 'Tutup Sidebar'"
                aria-label="Toggle Sidebar"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v18" />
                </svg>
            </button>
        </div>

        {{-- Nav Items --}}
        <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto" aria-label="Navigasi Samping">
            {{-- 1. Beranda --}}
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('home') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
               :title="sidebarCollapsed ? 'Beranda' : ''">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Beranda</span>
            </a>

            {{-- 2. Lacak Resi --}}
            <a href="{{ route('tracker.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('tracker.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
               :title="sidebarCollapsed ? 'Lacak Resi' : ''">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Lacak Resi</span>
            </a>

            {{-- 3. Lapor Pungli --}}
            <a href="{{ route('report.extortion.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('report.extortion.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
               :title="sidebarCollapsed ? 'Lapor Pungli' : ''">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Lapor Pungli</span>
            </a>

            {{-- 4. Sanggah Bansos --}}
            <a href="{{ route('report.dispute.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('report.dispute.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
               :title="sidebarCollapsed ? 'Sanggah Bansos' : ''">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Sanggah Bansos</span>
            </a>

            {{-- 5. Cek Tiket --}}
            <a href="{{ route('ticket.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('ticket.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
               :title="sidebarCollapsed ? 'Cek Tiket' : ''">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">Cek Tiket</span>
            </a>

            {{-- Layanan publik: Peta, Scorecard, Data --}}
                {{-- 6. Peta Anomali --}}
                <a href="{{ route('map.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('map.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                   :title="sidebarCollapsed ? 'Peta Anomali' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-cloak class="truncate">Peta Anomali</span>
                </a>

                {{-- 7. Scorecard SLA --}}
                <a href="{{ route('scorecard.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('scorecard.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                   :title="sidebarCollapsed ? 'Scorecard SLA' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-cloak class="truncate">Scorecard SLA</span>
                </a>

                {{-- 8. Data Publik --}}
                <a href="{{ route('data.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('data.*') ? 'bg-[#0f172a] text-[#e6ff94] shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                   :title="sidebarCollapsed ? 'Data Publik' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-cloak class="truncate">Data Publik</span>
                </a>
        </nav>

        {{-- Sidebar Footer: Auth / User Status --}}
        <div class="p-3 border-t border-slate-100 bg-slate-50/60">
            @auth
                <div x-show="!sidebarCollapsed" x-cloak class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-7 h-7 rounded-full border border-slate-200 shrink-0 object-cover">
                        @else
                            <div class="w-7 h-7 rounded-full bg-[#0f172a] text-[#e6ff94] font-bold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-900 truncate leading-tight">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] text-slate-500 truncate block">{{ auth()->user()->role->label() }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors cursor-pointer" title="Keluar">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
                @if(in_array(auth()->user()->role, [\App\Enums\UserRole::SuperAdmin, \App\Enums\UserRole::Moderator, \App\Enums\UserRole::AgencyOfficer], true))
                    <div x-show="!sidebarCollapsed" x-cloak class="mt-2 pt-2 border-t border-slate-200/60">
                        <a href="/admin" class="flex items-center justify-center gap-1.5 py-1.5 px-3 rounded-lg bg-amber-500 hover:bg-amber-600 text-slate-950 text-[11px] font-bold shadow-2xs transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Buka Panel Admin &rarr;</span>
                        </a>
                    </div>
                @endif
                <div x-show="sidebarCollapsed" x-cloak class="flex justify-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition-colors cursor-pointer" title="Keluar ({{ auth()->user()->name }})">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <div x-show="!sidebarCollapsed" x-cloak>
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-xl bg-slate-900 text-[#e6ff94] text-xs font-bold hover:bg-slate-800 transition-colors shadow-2xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Masuk Akun</span>
                    </a>
                </div>
                <div x-show="sidebarCollapsed" x-cloak class="flex justify-center">
                    <a href="{{ route('login') }}" class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer" title="Masuk Akun">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                </div>
            @endauth
        </div>
    </aside>

    {{-- Mobile Sidebar Drawer Overlay --}}
    <div x-show="mobileSidebarOpen" x-cloak class="fixed inset-0 z-50 md:hidden" @keydown.window.escape="mobileSidebarOpen = false">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs" @click="mobileSidebarOpen = false"></div>
        <div class="relative w-64 bg-white h-full p-4 flex flex-col justify-between shadow-xl">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider font-mono">Menu Navigasi</span>
                    <button type="button" @click="mobileSidebarOpen = false" class="p-1 rounded-lg text-slate-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('home') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Beranda</a>
                    <a href="{{ route('tracker.index') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('tracker.*') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Lacak Resi</a>
                    <a href="{{ route('report.extortion.create') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('report.extortion.*') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Lapor Pungli</a>
                    <a href="{{ route('report.dispute.create') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('report.dispute.*') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Sanggah Bansos</a>
                    <a href="{{ route('ticket.index') }}" class="block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-100">Cek Tiket</a>

                    <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider font-mono">Layanan Publik</div>
                        <a href="{{ route('map.index') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('map.*') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Peta Anomali</a>
                        <a href="{{ route('scorecard.index') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('scorecard.*') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Scorecard SLA</a>
                        <a href="{{ route('data.index') }}" class="block px-3 py-2 rounded-lg text-xs font-bold {{ request()->routeIs('data.*') ? 'bg-[#0f172a] text-[#e6ff94]' : 'text-slate-700 hover:bg-slate-100' }}">Data Publik</a>
                    @if($isAdmin)
                        <a href="/admin" class="block px-3 py-2 rounded-lg text-xs font-bold bg-amber-500 text-slate-950 mt-1">Panel Admin &rarr;</a>
                    @endif
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100">
                @guest
                    <a href="{{ route('login') }}" class="block w-full text-center text-xs font-bold text-slate-900 bg-slate-100 px-3 py-2 rounded-lg hover:bg-slate-200">
                        Masuk Akun
                    </a>
                @endguest
            </div>
        </div>
    </div>

    {{-- Main App Area --}}
    <div class="flex-1 flex flex-col min-w-0">
        <main id="main-content" class="flex-1 pb-16">
            @yield('content')
        </main>
    </div>

    {{-- Soft Background Dim Overlay --}}
    <div x-show="moreNavOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="md:hidden fixed inset-0 z-30 bg-slate-900/30 backdrop-blur-xs"
         @click="moreNavOpen = false"
         aria-hidden="true">
    </div>

    {{-- Mobile Floating iOS Glass Dock (5 Buttons) with Arched Radial Fan (Image #14) --}}
    <div class="md:hidden fixed bottom-4 inset-x-0 z-40 px-3 flex justify-center pointer-events-none" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
        <div class="relative pointer-events-auto flex justify-center w-full max-w-sm">

            {{-- Semicircular / Arched Floating Glass Fan Menu (Image #14) --}}
            <div x-show="moreNavOpen" x-cloak
                 x-transition:enter="transition ease-out duration-300 transform origin-bottom"
                 x-transition:enter-start="scale-50 translate-y-8 opacity-0"
                 x-transition:enter-end="scale-100 translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200 transform origin-bottom"
                 x-transition:leave-start="scale-100 translate-y-0 opacity-100"
                 x-transition:leave-end="scale-50 translate-y-8 opacity-0"
                 class="absolute bottom-6 left-1/2 -translate-x-1/2 w-[310px] h-[125px] rounded-t-full bg-white/95 backdrop-blur-2xl border border-white/90 shadow-[0_-12px_40px_rgba(15,23,42,0.18)] px-5 pt-3.5 pb-10 flex items-center justify-between z-10"
                 @click.outside="moreNavOpen = false">
                {{-- 1. Sanggah --}}
                <a href="{{ route('report.dispute.create') }}" class="flex flex-col items-center group -mt-1">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center text-slate-800 group-hover:bg-[#e6ff94] transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-slate-700 mt-1">Sanggah</span>
                </a>

                {{-- 2. Cek Tiket --}}
                <a href="{{ route('ticket.index') }}" class="flex flex-col items-center group -mt-5">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center text-slate-800 group-hover:bg-[#e6ff94] transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-slate-700 mt-1">Tiket</span>
                </a>

                {{-- 3. Scorecard SLA --}}
                <a href="{{ route('scorecard.index') }}" class="flex flex-col items-center group -mt-5">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center text-slate-800 group-hover:bg-[#e6ff94] transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-slate-700 mt-1">SLA</span>
                </a>

                {{-- 4. Data Publik --}}
                <a href="{{ route('data.index') }}" class="flex flex-col items-center group -mt-1">
                    <div class="w-10 h-10 rounded-full bg-[#ffedd5] border border-orange-300 shadow-2xs flex items-center justify-center text-orange-950 group-hover:bg-[#e6ff94] transition-colors">
                        <svg class="w-5 h-5 text-orange-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-slate-700 mt-1">Data</span>
                </a>
            </div>

            {{-- Main Dock Bar --}}
            <nav class="relative z-20 bg-white/85 backdrop-blur-xl border border-white/80 shadow-[0_8px_32px_rgba(15,23,42,0.18)] rounded-full px-3 py-2 flex items-center justify-between gap-1 w-full" aria-label="Dock Navigasi Mobile">
                {{-- 1. Beranda --}}
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-1 rounded-full text-[10px] font-bold transition-all {{ request()->routeIs('home') ? 'text-slate-900 font-extrabold' : 'text-slate-500 hover:text-slate-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>

                {{-- 2. Lacak Resi --}}
                <a href="{{ route('tracker.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 rounded-full text-[10px] font-bold transition-all {{ request()->routeIs('tracker.*') ? 'text-slate-900 font-extrabold' : 'text-slate-500 hover:text-slate-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Lacak</span>
                </a>

                {{-- 3. Center Prominent Plus Expand Button --}}
                <button
                    type="button"
                    @click="moreNavOpen = !moreNavOpen"
                    class="w-12 h-12 -mt-5 rounded-full bg-[#0f172a] text-[#e6ff94] shadow-[0_4px_16px_rgba(15,23,42,0.35)] flex items-center justify-center transition-all duration-300 transform active:scale-95 border-2 border-white focus:outline-none cursor-pointer"
                    aria-label="Menu Tambahan"
                >
                    <svg class="w-6 h-6 transition-transform duration-300" :class="moreNavOpen ? 'rotate-45 text-rose-400' : 'rotate-0 text-[#e6ff94]'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>

                {{-- 4. Peta Anomali --}}
                <a href="{{ route('map.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 rounded-full text-[10px] font-bold transition-all {{ request()->routeIs('map.*') ? 'text-slate-900 font-extrabold' : 'text-slate-500 hover:text-slate-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span>Peta</span>
                </a>

                {{-- 5. Lapor Pungli --}}
                <a href="{{ route('report.extortion.create') }}" class="flex flex-col items-center justify-center flex-1 py-1 rounded-full text-[10px] font-bold transition-all {{ request()->routeIs('report.extortion.*') ? 'text-slate-900 font-extrabold' : 'text-slate-500 hover:text-slate-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Lapor</span>
                </a>
            </nav>
        </div>
    </div>

    {{-- Global Toast Component --}}
    <div id="hw-toast" class="fixed bottom-20 md:bottom-5 right-5 z-50 transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none bg-slate-900 text-white px-4 py-2.5 rounded-full shadow-lg text-xs font-semibold flex items-center gap-2 border border-slate-800">
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
