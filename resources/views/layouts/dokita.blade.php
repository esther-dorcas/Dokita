<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokita')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&family=outfit:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

        @media (min-width: 1024px) {
            #app-sidebar {
                transform: translateX(0) !important;
                position: fixed;
                left: 0;
                top: 0;
            }
            #main-wrapper {
                margin-left: 260px;
            }
            #sidebar-overlay { display: none !important; }
        }

        .nav-link {
            @apply flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 w-full;
            color: #94a3b8; /* text-slate-400 */
        }
        .nav-link:hover {
            @apply bg-slate-800/50 text-white;
        }
        .nav-link.active {
            @apply bg-medical-500/10 text-medical-400 font-semibold border border-medical-500/20 shadow-[inset_0_1px_0_0_rgba(255,255,255,0.05)];
        }
        .nav-link.active .ni {
            @apply text-medical-400;
        }
        .ni {
            @apply w-5 h-5 shrink-0 text-slate-500 transition-colors duration-200;
        }
        .nav-link:hover .ni {
            @apply text-slate-300;
        }

        .nav-link-red {
            @apply text-slate-400;
        }
        .nav-link-red:hover {
            @apply bg-red-500/10 text-red-400;
        }
        .nav-link-red:hover .ni {
            @apply text-red-400;
        }
        .nav-link-red.active {
            @apply bg-red-500/10 text-red-400 font-semibold border border-red-500/20;
        }
        .nav-link-red.active .ni {
            @apply text-red-400;
        }
    </style>
    @stack('head')
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-medical-500/30">

<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

    {{-- Mobile overlay --}}
    <div id="sidebar-overlay"
         x-show="sidebarOpen" @click="sidebarOpen=false"
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
    </div>

    {{-- ═══ SIDEBAR ═══ --}}
    <aside id="app-sidebar"
           :style="sidebarOpen ? 'transform:translateX(0)' : 'transform:translateX(-100%)'"
           class="fixed top-0 left-0 bottom-0 z-50 w-[260px] bg-slate-950 flex flex-col transition-transform duration-300 ease-in-out border-r border-slate-800/50 lg:translate-x-0 shadow-2xl lg:shadow-none">

        {{-- Logo --}}
        <div class="h-[72px] px-6 flex items-center border-b border-slate-800/50 shrink-0">
            <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center shadow-lg shadow-medical-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                </div>
                <span class="text-xl font-display font-bold tracking-tight text-white">Dokita.</span>
            </a>
        </div>

        {{-- User info --}}
        <div class="p-5 border-b border-slate-800/50 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Patient</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-5 overflow-y-auto space-y-1 custom-scrollbar">
            <p class="px-4 pb-2 text-xs font-bold tracking-wider uppercase text-slate-500">Navigation</p>

            <a href="{{ route('patient.dashboard') }}" class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                <svg class="ni" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Tableau de bord
            </a>

            <a href="{{ route('hopitaux.index') }}" class="nav-link {{ request()->routeIs('hopitaux.*') ? 'active' : '' }}">
                <svg class="ni" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>
                Trouver un hôpital
            </a>

            <a href="{{ route('rdv.index') }}" class="nav-link {{ request()->routeIs('rdv.*') ? 'active' : '' }}">
                <svg class="ni" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Mes rendez-vous
            </a>

            <a href="{{ route('profil.index') }}" class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <svg class="ni" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Mon profil
            </a>

            <div class="h-px bg-slate-800/50 my-4 mx-2"></div>

            <a href="{{ route('urgence.create') }}" class="nav-link nav-link-red {{ request()->routeIs('urgence.*') ? 'active' : '' }}">
                <svg class="ni" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.81 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72 12 12 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45 12 12 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                Urgences médicales
            </a>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-slate-800/50 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link nav-link-red w-full text-left">
                    <svg class="ni" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ MAIN WRAPPER ═══ --}}
    <div id="main-wrapper" class="flex flex-col flex-1 min-h-screen transition-all duration-300 ease-in-out w-full">

        {{-- Top bar --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200/60 h-[72px] flex items-center justify-between px-6 shrink-0 shadow-sm">

            {{-- Left --}}
            <div class="flex items-center gap-4">
                {{-- Hamburger (mobile only) --}}
                <button @click="sidebarOpen=true" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-medical-500/50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div>
                    <h1 class="text-xl font-display font-bold text-slate-900 leading-tight">@yield('page-title', 'Tableau de bord')</h1>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">@yield('page-subtitle', 'Bienvenue sur votre espace santé')</p>
                </div>
            </div>

            {{-- Right — user dropdown --}}
            <div x-data="{ userOpen: false }" class="relative">
                <button @click="userOpen = !userOpen" class="flex items-center gap-3 p-1.5 pr-3 rounded-full border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 transition-all focus:outline-none focus:ring-2 focus:ring-medical-500/20 shadow-sm">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <span class="hidden md:block text-sm font-semibold text-slate-700 max-w-[130px] truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': userOpen}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                <div x-show="userOpen" @click.away="userOpen=false"
                     class="absolute right-0 mt-2 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-slate-200/50 p-2 z-50 origin-top-right"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     style="display: none;">
                     
                    <div class="px-4 py-3 border-b border-slate-100 mb-2">
                        <p class="text-xs font-medium text-slate-500">Connecté en tant que</p>
                        <p class="text-sm font-bold text-slate-900 mt-1 truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                        <p class="text-xs text-slate-500 truncate mt-0.5">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-medical-600 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Mon profil
                    </a>
                    
                    <div class="h-px bg-slate-100 my-2 mx-2"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 w-full text-left hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Flash alerts --}}
        @if(session('success') || session('error'))
            <div class="pt-6 px-6 lg:px-10 max-w-7xl mx-auto w-full">
                <div class="flex items-start gap-3 p-4 rounded-2xl text-sm font-medium border shadow-sm {{ session('success') ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' }}">
                    @if(session('success'))
                        <svg class="w-5 h-5 shrink-0 text-green-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-5 h-5 shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    @endif
                    <span class="leading-relaxed">{{ session('success') ?? session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-6 lg:p-10 max-w-7xl mx-auto w-full">
            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')
</body>
</html>
