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
        
        @php
            // On récupère la liste des patients uniques qui ont eu ou ont un RDV confirmé avec ce médecin
            $patientsUniques = $appointments->unique('patient_id');
        @endphp

        @forelse($patientsUniques as $rdv)
            @php
                $patientUser = $rdv->patient;
                $initials = collect(explode(' ', $patientUser->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('');
                $age = $patientUser->birth_date ? \Carbon\Carbon::parse($patientUser->birth_date)->age . ' ans' : 'Age inconnu';
                
                // On cherche le dernier RDV passé pour afficher la date de "Dernière Visite"
                $derniereVisite = $appointments->where('patient_id', $rdv->patient_id)
                    ->where('date_heure', '<=', now())
                    ->sortByDesc('date_heure')
                    ->first();
                
                $dateVisite = $derniereVisite ? $derniereVisite->date_heure->translatedFormat('d M Y') : 'Aucune';
                if ($derniereVisite && $derniereVisite->date_heure->isToday()) $dateVisite = "Aujourd'hui";
                if ($derniereVisite && $derniereVisite->date_heure->isYesterday()) $dateVisite = "Hier";

                $allergies = $patientUser->patient->allergies ?? 'Aucune';
            @endphp
            
            <div class="p-card">
                <div class="p-header">
                    <div class="p-avatar">{{ $initials }}</div>
                    <div>
                        <div class="p-name">{{ $patientUser->name }}</div>
                        <div class="p-id">#PT-{{ $patientUser->id }}-{{ date('Y') }}</div>
                    </div>
                </div>
                <div class="p-body">
                    <div class="p-stat">Âge : <strong>{{ $age }}</strong></div>
                    <div class="p-stat">Dernière Visite : <strong>{{ $dateVisite }}</strong></div>
                    <div class="p-stat {{ $allergies !== 'Aucune' ? 'alert' : '' }}">
                        Alerte Méd. : <strong>{{ $allergies }}</strong>
                    </div>
                </div>
                <div class="p-actions">
                    <a href="{{ route('medecin.consultation', ['patient_id' => $patientUser->id, 'motif' => 'Consultation depuis le répertoire']) }}" class="btn-dossier">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Dossier médical
                    </a>
                    <a href="{{ route('medecin.ordonnances', ['patient' => $patientUser->name]) }}" class="btn-ord">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Ordonnance
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #fff; border-radius: 16px; border: 1.5px dashed #e2e8f0; color: #64748b;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 15px; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 style="font-weight: 800; color: #0f172a; margin-bottom: 5px;">Aucun patient répertorié</h3>
                <p style="font-size: 13px;">Les patients apparaîtront ici dès qu'un de leurs rendez-vous sera confirmé par l'hôpital.</p>
            </div>
        @endforelse

    </div>

</div>
@endsection
