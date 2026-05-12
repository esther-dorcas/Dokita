@extends('layouts.medecin')

@section('title', 'Tableau de bord — Dokita PRO')

@push('head')
<style>
    :root {
        --blue: #2563eb; /* Patient Blue */
        --dark: #0c2340; /* Patient Dark */
        --radius-xl: 20px;
        --radius-lg: 14px;
    }

    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    .animate-up { animation: slideUp .4s ease-out; }

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
    
    .hero-content { position:relative; z-index:2; }
    .hero-title { font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 4px; line-height: 1.2; }
    .hero-sub   { font-size: 13px; color: rgba(255,255,255,.45); margin: 0; }

    /* ── STATS FLOTTANTES ── */
    .stats-float { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: -44px; position: relative; z-index: 10; padding: 0 2px; margin-bottom: 30px; }
    @media (max-width: 768px) { .stats-float { grid-template-columns: 1fr; } }
    
    .sf-card { background: #fff; border-radius: var(--radius-xl); border: 1px solid #e8edf5; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.02); transition: .2s; }
    .sf-card:hover { transform: translateY(-2px); border-color: #bae6fd; box-shadow: 0 10px 30px rgba(2,132,199,.08); }
    .sf-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .sf-val { font-size: 24px; font-weight: 800; color: #0f172a; line-height: 1; margin-bottom: 4px; }
    .sf-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }

    /* ── PLANNING DU JOUR ── */
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .section-title { font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; }
    .btn-view-all { font-size: 12px; font-weight: 700; color: var(--blue); text-decoration: none; }
    
    .planning-card { background: #fff; border-radius: var(--radius-xl); border: 1px solid #e8edf5; padding: 24px; }
    
    .rdv-item { display: flex; align-items: center; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f1f5f9; }
    .rdv-item:last-child { border-bottom: none; padding-bottom: 0; }
    .rdv-item:first-child { padding-top: 0; }
    
    .rdv-time { font-size: 14px; font-weight: 800; color: var(--blue); width: 60px; flex-shrink: 0; }
    .rdv-patient { flex: 1; }
    .rdv-name { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
    .rdv-motif { font-size: 12px; color: #64748b; }
    
    .rdv-action {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 12px;
        font-size: 11px; font-weight: 700; color: #475569; text-decoration: none; transition: .2s;
    }
    .rdv-action:hover { background: var(--blue); color: #fff; border-color: var(--blue); }

    /* ── ALERTS ── */
    .alert-card { background: #fef2f2; border-radius: var(--radius-xl); border: 1px solid #fecaca; padding: 20px; display: flex; gap: 16px; align-items: flex-start; }
    .alert-icon { width: 36px; height: 36px; background: #ef4444; color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; animation: pulse 2s infinite; }
    .alert-title { font-size: 14px; font-weight: 800; color: #991b1b; margin-bottom: 4px; }
    .alert-desc { font-size: 12px; color: #b91c1c; line-height: 1.5; }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-deco1"></div>
        <div class="hero-deco2"></div>
        <div class="hero-content">
            <h1 class="hero-title">Bonjour, Dr. {{ Auth::user()->name ?? 'Médecin' }}</h1>
            <p class="hero-sub">Voici un résumé de votre activité pour aujourd'hui, {{ now()->translatedFormat('l d F Y') }}.</p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-float">
        <div class="sf-card">
            <div class="sf-icon" style="background:#f0fdfa; color:#0d9488;">👥</div>
            <div>
                <div class="sf-val">{{ $patientsPrevusCount }}</div>
                <div class="sf-label">Patients prévus</div>
            </div>
        </div>
        <div class="sf-card">
            <div class="sf-icon" style="background:#eff6ff; color:#2563eb;">🩺</div>
            <div>
                <div class="sf-val">{{ $consultesJourCount }}</div>
                <div class="sf-label">Consultés ce jour</div>
            </div>
        </div>
        <div class="sf-card">
            <div class="sf-icon" style="background:#fef2f2; color:#ef4444;">🚨</div>
            <div>
                <div class="sf-val">{{ $urgencesAssigneesCount }}</div>
                <div class="sf-label">Urgence assignée</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- PLANNING --}}
        <div class="lg:col-span-2">
            <div class="section-header">
                <h2 class="section-title">Consultations à venir</h2>
                <a href="{{ route('medecin.planning') }}" class="btn-view-all">Voir tout le planning &rarr;</a>
            </div>
            
            <div class="planning-card">
                @forelse($upcomingConsultations as $rdv)
                <div class="rdv-item">
                    <div class="rdv-time">{{ $rdv->date_heure ? $rdv->date_heure->format('H:i') : '--:--' }}</div>
                    <div class="rdv-patient">
                        <div class="rdv-name">{{ $rdv->patient->user->name ?? 'Patient Anonyme' }}</div>
                        <div class="rdv-motif">{{ $rdv->motif ?? 'Pas de motif spécifié' }}</div>
                    </div>
                    <a href="{{ route('medecin.consultation', ['name' => $rdv->patient->user->name ?? '', 'motif' => $rdv->motif ?? '']) }}" class="rdv-action">
                        {{ $rdv->date_heure && $rdv->date_heure->isToday() && $rdv->date_heure->isPast() ? 'Démarrer' : 'Préparer dossier' }}
                    </a>
                </div>
                @empty
                <p class="text-sm text-gray-500 py-4 text-center">Aucune consultation prévue pour aujourd'hui.</p>
                @endforelse
            </div>
        </div>

        {{-- URGENCES ET NOTIFICATIONS --}}
        <div>
            <div class="section-header">
                <h2 class="section-title">Alertes & Infos</h2>
            </div>
            
            <div class="alert-card mb-4">
                <div class="alert-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <div class="alert-title">Code Rouge : Détresse Respiratoire</div>
                    <div class="alert-desc">Patient en approche (ETA 4 min). Préparez salle de réanimation 2.</div>
                </div>
            </div>

            <div class="planning-card">
                <h3 style="font-size:12px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 16px 0;">Activité récente</h3>
                <div style="display:flex; gap:12px; margin-bottom:12px;">
                    <div style="width:8px; height:8px; border-radius:50%; background:#10b981; margin-top:5px;"></div>
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#0f172a;">Rapport validé</div>
                        <div style="font-size:11px; color:#64748b;">Consultation avec M. TOSSOU terminée.</div>
                    </div>
                </div>
                <div style="display:flex; gap:12px;">
                    <div style="width:8px; height:8px; border-radius:50%; background:#f59e0b; margin-top:5px;"></div>
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#0f172a;">Annulation patient</div>
                        <div style="font-size:11px; color:#64748b;">Le rdv de 14h00 a été libéré.</div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

</div>
@endsection
