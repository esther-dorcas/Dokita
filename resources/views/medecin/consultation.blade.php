@extends('layouts.medecin')

@section('title', 'Consultation - Dokita PRO')

@push('head')
<style>
    :root {
        --blue: #2563eb;
        --dark: #0c2340;
        --radius-xl: 20px;
        --radius-lg: 14px;
    }

    @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .animate-in { animation: fadeIn .4s ease-out forwards; }

    /* ── HEADER ── */
    .consult-header {
        background: #fff;
        border-radius: var(--radius-xl);
        padding: 24px 30px;
        margin-bottom: 24px;
        border: 1px solid #e8edf5;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 30px rgba(0,0,0,.02);
    }
    .patient-info { display: flex; align-items: center; gap: 20px; }
    .patient-avatar {
        width: 60px; height: 60px; border-radius: 16px;
        background: #eff6ff; color: var(--blue);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; font-weight: 800; border: 1px solid #bfdbfe;
    }
    .patient-name { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .patient-meta { display: flex; gap: 12px; font-size: 13px; font-weight: 600; color: #64748b; flex-wrap: wrap; }
    .meta-item { display: flex; align-items: center; gap: 6px; }
    .meta-dot { width: 4px; height: 4px; border-radius: 50%; background: #cbd5e1; }

    .status-badge {
        background: #f0fdf4; color: #166534; padding: 6px 14px;
        border-radius: 20px; font-size: 12px; font-weight: 800;
        border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 6px;
        animation: pulse 2s infinite; white-space: nowrap;
    }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.6} }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }

    /* ── GRID ── */
    .consult-grid { display: grid; grid-template-columns: 350px 1fr; gap: 24px; }
    @media (max-width: 1024px) { .consult-grid { grid-template-columns: 1fr; } }
    @media (max-width: 640px) { .consult-header { flex-direction: column; gap: 16px; align-items: flex-start; } }

    /* ── PANELS ── */
    .panel {
        background: #fff; border-radius: var(--radius-xl);
        border: 1px solid #e8edf5; padding: 24px;
    }
    .panel-title {
        font-size: 14px; font-weight: 800; color: #0f172a;
        margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;
    }

    /* ── VITALS ── */
    .vitals-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }
    .vital-box { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 12px; text-align: center; }
    .vital-lbl { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .vital-val { font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 4px; }
    .vital-val span { font-size: 12px; color: #94a3b8; font-weight: 600; }

    /* ── HISTORY LIST ── */
    .history-list { display: flex; flex-direction: column; gap: 12px; }
    .history-item { background: #f8fafc; padding: 12px; border-radius: 10px; border-left: 3px solid var(--blue); }
    .history-date { font-size: 11px; color: #64748b; font-weight: 700; margin-bottom: 4px; }
    .history-text { font-size: 13px; font-weight: 600; color: #0f172a; }

    /* ── FORMS ── */
    .field-label { font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    .field-input {
        width: 100%; padding: 14px 16px; border-radius: 12px;
        background: #f8fafc; border: 1px solid #e2e8f0;
        font-size: 14px; color: #0f172a; margin-bottom: 20px;
        transition: .2s; outline: none; font-family: inherit;
    }
    .field-input:focus { background: #fff; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(2,132,199,.1); }
    textarea.field-input { resize: vertical; min-height: 100px; }

    .ord-box {
        background: #fdf8f6; border: 1px dashed #fdba74;
        border-radius: 12px; padding: 20px; margin-bottom: 20px;
    }

    /* ── BUTTONS ── */
    .action-row { display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; padding-top: 24px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; }
    .btn { padding: 12px 24px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: .2s; border: none; }
    .btn-outline { background: #fff; border: 1px solid #e2e8f0; color: #475569; }
    .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }
    .btn-primary { background: var(--blue); color: #fff; }
    .btn-primary:hover { background: #0369a1; }
    .btn-success { background: #16a34a; color: #fff; }
    .btn-success:hover { background: #15803d; }
</style>
@endpush

@section('content')
<div class="animate-in">

    {{-- HEADER PATIENT --}}
    <div class="consult-header">
        <div class="patient-info">
            <div class="patient-avatar">{{ strtoupper(substr(request('name', 'SOGLO Jean-Paul'), 0, 2)) }}</div>
            <div>
                <div class="patient-name">{{ request('name', 'SOGLO Jean-Paul') }}</div>
                <div class="patient-meta">
                    <span class="meta-item">Adulte</span>
                    <span class="meta-dot"></span>
                    <span class="meta-item">N° Dossier: #PT-2026-{{ rand(100, 999) }}</span>
                    <span class="meta-dot"></span>
                    <span class="meta-item" style="color:#ef4444; font-weight:800;">Allergie: Pénicilline</span>
                </div>
            </div>
        </div>
        <div class="status-badge">
            <div class="status-dot"></div>
            Consultation en cours
        </div>
    </div>

    {{-- GRID --}}
    <div class="consult-grid">
        
        {{-- COL GAUCHE : INFOS MÉDICALES --}}
        <div>
            <div class="panel" style="margin-bottom: 24px;">
                <div class="panel-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Dernières Constantes
                </div>
                
                <div class="vitals-grid">
                    <div class="vital-box">
                        <div class="vital-lbl">Groupe Sanguin</div>
                        <div class="vital-val" style="color:#ef4444;">O+</div>
                    </div>
                    <div class="vital-box">
                        <div class="vital-lbl">Poids</div>
                        <div class="vital-val">78 <span>kg</span></div>
                    </div>
                    <div class="vital-box">
                        <div class="vital-lbl">Taille</div>
                        <div class="vital-val">175 <span>cm</span></div>
                    </div>
                    <div class="vital-box">
                        <div class="vital-lbl">Tension</div>
                        <div class="vital-val">12/8</div>
                    </div>
                </div>
                <div class="vital-lbl" style="margin-bottom:8px;">Contact d'urgence (ICE)</div>
                <div style="background:#fef2f2; color:#991b1b; padding:10px 12px; border-radius:8px; font-size:12px; font-weight:700;">
                    SOGLO Marie (Épouse) : +229 97 45 XX XX
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Historique Récent
                </div>
                <div class="history-list">
                    <div class="history-item">
                        <div class="history-date">12 Janvier 2026</div>
                        <div class="history-text">Bilan sanguin annuel (Normal)</div>
                    </div>
                    <div class="history-item">
                        <div class="history-date">05 Novembre 2025</div>
                        <div class="history-text">Consultation pour grippe sévère</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COL DROITE : RÉDACTION --}}
        <div class="panel">
            <div class="panel-title">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Dossier Médical du jour
            </div>

            <label class="field-label">Motif de consultation (Symptômes)</label>
            <textarea class="field-input" style="min-height:80px;" placeholder="Ex: Maux de tête depuis 3 jours, fièvre...">{{ request('motif') }}</textarea>

            <label class="field-label">Diagnostic clinique</label>
            <textarea class="field-input" placeholder="Saisissez le diagnostic établi ici..."></textarea>

            <div class="ord-box">
                <label class="field-label" style="color:#c2410c;">Prescription / Ordonnance</label>
                <textarea class="field-input" style="margin-bottom:0; background:#fff; border-color:#fed7aa;" placeholder="- Paracétamol 1000mg : 1 cp 3x/jour..."></textarea>
            </div>

            <div class="action-row">
                <button class="btn btn-outline">Sauvegarder brouillon</button>
                <button class="btn btn-primary" onclick="alert('L\'ordonnance a été générée en PDF !')">Imprimer Ordonnance</button>
                <a href="{{ route('medecin.dashboard') }}" class="btn btn-success" style="text-decoration:none; display:inline-block; text-align:center;" onclick="alert('Consultation clôturée avec succès !')">Terminer la consultation</a>
            </div>
        </div>

    </div>

</div>
@endsection
