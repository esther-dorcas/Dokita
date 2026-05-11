@extends('layouts.hopital')

@section('title', 'Gestion des Rendez-vous — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .4s ease-out; }

    .page-header { background: #fff; border-radius: var(--radius-xl); padding: 24px 30px; margin-bottom: 24px; border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,.02); display: flex; justify-content: space-between; align-items: center; }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
    @media (max-width: 768px) { .stat-grid { grid-template-columns: 1fr; } }
    .stat-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #e8edf5; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
    .stat-val { font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .stat-lbl { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }

    .tabs-container { display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 2px solid #e8edf5; padding-bottom: 2px; overflow-x: auto; }
    .tab-btn { background: transparent; color: #64748b; padding: 12px 24px; font-size: 14px; font-weight: 800; border: none; cursor: pointer; border-bottom: 3px solid transparent; margin-bottom: -2px; transition: .2s; white-space: nowrap; }
    .tab-btn.active { color: var(--blue); border-bottom-color: var(--blue); }
    .tab-btn:hover:not(.active) { color: #0f172a; }
    
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: slideUp .4s ease-out; }

    .table-card { background: #fff; border-radius: var(--radius-xl); border: 1px solid #e8edf5; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,.02); overflow-x: auto; }
    
    .data-table { width: 100%; border-collapse: collapse; min-width: 700px; }
    .data-table th { text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; padding: 16px 12px; border-bottom: 1px solid #f1f5f9; }
    .data-table td { padding: 16px 12px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #0f172a; font-weight: 500; }
    .data-table tr:hover td { background: #f8fafc; }
    
    .patient-cell { display: flex; align-items: center; gap: 12px; }
    .patient-av { width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: var(--blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; flex-shrink: 0; }
    .patient-name { font-weight: 800; color: #0f172a; }
    .patient-motif { font-size: 11px; color: #64748b; margin-top: 2px; }

    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .status-badge.attente { background: #fffbeb; color: #d97706; }
    .status-badge.confirme { background: #f0fdf4; color: #16a34a; }
    .status-badge.annule { background: #fef2f2; color: #dc2626; }
    
    .btn-action { background: #f1f5f9; color: #475569; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; justify-content: center; }
    .btn-action:hover { background: #e2e8f0; color: #0f172a; }
</style>
@endpush

@section('content')
<div class="animate-up">

    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Rendez-vous</h1>
            <p class="page-desc">Suivez, confirmez et reprogrammez les consultations de vos patients.</p>
        </div>
    </div>

    @php
        $total = $allRdvs->count();
        $confirmes = $allRdvs->where('statut', 'confirme')->count();
        $attente = $allRdvs->whereIn('statut', ['en_attente', 'attente'])->count();
    @endphp

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-val">{{ $total }}</div>
            <div class="stat-lbl">Total Rendez-vous</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color: #16a34a;">{{ $confirmes }}</div>
            <div class="stat-lbl">Confirmés</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color: #d97706;">{{ $attente }}</div>
            <div class="stat-lbl">En attente / À venir</div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="tabs-container">
        <button class="tab-btn active" onclick="openTab(event, 'tab-today')">Aujourd'hui ({{ $rdvAujourdhui->count() }})</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-upcoming')">À venir ({{ $rdvAVenir->count() }})</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-history')">Historique & Passés ({{ $rdvHistorique->count() }})</button>
    </div>

    {{-- TAB: AUJOURD'HUI --}}
    <div id="tab-today" class="tab-content active">
        <div class="table-card">
            <table class="data-table">
                <thead><tr><th>Patient & Motif</th><th>Date & Heure</th><th>Médecin affecté</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($rdvAujourdhui as $rdv)
                        @include('hopital.partials.rdv-row', ['rdv' => $rdv])
                    @empty
                        <tr><td colspan="5" style="text-align: center; padding: 60px 40px; color: #64748b; border: 1px dashed #cbd5e1; border-radius: 12px;"><div style="font-size: 32px; margin-bottom: 12px;">📅</div><div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">Aucun résultat</div><div style="font-size: 13px;">Il n'y a pas de rendez-vous prévus pour aujourd'hui.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TAB: À VENIR --}}
    <div id="tab-upcoming" class="tab-content">
        <div class="table-card">
            <table class="data-table">
                <thead><tr><th>Patient & Motif</th><th>Date & Heure</th><th>Médecin affecté</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($rdvAVenir as $rdv)
                        @include('hopital.partials.rdv-row', ['rdv' => $rdv])
                    @empty
                        <tr><td colspan="5" style="text-align: center; padding: 60px 40px; color: #64748b; border: 1px dashed #cbd5e1; border-radius: 12px;"><div style="font-size: 32px; margin-bottom: 12px;">📅</div><div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">Aucun résultat</div><div style="font-size: 13px;">Il n'y a pas de rendez-vous programmés pour les semaines ou mois à venir.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TAB: HISTORIQUE --}}
    <div id="tab-history" class="tab-content">
        <div class="table-card">
            <table class="data-table">
                <thead><tr><th>Patient & Motif</th><th>Date & Heure</th><th>Médecin affecté</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($rdvHistorique as $rdv)
                        @include('hopital.partials.rdv-row', ['rdv' => $rdv])
                    @empty
                        <tr><td colspan="5" style="text-align: center; padding: 60px 40px; color: #64748b; border: 1px dashed #cbd5e1; border-radius: 12px;"><div style="font-size: 32px; margin-bottom: 12px;">📅</div><div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">Aucun résultat</div><div style="font-size: 13px;">L'historique des rendez-vous des semaines/mois précédents est vide.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Formulaire invisible pour la modification --}}
<form id="form-reprogrammer" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="date_heure" id="input-date-heure">
</form>

@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

<script>
    function openTab(evt, tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
    }

    function reprogrammerRDV(id, currentDate) {
        let newDate = prompt("Veuillez saisir la nouvelle date et heure (Format : AAAA-MM-JJ HH:MM)", currentDate.replace('T', ' '));
        if (newDate) {
            let form = document.getElementById('form-reprogrammer');
            form.action = `/hopital/rdv/${id}/reprogrammer`;
            document.getElementById('input-date-heure').value = newDate.replace(' ', 'T');
            form.submit();
        }
    }
</script>
@endsection
