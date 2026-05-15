<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokita — Votre santé en quelques clics</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .reveal { transform: translateY(20px); opacity: 0; transition: transform 800ms cubic-bezier(.2,.8,.2,1), opacity 800ms ease; }
        .reveal.reveal-visible { transform: translateY(0); opacity: 1; }
        .leaflet-container { border-radius: 18px; }

        /* ══ NAV ══ */
        #main-nav { background: #0f2d52; box-shadow: 0 2px 20px rgba(0,0,0,0.25); }
        .nav-link { color: rgba(255,255,255,0.85); font-weight: 600; font-size: 0.875rem; transition: color 0.2s; position: relative; padding-bottom: 2px; margin: 0 1.5rem; }
        .nav-link:hover { color: #ffffff; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#22d3ee; transition:width 0.25s ease; }
        .nav-link:hover::after { width:100%; }

        /* ══ HERO ══ */
        #accueil { background: #0f2d52; position: relative; overflow: hidden; min-height: 100vh; }
        .blob { position:absolute; pointer-events:none; }
        .blob-1 { width:500px; height:500px; background:rgba(6,182,212,0.18); top:-120px; left:-80px; border-radius:60% 40% 55% 45% / 50% 60% 40% 50%; }
        .blob-2 { width:380px; height:380px; background:rgba(2,132,199,0.22); bottom:-100px; left:200px; border-radius:45% 55% 40% 60% / 55% 45% 55% 45%; }
        .blob-3 { width:160px; height:160px; background:#fbbf24; top:80px; right:460px; border-radius:9999px; opacity:0.55; }
        .blob-4 { width:420px; height:420px; background:rgba(6,182,212,0.15); bottom:-80px; right:-60px; border-radius:50% 50% 40% 60% / 45% 55% 45% 55%; }
        .hero-badge { display:inline-flex; align-items:center; gap:0.5rem; background:rgba(255,255,255,0.10); border:1px solid rgba(255,255,255,0.20); border-radius:9999px; padding:0.4rem 0.875rem; font-size:0.75rem; font-weight:700; color:rgba(255,255,255,0.90); }
        .hero-inner { position:relative; z-index:10; width:100%; max-width:80rem; margin:0 auto; padding-left:2rem; padding-right:2rem; padding-top:calc(72px + 10rem); padding-bottom:5rem; display:flex; align-items:flex-start; gap:4rem; }
        .hero-left { flex:1 1 0%; min-width:0; }
        .hero-right { flex:0 0 420px; width:420px; align-self:flex-start; position:sticky; top:calc(72px + 1.5rem); }
        .hero-card { background:#ffffff; border-radius:1.25rem; box-shadow:0 30px 80px rgba(0,0,0,0.35); padding:2.25rem 2rem; width:100%; box-sizing:border-box; }
        .form-input { width:100%; border:1.5px solid #e2e8f0; border-radius:0.625rem; padding:0.75rem 1rem; font-size:0.875rem; color:#334155; background:#f8fafc; transition:border-color .2s,box-shadow .2s; outline:none; box-sizing:border-box; }
        .form-input:focus { border-color:#0891b2; box-shadow:0 0 0 3px rgba(8,145,178,0.12); background:#fff; }
        .form-input::placeholder { color:#94a3b8; }
        .form-select { width:100%; border:1.5px solid #e2e8f0; border-radius:0.625rem; padding:0.75rem 1rem; font-size:0.875rem; color:#334155; background:#f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 1rem center; appearance:none; cursor:pointer; transition:border-color .2s; outline:none; box-sizing:border-box; }
        .form-select:focus { border-color:#0891b2; box-shadow:0 0 0 3px rgba(8,145,178,0.12); background-color:#fff; }
        .btn-primary { display:inline-flex; align-items:center; justify-content:center; width:100%; padding:0.875rem 1.5rem; background:#0891b2; color:#fff; font-weight:800; font-size:0.9rem; border-radius:0.625rem; transition:background .2s,transform .15s; cursor:pointer; border:none; }
        .btn-primary:hover { background:#0284c7; transform:translateY(-1px); }

        /* ══ SECTION LABEL ══ */
        .section-label { font-size:11px; font-weight:700; letter-spacing:0.22em; text-transform:uppercase; color:#0891b2; display:block; }

        /* ══ FEATURE CARDS ══ */
        .feature-card { background:#fff; border:1px solid #e2e8f0; border-radius:1.5rem; padding:1.75rem; transition:box-shadow 0.25s, transform 0.25s, border-color 0.25s; }
        .feature-card:hover { box-shadow:0 12px 40px rgba(8,145,178,0.12); transform:translateY(-3px); border-color:#bae6fd; }
        .feature-icon { width:52px; height:52px; border-radius:1rem; background:rgba(8,145,178,0.08); border:1px solid rgba(8,145,178,0.18); display:flex; align-items:center; justify-content:center; flex-shrink:0; }

        /* ══ STAT CARDS ══ */
        .stat-card { background:#0f2d52; border-radius:1.5rem; padding:1.75rem 2rem; color:#fff; position:relative; overflow:hidden; }
        .stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:100px; height:100px; background:rgba(34,211,238,0.12); border-radius:9999px; }
        .stat-number { font-size:2.5rem; font-weight:900; color:#ffffff; line-height:1; }
        .stat-label { font-size:0.8rem; font-weight:600; color:rgba(255,255,255,0.55); margin-top:0.375rem; text-transform:uppercase; letter-spacing:0.1em; }
        .stat-trend { display:inline-flex; align-items:center; gap:4px; background:rgba(34,211,238,0.15); border:1px solid rgba(34,211,238,0.25); border-radius:9999px; padding:3px 10px; font-size:11px; font-weight:700; color:#22d3ee; margin-top:0.75rem; }

        /* ══ DOCTOR CARDS ══ */
        .doctor-card { background:#fff; border:1px solid #e2e8f0; border-radius:1.5rem; overflow:hidden; transition:box-shadow 0.25s, transform 0.25s; }
        .doctor-card:hover { box-shadow:0 16px 48px rgba(0,0,0,0.10); transform:translateY(-3px); }
        .doctor-tag { display:inline-flex; align-items:center; gap:6px; background:rgba(8,145,178,0.08); border:1px solid rgba(8,145,178,0.18); border-radius:9999px; padding:4px 12px; font-size:11px; font-weight:700; color:#0891b2; }

        /* ══ TIMELINE ══ */
        .timeline-step { display:flex; gap:1.25rem; align-items:flex-start; }
        .timeline-num { width:40px; height:40px; border-radius:9999px; background:#0891b2; color:#fff; font-weight:900; font-size:0.9rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 16px rgba(8,145,178,0.35); }
        .timeline-connector { width:2px; background:linear-gradient(to bottom, #0891b2, rgba(8,145,178,0.15)); margin-left:19px; height:2rem; }

        /* ══ TESTIMONIAL CARDS ══ */
        .testimonial-card { background:#fff; border:1px solid #e2e8f0; border-radius:1.5rem; padding:2rem; transition:box-shadow 0.25s, transform 0.25s; }
        .testimonial-card:hover { box-shadow:0 12px 40px rgba(0,0,0,0.08); transform:translateY(-2px); }
        .quote-icon { color:rgba(8,145,178,0.15); font-size:5rem; line-height:1; font-family:Georgia,serif; position:absolute; top:0.5rem; right:1.5rem; }

        /* ══ MAP SECTION ══ */
        .map-card { background:#fff; border-radius:2rem; border:1px solid #e2e8f0; padding:1.5rem; }

        /* ══ CTA BAND ══ */
        .cta-band { background:linear-gradient(135deg, #0f2d52 0%, #0c4a6e 100%); border-radius:2rem; padding:4rem 3rem; position:relative; overflow:hidden; }
        .cta-band::before { content:''; position:absolute; top:-60px; right:-60px; width:300px; height:300px; background:rgba(34,211,238,0.08); border-radius:9999px; }
        .cta-band::after  { content:''; position:absolute; bottom:-80px; left:10%; width:250px; height:250px; background:rgba(8,145,178,0.10); border-radius:9999px; }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 1023px) {
            .hero-inner { flex-direction:column-reverse; padding-top:calc(72px + 2.5rem); gap:2rem; }
            .hero-right { flex:none; width:100%; position:static; }
        }
    </style>
</head>

<body class="min-h-screen text-slate-900 overflow-x-hidden bg-slate-50">
<div class="relative">

    {{-- ══ NAV (inchangée) ══ --}}
    <nav id="main-nav" class="fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-[72px] items-center justify-between">
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center border-2 border-white px-4 py-2 rounded-lg">
                        <span class="text-white font-black text-xl tracking-tight">Dokita</span>
                    </span>
                </a>
                <div class="hidden lg:flex items-center">
                    <a href="#about"                       class="nav-link">Qui sommes-nous&nbsp;?</a>
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
                <a href="#about"                       class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Qui sommes-nous&nbsp;?</a>
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

    <main>

        {{-- ══ HERO (inchangée) ══ --}}
        <section id="accueil">
            <div class="blob blob-1" aria-hidden="true"></div>
            <div class="blob blob-2" aria-hidden="true"></div>
            <div class="blob blob-3" aria-hidden="true"></div>
            <div class="blob blob-4" aria-hidden="true"></div>
            <div class="hero-inner">
                <div class="hero-left reveal">
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white leading-[1.05] mb-8">
                        L'expérience médicale,<br>
                        <span class="text-[#22d3ee]">numérique</span><br>
                        pensée pour tous.
                    </h1>
                    <p class="text-lg sm:text-xl text-white leading-relaxed mb-10 max-w-lg font-medium">
                        Localisez les meilleurs établissements de santé près de chez vous.
                        Prenez rendez-vous et recevez des rappels automatiques.
                    </p>
                    <div class="flex flex-wrap gap-3 mb-12">
                        <div class="hero-badge">✅ Gratuit pour les patients</div>
                        <div class="hero-badge">🔒 Données sécurisées</div>
                    </div>
                    <div class="grid grid-cols-3 gap-8 border-t border-white/10 pt-10 max-w-lg">
                        <div>
                            <p class="text-3xl sm:text-4xl font-black text-white">{{ max(0, count($hopitaux)) }}</p>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-white font-bold mt-1">Hôpitaux</p>
                        </div>
                        <div class="border-l border-white/10 pl-8">
                            <p class="text-3xl sm:text-4xl font-black text-white">+1.2k</p>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-white font-bold mt-1">RDV / mois</p>
                        </div>
                        <div class="border-l border-white/10 pl-8">
                            <p class="text-3xl sm:text-4xl font-black text-white">24/7</p>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-white font-bold mt-1">Disponible</p>
                        </div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-card reveal">
                        <h3 class="text-xl font-black text-slate-900 mb-6">Prendre rendez-vous</h3>
                        <form action="{{ route('rdv.create') }}" method="GET" class="space-y-4">
                            <select class="form-select" name="specialite" required>
                                <option value="" disabled selected>Choisir une spécialité *</option>
                                <option>Médecine générale</option><option>Cardiologie</option>
                                <option>Pédiatrie</option><option>Gynécologie</option>
                                <option>Dermatologie</option><option>Urgences</option>
                            </select>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text"  class="form-input" placeholder="Prénom *"  name="prenom"    required>
                                <input type="text"  class="form-input" placeholder="Nom *"      name="nom"       required>
                            </div>
                            <input type="email" class="form-input" placeholder="Adresse e-mail *" name="email"     required>
                            <input type="tel"   class="form-input" placeholder="Téléphone *"       name="telephone" required>
                            <select class="form-select" name="hopital" required>
                                <option value="" disabled selected>Choisir un hôpital *</option>
                                @foreach($hopitaux as $h)
                                    <option value="{{ $h->id }}">{{ $h->nom }}</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-400">* Champs obligatoires</p>
                            <button type="submit" class="btn-primary">Confirmer la demande</button>
                        </form>
                        <p class="mt-5 text-[11px] text-slate-400 flex items-start gap-2 leading-relaxed">
                            <span class="text-[#0891b2] text-sm flex-shrink-0">🛡</span>
                            Vos informations sont sécurisées et traitées conformément à la protection des données de santé.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════ TRUST BAND (Style Doctolib) ══════════ --}}
<section class="mt-24 mb-20 py-20" style="background-color: #bae6fd !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- La Grande Citation --}}
        <div class="relative max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-4xl font-black text-[#0f2d52] leading-[1.4] mb-8">
                Parce que chaque minute compte, <br> Dokita facilite la recherche d’hôpitaux et la prise de rendez-vous médicaux.
            </h2>
            <p class="text-lg font-black text-[#0891b2] tracking-wide">L'équipe Dokita & ses partenaires</p>
        </div>
    </div>
</section>

        {{-- ══════════ QUI SOMMES-NOUS ? ══════════ --}}
        <section class="mt-16 mb-24 bg-white overflow-hidden" id="about">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- En-tête simplifié --}}
                <div class="text-center mb-16 reveal">
                    <div class="w-24 h-1 bg-[#0891b2] mx-auto rounded-full opacity-20"></div>
                </div>

                <div class="flex flex-col md:flex-row gap-12 lg:gap-20 items-center">
                    {{-- IMAGE - Décollée et arrondie --}}
                    <div class="w-full md:w-5/12">
                        <img src="/images/doctor-tablet.jpg" 
                             alt="Médecin Dokita" 
                             class="w-full h-[450px] lg:h-[550px] object-cover rounded-[2.5rem] shadow-2xl bg-slate-100">
                    </div>
                    

                    {{-- TEXTE --}}
                    <div class="w-full md:w-7/12 reveal">
                        <span class="section-label mb-4" style="font-size: 1.25rem !important; font-weight: 900 !important;">Qui sommes-nous ?</span>
                        <p class="text-lg text-slate-600 leading-relaxed mb-8">
                            Dokita a été conçue pour simplifier le parcours médical en reliant patients, médecins et hôpitaux sur une plateforme intuitive et sécurisée.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            @php
                                $aboutFeatures = [
                                    ['title'=>'Géolocalisation','desc'=>'Trouvez l\'hôpital le plus proche.'],
                                    ['title'=>'RDV en ligne','desc'=>'Réservez en quelques clics.'],
                                    ['title'=>'Rappels','desc'=>'Ne manquez plus vos consultations.'],
                                    ['title'=>'Urgences','desc'=>'Signalement rapide et efficace.'],
                                ];
                            @endphp
                            @foreach($aboutFeatures as $af)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="font-black text-[#0f2d52] text-sm mb-1">{{ $af['title'] }}</p>
                                <p class="text-slate-500 text-xs">{{ $af['desc'] }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div class="bg-[#f8fafc] border-l-4 border-[#0891b2] p-6 rounded-r-2xl">
                            <p class="text-sm text-slate-700 italic leading-relaxed">
                                « Notre mission est de digitaliser la santé au Bénin pour que chaque citoyen puisse trouver un hôpital et prendre RDV facilement. »
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         {{-- ══════════ NOS ENGAGEMENTS ══════════ --}}
<section class="py-24 relative overflow-hidden bg-white" id="engagements">
    {{-- Décoration de fond --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-500/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20 reveal pt-6">
            
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight">
                Les valeurs qui guident <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-600">chaque décision</span>
            </h2>
            <p class="mt-6 text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                Dokita est construite autour de principes clairs et inébranlables, au service de la santé des patients et du quotidien des professionnels au Bénin.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 reveal">

            {{-- Accessibilité --}}
            <div class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(8,145,178,0.1)] hover:-translate-y-2 transition-all duration-500 overflow-hidden text-center flex flex-col items-center">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="w-20 h-20 mb-6 rounded-2xl bg-cyan-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10 text-cyan-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Accessibilité</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Une solution utilisable sur n'importe quel appareil, sans installation. Pensée pour tous les citoyens, où qu'ils soient.
                </p>
            </div>

            {{-- Sécurité --}}
            <div class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(8,145,178,0.1)] hover:-translate-y-2 transition-all duration-500 overflow-hidden text-center flex flex-col items-center">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="w-20 h-20 mb-6 rounded-2xl bg-cyan-50 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10 text-cyan-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Sécurité absolue</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Vos données médicales sont strictement confidentielles, chiffrées de bout en bout et hébergées en toute sécurité.
                </p>
            </div>

            {{-- Simplicité --}}
            <div class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(8,145,178,0.1)] hover:-translate-y-2 transition-all duration-500 overflow-hidden text-center flex flex-col items-center">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="w-20 h-20 mb-6 rounded-2xl bg-cyan-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10 text-cyan-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Simplicité</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Une interface épurée et intuitive. Trouver un soin ou consulter son dossier ne prend que quelques clics.
                </p>
            </div>

            {{-- Rapidité --}}
            <div class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(8,145,178,0.1)] hover:-translate-y-2 transition-all duration-500 overflow-hidden text-center flex flex-col items-center">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                <div class="w-20 h-20 mb-6 rounded-2xl bg-cyan-50 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500">
                    <svg class="w-10 h-10 text-cyan-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Immédiateté</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Fini les files d'attente interminables. Les urgences et la prise en charge sont signalées en temps réel.
                </p>
            </div>

        </div>
    </div>
</section>


        {{-- ══════════ COMMENT ÇA MARCHE ══════════ --}}
        <section class="py-20 bg-white overflow-hidden" id="comment">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-12 items-center">

                    {{-- Image + features grid --}}
                    <div class="w-full lg:w-1/2 reveal lg:-ml-20">
                        <div class="relative rounded-[2rem] overflow-hidden shadow-2xl" style="height:650px;">
                            <img src="/images/doc.jpg" alt="Consultation médicale" class="w-full h-full object-cover" style="object-position: left center;">
                            <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(15,45,82,0.6) 0%, transparent 60%);"></div>
                            <div class="absolute top-6 left-6">
                                <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.25);border-radius:1.25rem;padding:1rem 1.25rem;display:flex;align-items:center;gap:0.75rem;">
                                    <div style="width:36px;height:36px;background:#0891b2;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
                                        <svg style="width:18px;height:18px;" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <p style="font-size:12px;font-weight:800;color:#fff;">RDV confirmé</p>
                                        <p style="font-size:10px;color:rgba(255,255,255,0.7);">Dr. Amina K. · 14h30</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute bottom-6 right-6">
                                <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.25);border-radius:1.25rem;padding:1rem 1.25rem;">
                                    <p style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.65);text-transform:uppercase;letter-spacing:0.1em;">Rappel envoyé</p>
                                    <p style="font-size:1.5rem;font-weight:900;color:#22d3ee;">89%</p>
                                    <p style="font-size:11px;color:rgba(255,255,255,0.6);">des patients reconfirment</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Texte + timeline --}}
                    <div class="w-full lg:w-1/2">
                    
                        <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-3 mt-2">
                            Prendre un RDV en <span class="text-[#0891b2]">3 étapes</span>
                        </h2>
                        <p class="text-slate-500 text-base mb-10 leading-relaxed">Simple, rapide, sécurisé. Aucune installation requise, accessible depuis n'importe quel appareil.</p>

                        @php
                            $steps = [
                                ['num'=>'1','title'=>'Trouvez un hôpital ou un spécialiste','desc'=>'Utilisez la carte interactive ou le formulaire de recherche pour localiser l\'établissement le plus adapté à votre besoin.'],
                                ['num'=>'2','title'=>'Remplissez le formulaire de demande','desc'=>'Indiquez vos informations, choisissez votre spécialité et confirmez votre créneau en quelques secondes.'],
                                ['num'=>'3','title'=>'Recevez la confirmation & le rappel','desc'=>'Un email de confirmation est envoyé immédiatement. Un rappel automatique est envoyé 24h avant votre rendez-vous.'],
                            ];
                        @endphp
                        <div class="space-y-1">
                            @foreach($steps as $i => $step)
                            <div>
                                <div class="timeline-step">
                                    <div class="timeline-num">{{ $step['num'] }}</div>
                                    <div class="pb-6">
                                        <p class="font-black text-slate-900 text-base">{{ $step['title'] }}</p>
                                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                                    </div>
                                </div>
                                @if($i < count($steps)-1)
                                    <div class="timeline-connector"></div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-12">
                            <a href="{{ route('rdv.create') }}" 
                               class="inline-flex items-center justify-center gap-3 rounded-2xl shadow-xl transition-all hover:bg-[#0369a1] active:scale-95" 
                               style="background-color: #0891b2 !important; color: white !important; padding: 1.25rem 2.5rem !important; font-size: 1.15rem !important; font-weight: 800 !important; border: none; text-decoration: none;">
                                 PRENDRE UN RENDEZ-VOUS →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════ CARTE ══════════ --}}
        <section class="py-20 bg-slate-50" id="hospitaux">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 reveal">
                    <span class="section-label mb-3">Carte interactive</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mt-2">Hôpitaux du Bénin — trouvez près de vous</h2>
                </div>
                <div class="reveal rounded-[2rem] border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                    <div class="grid gap-6 lg:grid-cols-[1fr_320px] items-start">
                        <div class="relative overflow-hidden rounded-[1.75rem] border border-slate-200 bg-slate-900 p-4 sm:p-6">
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <p class="text-white font-black text-lg">Bénin — hôpitaux référencés</p>
                                <span style="background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.15);border-radius:9999px;padding:6px 12px;font-size:11px;font-weight:700;color:#fff;">{{ count($hopitaux) }} lieux</span>
                            </div>
                            <div id="leaflet-map" class="w-full h-[420px]"></div>
                        </div>
                        <aside class="space-y-4">
                            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                                <h3 class="text-lg font-black text-slate-900">Comment ça marche</h3>
                                <ul class="mt-3 space-y-3 text-sm text-slate-600">
                                    <li class="flex gap-3"><span class="font-black text-[#0891b2]">1</span> Repérez le marqueur d'un hôpital</li>
                                    <li class="flex gap-3"><span class="font-black text-[#0891b2]">2</span> Ouvrez la fiche dans le popup</li>
                                    <li class="flex gap-3"><span class="font-black text-[#0891b2]">3</span> Prenez RDV quand vous voulez</li>
                                </ul>
                            </div>
                            <div class="rounded-[1.5rem] border border-slate-200 bg-white p-5">
                                <h3 class="text-lg font-black text-slate-900">Autour de moi</h3>
                                <p class="mt-2 text-sm text-slate-600">Géolocalisation pour centrer la carte.</p>
                                <button onclick="window.dokitaLocateUser()" class="mt-4 w-full inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-bold shadow-md transition-all active:scale-95" style="background-color: #0891b2 !important; color: white !important; border: none;">📍 Centrer la carte</button>
                            </div>
                            <div class="rounded-[1.5rem] border border-slate-200 bg-white p-5">
                                <h3 class="text-lg font-black text-slate-900">Conseil</h3>
                                <p class="mt-2 text-sm text-slate-600">Vérifiez l'adresse et la spécialité dans les popups avant de confirmer un RDV.</p>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- ══════════ TÉMOIGNAGES (Style Doctolib) ══════════ --}}
        <section class="py-24 bg-[#f0f7ff]" id="temoignages">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 reveal">
                    <h2 class="text-4xl md:text-5xl font-black text-[#0f2d52] tracking-tight">Paroles de soignants</h2>
                </div>

                <div class="flex flex-nowrap lg:grid lg:grid-cols-2 gap-8 overflow-x-auto pb-8 lg:pb-0 scrollbar-hide">
                    @php
                        $proQuotes = [
                            [
                                'name' => 'Florian D.',
                                'role' => 'Ostéopathe',
                                'text' => 'Dokita améliore ma pratique : moins d\'appels en consultation pour plus d\'attention aux consultants. L\'application et le site sont de plus en plus efficaces.',
                                'img' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=400&h=500&auto=format&fit=crop'
                            ],
                            [
                                'name' => 'Dr Patrick M.',
                                'role' => 'Gastro-entérologue',
                                'text' => 'J\'ai gagné au moins cinq minutes par consultation ! La gestion des rendez-vous est fluide et permet de se concentrer sur l\'essentiel : le patient.',
                                'img' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=400&h=500&auto=format&fit=crop'
                            ]
                        ];
                    @endphp

                    @foreach($proQuotes as $q)
                    <div class="min-w-[85vw] sm:min-w-[600px] lg:min-w-0 bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col sm:flex-row reveal">
                        {{-- Image side --}}
                        <div class="w-full sm:w-2/5 h-64 sm:h-auto relative">
                            <img src="{{ $q['img'] }}" alt="{{ $q['name'] }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                        </div>
                        {{-- Text side --}}
                        <div class="w-full sm:w-3/5 p-8 lg:p-10 flex flex-col justify-center">
                            <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $q['name'] }}</h3>
                            <p class="text-sm font-semibold text-slate-500 mb-6">{{ $q['role'] }}</p>
                            
                            <div class="relative">
                                <p class="text-slate-600 leading-relaxed italic">
                                    « {{ $q['text'] }} »
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Mobile scroll hint --}}
                <div class="flex justify-center gap-2 mt-8 lg:hidden">
                    <div class="w-2 h-2 rounded-full bg-[#0891b2]"></div>
                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                </div>
            </div>
        </section>

        {{-- ══════════ CTA ══════════ --}}
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="cta-band relative overflow-hidden rounded-[3rem] p-10 md:p-16 lg:p-20 shadow-2xl" style="background: #0f2d52 !important;">
                    {{-- Decorative background --}}
                    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/3 w-[500px] h-[500px] bg-cyan-500/20 rounded-full blur-[120px]"></div>
                    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/3 w-[400px] h-[400px] bg-blue-600/30 rounded-full blur-[100px]"></div>

                    <div class="relative z-10 grid lg:grid-cols-2 gap-12 items-center">
                        <div class="text-left">
                            <span class="inline-block px-4 py-1.5 rounded-full bg-white text-cyan-400 text-xs font-black uppercase tracking-widest mb-6 border border-white/10">
                                Prêt à commencer ?
                            </span>
                            <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">
                                Rejoignez l'ère de la <span class="text-cyan-400">santé numérique</span> au Bénin
                            </h2>
                            <p class="text-slate-300 text-lg leading-relaxed mb-10">
                                Simplifiez la prise de rendez-vous, réduisez les absences grâce aux rappels et accédez à un réseau de santé fiable en quelques clics.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-10 py-5 text-base font-black text-[#0f2d52] hover:bg-cyan-50 transition-all shadow-xl hover:translate-y-[-3px]">
                                    Créer mon compte gratuit
                                </a>
                                <a href="#hospitaux" class="inline-flex items-center justify-center rounded-2xl border-2 border-white/20 bg-white/5 px-10 py-5 text-base font-black text-white hover:bg-white/10 transition-all">
                                    Voir les hôpitaux
                                </a>
                            </div>
                        </div>
                        <div class="hidden lg:block relative">
                            {{-- Mock UI --}}
                            <div class="relative bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-8 shadow-2xl overflow-hidden">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex gap-2">
                                        <div class="w-3 h-3 rounded-full bg-red-400/50"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400/50"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-400/50"></div>
                                    </div>
                                    <div class="text-[10px] font-black text-white uppercase tracking-widest">Dokita Interface</div>
                                </div>
                                <div class="space-y-4">
                                    <div class="h-10 bg-white/10 rounded-xl w-3/4"></div>
                                    <div class="h-28 bg-white/5 rounded-xl w-full flex items-center justify-center border border-white/5">
                                        <div class="w-14 h-14 rounded-full bg-cyan-500/20 flex items-center justify-center border border-cyan-500/30">
                                            <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="h-16 bg-white/5 rounded-xl border border-white/5"></div>
                                        <div class="h-16 bg-white/5 rounded-xl border border-white/5"></div>
                                    </div>
                                </div>
                            </div>
                            {{-- Badge --}}
                            <div class="absolute -bottom-4 -right-4 bg-[#0891b2] text-white p-6 rounded-3xl shadow-2xl border border-white/10">
                                <p class="text-3xl font-black">+25k</p>
                                <p class="text-[10px] font-bold uppercase tracking-widest opacity-80">RDV gérés</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function(){
    const io=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('reveal-visible');}),{threshold:0.10});
    document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
})();
document.addEventListener('DOMContentLoaded',function(){
    const mapEl=document.getElementById('leaflet-map');
    if(!mapEl)return;
    const map=L.map('leaflet-map',{scrollWheelZoom:true}).setView([6.3654,2.4183],8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);
    const hospIcon=L.divIcon({html:'<div style="width:40px;height:40px;border-radius:50%;background:#0891b2;display:flex;align-items:center;justify-content:center;color:#fff;border:3px solid #fff;box-shadow:0 8px 24px rgba(8,145,178,.4)">🏥</div>',iconSize:[40,40],iconAnchor:[20,40],className:''});
    window.dokitaLocateUser=function(){if(!navigator.geolocation)return;navigator.geolocation.getCurrentPosition(pos=>map.setView([pos.coords.latitude,pos.coords.longitude],14,{animate:true}),()=>{},{enableHighAccuracy:true,timeout:8000});};
    @php $hopitauxJson=$hopitaux->map(fn($h)=>['id'=>$h->id,'nom'=>$h->nom,'adresse'=>$h->adresse??'Bénin','lat'=>$h->latitude,'lng'=>$h->longitude])->values()->toArray(); @endphp
    const data={!! json_encode($hopitauxJson) !!};
    const bounds=[];
    data.forEach(h=>{
        if(typeof h.lat==='number'&&typeof h.lng==='number'){
            bounds.push([h.lat,h.lng]);
            L.marker([h.lat,h.lng],{icon:hospIcon}).addTo(map).bindPopup(
                `<div style="font-family:Inter,sans-serif;padding:8px 10px">
                    <div style="font-weight:800;margin-bottom:4px">${h.nom}</div>
                    <div style="color:#64748b;font-size:12px;margin-bottom:8px">${h.adresse||''}</div>
                    <a href="/hopitaux/${h.id}" style="display:block;text-align:center;background:#0891b2;color:#fff;padding:8px;border-radius:10px;font-size:12px;font-weight:800;text-decoration:none">📅 Prendre RDV</a>
                </div>`
            );
        }
    });
    if(bounds.length)map.fitBounds(bounds,{padding:[20,20]});
});
</script>

@include('partials.samu-modal')

</body>
</html>