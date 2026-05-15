<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokita — Espace Professionnel</title>
    <meta name="description" content="Plateforme dédiée aux professionnels de santé au Bénin.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #ffffff; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; line-height: 1.6; color: #1e293b; }

        /* ══ NAV ══ */
        #main-nav { background: #0f2d52; box-shadow: 0 2px 20px rgba(0,0,0,0.25); }
        .nav-link { color: rgba(255,255,255,0.85); font-weight: 600; font-size: 0.875rem; transition: color 0.2s; position: relative; padding-bottom: 2px; margin: 0 1.5rem; }
        .nav-link:hover { color: #ffffff; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#22d3ee; transition:width 0.25s ease; }
        .nav-link:hover::after { width:100%; }

        /* ══ HERO ══ */
        .hero-section {
            background-color: #0f2d52;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-glow-1 {
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: radial-gradient(circle at top right, rgba(8,145,178,0.30), transparent 50%);
            pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute;
            top: -80px; right: -80px;
            width: 400px; height: 400px;
            background: rgba(34,211,238,0.08);
            border-radius: 9999px;
            pointer-events: none;
        }
        .hero-inner {
            position: relative;
            z-index: 10;
            max-width: 80rem;
            margin: 0 auto;
            padding: 5rem 2rem 8rem;
        }
        @media (min-width: 1024px) {
            .hero-inner { padding: 7rem 2rem 10rem; }
        }
        .hero-grid {
            display: grid;
            gap: 4rem;
            align-items: center;
        }
        @media (min-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr 1fr; }
        }

        /* Badge hero */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 9999px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.22);
            padding: 0.4rem 1rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.95);
        }

        /* Stats hero */
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.12);
            padding-top: 2rem;
            margin-top: 2rem;
        }
        .hero-stat-divider {
            border-left: 1px solid rgba(255,255,255,0.12);
            padding-left: 1.5rem;
        }

        /* Widget live */
        .live-widget {
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 2rem;
            padding: 1.5rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }
        .live-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            margin-top: 0.75rem;
        }
        .live-icon-wrap {
            width: 2rem; height: 2rem;
            border-radius: 0.5rem;
            background: rgba(8,145,178,0.30);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* ══ CARDS ══ */
        .flat-card { border: 1px solid #e5e7eb; transition: box-shadow 0.2s, transform 0.2s; }
        .flat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.08); transform: translateY(-2px); }

        /* ══ AVATAR ══ */
        .avatar-placeholder { width:48px; height:48px; border-radius:50%; background:#0891b2; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:14px; flex-shrink:0; }

        /* ══ BADGE SPÉCIALITÉ ══ */
        .spec-badge { display:inline-flex; align-items:center; gap:6px; background:#e0f2fe; color:#0369a1; border-radius:9999px; padding:4px 12px; font-size:11px; font-weight:700; }

        /* ══ BADGE STATUT ══ */
        .status-on  { background:#dcfce7; color:#166534; }
        .status-off { background:#f1f5f9; color:#64748b; }
        .status-badge { display:inline-flex; align-items:center; gap:5px; border-radius:9999px; padding:3px 10px; font-size:11px; font-weight:700; }

        /* ══ TAG HÔPITAL ══ */
        .hosp-tag { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; border-radius:9999px; padding:3px 10px; font-size:11px; font-weight:600; }

        /* ══ PROGRESS BAR ══ */
        .progress-track { background:#e2e8f0; border-radius:9999px; height:6px; overflow:hidden; }
        .progress-fill  { background:#0891b2; border-radius:9999px; height:6px; }

        /* ══ SECTION TITLE ══ */
        .section-label { font-size:11px; font-weight:700; letter-spacing:0.2em; text-transform:uppercase; color:#0891b2; display:block; }

        /* ══ GRIDS ══ */
        .cards-grid { display:grid; gap:1.25rem; }
        @media (min-width: 640px)  { .cards-grid { grid-template-columns: repeat(2,1fr); } }
        @media (min-width: 1024px) { .cards-grid { grid-template-columns: repeat(3,1fr); } }

        .specs-grid { display:grid; gap:1rem; grid-template-columns: repeat(2,1fr); }
        @media (min-width: 640px)  { .specs-grid { grid-template-columns: repeat(3,1fr); } }
        @media (min-width: 1024px) { .specs-grid { grid-template-columns: repeat(4,1fr); } }

        /* ══ BUTTONS ══ */
        .btn-primary   { display:inline-flex; align-items:center; justify-content:center; border-radius:0.75rem; background:#0891b2; padding:1rem 2rem; font-size:0.875rem; font-weight:700; color:#fff; transition:background .2s; text-decoration:none; }
        .btn-primary:hover { background:#0284c7; }
        .btn-outline   { display:inline-flex; align-items:center; justify-content:center; border-radius:0.75rem; border:1px solid rgba(255,255,255,0.30); background:rgba(255,255,255,0.10); padding:1rem 2rem; font-size:0.875rem; font-weight:700; color:#fff; transition:background .2s; text-decoration:none; }
        .btn-outline:hover { background:rgba(255,255,255,0.20); }
        .btn-outline-blue { display:inline-flex; align-items:center; gap:0.5rem; border-radius:0.75rem; border:2px solid #0891b2; padding:0.875rem 2rem; font-size:0.875rem; font-weight:700; color:#0891b2; transition:background .2s, color .2s; text-decoration:none; }
        .btn-outline-blue:hover { background:#0891b2; color:#fff; }
        .btn-white  { display:inline-flex; align-items:center; justify-content:center; border-radius:0.75rem; background:#ffffff; padding:1rem 2.5rem; font-size:0.875rem; font-weight:700; color:#0891b2; box-shadow:0 20px 40px rgba(0,0,0,0.2); transition:background .2s; text-decoration:none; }
        .btn-white:hover { background:#f1f5f9; }

        /* ══ CTA SECTION ══ */
        .cta-box {
            border: 1px solid rgba(255,255,255,0.12);
            background: linear-gradient(135deg, rgba(8,145,178,0.25), rgba(15,45,82,0.4));
            border-radius: 2rem;
            padding: 4rem 3rem;
            text-align: center;
        }

        /* ══ REVEAL ══ */
        .reveal { transform:translateY(20px); opacity:0; transition:transform 700ms cubic-bezier(.2,.8,.2,1), opacity 700ms ease; }
        .reveal.visible { transform:translateY(0); opacity:1; }

        /* ══ SECTION PADDING ══ */
        .section { padding: 5rem 0; }
        .section-inner { max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        @media (min-width: 640px)  { .section-inner { padding: 0 1.5rem; } }
        @media (min-width: 1024px) { .section-inner { padding: 0 2rem; } }
        .section-head { text-align: center; margin-bottom: 3.5rem; }
    </style>
</head>
<body class="min-h-screen antialiased overflow-x-hidden">

{{-- ══ NAVBAR ══ --}}
<nav id="main-nav" class="fixed top-0 inset-x-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-[72px] items-center justify-between">
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <span class="inline-flex items-center justify-center border-2 border-white px-4 py-2 rounded-lg">
                    <span class="text-white font-black text-xl tracking-tight">Dokita</span>
                </span>
            </a>
            <div class="hidden lg:flex items-center">
                <a href="{{ route('home') }}#about"   class="nav-link">Qui sommes-nous&nbsp;?</a>
                <a href="{{ route('faq') }}"           class="nav-link">Besoin d'aide&nbsp;?</a>
                <a href="{{ route('professional') }}"  class="nav-link">Espace professionnel</a>
            </div>
            <div class="hidden lg:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"    class="rounded-lg border-2 border-white/60 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10 hover:border-white">Se connecter</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#0891b2]/40 transition hover:bg-[#0284c7]">S'inscrire gratuitement</a>
                @else
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#0284c7]">Mon espace</a>
                @endguest
            </div>
            <button class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/30 text-white"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden border-t border-white/10 bg-[#0f2d52] px-4 py-5 lg:hidden">
        <div class="space-y-1">
            <a href="{{ route('home') }}#about"   class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Qui sommes-nous&nbsp;?</a>
            <a href="{{ route('faq') }}"           class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Besoin d'aide&nbsp;?</a>
            <a href="{{ route('professional') }}"  class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Espace professionnel</a>
        </div>
        <div class="mt-4 flex flex-col gap-3 pt-4 border-t border-white/10">
            @guest
                <a href="{{ route('login') }}"    class="block rounded-lg border-2 border-white/50 px-4 py-3 text-center text-sm font-bold text-white">Se connecter</a>
                <a href="{{ route('register') }}" class="block rounded-lg bg-[#0891b2] px-4 py-3 text-center text-sm font-bold text-white">S'inscrire gratuitement</a>
            @else
                <a href="{{ route('dashboard') }}" class="block rounded-lg bg-[#0891b2] px-4 py-3 text-center text-sm font-bold text-white">Mon espace</a>
            @endguest
        </div>
    </div>
</nav>

<div style="padding-top:72px;">

    {{-- ══ HERO ══ --}}
    <section class="hero-section">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <div class="hero-inner">
            <div class="hero-grid">

                {{-- Texte --}}
                <div style="display:flex; flex-direction:column; gap:2rem;">
                    

                    <h1 style="font-size:clamp(2.5rem,5vw,4rem);font-weight:900;line-height:1.05;letter-spacing:-0.02em;color:#ffffff;margin:0;">
                        Médecins &amp; hôpitaux<br>
                        <span style="color:#22d3ee;">connectés</span> à<br>votre service.
                    </h1>

                    <p style="font-size:1.1rem;color:rgba(255,255,255,0.80);line-height:1.7;max-width:32rem;margin:0;">
                        Dokita regroupe les meilleurs professionnels de santé et établissements du Bénin au sein d'une plateforme unifiée — pour des soins accessibles, rapides et traçables.
                    </p>

                    <div style="display:flex;flex-wrap:wrap;gap:1rem;">
                        <a href="{{ route('register') }}" class="btn-primary">Rejoindre le réseau</a>
                        <a href="{{ route('login') }}" class="btn-outline">Voir les médecins</a>
                    </div>

                    <div class="hero-stats">
                        <div>
                            <p style="font-size:2rem;font-weight:900;color:#ffffff;margin:0;">+250</p>
                            <p style="font-size:10px;text-transform:uppercase;letter-spacing:0.2em;color:rgba(255,255,255,0.45);font-weight:700;margin:4px 0 0;">Médecins</p>
                        </div>
                        <div class="hero-stat-divider">
                            <p style="font-size:2rem;font-weight:900;color:#ffffff;margin:0;">+120</p>
                            <p style="font-size:10px;text-transform:uppercase;letter-spacing:0.2em;color:rgba(255,255,255,0.45);font-weight:700;margin:4px 0 0;">Hôpitaux</p>
                        </div>
                        <div class="hero-stat-divider">
                            <p style="font-size:2rem;font-weight:900;color:#ffffff;margin:0;">12</p>
                            <p style="font-size:10px;text-transform:uppercase;letter-spacing:0.2em;color:rgba(255,255,255,0.45);font-weight:700;margin:4px 0 0;">Spécialités</p>
                        </div>
                    </div>
                </div>

                {{-- Widget live --}}
                <div class="live-widget">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                        <p style="font-size:0.875rem;font-weight:900;color:#ffffff;margin:0;">Activité en temps réel</p>
                        <span style="display:flex;align-items:center;gap:6px;font-size:11px;color:#86efac;font-weight:600;">
                            <span style="width:8px;height:8px;border-radius:9999px;background:#4ade80;animation:pulse 2s infinite;"></span>
                            Live
                        </span>
                    </div>

                    @php
                        $liveStats = [
                            ['label'=>'Médecins connectés',       'value'=>'47',  'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['label'=>'RDV confirmés aujourd\'hui','value'=>'134', 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['label'=>'Hôpitaux ouverts',         'value'=>'28',  'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['label'=>'Rappels envoyés',          'value'=>'89',  'icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                        ];
                    @endphp

                    @foreach($liveStats as $s)
                    <div class="live-row">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div class="live-icon-wrap">
                                <svg style="width:16px;height:16px;color:#22d3ee;" fill="none" stroke="#22d3ee" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                                </svg>
                            </div>
                            <span style="font-size:0.875rem;color:rgba(255,255,255,0.85);">{{ $s['label'] }}</span>
                        </div>
                        <span style="font-size:1rem;font-weight:900;color:#22d3ee;">{{ $s['value'] }}</span>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    {{-- ══ BANDEAU D'INTRODUCTION ══ --}}
    <div class="relative z-10" style="margin-top: -80px;">
        <div class="section-inner">
            <div class="max-w-4xl mx-auto px-6">
                <div class="bg-white border border-slate-100 py-12 px-8 text-center rounded-[2.5rem] shadow-sm mb-32">
                    <h2 class="text-3xl md:text-4xl font-medium text-slate-700 italic">Dokita s'efforce à :</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════ SOLUTIONS POUR LES PROFESSIONNELS (Style Doctolib) ══════════ --}}
    <section class="section bg-slate-50 pt-0" id="solutions">
        <style>
            .hover-turquoise {
                color: #1e293b !important; /* slate-800 */
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 900;
                font-size: 0.875rem;
            }
            .hover-turquoise:hover {
                color: #0891b2 !important; /* Turquoise */
                text-decoration: underline !important;
            }
            .hover-turquoise svg {
                transition: transform 0.3s ease;
            }
            .hover-turquoise:hover svg {
                transform: translateX(5px);
            }
        </style>
        <div class="section-inner space-y-64">
            
            {{-- BLOC 1 : Améliorez votre quotidien --}}
            <div class="flex flex-col md:flex-row items-center gap-16 reveal">
                <div class="w-full lg:w-1/2 flex justify-start">
                    <div class="relative max-w-md">
                        <img src="/images/noi.jpg" alt="Améliorez votre quotidien" class="w-full rounded-[2.5rem] shadow-2xl object-cover aspect-[4/3]">
                    </div>
                </div>
                <div class="w-full lg:w-1/2 space-y-4">
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">
                        <span class="relative inline-block">
                            Améliorez
                            <span class="absolute bottom-1 left-0 w-full h-3 bg-[#0891b2]/30 -z-10 rounded-full"></span>
                        </span><br>
                        votre quotidien
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed font-medium">
                        Des spécialistes expérimentés pour vous accompagner à chaque étape de votre parcours de santé.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('register') }}" class="hover-turquoise">
                            En savoir plus <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- BLOC 2 : Mieux soigner --}}
            <div class="grid md:grid-cols-2 items-center gap-12 lg:gap-20 reveal">
                {{-- Texte à gauche --}}
                <div class="order-2 md:order-1 space-y-4 text-left">
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">
                        <span class="relative inline-block">
                            Mieux soigner
                            <span class="absolute bottom-1 left-0 w-full h-3 bg-[#0891b2]/30 -z-10 rounded-full"></span>
                        </span>
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed font-medium">
                        De nouveaux standards de soin pour offrir plus de temps médical de qualité à vos patients.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('register') }}" class="hover-turquoise">
                            En savoir plus <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                {{-- Image à droite --}}
                <div class="order-1 md:order-2 flex justify-end">
                    <div class="relative max-w-md">
                        <img src="/images/imb.jpg" alt="Mieux soigner" class="w-full rounded-[2.5rem] shadow-2xl object-cover aspect-[4/3]">
                    </div>
                </div>
            </div>

            {{-- BLOC 3 : Augmentez vos revenus --}}
            <div class="flex flex-col md:flex-row items-center gap-16 reveal">
                <div class="w-full lg:w-1/2 flex justify-start pt-12">
                    <div class="relative max-w-md">
                        <img src="/images/afri.jpg" alt="Equipe médicale" class="w-full rounded-[2.5rem] shadow-2xl object-cover aspect-[4/3]">
                    </div>
                </div>
                <div class="w-full lg:w-1/2 space-y-4 pb-12">
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">
                        <span class="relative inline-block">
                            Bénéficiez d’une équipe
                            <span class="absolute bottom-1 left-0 w-full h-3 bg-[#0891b2]/30 -z-10 rounded-full"></span>
                        </span><br>
                        de spécialistes qualifiés
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed font-medium">
                        Des médecins expérimentés et engagés pour vous offrir une prise en charge moderne, accessible et de qualité.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('register') }}" class="hover-turquoise">
                            En savoir plus <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════ SECTION SPÉCIALITÉS & ÉTABLISSEMENTS (Style Doctolib) ══════════ --}}
    <section class="section bg-white" id="solutions-detail">
        <div class="section-inner">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-8">Découvrez nos solutions pensées pour vous</h2>
                
                {{-- Sélecteur d'onglets --}}
                <div x-data="{ tab: 'praticiens' }">
                    <div class="inline-flex p-1 bg-slate-100 rounded-full mb-16">
                        <button 
                            @click="tab = 'praticiens'"
                            :class="tab === 'praticiens' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                            class="px-8 py-2.5 rounded-full text-sm font-bold transition-all duration-200">
                            Praticiens
                        </button>
                        <button 
                            @click="tab = 'etablissements'"
                            :class="tab === 'etablissements' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                            class="px-8 py-2.5 rounded-full text-sm font-bold transition-all duration-200">
                            Établissements de santé
                        </button>
                    </div>

                    {{-- Contenu des onglets --}}
                    <div class="w-full text-left">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            
                            {{-- Image à gauche --}}
                            <div class="reveal">
                                <template x-if="tab === 'praticiens'">
                                    <img src="/images/afro.jpg" alt="Praticiens" class="w-full rounded-[2.5rem] shadow-2xl object-cover aspect-[4/3]">
                                </template>
                                <template x-if="tab === 'etablissements'">
                                    <img src="/images/et.jpg" alt="Établissements" class="w-full rounded-[2.5rem] shadow-2xl object-cover aspect-[4/3]">
                                </template>
                            </div>

                            {{-- Liste à droite --}}
                            <div class="reveal">
                                {{-- Contenu Praticiens --}}
                                <template x-if="tab === 'praticiens'">
                                    <div class="grid md:grid-cols-2 gap-x-8 gap-y-2">
                                        @php
                                            $praticiens = [
                                                ['n' => 'Médecin généraliste', 'i' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                                ['n' => 'Médecin spécialiste', 'i' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                                                ['n' => 'Chirurgien-dentiste', 'i' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z'],
                                                ['n' => 'Masseur-kinésithérapeute', 'i' => 'M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 10-3 0m-6 3V11m0 2.5V9a1.5 1.5 0 113 0'],
                                                ['n' => 'Ostéopathe', 'i' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'],
                                                ['n' => 'Pédicure-Podologue', 'i' => 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6'],
                                                ['n' => 'Psychologue', 'i' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.989-2.386l-.548-.547z'],
                                                ['n' => 'Sage-Femme', 'i' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                                                ['n' => 'Pharmacien', 'i' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.34a2 2 0 00-1.029 1.488l-.29 2.18a2 2 0 001.216 2.132l1.344.537a2 2 0 001.93-.205l1.637-1.144a2 2 0 00.75-1.73l-.066-2.112a2 2 0 00-.542-1.347z'],
                                                ['n' => 'Infirmier', 'i' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                                                ['n' => 'Opticien / Audioprothésiste', 'i' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                                                ['n' => 'Diététicien', 'i' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3'],
                                                ['n' => 'Laboratoire', 'i' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.34a2 2 0 00-1.029 1.488l-.29 2.18a2 2 0 001.216 2.132l1.344.537a2 2 0 001.93-.205l1.637-1.144a2 2 0 00.75-1.73l-.066-2.112a2 2 0 00-.542-1.347z'],
                                                ['n' => 'Secrétaire médical', 'i' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 5z'],
                                                ['n' => 'Assistant dentaire', 'i' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                                ['n' => 'Télésecrétariat', 'i' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 5z'],
                                                ['n' => 'Autre spécialité', 'i' => 'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            ];
                                        @endphp
                                        @foreach($praticiens as $p)
                                            <a href="#" class="flex items-center justify-between p-1.5 rounded-xl hover:bg-slate-50 transition-colors group">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-[#0891b2] group-hover:scale-110 transition-transform">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $p['i'] }}"/></svg>
                                                    </span>
                                                    <span class="text-[13px] font-semibold text-slate-700 group-hover:text-slate-900">{{ $p['n'] }}</span>
                                                </div>
                                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#0891b2] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endforeach
                                    </div>
                                </template>

                                {{-- Contenu Établissements --}}
                                <template x-if="tab === 'etablissements'">
                                    <div class="grid md:grid-cols-2 gap-x-8 gap-y-2">
                                        @php
                                            $etabs = [
                                                ['n' => 'Hôpital', 'i' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                                ['n' => 'Centre d\'imagerie', 'i' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
                                                ['n' => 'CPTS', 'i' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                                                ['n' => 'MSP', 'i' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                                ['n' => 'Centre de santé', 'i' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                                ['n' => 'Maison de retraite', 'i' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                                ['n' => 'DNS & GRADES', 'i' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z'],
                                            ];
                                        @endphp
                                        @foreach($etabs as $e)
                                            <a href="#" class="flex items-center justify-between p-1.5 rounded-xl hover:bg-slate-50 transition-colors group">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-[#0891b2] group-hover:scale-110 transition-transform">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $e['i'] }}"/></svg>
                                                    </span>
                                                    <span class="text-[13px] font-semibold text-slate-700 group-hover:text-slate-900">{{ $e['n'] }}</span>
                                                </div>
                                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#0891b2] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endforeach
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════ SECTION AVANTAGES POUR LES PROS ══════════ --}}
    <section class="section bg-slate-50" id="avantages">
        <style>
            .advantage-card:hover .advantage-icon-box {
                background-color: #0891b2 !important;
            }
            .advantage-card:hover .advantage-icon {
                color: #ffffff !important;
                fill: #ffffff !important;
            }
            .advantage-card:hover .advantage-title {
                color: #0891b2 !important;
            }
        </style>
        <div class="section-inner">
            <div class="text-center mb-16 reveal">
                <span class="text-[#0891b2] font-bold tracking-widest uppercase text-xs">Pourquoi nous rejoindre ?</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mt-4">Des outils pensés pour votre réussite</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Carte 1 --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 reveal advantage-card cursor-pointer">
                    <div class="w-16 h-16 bg-[#0891b2]/10 rounded-2xl flex items-center justify-center mb-6 advantage-icon-box transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#0891b2] advantage-icon fill-current transition-colors duration-300" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 advantage-title transition-colors">Visibilité accrue</h3>
                    <p class="text-slate-600 leading-relaxed">Soyez visible par des milliers de patients qui recherchent des soins chaque jour au Bénin.</p>
                </div>

                {{-- Carte 2 --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 reveal advantage-card cursor-pointer">
                    <div class="w-16 h-16 bg-[#0891b2]/10 rounded-2xl flex items-center justify-center mb-6 advantage-icon-box transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#0891b2] advantage-icon fill-current transition-colors duration-300" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 advantage-title transition-colors">Gestion simplifiée</h3>
                    <p class="text-slate-600 leading-relaxed">Un agenda intelligent pour gérer vos rendez-vous, vos disponibilités et votre patientèle en un clic.</p>
                </div>

                {{-- Carte 3 --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 reveal advantage-card cursor-pointer">
                    <div class="w-16 h-16 bg-[#0891b2]/10 rounded-2xl flex items-center justify-center mb-6 advantage-icon-box transition-colors duration-300">
                        <svg class="w-8 h-8 text-[#0891b2] advantage-icon fill-current transition-colors duration-300" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 advantage-title transition-colors">Gain de temps</h3>
                    <p class="text-slate-600 leading-relaxed">Réduisez les rendez-vous non honorés grâce aux rappels automatiques par SMS et email.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section class="section" style="background:#0f2d52;">
        <div class="section-inner">
            <div class="cta-box reveal">
                <span class="section-label" style="color:#7dd3fc;margin-bottom:1rem;">Vous êtes professionnel de santé ?</span>
                <h2 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:#ffffff;margin:0.75rem 0 0;">Rejoignez le réseau Dokita.</h2>
                <p style="max-width:36rem;margin:1rem auto 0;color:rgba(255,255,255,0.75);font-size:0.9rem;line-height:1.7;">
                    Inscrivez votre cabinet ou votre établissement sur Dokita pour être visible par des milliers de patients au Bénin. Gestion des RDV, rappels automatiques et dossiers patients inclus.
                </p>
                <div style="margin-top:2rem;display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:1rem;">
                    <a href="{{ route('register') }}" class="btn-white">Créer un compte professionnel</a>
                    <a href="{{ route('faq') }}"      class="btn-outline">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

</div>

@include('partials.footer')

<script>
(function(){
    const io = new IntersectionObserver(entries => entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('visible');
    }), { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>

@include('partials.samu-modal')
</body>
</html>