@extends('layouts.hopital')

@section('title', 'Paramètres de l\'établissement — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .4s ease-out; }

    .page-header { margin-bottom: 24px; }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    .settings-layout { display: grid; grid-template-columns: 280px 1fr; gap: 30px; align-items: start; }
    @media (max-width: 800px) { .settings-layout { grid-template-columns: 1fr; } }

    /* MENU LATÉRAL DES PARAMÈTRES */
    .settings-nav { background: #fff; border-radius: 16px; border: 1px solid #e8edf5; padding: 12px; position: sticky; top: 20px; }
    .settings-nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #475569; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 10px; transition: .2s; cursor: pointer; }
    .settings-nav-item.active { background: #f0fdf4; color: #16a34a; }
    .settings-nav-item:hover:not(.active) { background: #f8fafc; color: #0f172a; }

    /* CARTES DE FORMULAIRE */
    .settings-card { background: #fff; border-radius: 16px; border: 1px solid #e8edf5; padding: 32px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,.02); scroll-margin-top: 20px; }
    .card-title { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; }

    /* FORMULAIRES */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
    
    .field-label { font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    .field-input { width: 100%; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; color: #0f172a; font-weight: 600; font-size: 13px; outline: none; transition: 0.2s; }
    .field-input:focus { border-color: var(--blue); background: #fff; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

    /* TOGGLE SWITCH */
    .switch-row { display: flex; justify-content: space-between; align-items: center; padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 16px; }
    .switch-info strong { display: block; font-size: 13px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
    .switch-info span { font-size: 11px; color: #64748b; }
    .toggle { position: relative; width: 44px; height: 24px; background: #cbd5e1; border-radius: 24px; cursor: pointer; transition: .3s; flex-shrink: 0; }
    .toggle::after { content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: #fff; border-radius: 50%; transition: .3s; }
    .toggle.active { background: #22c55e; }
    .toggle.active::after { transform: translateX(20px); }

    .btn-save { background: var(--blue); color: #fff; padding: 14px 28px; border-radius: 12px; font-size: 13px; font-weight: 800; border: none; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-save:hover { background: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="animate-up">

    <div class="page-header">
        <h1 class="page-title">Paramètres de l'établissement</h1>
        <p class="page-desc">Gérez les informations de contact, les urgences et la sécurité de l'hôpital.</p>
    </div>

    <div class="settings-layout">
        
        <div class="settings-nav">
            <a href="#infos" class="settings-nav-item active" onclick="activateNav(this)">🏢 Informations générales</a>
            <a href="#sos" class="settings-nav-item" onclick="activateNav(this)">🚨 Service des Urgences</a>
            <a href="#secu" class="settings-nav-item" onclick="activateNav(this)">🔒 Sécurité & Accès</a>
        </div>

        <div class="settings-content">
            
            {{-- INFORMATIONS GÉNÉRALES --}}
            <div class="settings-card" id="infos">
                <div class="card-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Informations du Centre
                </div>
                <form method="POST" action="{{ route('hopital.parametres.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Nom de l'établissement</label>
                            <input type="text" name="nom" class="field-input" value="{{ $hopital->nom ?? Auth::user()->name }}" required>
                        </div>
                        <div>
                            <label class="field-label">Type d'établissement</label>
                            <select class="field-input" disabled style="opacity: 0.7;">
                                <option value="clinique">Clinique Privée</option>
                                <option value="hopital" selected>Hôpital Public</option>
                                <option value="centre">Centre de santé communautaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Téléphone principal</label>
                            <input type="tel" name="telephone" class="field-input" value="{{ $hopital->telephone ?? Auth::user()->telephone }}" required>
                        </div>
                        <div>
                            <label class="field-label">Email de contact</label>
                            <input type="email" class="field-input" value="{{ Auth::user()->email }}" disabled style="opacity: 0.7;">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Adresse Physique</label>
                            <input type="text" name="adresse" class="field-input" value="{{ $hopital->adresse ?? '' }}" style="margin-bottom: 20px;">
                        </div>
                        <div>
                            <label class="field-label">Capacité en Lits (Total disponibles)</label>
                            <input type="number" name="capacite_lits" class="field-input" value="{{ $hopital->capacite_lits ?? '' }}" min="0" style="margin-bottom: 20px;" placeholder="Ex: 50">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Latitude GPS</label>
                            <input type="text" id="lat-input" name="latitude" class="field-input" value="{{ $hopital->latitude ?? '' }}" style="margin-bottom: 8px;" placeholder="Ex: 6.36536">
                        </div>
                        <div>
                            <label class="field-label">Longitude GPS</label>
                            <input type="text" id="lng-input" name="longitude" class="field-input" value="{{ $hopital->longitude ?? '' }}" style="margin-bottom: 8px;" placeholder="Ex: 2.41833">
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <p style="font-size: 11px; color: #64748b; margin: 0; max-width: 60%;">
                            <em>Astuce : Vous pouvez trouver ces coordonnées sur <a href="https://maps.google.com" target="_blank" style="color:var(--blue);">Google Maps</a> en faisant un clic droit sur votre clinique.</em>
                        </p>
                        <button type="button" id="btn-geoloc" onclick="obtenirGeolocalisation()" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: 0.2s;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            <span id="btn-geoloc-text">Me localiser</span>
                        </button>
                    </div>
                    <button type="submit" class="btn-save">Enregistrer les modifications</button>
                </form>
            </div>

            {{-- GESTION DES URGENCES --}}
            <div class="settings-card" id="sos">
                <div class="card-title" style="color: #dc2626;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Service des Urgences (SOS)
                </div>
                
                <div class="switch-row">
                    <div class="switch-info">
                        <strong>Réception des alertes SOS (Actif)</strong>
                        <span>Votre hôpital apparaît sur la carte des urgences des patients. S'il est désactivé, l'hôpital n'est plus alerté.</span>
                    </div>
                    <div class="toggle active" onclick="this.classList.toggle('active')"></div>
                </div>

                <div class="switch-row">
                    <div class="switch-info">
                        <strong>Ligne de garde 24/7</strong>
                        <span>Redirection automatique des appels téléphoniques d'urgence venant de l'application vers votre centre.</span>
                    </div>
                    <div class="toggle active" onclick="this.classList.toggle('active')"></div>
                </div>

                <div style="margin-top: 16px;">
                    <label class="field-label">Numéro direct des urgences</label>
                    <input type="tel" class="field-input" value="+229 21 00 00 00" style="margin-bottom: 20px;">
                </div>
                
                <button type="button" class="btn-save" onclick="alert('Paramètres d\'urgence mis à jour.')" style="background: #ef4444;">Mettre à jour le service SOS</button>
            </div>

            {{-- SÉCURITÉ --}}
            <div class="settings-card" id="secu">
                <div class="card-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Sécurité & Accès
                </div>
                
                <form onsubmit="event.preventDefault(); alert('Votre mot de passe a été modifié avec succès.');">
                    <div style="margin-bottom: 16px;">
                        <label class="field-label">Nouveau mot de passe</label>
                        <input type="password" class="field-input" placeholder="••••••••" required>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label class="field-label">Confirmer le mot de passe</label>
                        <input type="password" class="field-input" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn-save" style="background: #0f172a;">Mettre à jour le mot de passe</button>
                </form>
            </div>

        </div>

    </div>

</div>

<script>
    function activateNav(element) {
        document.querySelectorAll('.settings-nav-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    function obtenirGeolocalisation() {
        const btnText = document.getElementById('btn-geoloc-text');
        const btn = document.getElementById('btn-geoloc');
        
        btnText.innerText = "Recherche...";
        btn.style.opacity = "0.7";

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lat-input').value = position.coords.latitude.toFixed(6);
                document.getElementById('lng-input').value = position.coords.longitude.toFixed(6);
                
                btnText.innerText = "Localisé !";
                btn.style.background = "#dcfce7";
                btn.style.borderColor = "#22c55e";
                btn.style.color = "#16a34a";
                btn.style.opacity = "1";
            }, function(error) {
                alert("Impossible de récupérer la position. Veuillez autoriser la localisation.");
                btnText.innerText = "Me localiser";
                btn.style.opacity = "1";
            }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        } else {
            alert("La géolocalisation n'est pas supportée par ce navigateur.");
            btnText.innerText = "Me localiser";
        }
    }
</script>
@endsection
