@extends('layouts.hopital')

@section('title', 'Équipe Médicale — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .4s ease-out; }

    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; background: #fff; padding: 24px 30px; border-radius: var(--radius-xl); border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,.02); }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }
    
    .btn-add { background: var(--blue); color: #fff; padding: 12px 20px; border-radius: 12px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: .2s; }
    .btn-add:hover { background: #1d4ed8; }

    .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .doc-card { background: #fff; border-radius: 16px; border: 1px solid #e8edf5; padding: 24px; transition: .2s; position: relative; }
    .doc-card:hover { transform: translateY(-3px); border-color: #bae6fd; box-shadow: 0 10px 25px rgba(37,99,235,.06); }
    
    .doc-head { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
    .doc-av { width: 48px; height: 48px; border-radius: 12px; background: #f0f9ff; color: var(--blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px; }
    .doc-name { font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
    .doc-spec { font-size: 12px; font-weight: 600; color: #64748b; }
    
    .doc-stats { display: flex; gap: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9; margin-bottom: 16px; }
    .stat { flex: 1; text-align: center; }
    .stat-v { font-size: 16px; font-weight: 800; color: #0f172a; }
    .stat-l { font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }

    .btn-action { display: block; width: 100%; text-align: center; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; color: #475569; font-size: 12px; font-weight: 700; text-decoration: none; transition: .2s; }
    .doc-card:hover .btn-action { background: var(--blue); color: #fff; border-color: var(--blue); }

    .status-dot { position: absolute; top: 24px; right: 24px; width: 10px; height: 10px; border-radius: 50%; }
    .status-dot.active { background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.1); }
    .status-dot.busy { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.1); }
    .status-dot.absent { background: #94a3b8; box-shadow: 0 0 0 3px rgba(148,163,184,.1); }
</style>
@endpush

@section('content')
<div class="animate-up">

    <div class="page-header">
        <div>
            <h1 class="page-title">Équipe Médicale</h1>
            <p class="page-desc">Gérez les praticiens affiliés à votre établissement.</p>
        </div>
        <a href="{{ route('hopital.medecins.create') }}" class="btn-add">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Ajouter un praticien
        </a>
    </div>

    <div class="doc-grid">
        
        @forelse($medecins as $medecin)
            @php
                $nameParts = explode(' ', $medecin->name);
                $initials  = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1] ?? '', 0, 1));
                
                $medModel = $medecin->medecin;
                $isAbsent = $medModel && $medModel->statut === 'inactif';
                $inConsultation = false;
                
                if (!$isAbsent && $medModel && $medModel->rendezVous) {
                    $now = now();
                    $inConsultation = $medModel->rendezVous->contains(function ($rdv) use ($now) {
                        if ($rdv->statut !== 'confirme' || !$rdv->date_heure) return false;
                        $start = $rdv->date_heure;
                        $end = $start->copy()->addMinutes(30);
                        return $now->between($start, $end);
                    });
                }

                if ($isAbsent) {
                    $statusClass = 'absent';
                    $statusTitle = 'Absent';
                } elseif ($inConsultation) {
                    $statusClass = 'busy';
                    $statusTitle = 'En consultation';
                } else {
                    $statusClass = 'active';
                    $statusTitle = 'Disponible';
                }
            @endphp
            <div class="doc-card">
                <div class="status-dot {{ $statusClass }}" title="{{ $statusTitle }}"></div>
                <div class="doc-head">
                    <div class="doc-av">{{ $initials }}</div>
                    <div>
                        <div class="doc-name">{{ $medecin->name }}</div>
                        <div class="doc-spec">{{ $medecin->specialty ?? 'Médecine Générale' }}</div>
                    </div>
                </div>
                <div class="doc-stats">
                    <div class="stat"><div class="stat-v">{{ rand(5, 20) }}</div><div class="stat-l">RDV Jour</div></div>
                    <div class="stat"><div class="stat-v">{{ rand(100, 999) }}</div><div class="stat-l">Patients</div></div>
                    <div class="stat"><div class="stat-v">4.{{ rand(5, 9) }}/5</div><div class="stat-l">Avis</div></div>
                </div>
                <a href="{{ route('hopital.medecins.edit', $medecin->id) }}" class="btn-action">Gérer le profil</a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #64748b; font-size: 14px; background: #fff; border-radius: 16px; border: 1px dashed #cbd5e1;">
                Aucun médecin inscrit dans la base de données pour le moment.
            </div>
        @endforelse

    </div>

</div>
@endsection
