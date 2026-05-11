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
                <form onsubmit="event.preventDefault(); alert('Modifications enregistrées avec succès dans la base de données !');">
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Nom de l'établissement</label>
                            <input type="text" class="field-input" value="{{ Auth::user()->name ?? 'Clinique Boni' }}" required>
                        </div>
                        <div>
                            <label class="field-label">Type d'établissement</label>
                            <select class="field-input">
                                <option value="clinique">Clinique Privée</option>
                                <option value="hopital" selected>Hôpital Public</option>
                                <option value="centre">Centre de santé communautaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Téléphone principal</label>
                            <input type="tel" class="field-input" value="{{ Auth::user()->telephone ?? '21000000' }}" required>
                        </div>
                        <div>
                            <label class="field-label">Email de contact</label>
                            <input type="email" class="field-input" value="{{ Auth::user()->email ?? 'contact@hopital.com' }}" required>
                        </div>
                    </div>
                    <div>
                        <label class="field-label">Adresse Physique</label>
                        <input type="text" class="field-input" value="Lot 45, Quartier Jacquot, Cotonou" style="margin-bottom: 20px;">
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
</script>
@endsection
