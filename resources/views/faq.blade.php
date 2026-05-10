<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre d'aide — Dokita</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: #0f172a; margin: 0; padding: 0; }

        /* ══ NAVBAR ══ */
        #main-nav { background: #0f2d52; box-shadow: 0 2px 20px rgba(0,0,0,0.25); }
        .nav-link { color: rgba(255,255,255,0.85); font-weight: 600; font-size: 0.875rem; transition: color 0.2s; position: relative; padding-bottom: 2px; margin: 0 1.5rem; }
        .nav-link:hover { color: #ffffff; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#22d3ee; transition:width 0.25s ease; }
        .nav-link:hover::after { width:100%; }

        /* ══ HERO ══ */
        .hero { background: #0f2d52; padding: 132px 0 130px; text-align: center; color: white; position: relative; overflow: hidden; }
        .hero::before { content:''; position:absolute; top:-30%; right:-20%; width:400px; height:400px; background:rgba(6,182,212,0.1); border-radius:50%; pointer-events:none; }
        .hero::after { content:''; position:absolute; bottom:-30%; left:-10%; width:350px; height:350px; background:rgba(2,132,199,0.08); border-radius:50%; pointer-events:none; }
        .hero h1 { font-size: 2.75rem; font-weight: 800; margin-bottom: 2.5rem; letter-spacing: -0.02em; position: relative; z-index: 2; }
        .search-wrap { max-width: 680px; margin: 0 auto; position: relative; padding: 0 1.5rem; z-index: 2; }
        .search-input { width: 100%; padding: 1.1rem 1.5rem 1.1rem 4rem; border-radius: 9999px; border: none; font-size: 0.95rem; color: #1e293b; box-shadow: 0 15px 40px rgba(0,0,0,0.2); outline: none; transition: box-shadow 0.2s; }
        .search-input:focus { box-shadow: 0 20px 45px rgba(0,0,0,0.25); }
        .search-input::placeholder { color: #94a3b8; }
        .search-icon { position: absolute; left: 2.75rem; top: 50%; transform: translateY(-50%); color: #94a3b8; width: 22px; height: 22px; }

        /* ══ CATEGORIES ══ */
        .categories { max-width: 1200px; margin: -65px auto 0; padding: 0 2rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; position: relative; z-index: 10; }
        .cat-card { background: white; border-radius: 1.5rem; padding: 2.5rem 1.5rem; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.08); border: 1px solid rgba(226,232,240,0.6); cursor: pointer; transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1); }
        .cat-card:hover { transform: translateY(-10px); box-shadow: 0 25px 45px rgba(0,0,0,0.12); border-color: #0891b2; }
        .cat-icon { font-size: 2.2rem; margin-bottom: 1.2rem; color: #0891b2; height: 50px; display: flex; align-items: center; justify-content: center; }
        .cat-card h3 { font-size: 1rem; font-weight: 800; color: #0f2d52; margin-bottom: 0.5rem; }
        .cat-card p { font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }

        /* ══ NOUVELLE SECTION : COMMENT UTILISER DOKITA ? (CRÉATIVE & PRO) ══ */
        .guide-modern { max-width: 1280px; margin: 100px auto 60px; padding: 0 2rem; }
        .section-header { text-align: center; margin-bottom: 3rem; }
        .section-badge { display: inline-block; background: #e0f2fe; padding: 0.3rem 1rem; border-radius: 999px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #0891b2; margin-bottom: 1rem; }
        .section-header h2 { font-size: 2rem; font-weight: 800; color: #0f2d52; margin-bottom: 1rem; position: relative; display: inline-block; }
        .section-header h2::after { content: ''; position: absolute; bottom: -12px; left: 25%; width: 50%; height: 3px; background: linear-gradient(90deg, #0891b2, #22d3ee); border-radius: 3px; }
        .section-header p { color: #64748b; max-width: 650px; margin: 1.5rem auto 0; font-size: 1rem; line-height: 1.6; }
        
        .steps-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin: 3rem 0; }
        .step-modern { background: #fff; border-radius: 1.75rem; padding: 2rem 1.5rem; text-align: center; transition: all 0.3s ease; border: 1px solid #eef2ff; box-shadow: 0 10px 30px rgba(0,0,0,0.02); position: relative; overflow: hidden; }
        .step-modern::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, #0891b2, #22d3ee); transform: scaleX(0); transition: transform 0.4s ease; transform-origin: left; }
        .step-modern:hover { transform: translateY(-10px); border-color: #cbd5e1; box-shadow: 0 25px 50px rgba(8,145,178,0.12); }
        .step-modern:hover::before { transform: scaleX(1); }
        .step-number-modern { width: 56px; height: 56px; background: #0f2d52; color: white; font-size: 1.6rem; font-weight: 800; border-radius: 30px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(15,45,82,0.2); transition: all 0.3s; }
        .step-modern:hover .step-number-modern { background: #0891b2; transform: scale(1.05); }
        .step-icon { margin-bottom: 1.2rem; font-size: 2.4rem; color: #0891b2; }
        .step-modern h3 { font-size: 1.2rem; font-weight: 800; color: #0f2d52; margin-bottom: 0.75rem; }
        .step-modern p { font-size: 0.85rem; color: #64748b; line-height: 1.6; }
        .step-link { display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 1.2rem; font-size: 0.8rem; font-weight: 700; color: #0891b2; text-decoration: none; border-bottom: 1px dashed #0891b2; transition: gap 0.2s; }
        .step-link:hover { gap: 0.75rem; }

        /* ══ BANDEAU VIDÉO / TÉMOIGNAGE (optionnel pour renforcer) ══ */
        .video-banner { background: linear-gradient(135deg, #0f2d52 0%, #0a1f3a 100%); border-radius: 2rem; padding: 2.5rem; margin: 3rem 0 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 2rem; }
        .video-text h4 { color: white; font-size: 1.3rem; font-weight: 800; margin-bottom: 0.5rem; }
        .video-text p { color: #94a3b8; font-size: 0.9rem; }
        .video-btn { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 999px; padding: 0.8rem 1.8rem; color: white; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; transition: all 0.2s; cursor: pointer; }
        .video-btn:hover { background: #0891b2; border-color: #0891b2; transform: scale(1.02); }

        /* ══ MAIN CONTENT (FAQ + ASIDE) ══ */
        .main-container { max-width: 1280px; margin: 60px auto 80px; padding: 0 2rem; display: grid; grid-template-columns: 1fr 380px; gap: 4rem; }
        .faq-section .section-title { font-size: 1.5rem; font-weight: 800; color: #0f2d52; display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
        .title-icon { width: 44px; height: 44px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; color: #0891b2; font-size: 1.3rem; font-weight: 900; }
        .faq-list { display: flex; flex-direction: column; gap: 0.75rem; }
        .faq-item { background: white; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden; transition: all 0.2s; }
        .faq-item:hover { border-color: #0891b2; box-shadow: 0 8px 25px rgba(8,145,178,0.08); }
        .faq-item summary { padding: 1.2rem 1.5rem; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; font-weight: 700; color: #0f2d52; }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-q { font-weight: 700; font-size: 0.95rem; }
        .faq-arrow { width: 14px; height: 14px; color: #cbd5e1; transition: transform 0.3s; }
        .faq-item[open] .faq-arrow { transform: rotate(90deg); color: #0891b2; }
        .faq-a { padding: 0 1.5rem 1.2rem; color: #64748b; line-height: 1.7; font-size: 0.875rem; }

        /* ══ SIDEBAR CARDS ══ */
        .side-card-dark { background: #0f2d52; border-radius: 2rem; padding: 2.5rem; color: white; margin-bottom: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .side-card-dark h3 { font-size: 1.3rem; font-weight: 800; margin-bottom: 1rem; }
        .contact-item { display: flex; align-items: center; gap: 1rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border-radius: 0.75rem; margin-bottom: 0.75rem; text-decoration: none; color: white; font-weight: 700; font-size: 0.85rem; transition: 0.2s; }
        .contact-item:hover { background: rgba(255,255,255,0.12); }
        .btn-chat { width: 100%; margin-top: 1rem; padding: 1rem; background: #00c2cb; color: white; border-radius: 0.75rem; font-weight: 800; border: none; display: flex; align-items: center; justify-content: center; gap: 0.6rem; cursor: pointer; transition: 0.2s; }
        .btn-chat:hover { background: #00adb5; transform: translateY(-2px); }
        .side-card-light { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 2rem; padding: 2.5rem; }
        .side-card-light h3 { font-size: 1.2rem; font-weight: 800; color: #0f2d52; margin-bottom: 0.75rem; }
        .side-link { color: #0891b2; font-weight: 800; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: gap 0.2s; }
        .side-link:hover { gap: 0.6rem; }

        /* ══ BOTTOM CTA ══ */
        .bottom-cta { text-align: center; padding: 100px 0; background: #f8fafc; border-top: 1px solid #eef2ff; }
        .bottom-cta h2 { font-size: 2rem; font-weight: 800; color: #0f2d52; margin-bottom: 1rem; }
        .bottom-cta p { color: #64748b; margin-bottom: 2.25rem; font-size: 0.95rem; }
        .btn-ticket { display: inline-flex; background: #0f2d52; color: white; padding: 1rem 2.5rem; border-radius: 0.75rem; font-weight: 800; text-decoration: none; transition: 0.3s; }
        .btn-ticket:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(15,45,82,0.2); background: #0891b2; }

        .footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid #1e293b; margin-top: 3rem; font-size: 0.75rem; }

        @media (max-width: 1024px) {
            .categories, .steps-container { grid-template-columns: repeat(2,1fr); }
            .main-container { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 640px) {
            .categories, .steps-container { grid-template-columns: 1fr; }
            .hero h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <nav id="main-nav" class="fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-[72px] items-center justify-between">
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center border-2 border-white px-4 py-2 rounded-lg">
                        <span class="text-white font-black text-xl tracking-tight">Dokita</span>
                    </span>
                </a>
                <div class="hidden lg:flex items-center">
                    <a href="{{ route('home') }}#about" class="nav-link">Qui sommes-nous&nbsp;?</a>
                    <a href="{{ route('faq') }}" class="nav-link">Besoin d'aide&nbsp;?</a>
                    <a href="{{ route('professional') }}" class="nav-link">Espace professionnel</a>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="rounded-lg border-2 border-white/60 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Se connecter</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-[#0284c7]">S'inscrire</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white transition">Mon espace</a>
                    @endguest
                </div>
                <button class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/30 text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden border-t border-white/10 bg-[#0f2d52] px-4 py-5 lg:hidden">
            <!-- menu mobile identique à l'original -->
            <div class="space-y-1">
                <a href="{{ route('home') }}#about" class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10">Qui sommes-nous&nbsp;?</a>
                <a href="{{ route('faq') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10">Besoin d'aide&nbsp;?</a>
                <a href="{{ route('professional') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10">Espace professionnel</a>
            </div>
            <div class="mt-4 flex flex-col gap-3 pt-4 border-t border-white/10">
                @guest
                    <a href="{{ route('login') }}" class="block rounded-lg border-2 border-white/50 px-4 py-3 text-center text-sm font-bold text-white">Se connecter</a>
                    <a href="{{ route('register') }}" class="block rounded-lg bg-[#0891b2] px-4 py-3 text-center text-sm font-bold text-white">S'inscrire</a>
                @else
                    <a href="{{ route('dashboard') }}" class="block rounded-lg bg-[#0891b2] px-4 py-3 text-center text-sm font-bold text-white">Mon espace</a>
                @endguest
            </div>
        </div>
    </nav>

    <main>
        <section class="hero">
            <div class="max-w-4xl mx-auto px-6">
                <h1>Comment pouvons-nous vous aider ?</h1>
                <div class="search-wrap">
                    <input type="text" class="search-input" placeholder="Rechercher une réponse (ex: prendre rendez-vous...)">
                    <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z"/>
                    </svg>
                </div>
            </div>
        </section>

       
        <!-- ========== SECTION COMMENT UTILISER DOKITA ? CRÉATIVE & PRO ========== -->
       <!-- ========== SECTION CATÉGORIES - VERSION PROFESSIONNELLE ========== -->
<div class="categories-section">
    <div class="categories-container">
        <div class="section-top">
            <h2>Explorez par thématique</h2>
            <p>Des réponses claires et structurées pour chaque besoin</p>
        </div>
        <div class="categories-grid">
            <a href="#" class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <h3>Patients</h3>
                <p>RDV, rappels, documents</p>
                <span class="count">12 articles</span>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                    </svg>
                </div>
                <h3>Praticiens</h3>
                <p>Agenda, téléconsultation</p>
                <span class="count">8 articles</span>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </div>
                <h3>Compte & sécurité</h3>
                <p>Données, confidentialité</p>
                <span class="count">15 articles</span>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />
                        <line x1="12" y1="18" x2="12" y2="18" stroke-width="2.5" />
                    </svg>
                </div>
                <h3>Application mobile</h3>
                <p>Installation, notifications</p>
                <span class="count">6 articles</span>
            </a>
        </div>
    </div>
</div>

<style>
    .categories-section {
        max-width: 1280px;
        margin: 60px auto 0;
        padding: 0 2rem;
        position: relative;
        z-index: 15;
    }
    .section-top {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .badge {
        display: inline-block;
        background: #e0f2fe;
        color: #0891b2;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.3rem 1rem;
        border-radius: 999px;
        margin-bottom: 1rem;
    }
    .section-top h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0f2d52;
        margin-bottom: 0.5rem;
    }
    .section-top p {
        color: #64748b;
        font-size: 0.95rem;
    }
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.8rem;
    }
    .category-card {
        background: #ffffff;
        border-radius: 1.5rem;
        padding: 2rem 1.5rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid #eef2ff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }
    .category-card:hover {
        transform: translateY(-6px);
        border-color: #0891b2;
        box-shadow: 0 20px 35px rgba(8,145,178,0.1);
    }
    .category-icon {
        width: 64px;
        height: 64px;
        background: #f0f9ff;
        border-radius: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0891b2;
        transition: all 0.2s;
    }
    .category-card:hover .category-icon {
        background: #0891b2;
        color: white;
        transform: scale(1.02);
    }
    .category-card h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f2d52;
        margin: 0.5rem 0 0.2rem;
    }
    .category-card p {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
    }
    .count {
        font-size: 0.7rem;
        font-weight: 700;
        background: #f8fafc;
        padding: 0.25rem 0.8rem;
        border-radius: 999px;
        color: #0891b2;
        margin-top: 0.5rem;
    }
    @media (max-width: 1024px) {
        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .categories-section {
            margin-top: -40px;
        }
        .categories-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

        <div class="main-container">
            <div class="faq-section">
                <div class="section-title"><div class="title-icon">?</div><span>Questions fréquentes</span></div>
                <div class="faq-list">
                    @php
                        $faqs = [
                            ['q' => 'Comment prendre rendez-vous en ligne ?', 'a' => "C'est très simple ! Recherchez un médecin par nom ou par spécialité sur la page d'accueil, choisissez un créneau disponible et confirmez votre rendez-vous. Vous recevrez une confirmation immédiate par SMS."],
                            ['q' => 'Est-ce que le service est gratuit pour les patients ?', 'a' => "Oui, la recherche et la prise de rendez-vous sur Dokita sont entièrement gratuites pour tous les patients au Bénin."],
                            ['q' => "Que faire en cas d'urgence ?", 'a' => "En cas d'urgence vitale, composez immédiatement le 122 (SAMU Bénin). Vous pouvez également utiliser le bouton 'Déclarer une urgence' sur notre plateforme pour être orienté vers la structure la plus proche."],
                            ['q' => 'Comment annuler un rendez-vous ?', 'a' => "Vous pouvez annuler ou reporter votre rendez-vous depuis votre espace patient, dans la section 'Mes rendez-vous', au moins 4 heures avant l'heure prévue."],
                            ['q' => 'Recevrai-je un rappel avant mon rendez-vous ?', 'a' => "Oui ! Vous recevrez un email et un SMS de rappel 24 heures avant votre rendez-vous."],
                            ['q' => 'Mes données de santé sont-elles sécurisées ?', 'a' => "Absolument. Dokita utilise des protocoles de chiffrement de bout en bout et respecte les normes de protection des données de santé au Bénin."]
                        ];
                    @endphp
                    @foreach($faqs as $f)
                    <details class="faq-item">
                        <summary><span class="faq-q">{{ $f['q'] }}</span><svg class="faq-arrow" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></summary>
                        <div class="faq-a">{{ $f['a'] }}</div>
                    </details>
                    @endforeach
                </div>
                <div class="mt-8 text-center"><a href="#" class="text-[#0f2d52] font-extrabold text-sm border-b-2 border-[#0f2d52] pb-1 hover:text-[#0891b2]">Voir toutes les questions →</a></div>
            </div>

            <aside>
                <div class="side-card-dark">
                    <h3>Besoin d'un contact direct ?</h3>
                    <p>Notre équipe de support est disponible du Lundi au Samedi.</p>
                    <a href="tel:+22921000000" class="contact-item"><span>📞</span><span>+229 21 00 00 00</span></a>
                    <a href="mailto:support@dokita.bj" class="contact-item"><span>✉️</span><span>support@dokita.bj</span></a>
                    <button class="btn-chat"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Chat en direct</button>
                </div>
                <div class="side-card-light">
                    <h3>Vous êtes un praticien ?</h3>
                    <p>Découvrez comment Dokita peut transformer votre activité.</p>
                    <a href="#" class="side-link">En savoir plus →</a>
                </div>
            </aside>
        </div>

        <section class="bottom-cta">
            <div class="max-w-2xl mx-auto px-6">
                <h2>Toujours pas trouvé de réponse ?</h2>
                <p>Envoyez-nous un message détaillé et nous vous répondrons sous 24h.</p>
                <a href="#" class="btn-ticket">Ouvrir un ticket support</a>
            </div>
        </section>
    </main>

    {{-- ══════════ FOOTER ══════════ --}}
    <footer class="bg-slate-950 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-4">
                <div>
                    <span class="inline-flex items-center justify-center border-2 border-white/30 px-3 py-1.5 rounded-lg">
                        <span class="text-white font-black text-lg">Dokita</span>
                    </span>
                    <p class="mt-4 text-sm leading-7 text-slate-400">Plateforme e-santé pour la prise de rendez-vous, la géolocalisation d'hôpitaux et les rappels automatiques au Bénin.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="#"    class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10 transition">Support</a>
                        <a href="#faq" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10 transition">FAQ</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Navigation</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}#hospitaux"   class="hover:text-white transition font-semibold">Hôpitaux</a></li>
                        <li><a href="{{ route('home') }}#medecins"    class="hover:text-white transition font-semibold">Médecins</a></li>
                        <li><a href="{{ route('home') }}#temoignages" class="hover:text-white transition font-semibold">Témoignages</a></li>
                        <li><a href="{{ route('faq') }}"         class="hover:text-white transition font-semibold">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Contact</h3>
                    <p class="text-sm text-slate-400">support@dokita.bj</p>
                    <p class="mt-3 text-sm text-slate-400">+229 90 00 00 00</p>
                    <p class="mt-3 text-xs text-slate-500">Lun–Ven 08:00–18:00</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Réseaux</h3>
                    <div class="flex flex-wrap gap-3 text-white">
                        <a href="#" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/10 transition">FB</a>
                        <a href="#" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/10 transition">TW</a>
                        <a href="#" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/10 transition">IG</a>
                    </div>
                    <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs uppercase tracking-widest text-slate-500 font-bold">Sécurité</p>
                        <p class="mt-2 text-sm text-slate-400 leading-relaxed">Vos informations sont protégées et utilisées uniquement pour la gestion des rendez-vous.</p>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-slate-800 pt-8 text-xs text-slate-600 text-center">© {{ date('Y') }} Dokita. Tous droits réservés.</div>
        </div>
    </footer>
</body>
</html>