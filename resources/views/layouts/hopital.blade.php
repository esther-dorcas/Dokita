<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokita — Espace Hôpital')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --nav-bg: #0c2340; /* Charte Dokita */
            --nav-accent: #2563eb; /* Patient Blue */
            --radius: 16px;
        }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; margin: 0; }

        .dashboard-layout { display: flex; min-height: 100vh; }

        /* ══ SIDEBAR ══ */
        .sidebar {
            width: 240px; min-width: 240px;
            background: var(--nav-bg);
            display: flex; flex-direction: column;
            position: sticky; top: 0; height: 100vh;
            z-index: 50;
        }
        .sidebar-logo {
            padding: 22px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        
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
            width: 34px; height: 34px; border-radius: 8px;
            background: #fff; color: var(--nav-bg);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 800; flex-shrink: 0;
        }
        .user-name { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.85); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px; }
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
            <a href="{{ route('hopital.dashboard') }}" class="inline-flex items-center justify-center border-2 border-white px-4 py-2 rounded-lg" style="text-decoration:none;">
                <span class="text-white font-black text-xl tracking-tight">Dokita</span>
            </a>
            <div style="font-size: 10px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1.2px; margin-top: 8px; font-weight: 600;">Portail Établissement</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Gestion Centre</div>

            <a href="{{ route('hopital.dashboard') }}" class="nav-item {{ request()->routeIs('hopital.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Tableau de bord
            </a>

            <a href="{{ route('hopital.urgences') }}" class="nav-item {{ request()->routeIs('hopital.urgences') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Urgences
                <span class="nav-badge urgent">SOS</span>
            </a>

            <div class="nav-section">Ressources</div>

            <a href="{{ route('hopital.medecins') }}" class="nav-item {{ request()->routeIs('hopital.medecins*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Équipe Médicale
            </a>

            <a href="{{ route('hopital.rdv') }}" class="nav-item {{ request()->routeIs('hopital.rdv') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Rendez-vous
                <span class="nav-badge">12</span>
            </a>

            <div class="nav-section">Administration</div>

            <a href="{{ route('hopital.parametres') }}" class="nav-item {{ request()->routeIs('hopital.parametres') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Paramètres Centre
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="nav-item w-full text-left" style="background:none;border:none;cursor:pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m6-11V7a3 3 0 01-6 0v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </nav>

        <div class="sidebar-user">
            <div class="user-avatar">H</div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? 'Hôpital / Clinique' }}</div>
                <div class="user-role">Centre de santé</div>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="main-content">
        <div class="content-padding">
            @yield('content')
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>
