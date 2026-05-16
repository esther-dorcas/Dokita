@extends('layouts.medecin')

@section('title', 'Profil Professionnel — Dokita PRO')

@push('head')
<style>
    :root {
        --blue: #2563eb; /* Patient Blue */
        --dark: #0c2340; /* Patient Dark */
        --radius-xl: 20px;
        --radius-lg: 14px;
    }

    /* ── ANIMATIONS ── */
    @keyframes slideUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.35} }
    .animate-up { animation: slideUp 0.4s ease-out; }

    /* ── HERO ── */
    .hero {
        background: var(--dark);
        border-radius: var(--radius-xl);
        padding: 32px 28px 76px;
        position: relative; overflow: hidden;
        margin-bottom: 0;
    }
    .hero-deco1 { position:absolute; top:-50px; right:-50px; width:220px; height:220px; border-radius:50%; background:rgba(2,132,199,.18); }
    .hero-deco2 { position:absolute; bottom:-70px; right:80px; width:160px; height:160px; border-radius:50%; background:rgba(2,132,199,.1); }
    
    .hero-content { position:relative; z-index:2; display:flex; align-items:center; gap:20px; }
    
    .avatar-wrapper {
        width: 64px; height: 64px; background: rgba(255,255,255,0.1);
        border-radius: 16px; display: flex; align-items: center; justify-content: center;
        font-size: 24px; font-weight: 800; color: #fff;
        border: 2px solid rgba(255,255,255,0.2); flex-shrink: 0;
    }
    .hero-tag {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
        padding: 3px 12px; border-radius: 20px;
        font-size: 10px; font-weight: 700; color: #bae6fd;
        margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .hero-dot { width: 6px; height: 6px; border-radius: 50%; background: #38bdf8; animation: pulse 2s infinite; }
    .hero-title { font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 4px; line-height: 1.2; }
    .hero-sub   { font-size: 13px; color: rgba(255,255,255,.45); margin: 0; line-height: 1.5; }

    /* ── CONTENT GRID ── */
    .profile-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: -44px; position: relative; z-index: 10; padding: 0 2px; }
    @media (max-width: 1024px) { .profile-grid { grid-template-columns: 1fr; } }

    /* ── CARDS ── */
    .form-card {
        background: #fff; border-radius: var(--radius-xl); padding: 32px;
        border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,0.02); margin-bottom: 24px;
    }
    .section-title {
        font-size: 11px; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px;
    }
    .section-title::after { content: ""; flex: 1; height: 1px; background: #f1f5f9; }

    /* ── FORMS ── */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 640px) { .form-row { grid-template-columns: 1fr; } }

    .field-group { margin-bottom: 20px; }
    .field-label { font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 6px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    .field-input {
        width: 100%; padding: 12px 14px; border-radius: 10px;
        background: #f8fafc; border: 1px solid #e2e8f0;
        font-size: 13px; font-weight: 600; color: #0f172a;
        transition: 0.2s; outline: none;
    }
    .field-input:focus { background: #fff; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(2,132,199, 0.1); }
    select.field-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2364748b' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; }

    /* ── HORAIRES CARD ── */
    .schedule-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
    .schedule-row:last-child { border-bottom: none; padding-bottom: 0; }
    .schedule-day { font-weight: 700; color: #0f172a; }
    .schedule-hours { color: var(--blue); font-weight: 600; background: #f0f9ff; padding: 4px 10px; border-radius: 6px; }
    .schedule-closed { color: #ef4444; font-weight: 600; background: #fef2f2; padding: 4px 10px; border-radius: 6px; }

    /* ── BUTTONS ── */
    .btn-premium {
        background: var(--blue); color: #fff;
        padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 12px;
        border: none; cursor: pointer; transition: 0.2s; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;
    }
    .btn-premium:hover { background: #0369a1; }

    .btn-sec {
        display: block; width: 100%; padding: 12px; text-align: center;
        border-radius: 10px; background: #f8fafc; color: #0f172a; font-weight: 700; font-size: 12px;
        border: 1px solid #e2e8f0; transition: 0.2s; text-decoration: none;
    }
    .btn-sec:hover { background: #f1f5f9; border-color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="animate-up">
    
    {{-- ══ HERO PROFILE ══ --}}
    <div class="hero">
        <div class="hero-deco1"></div>
        <div class="hero-deco2"></div>
        <div class="hero-content">
            <div class="avatar-wrapper">
                @php
                    $nameParts = explode(' ', Auth::user()->name ?? 'Medecin Doe');
                    $initials  = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1] ?? '', 0, 1));
                @endphp
                {{ $initials }}
            </div>
            <div>
                <div class="hero-tag"><span class="hero-dot"></span> Compte Professionnel Certifié</div>
                <h1 class="hero-title">Dr. {{ Auth::user()->name ?? 'Médecin' }}</h1>
                <p class="hero-sub">Gérez votre profil public et les paramètres de votre cabinet.</p>
            </div>
        </div>
    </div>

    {{-- ══ PROFILE GRID ══ --}}
    <form action="{{ route('medecin.profil.update') }}" method="POST">
        @csrf
        <div class="profile-grid">
            
            {{-- COLONNE GAUCHE : INFOS PERSONNELLES & PRO --}}
            <div>
                <div class="form-card">
                    <div class="section-title">Informations Personnelles</div>
                    
                    <div class="form-row">
                        <div class="field-group">
                            <label class="field-label">Nom Complet</label>
                            <input type="text" name="name" value="{{ Auth::user()->name ?? 'Médecin' }}" class="field-input">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Adresse E-mail</label>
                            <input type="email" value="{{ Auth::user()->email ?? 'medecin@example.com' }}" class="field-input" readonly style="background:#f1f5f9; color:#64748b; cursor:not-allowed;">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="field-group mb-0">
                            <label class="field-label">Téléphone de contact</label>
                            <input type="text" name="telephone" value="{{ Auth::user()->telephone ?? '+229 97 00 00 11' }}" class="field-input">
                        </div>
                        <div class="field-group mb-0">
                            <label class="field-label">N° Ordre / N° d'inscription</label>
                            <input type="text" value="{{ Auth::user()->license_number ?? 'Non renseigné' }}" class="field-input" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-card mb-0">
                    <div class="section-title">Informations du Cabinet</div>
                    
                    <div class="form-row">
                        <div class="field-group">
                            <label class="field-label">Spécialité Principale</label>
                            <input type="text" value="{{ Auth::user()->specialty ?? 'Médecine Générale' }}" class="field-input" readonly>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Années d'expérience</label>
                            <input type="number" name="experience" value="{{ Auth::user()->medecin->experience ?? 1 }}" class="field-input">
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Hôpital / Cabinet d'affiliation</label>
                        <input type="text" value="{{ Auth::user()->medecin->hopital->nom ?? 'Non renseigné' }}" class="field-input" readonly>
                    </div>

                    <div class="field-group mb-0">
                        <label class="field-label">Tarif Consultation Standard (FCFA)</label>
                        <input type="number" name="tarif" value="{{ Auth::user()->medecin->tarif ?? 10000 }}" class="field-input" style="font-weight:800; color:var(--blue);">
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="btn-premium">Mettre à jour le profil public</button>
                    </div>
                </div>
            </div>

            {{-- COLONNE DROITE : HORAIRES & SÉCURITÉ --}}
            <div>
                
                {{-- HORAIRES --}}
                <div class="form-card">
                    <div class="section-title">Horaires de Consultation</div>
                    @php
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                        $dispos = Auth::user()->medecin->disponibilites ?? [];
                    @endphp
                    @foreach($jours as $jour)
                        @php
                            $horaire = $dispos[strtolower($jour)] ?? null;
                        @endphp
                        <div class="schedule-row">
                            <span class="schedule-day">{{ $jour }}</span>
                            @if($horaire && isset($horaire['debut']) && isset($horaire['fin']))
                                <span class="schedule-hours">{{ $horaire['debut'] }} - {{ $horaire['fin'] }}</span>
                            @else
                                <span class="schedule-closed">Fermé</span>
                            @endif
                        </div>
                    @endforeach
                    <a href="{{ route('medecin.settings') }}" class="btn-sec" style="margin-top:16px;">Modifier les horaires</a>
                </div>

                {{-- SÉCURITÉ --}}
                <div class="form-card">
                    <div class="section-title">Paramètres & Sécurité</div>
                    <p class="text-[13px] text-slate-500 mb-5 leading-relaxed">Gérez vos identifiants, votre mot de passe et vos paramètres avancés de connexion.</p>
                    <a href="{{ route('medecin.settings') }}" class="btn-sec">
                        Changer mon mot de passe
                    </a>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection
