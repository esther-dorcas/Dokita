@extends('layouts.hopital')

@section('title', 'Tableau de Bord — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .4s ease-out; }

    .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: var(--radius-xl); padding: 24px; border: 1px solid #e8edf5; display: flex; align-items: center; gap: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.02); transition: .2s; }
    .stat-card:hover { transform: translateY(-3px); border-color: #bae6fd; }
    .stat-icon { width: 48px; height: 48px; border-radius: 14px; background: #f0f9ff; color: var(--blue); display: flex; align-items: center; justify-content: center; }
    .stat-icon.alert { background: #fef2f2; color: #ef4444; }
    .stat-icon.success { background: #f0fdf4; color: #22c55e; }
    .stat-val { font-size: 24px; font-weight: 800; color: #0f172a; line-height: 1; margin-bottom: 4px; }
    .stat-lbl { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }

    .panel-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
    @media (max-width: 1024px) { .panel-grid { grid-template-columns: 1fr; } }
    
    .panel { background: #fff; border-radius: var(--radius-xl); border: 1px solid #e8edf5; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,.02); }
    .panel-title { font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .view-all { font-size: 12px; font-weight: 700; color: var(--blue); text-decoration: none; }

    /* Tables */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; }
    .data-table td { padding: 14px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #0f172a; font-weight: 600; }
    .data-table tr:last-child td { border-bottom: none; }
    .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .status-badge.urgent { background: #fef2f2; color: #ef4444; }
    .status-badge.waiting { background: #fffbeb; color: #d97706; }
    .status-badge.active { background: #f0fdf4; color: #22c55e; }

    /* Medecins List */
    .doc-item { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .doc-item:last-child { margin-bottom: 0; }
    .doc-av { width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; }
    .doc-info { flex: 1; }
    .doc-name { font-size: 13px; font-weight: 800; color: #0f172a; }
    .doc-spec { font-size: 11px; color: #64748b; }
    .doc-status { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; }
</style>
@endpush

@section('content')
<div class="animate-up">

    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin:0 0 4px 0;">Tableau de Bord Établissement</h1>
        <p style="font-size: 14px; color: #64748b; margin:0;">Supervision en temps réel des activités et des urgences de {{ Auth::user()->name ?? 'votre hôpital' }}.</p>
    </div>

    {{-- STATS --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"/></svg></div>
            <div><div class="stat-val">{{ $medecinsActifsCount }}</div><div class="stat-lbl">Médecins Actifs</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
            <div><div class="stat-val">{{ $consultationsTodayCount }}</div><div class="stat-lbl">Consultations du jour</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon alert"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
            <div><div class="stat-val">{{ $urgencesEnCoursCount }}</div><div class="stat-lbl">Urgences en cours</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div>
            <div><div class="stat-val">{{ $litsDisponibles }}</div><div class="stat-lbl">Lits Disponibles</div></div>
        </div>
    </div>

    <div class="panel-grid">
        
        {{-- URGENCES ET RDV RECENTS --}}
        <div class="panel">
            <div class="panel-title">
                Demandes Récentes (Urgences & RDV)
                <a href="{{ route('hopital.urgences') }}" class="view-all">Tout afficher</a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Type / Motif</th>
                        <th>Statut</th>
                        <th>Affectation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentDemandes as $rdv)
                    <tr>
                        <td><strong>{{ $rdv->patient->user->name ?? 'Anonyme' }}</strong><br><span style="font-size:11px; color:#64748b; font-weight:400;">{{ $rdv->created_at->format('H:i') }} - {{ $rdv->patient->user->telephone ?? '' }}</span></td>
                        <td>{{ $rdv->motif ?? 'Consultation' }}</td>
                        <td>
                            <span class="status-badge {{ $rdv->statut === 'urgent' ? 'urgent' : ($rdv->statut === 'en_attente' ? 'waiting' : 'active') }}">
                                {{ $rdv->statut_label ?? $rdv->statut }}
                            </span>
                        </td>
                        <td>{{ $rdv->medecin->user->name ?? 'Non affecté' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:20px; color:#94a3b8;">Aucune demande récente.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- EQUIPE DE GARDE --}}
        <div class="panel">
            <div class="panel-title">
                Médecins de Garde
                <a href="{{ route('hopital.medecins') }}" class="view-all">Gérer</a>
            </div>
            
            @forelse($medecinsGarde as $userDoc)
            <div class="doc-item">
                <div class="doc-av">{{ $userDoc->medecin->initiales ?? 'DR' }}</div>
                <div class="doc-info">
                    <div class="doc-name">Dr. {{ $userDoc->name }}</div>
                    <div class="doc-spec">{{ $userDoc->medecin->specialite->nom_specialite ?? 'Généraliste' }}</div>
                </div>
                <div class="doc-status" title="Disponible"></div>
            </div>
            @empty
            <p class="text-xs text-gray-400">Aucun médecin de garde répertorié.</p>
            @endforelse

            <a href="{{ route('hopital.medecins.create') }}" class="view-all" style="display:block; text-align:center; margin-top:20px; padding:10px; background:#f8fafc; border-radius:10px;">+ Ajouter un médecin</a>
        </div>

    </div>

</div>
@endsection
