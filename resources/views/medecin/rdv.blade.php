@extends('layouts.medecin')

@section('title', 'Mes Patients — Dokita PRO')

@push('head')
<style>
    :root {
        --blue: #2563eb;
        --dark: #0c2340;
        --radius-xl: 20px;
    }

    @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .animate-in { animation: fadeIn .4s ease-out forwards; }

    /* ── HEADER & SEARCH ── */
    .page-header {
        background: #fff;
        border-radius: var(--radius-xl);
        padding: 24px 30px;
        margin-bottom: 24px;
        border: 1px solid #e8edf5;
        box-shadow: 0 10px 30px rgba(0,0,0,.02);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;
    }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    .search-box {
        display: flex; align-items: center; gap: 10px;
        background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 12px; padding: 10px 16px; min-width: 300px;
        transition: .2s;
    }
    .search-box:focus-within { background: #fff; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(2,132,199,.1); }
    .search-box input { border: none; background: transparent; outline: none; font-size: 13px; width: 100%; font-weight: 600; color: #0f172a; }

    /* ── GRID PATIENTS ── */
    .patient-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;
    }

    /* ── CARD PATIENT ── */
    .p-card {
        background: #fff; border-radius: 16px; border: 1px solid #e8edf5;
        padding: 20px; display: flex; flex-direction: column;
        transition: .2s; box-shadow: 0 4px 15px rgba(0,0,0,.01);
    }
    .p-card:hover { transform: translateY(-3px); border-color: #bae6fd; box-shadow: 0 10px 25px rgba(2,132,199,.08); }
    
    .p-header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
    .p-avatar {
        width: 46px; height: 46px; border-radius: 12px;
        background: #eff6ff; color: var(--blue); border: 1px solid #bfdbfe;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 800; flex-shrink: 0;
    }
    .p-name { font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
    .p-id { font-size: 11px; font-weight: 700; color: #94a3b8; }

    .p-body { margin-bottom: 20px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .p-stat { font-size: 12px; color: #475569; display: flex; justify-content: space-between; align-items: center; }
    .p-stat strong { font-weight: 700; color: #0f172a; }
    .p-stat.alert strong { color: #ef4444; }

    .p-actions { display: flex; gap: 8px; }
    .btn-dossier {
        flex: 1; text-align: center;
        background: #f8fafc; border: 1px solid #e2e8f0;
        padding: 10px 8px; border-radius: 10px; font-size: 12px; font-weight: 700;
        color: #475569; text-decoration: none; transition: .2s; display: flex; align-items: center; justify-content: center; gap: 5px;
    }
    .p-card:hover .btn-dossier { background: var(--blue); color: #fff; border-color: var(--blue); }
    .btn-ord {
        flex-shrink: 0; text-align: center;
        background: #fdf8f6; border: 1px solid #fed7aa;
        padding: 10px 12px; border-radius: 10px; font-size: 12px; font-weight: 700;
        color: #c2410c; text-decoration: none; transition: .2s; display: flex; align-items: center; justify-content: center; gap: 5px; white-space: nowrap;
    }
    .btn-ord:hover { background: #c2410c; color: #fff; border-color: #c2410c; }

</style>
@endpush

@section('content')
<div class="animate-in">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Répertoire des Patients</h1>
            <p class="page-desc">Accédez aux dossiers médicaux de vos patients réguliers.</p>
        </div>
        <div class="search-box">
            <svg width="16" height="16" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Rechercher un nom, un n° de dossier...">
        </div>
    </div>

    {{-- Bannière RDV en attente de confirmation hôpital --}}
    @if(isset($enAttenteCount) && $enAttenteCount > 0)
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:14px 20px;display:flex;align-items:center;gap:14px;margin-bottom:20px;">
        <div style="width:36px;height:36px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div style="font-size:14px;font-weight:800;color:#1e40af;">{{ $enAttenteCount }} rendez-vous en attente de validation</div>
            <div style="font-size:12px;color:#3b82f6;">Ces rendez-vous ne s'afficheront ici qu'une fois confirmés par l'hôpital.</div>
        </div>
    </div>
    @endif

    {{-- GRID --}}
    <div class="patient-grid">
        
        {{-- PATIENT 1 --}}
        <div class="p-card">
            <div class="p-header">
                <div class="p-avatar">SJ</div>
                <div>
                    <div class="p-name">SOGLO Jean-Paul</div>
                    <div class="p-id">#PT-2026-892</div>
                </div>
            </div>
            <div class="p-body">
                <div class="p-stat">Sexe / Âge : <strong>Homme, 42 ans</strong></div>
                <div class="p-stat">Dernière Visite : <strong>Aujourd'hui</strong></div>
                <div class="p-stat alert">Alerte Méd. : <strong>Allergie Pénicilline</strong></div>
            </div>
            <div class="p-actions">
                <a href="{{ route('medecin.consultation', ['name' => 'SOGLO Jean-Paul', 'motif' => 'Ouverture du dossier depuis le répertoire']) }}" class="btn-dossier">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossier médical
                </a>
                <a href="{{ route('medecin.ordonnances', ['patient' => 'SOGLO Jean-Paul']) }}" class="btn-ord">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Ordonnance
                </a>
            </div>
        </div>

        {{-- PATIENT 2 --}}
        <div class="p-card">
            <div class="p-header">
                <div class="p-avatar">AA</div>
                <div>
                    <div class="p-name">AMADOU Aminata</div>
                    <div class="p-id">#PT-2025-104</div>
                </div>
            </div>
            <div class="p-body">
                <div class="p-stat">Sexe / Âge : <strong>Femme, 28 ans</strong></div>
                <div class="p-stat">Dernière Visite : <strong>03 Mars 2026</strong></div>
                <div class="p-stat">Alerte Méd. : <strong>Asthme (Léger)</strong></div>
            </div>
            <div class="p-actions">
                <a href="{{ route('medecin.consultation', ['name' => 'AMADOU Aminata', 'motif' => 'Revue du dossier médical']) }}" class="btn-dossier">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossier médical
                </a>
                <a href="{{ route('medecin.ordonnances', ['patient' => 'AMADOU Aminata']) }}" class="btn-ord">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Ordonnance
                </a>
            </div>
        </div>

        {{-- PATIENT 3 --}}
        <div class="p-card">
            <div class="p-header">
                <div class="p-avatar">DM</div>
                <div>
                    <div class="p-name">DOSSOU Maxime</div>
                    <div class="p-id">#PT-2024-541</div>
                </div>
            </div>
            <div class="p-body">
                <div class="p-stat">Sexe / Âge : <strong>Homme, 55 ans</strong></div>
                <div class="p-stat">Dernière Visite : <strong>15 Fév 2026</strong></div>
                <div class="p-stat alert">Alerte Méd. : <strong>Diabète Type 2</strong></div>
            </div>
            <div class="p-actions">
                <a href="{{ route('medecin.consultation', ['name' => 'DOSSOU Maxime', 'motif' => 'Suivi de maladie chronique']) }}" class="btn-dossier">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossier médical
                </a>
                <a href="{{ route('medecin.ordonnances', ['patient' => 'DOSSOU Maxime']) }}" class="btn-ord">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Ordonnance
                </a>
            </div>
        </div>

        {{-- PATIENT 4 --}}
        <div class="p-card">
            <div class="p-header">
                <div class="p-avatar">KE</div>
                <div>
                    <div class="p-name">KOUASSI Eliane</div>
                    <div class="p-id">#PT-2026-002</div>
                </div>
            </div>
            <div class="p-body">
                <div class="p-stat">Sexe / Âge : <strong>Femme, 34 ans</strong></div>
                <div class="p-stat">Dernière Visite : <strong>Aujourd'hui</strong></div>
                <div class="p-stat">Alerte Méd. : <strong style="color:#64748b;">Aucune</strong></div>
            </div>
            <div class="p-actions">
                <a href="{{ route('medecin.consultation', ['name' => 'KOUASSI Eliane', 'motif' => 'Analyse des nouveaux symptômes']) }}" class="btn-dossier">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossier médical
                </a>
                <a href="{{ route('medecin.ordonnances', ['patient' => 'KOUASSI Eliane']) }}" class="btn-ord">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Ordonnance
                </a>
            </div>
        </div>

        {{-- PATIENT 5 --}}
        <div class="p-card">
            <div class="p-header">
                <div class="p-avatar">BT</div>
                <div>
                    <div class="p-name">BIO Tchané</div>
                    <div class="p-id">#PT-2023-998</div>
                </div>
            </div>
            <div class="p-body">
                <div class="p-stat">Sexe / Âge : <strong>Homme, 60 ans</strong></div>
                <div class="p-stat">Dernière Visite : <strong>Hier</strong></div>
                <div class="p-stat alert">Alerte Méd. : <strong>Hypertension</strong></div>
            </div>
            <div class="p-actions">
                <a href="{{ route('medecin.consultation', ['name' => 'BIO Tchané', 'motif' => 'Suivi post-opératoire']) }}" class="btn-dossier">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossier médical
                </a>
                <a href="{{ route('medecin.ordonnances', ['patient' => 'BIO Tchané']) }}" class="btn-ord">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Ordonnance
                </a>
            </div>
        </div>

        {{-- PATIENT 6 --}}
        <div class="p-card">
            <div class="p-header">
                <div class="p-avatar">DC</div>
                <div>
                    <div class="p-name">DOSSA Clémence</div>
                    <div class="p-id">#PT-2026-112</div>
                </div>
            </div>
            <div class="p-body">
                <div class="p-stat">Sexe / Âge : <strong>Femme, 19 ans</strong></div>
                <div class="p-stat">Dernière Visite : <strong>Il y a 2 jours</strong></div>
                <div class="p-stat">Alerte Méd. : <strong style="color:#64748b;">Aucune</strong></div>
            </div>
            <div class="p-actions">
                <a href="{{ route('medecin.consultation', ['name' => 'DOSSA Clémence', 'motif' => 'Bilan de santé']) }}" class="btn-dossier">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossier médical
                </a>
                <a href="{{ route('medecin.ordonnances', ['patient' => 'DOSSA Clémence']) }}" class="btn-ord">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Ordonnance
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
