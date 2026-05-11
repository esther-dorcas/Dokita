@extends('layouts.dokita')

@section('title', 'SOS Urgence — Dokita')

@push('head')
<style>
    :root {
        --medical-red: #dc2626;
        --medical-red-dark: #b91c1c;
        --radius-xl: 20px;
        --radius-lg: 14px;
    }

    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.35} }
    .animate-up { animation: slideUp .4s ease-out; }

    /* ── HERO ── */
    .hero {
        background: var(--medical-red-dark);
        border-radius: var(--radius-xl);
        padding: 32px 28px 76px;
        position: relative; overflow: hidden;
        margin-bottom: 0;
    }
    .hero-deco1 { position:absolute; top:-50px; right:-50px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,.12); }
    .hero-deco2 { position:absolute; bottom:-70px; right:80px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,.06); }
    .hero-content { position:relative; z-index:2; max-width:600px; text-align: center; margin: 0 auto; }
    
    .hero-icon {
        width: 64px; height: 64px; background: rgba(255,255,255,.15);
        border-radius: 16px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 32px;
        animation: pulse 2s infinite; border: 2px solid rgba(255,255,255,.2);
    }
    .hero-title { font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
    .hero-sub   { font-size: 13px; color: rgba(255,255,255,.7); line-height: 1.6; }

    /* ── FORM CARD ── */
    .emergency-card {
        background: #fff; border-radius: var(--radius-xl); padding: 32px;
        border: 1px solid #fecaca; box-shadow: 0 10px 30px rgba(220, 38, 38, 0.08);
        max-width: 700px; margin: -44px auto 0; position: relative; z-index: 10;
    }

    /* ── FORM ELEMENTS ── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
    
    .field-label { font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .field-select, .field-input, .field-textarea {
        width: 100%; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 10px; color: #0f172a; font-weight: 600; font-size: 13px;
        outline: none; transition: 0.2s;
    }
    .field-select { background: #fef2f2; border-color: #fecaca; color: #991b1b; cursor: pointer; }
    .field-select:focus { border-color: var(--medical-red); box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1); }
    .field-input:focus, .field-textarea:focus { border-color: #93c5fd; background: #fff; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .field-textarea { min-height: 100px; resize: none; margin-bottom: 24px; }

    /* ── LOCATION BOX ── */
    .loc-wrapper { position: relative; }
    .loc-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--medical-red); }
    .loc-input { padding-left: 38px !important; }

    /* ── WARNING BOX ── */
    .warning-banner {
        background: #fff7ed; border-radius: 12px; padding: 16px 20px;
        border: 1px solid #fed7aa; display: flex; gap: 16px; align-items: flex-start;
        margin-bottom: 24px;
    }
    .warn-icon { font-size: 20px; flex-shrink: 0; }
    .warn-text { font-size: 12px; color: #9a3412; font-weight: 600; line-height: 1.6; margin: 0; }

    /* ── BUTTONS ── */
    .btn-sos {
        width: 100%; background: var(--medical-red); color: #fff;
        padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 800;
        border: none; cursor: pointer; transition: 0.2s; text-transform: uppercase; letter-spacing: 1px;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.25);
    }
    .btn-sos:hover { background: var(--medical-red-dark); transform: translateY(-2px); box-shadow: 0 12px 25px rgba(239, 68, 68, 0.35); }
    
    .btn-call {
        width: 100%; background: transparent; color: #64748b;
        padding: 12px; font-size: 12px; font-weight: 700; border: none;
        cursor: pointer; transition: 0.2s; margin-top: 10px; text-decoration: underline;
    }
    .btn-call:hover { color: #0f172a; }

    /* ── SUCCESS STATE ── */
    .success-overlay { display: none; text-align: center; animation: slideUp 0.4s ease-out; }
    .success-icon {
        width: 80px; height: 80px; background: #f0fdf4; border: 2px solid #10b981; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;
        color: #10b981;
    }
    .success-icon svg { width: 40px; height: 40px; }
    .success-title { font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 12px; }
    .success-text { font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.6; }
    .success-code { font-size: 18px; font-weight: 800; color: var(--medical-red); letter-spacing: 1px; padding: 12px 24px; background: #fef2f2; border-radius: 12px; display: inline-block; margin-bottom: 30px; border: 1px dashed #fecaca; }
    .btn-back {
        display: inline-flex; align-items: center; justify-content: center;
        background: #0f172a; color: #fff; padding: 12px 28px;
        border-radius: 10px; font-size: 13px; font-weight: 700;
        text-decoration: none; transition: 0.2s;
    }
    .btn-back:hover { background: #1e293b; }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- ══ EMERGENCY HERO ══ --}}
    <div class="hero">
        <div class="hero-deco1"></div>
        <div class="hero-deco2"></div>
        <div class="hero-content">
            <div class="hero-icon">🚨</div>
            <h1 class="hero-title">Alerte Secours</h1>
            <p class="hero-sub">Assistance médicale prioritaire. Les secours seront déployés en moins de 5 minutes.</p>
        </div>
    </div>

    {{-- ══ EMERGENCY FORM ══ --}}
    <div class="emergency-card">
        
        <div id="form-container">
            <form id="urgence-form" action="{{ route('urgence.store') }}" method="POST" onsubmit="handleEmergency(event)">
                @csrf

                <div class="form-grid">
                    <div>
                        <label class="field-label">Nature de l'urgence</label>
                        <select name="description" class="field-select" required>
                            <option value="" disabled selected>Sélectionnez le type d'urgence...</option>
                            <option value="Accident de la route">🚗 Accident de la route</option>
                            <option value="Malaise cardiaque">❤️ Malaise cardiaque</option>
                            <option value="Détresse respiratoire">🫁 Détresse respiratoire</option>
                            <option value="Accouchement imminent">👶 Accouchement imminent</option>
                            <option value="Traumatisme grave">🦴 Traumatisme grave</option>
                            <option value="Autre urgence grave">⚠️ Autre urgence vitale</option>
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Géolocalisation</label>
                        <button type="button" id="btn-locate" onclick="getEmergencyLocation()" class="field-input" style="display:flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; font-weight:700;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span id="loc-text">Transmettre ma position</span>
                        </button>
                        <input type="hidden" name="localisation" id="loc-input" value="Position non renseignée">
                    </div>
                </div>

                <div>
                    <label class="field-label">Détails de la situation (Optionnel)</label>
                    <textarea name="details" class="field-textarea" placeholder="Ex: Patient inconscient, saignements importants... Précisez tout détail utile pour les secours."></textarea>
                </div>

                <input type="hidden" name="latitude" id="lat-input">
                <input type="hidden" name="longitude" id="lng-input">

                <div class="warning-banner">
                    <div class="warn-icon">⚠️</div>
                    <p class="warn-text">En appuyant sur "Déclencher l'alerte", votre position exacte et votre dossier médical d'urgence seront transmis immédiatement à l'hôpital le plus proche. <strong>Préparez-vous à recevoir un appel.</strong></p>
                </div>

                <button type="submit" class="btn-sos">
                    Déclencher l'alerte
                </button>

                <button type="button" class="btn-call" onclick="window.location.href='tel:122'">
                    Ou appeler directement les pompiers (122)
                </button>
            </form>
        </div>

        {{-- ══ SUCCESS STATE ══ --}}
        <div id="success-container" class="success-overlay">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="success-title">Alerte transmise !</h2>
            <p class="success-text">Les secours ont reçu votre signalement et se dirigent vers votre position.<br>Restez calme et gardez votre téléphone allumé.</p>
            <div class="success-code">Code Suivi : #EM-{{ rand(1000, 9999) }}</div>
            <div>
                <a href="{{ route('patient.dashboard') }}" class="btn-back">
                    Retour au Tableau de Bord
                </a>
            </div>
        </div>

    </div>

</div>

<script>
    // Géolocalisation au clic
    function getEmergencyLocation() {
        var btn = document.getElementById('btn-locate');
        var text = document.getElementById('loc-text');

        if (!navigator.geolocation) {
            text.textContent = 'Non supporté par le navigateur';
            return;
        }

        text.textContent = 'Recherche en cours...';
        btn.style.opacity = '0.7';

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                document.getElementById('lat-input').value = pos.coords.latitude;
                document.getElementById('lng-input').value = pos.coords.longitude;
                document.getElementById('loc-input').value = 'Position transmise ✓';
                
                text.textContent = 'Position verrouillée ✓';
                btn.style.backgroundColor = '#f0fdf4';
                btn.style.color = '#166534';
                btn.style.borderColor = '#bbf7d0';
                btn.style.opacity = '1';
            },
            function(error) {
                text.textContent = 'Échec / Accès refusé';
                btn.style.backgroundColor = '#fef2f2';
                btn.style.color = '#991b1b';
                btn.style.borderColor = '#fecaca';
                btn.style.opacity = '1';
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    // Gestion de la soumission (AJAX)
    function handleEmergency(e) {
        e.preventDefault();
        
        // Cacher le formulaire, montrer le succès
        document.getElementById('form-container').style.display = 'none';
        document.getElementById('success-container').style.display = 'block';
        
        // Envoi des données en arrière-plan
        var form = document.getElementById('urgence-form');
        var data = new FormData(form);
        fetch(form.action, { 
            method: 'POST', 
            body: data, 
            headers: { 'X-Requested-With': 'XMLHttpRequest' } 
        }).catch(function(error) {
            console.error('Erreur lors de l\'envoi de l\'alerte:', error);
        });
    }
</script>
@endsection
