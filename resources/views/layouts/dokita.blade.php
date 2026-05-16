<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokita')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --nav-bg: #0c2340;
            --nav-accent: #2563eb;
            --radius: 16px;
        }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; margin: 0; }

        .dashboard-layout { display: flex; min-height: 100vh; }

        /* ══ SIDEBAR ══ */
        .sidebar {
            width: 220px; min-width: 220px;
            background: var(--nav-bg);
            display: flex; flex-direction: column;
            position: sticky; top: 0; height: 100vh;
            z-index: 50;
        }
        .sidebar-logo {
            padding: 22px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .logo-text  { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .logo-sub   { font-size: 10px; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1.2px; margin-top: 2px; }

        .sidebar-nav { flex: 1; padding: 10px 8px; display: flex; flex-direction: column; gap: 1px; overflow-y: auto; }
        .nav-section { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; color: rgba(255,255,255,0.2); padding: 14px 12px 5px; }

        .nav-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: 9px;
            color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 400;
            text-decoration: none; transition: all .15s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.9); }
        .nav-item.active { background: var(--nav-accent); color: #fff; font-weight: 600; }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; opacity: .75; }
        .nav-item.active svg { opacity: 1; }
        
        .nav-badge { margin-left: auto; background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.85); font-size: 10px; font-weight: 700; padding: 1px 7px; border-radius: 20px; }
        .nav-badge.urgent { background: #ef4444; color: #fff; }

        .sidebar-user {
            padding: 14px 16px; border-top: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--nav-accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; flex-shrink: 0;
            position: relative;
        }
        .status-indicator {
            position: absolute; bottom: 0; right: 0;
            width: 10px; height: 10px; background: #22c55e;
            border-radius: 50%; border: 2px solid var(--nav-bg);
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
            animation: statusPulse 2s infinite;
        }
        @keyframes statusPulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            70% { transform: scale(1.1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        .user-name { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.85); }
        .user-role { font-size: 10px; color: rgba(255,255,255,0.3); margin-top: 1px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ══ MAIN ══ */
        .main-content { flex: 1; background: #f1f5f9; display: flex; flex-direction: column; min-width: 0; }
        .content-padding { padding: 28px; flex: 1; }

        @media (max-width: 1024px) {
            .sidebar { display: none; }
        }
    </style>
    @stack('head')
</head>
<body class="antialiased">

<div class="dashboard-layout">
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center justify-center border-2 border-white px-4 py-2 rounded-lg">
                <span class="text-white font-black text-xl tracking-tight">Dokita</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Principal</div>

            <a href="{{ route('patient.dashboard') }}"
               class="nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('rdv.index') }}"
               class="nav-item {{ request()->routeIs('rdv.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Mes rendez-vous
                @if(isset($upcomingCount) && $upcomingCount > 0)
                    <span class="nav-badge">{{ $upcomingCount }}</span>
                @endif
            </a>

            <a href="{{ route('hopitaux.index') }}"
               class="nav-item {{ request()->routeIs('hopitaux.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Hôpitaux & Carte
            </a>

            <a href="{{ route('urgence.create') }}"
               class="nav-item {{ request()->routeIs('urgence.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                Urgence
                <span class="nav-badge urgent">!</span>
            </a>

            <div class="nav-section">Mon dossier</div>

            <a href="{{ route('profil.index') }}" class="nav-item {{ request()->routeIs('profil.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Santé & Constantes
            </a>

            <a href="{{ route('patient.history') }}" class="nav-item {{ request()->routeIs('patient.history') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Historique
            </a>

            <div class="nav-section">Compte</div>

            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Paramètres du compte
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="nav-item w-full text-left">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6-11V7a3 3 0 01-6 0v1"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </nav>

        <div class="sidebar-user">
            @php
                $nameParts = explode(' ', Auth::user()->name);
                $initials  = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1] ?? '', 0, 1));
            @endphp
            <div class="user-avatar">
                {{ $initials }}
                <div class="status-indicator"></div>
            </div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Patient</div>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="main-content">
        <div class="content-padding">
            @yield('content')
        </div>

        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>
