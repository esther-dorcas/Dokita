@extends('layouts.dokita')

@section('title', 'Santé & Constantes — Dokita')

@push('head')
<style>
    :root {
        --blue: #2563eb;
        --dark: #0c2340;
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
    .hero-deco1 { position:absolute; top:-50px; right:-50px; width:220px; height:220px; border-radius:50%; background:rgba(37,99,235,.18); }
    .hero-deco2 { position:absolute; bottom:-70px; right:80px; width:160px; height:160px; border-radius:50%; background:rgba(37,99,235,.1); }
    
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
        font-size: 10px; font-weight: 700; color: #93c5fd;
        margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .hero-dot { width: 6px; height: 6px; border-radius: 50%; background: #22d3ee; animation: pulse 2s infinite; }
    .hero-title { font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 4px; line-height: 1.2; }
    .hero-sub   { font-size: 13px; color: rgba(255,255,255,.45); margin: 0; line-height: 1.5; }

    /* ── CONTENT GRID ── */
    .profile-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: -44px; position: relative; z-index: 10; padding: 0 2px; }
    @media (max-width: 1024px) { .profile-grid { grid-template-columns: 1fr; } }

    /* ── CARDS ── */
    .form-card {
        background: #fff; border-radius: var(--radius-xl); padding: 32px;
        border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
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
    .field-input:focus { background: #fff; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

    /* ── ICE CARD ── */
    .ice-banner {
        background: #fef2f2; border-radius: 16px; padding: 20px;
        border: 1px dashed #fecaca; margin-top: 24px;
    }
    .ice-title { color: #991b1b; font-weight: 800; font-size: 12px; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
    .ice-banner .field-input { background: #fff; border-color: #fecaca; color: #991b1b; }
    .ice-banner .field-input:focus { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    /* ── VITAL STATS ── */
    .vital-stat-mini {
        background: #fff; border-radius: 16px; padding: 16px;
        border: 1px solid #e2e8f0; text-align: center;
        transition: 0.2s;
    }
    .vital-stat-mini:hover { border-color: #bfdbfe; box-shadow: 0 4px 12px rgba(37,99,235,.05); }
    .vital-label { font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    
    /* ── BUTTON ── */
    .btn-premium {
        background: var(--blue); color: #fff;
        padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 12px;
        border: none; cursor: pointer; transition: 0.2s; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .btn-premium:hover { background: #1d4ed8; }

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
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="hero-tag"><span class="hero-dot"></span> Dossier Patient Actif</div>
                <h1 class="hero-title">{{ Auth::user()->name }}</h1>
                <p class="hero-sub">Patient inscrit depuis le {{ Auth::user()->created_at->translatedFormat('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- ══ PROFILE GRID ══ --}}
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="profile-grid">
            
            {{-- COLONNE GAUCHE : FORMULAIRES --}}
            <div class="space-y-6">
                
                {{-- SECTION 1 : INFOS GÉNÉRALES --}}
                <div class="form-card">
                    <div class="section-title">Informations Personnelles</div>
                    
                    <div class="form-row">
                        <div class="field-group">
                            <label class="field-label">Nom Complet</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="field-input">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Adresse E-mail</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="field-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="field-group mb-0">
                            <label class="field-label">Téléphone</label>
                            <input type="text" name="telephone" value="{{ Auth::user()->telephone }}" placeholder="+229 00 00 00 00" class="field-input">
                        </div>
                        <div class="field-group mb-0">
                            <label class="field-label">Date de Naissance</label>
                            <input type="date" name="birth_date" value="{{ Auth::user()->birth_date }}" class="field-input">
                        </div>
                    </div>

                    <div class="ice-banner">
                        <div class="ice-title">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            Contact d'urgence (ICE)
                        </div>
                        <div class="form-row">
                            <div>
                                <label class="field-label !text-red-800">Nom du contact</label>
                                <input type="text" name="ice_name" value="{{ $patient->ice_name ?? '' }}" placeholder="Ex: Mère, Conjoint..." class="field-input">
                            </div>
                            <div>
                                <label class="field-label !text-red-800">Téléphone urgence</label>
                                <input type="text" name="ice_phone" value="{{ $patient->ice_phone ?? '' }}" class="field-input">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn-premium">Enregistrer les modifications</button>
                    </div>
                </div>
            </div>

            {{-- COLONNE DROITE : SANTÉ ET RÉGLAGES --}}
            <div class="space-y-6">
                
                {{-- CONSTANTES MÉDICALES --}}
                <div class="form-card">
                    <div class="section-title">Données Médicales</div>
                    <div class="space-y-4">
                        <div class="vital-stat-mini">
                            <div class="vital-label">Groupe Sanguin</div>
                            <select name="blood_group" class="field-input mt-2 text-center !font-bold">
                                @foreach(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $g)
                                    <option value="{{ $g }}" {{ (isset($patient) && $patient->blood_group == $g) ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="vital-stat-mini">
                                <div class="vital-label">Taille (cm)</div>
                                <input type="number" name="height" value="{{ $patient->height ?? '175' }}" class="field-input mt-2 text-center !font-bold">
                            </div>
                            <div class="vital-stat-mini">
                                <div class="vital-label">Poids (kg)</div>
                                <input type="number" name="weight" value="{{ $patient->weight ?? '72' }}" class="field-input mt-2 text-center !font-bold">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SÉCURITÉ --}}
                <div class="form-card">
                    <div class="section-title">Sécurité</div>
                    <p class="text-[13px] text-slate-500 mb-5 leading-relaxed">Modifiez vos accès pour garantir la sécurité de votre compte.</p>
                    <a href="{{ route('profile.edit') }}" class="btn-sec">
                        Changer mon mot de passe
                    </a>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection
