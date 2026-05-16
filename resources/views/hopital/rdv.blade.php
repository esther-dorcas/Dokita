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
        $total     = $allRdvs->count();
        $confirmes = $allRdvs->where('statut', 'confirme')->count();
        $nbAttente = $rdvEnAttente->count();
    @endphp

    {{-- Bannière alerte si RDV en attente --}}
    @if($nbAttente > 0)
    <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:14px 20px; display:flex; align-items:center; gap:14px; margin-bottom:20px;">
        <div style="width:36px;height:36px;background:#f59e0b;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        </div>
        <div>
            <div style="font-size:14px;font-weight:800;color:#92400e;">{{ $nbAttente }} rendez-vous en attente de confirmation</div>
            <div style="font-size:12px;color:#b45309;">Veuillez les confirmer ou les annuler — le médecin ne les voit pas encore.</div>
        </div>
        <button onclick="openTab(null,'tab-confirm');this.closest('div').style.display='none'" style="margin-left:auto;background:#f59e0b;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">Voir &rarr;</button>
    </div>
    @endif

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-val">{{ $total }}</div>
            <div class="stat-lbl">Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color: #16a34a;">{{ $confirmes }}</div>
            <div class="stat-lbl">Confirmés</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color: #d97706;">{{ $nbAttente }}</div>
            <div class="stat-lbl">En attente</div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="tabs-container">
        <button class="tab-btn {{ $nbAttente > 0 ? '' : 'active' }}" onclick="openTab(event, 'tab-today')">Aujourd'hui ({{ $rdvAujourdhui->count() }})</button>
        <button class="tab-btn {{ $nbAttente > 0 ? 'active' : '' }}" onclick="openTab(event, 'tab-confirm')" style="{{ $nbAttente > 0 ? 'color:#d97706;border-bottom-color:#d97706;' : '' }}">
            À confirmer
            @if($nbAttente > 0)<span style="background:#f59e0b;color:#fff;border-radius:999px;font-size:10px;padding:1px 7px;margin-left:6px;">{{ $nbAttente }}</span>@endif
        </button>
        <button class="tab-btn" onclick="openTab(event, 'tab-upcoming')">À venir ({{ $rdvAVenir->count() }})</button>
        <button class="tab-btn" onclick="openTab(event, 'tab-history')">Historique ({{ $rdvHistorique->count() }})</button>
    </div>

    {{-- TAB: AUJOURD'HUI --}}
    <div id="tab-today" class="tab-content {{ $nbAttente > 0 ? '' : 'active' }}">
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

    {{-- TAB: À CONFIRMER --}}
    <div id="tab-confirm" class="tab-content {{ $nbAttente > 0 ? 'active' : '' }}">
        <div class="table-card">
            <table class="data-table">
                <thead><tr><th>Patient & Motif</th><th>Date & Heure</th><th>Médecin affecté</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($rdvEnAttente as $rdv)
                        @include('hopital.partials.rdv-row', ['rdv' => $rdv])
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:60px 40px;color:#64748b;">
                            <div style="font-size:32px;margin-bottom:12px;">✅</div>
                            <div style="font-weight:700;color:#0f172a;margin-bottom:4px;">Tout est à jour</div>
                            <div style="font-size:13px;">Aucun rendez-vous en attente de confirmation.</div>
                        </td></tr>
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

{{-- MODAL REPROGRAMMER --}}
<div id="modal-reprogrammer" style="display:none; position:fixed; inset:0; background:rgba(12,35,64,.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:var(--radius-xl); padding:30px; width:100%; max-width:400px; box-shadow:0 20px 40px rgba(0,0,0,.15); animation:slideUp .3s ease-out;">
        <h3 style="margin-top:0; color:#0f172a; font-size:18px; font-weight:800; margin-bottom:10px;">Reprogrammer le rendez-vous</h3>
        <p style="font-size:13px; color:#64748b; margin-bottom:20px;">Veuillez choisir la nouvelle date et heure pour ce rendez-vous.</p>
        
        <form id="form-reprogrammer" method="POST">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:11px; font-weight:800; color:#475569; margin-bottom:6px; text-transform:uppercase; letter-spacing:.5px;">Nouvelle Date & Heure</label>
                <input type="datetime-local" name="date_heure" id="modal-date-heure" required style="width:100%; padding:12px 14px; border-radius:10px; background:#f8fafc; border:1px solid #e2e8f0; font-size:14px; font-weight:600; color:#0f172a; outline:none; transition:.2s;" onfocus="this.style.borderColor='var(--blue)';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'" onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeModal()" style="padding:10px 18px; border-radius:10px; font-size:13px; font-weight:700; background:#f1f5f9; color:#475569; border:none; cursor:pointer; transition:.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Annuler</button>
                <button type="submit" style="padding:10px 18px; border-radius:10px; font-size:13px; font-weight:700; background:var(--blue); color:#fff; border:none; cursor:pointer; transition:.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='var(--blue)'">Confirmer</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL ANNULER --}}
<div id="modal-annuler" style="display:none; position:fixed; inset:0; background:rgba(12,35,64,.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:var(--radius-xl); padding:30px; width:100%; max-width:400px; box-shadow:0 20px 40px rgba(0,0,0,.15); animation:slideUp .3s ease-out; text-align:center;">
        <div style="width:50px; height:50px; border-radius:50%; background:#fef2f2; color:#dc2626; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 style="margin-top:0; color:#0f172a; font-size:18px; font-weight:800; margin-bottom:10px;">Annuler le rendez-vous ?</h3>
        <p style="font-size:13px; color:#64748b; margin-bottom:24px;">Êtes-vous absolument sûr de vouloir annuler ce rendez-vous ? Cette action est irréversible et le patient sera notifié.</p>
        
        <form id="form-annuler" method="POST">
            @csrf
            <input type="hidden" name="statut" value="annule">
            
            <div style="display:flex; justify-content:center; gap:10px;">
                <button type="button" onclick="closeModal()" style="padding:10px 18px; border-radius:10px; font-size:13px; font-weight:700; background:#f1f5f9; color:#475569; border:none; cursor:pointer; transition:.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Garder le RDV</button>
                <button type="submit" style="padding:10px 18px; border-radius:10px; font-size:13px; font-weight:700; background:#dc2626; color:#fff; border:none; cursor:pointer; transition:.2s;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">Oui, annuler</button>
            </div>
        </form>
    </div>
</div>

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
        if (evt && evt.currentTarget) evt.currentTarget.classList.add('active');
    }

    function reprogrammerRDV(id, currentDate) {
        let form = document.getElementById('form-reprogrammer');
        form.action = `/hopital/rdv/${id}/reprogrammer`;
        
        let dateInput = document.getElementById('modal-date-heure');
        dateInput.value = currentDate.replace(' ', 'T').substring(0, 16);
        
        let modal = document.getElementById('modal-reprogrammer');
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modal-reprogrammer').style.display = 'none';
        document.getElementById('modal-annuler').style.display = 'none';
    }

    function annulerRDV(id) {
        let form = document.getElementById('form-annuler');
        form.action = `/hopital/rdv/${id}/statut`;
        
        let modal = document.getElementById('modal-annuler');
        modal.style.display = 'flex';
    }
</script>
@endsection
