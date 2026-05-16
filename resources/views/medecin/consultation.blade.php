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
        border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 8px;
        white-space: nowrap; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.1);
    }
    .status-dot { 
        width: 8px; height: 8px; border-radius: 50%; background: #22c55e; 
        position: relative;
    }
    .status-dot::after {
        content: ''; position: absolute; inset: -4px;
        border-radius: 50%; border: 2px solid #22c55e;
        animation: ringPulse 1.5s infinite;
    }
    @keyframes ringPulse {
        0% { transform: scale(0.5); opacity: 1; }
        100% { transform: scale(2.5); opacity: 0; }
    }

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

    /* ── TOAST ── */
    @keyframes toastIn  { from{opacity:0;transform:translateX(60px)} to{opacity:1;transform:translateX(0)} }
    @keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(60px)} }
    #c-toast-wrap { position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none; }
    .c-toast { background:#fff; border-radius:12px; padding:14px 18px; box-shadow:0 8px 30px rgba(0,0,0,.12); display:flex; align-items:center; gap:12px; min-width:260px; border-left:4px solid #22c55e; animation:toastIn .3s ease-out; pointer-events:all; }
    .c-toast.warning { border-left-color:#f59e0b; }
    .c-toast-icon { width:32px; height:32px; border-radius:8px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .c-toast.warning .c-toast-icon { background:#fffbeb; }
    .c-toast-title { font-size:13px; font-weight:800; color:#0f172a; }
    .c-toast-desc  { font-size:12px; color:#64748b; }

    /* ── MODAL CONFIRMATION FIN DE CONSULTATION ── */
    .fin-overlay { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9100; display:flex; align-items:center; justify-content:center; padding:20px; opacity:0; pointer-events:none; transition:opacity .2s; }
    .fin-overlay.open { opacity:1; pointer-events:all; }
    .fin-box { background:#fff; border-radius:20px; width:100%; max-width:400px; padding:28px; box-shadow:0 25px 60px rgba(0,0,0,.15); text-align:center; transform:translateY(12px); transition:transform .2s; }
    .fin-overlay.open .fin-box { transform:translateY(0); }
    .fin-icon { width:56px; height:56px; background:#f0fdf4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
    .fin-title { font-size:17px; font-weight:800; color:#0f172a; margin-bottom:8px; }
    .fin-desc  { font-size:13px; color:#64748b; margin-bottom:24px; line-height:1.6; }
    .fin-actions { display:flex; gap:12px; justify-content:center; }
    .btn-fin-cancel { background:#f1f5f9; color:#475569; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; }
    .btn-fin-cancel:hover { background:#e2e8f0; }
    .btn-fin-ok { background:#16a34a; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; }
    .btn-fin-ok:hover { background:#15803d; }
</style>
@endpush

@section('content')
<div class="animate-in">

    {{-- HEADER PATIENT --}}
    <div class="consult-header">
        <div class="patient-info">
            @php
                $initials = collect(explode(' ', $patient->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('');
                $age = $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->age . ' ans' : 'Âge inconnu';
                $allergies = $patient->patient->allergies ?? 'Aucune';
            @endphp
            <div class="patient-avatar">{{ $initials }}</div>
            <div>
                <div class="patient-name">{{ $patient->name }}</div>
                <div class="patient-meta">
                    <span class="meta-item">{{ $age }}</span>
                    <span class="meta-dot"></span>
                    <span class="meta-item">N° Dossier: #PT-{{ $patient->id }}-{{ date('Y') }}</span>
                    <span class="meta-dot"></span>
                    <span class="meta-item" style="color:{{ $allergies !== 'Aucune' ? '#ef4444' : '#64748b' }}; font-weight:800;">Allergie: {{ $allergies }}</span>
                </div>
            </div>
        </div>
        @php
            $nextRdv = Auth::user()->medecin->rendezVous()
                ->where('patient_id', $patient->id)
                ->whereIn('statut', ['confirme', 'reporte'])
                ->where('date_heure', '>=', now()->startOfDay())
                ->orderBy('date_heure', 'asc')
                ->first();
        @endphp

        @if($nextRdv && $nextRdv->date_heure->isToday())
            <div class="status-badge">
                <div class="status-dot"></div>
                Consultation en cours
            </div>
        @elseif($nextRdv && $nextRdv->date_heure->isFuture())
            <div class="status-badge" style="background: #eff6ff; color: #1e40af; border-color: #bfdbfe; box-shadow: none;">
                <div class="status-dot" style="background: #3b82f6;">
                    <style>.status-dot::after { display: none !important; }</style>
                </div>
                Prochaine séance : {{ $nextRdv->date_heure->translatedFormat('d F') }} à {{ $nextRdv->date_heure->format('H:i') }}
            </div>
        @else
            <div class="status-badge" style="background: #f1f5f9; color: #475569; border-color: #e2e8f0; box-shadow: none;">
                <div class="status-dot" style="background: #94a3b8;">
                    <style>.status-dot::after { display: none !important; }</style>
                </div>
                Dossier historique (Hors séance)
            </div>
        @endif
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
                        <div class="vital-val" style="color:#ef4444;">{{ $patient->patient->groupe_sanguin ?? 'N/A' }}</div>
                    </div>
                    <div class="vital-box">
                        <div class="vital-lbl">Poids</div>
                        <div class="vital-val">{{ $patient->patient->poids ?? '--' }} <span>kg</span></div>
                    </div>
                    <div class="vital-box">
                        <div class="vital-lbl">Taille</div>
                        <div class="vital-val">{{ $patient->patient->taille ?? '--' }} <span>cm</span></div>
                    </div>
                    <div class="vital-box">
                        <div class="vital-lbl">Tension</div>
                        <div class="vital-val">{{ $patient->patient->tension ?? '--' }}</div>
                    </div>
                </div>
                <div class="vital-lbl" style="margin-bottom:8px;">Contact d'urgence (ICE)</div>
                <div style="background:#fef2f2; color:#991b1b; padding:10px 12px; border-radius:8px; font-size:12px; font-weight:700;">
                    {{ $patient->patient->contact_urgence_nom ?? 'Non renseigné' }} : {{ $patient->patient->contact_urgence_tel ?? '--' }}
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Historique Récent
                </div>
                <div class="history-list">
                    @php
                        $historique = \App\Models\RendezVous::where('patient_id', $patient->id)
                            ->where('statut', 'termine')
                            ->orderBy('date_heure', 'desc')
                            ->take(3)
                            ->get();
                    @endphp
                    @forelse($historique as $rdvHist)
                        <div class="history-item">
                            <div class="history-date">{{ $rdvHist->date_heure->translatedFormat('d F Y') }}</div>
                            <div class="history-text">{{ $rdvHist->motif ?? 'Consultation médicale' }}</div>
                        </div>
                    @empty
                        <p style="font-size:12px; color:#64748b; margin:0;">Aucun historique disponible.</p>
                    @endforelse
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

            <div class="ord-box" style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                <div>
                    <div class="field-label" style="color:#c2410c; margin-bottom:4px;">Prescription / Ordonnance</div>
                    <p style="font-size:12px; color:#92400e; margin:0;">Rédigez et imprimez l'ordonnance pour ce patient.</p>
                </div>
                <a href="{{ route('medecin.ordonnances', ['patient_id' => $patient->id]) }}"
                   style="display:inline-flex; align-items:center; gap:8px; padding:11px 20px; background:#c2410c; color:#fff; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; white-space:nowrap; transition:.2s; flex-shrink:0;"
                   onmouseover="this.style.background='#9a3412'" onmouseout="this.style.background='#c2410c'">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    Rédiger l'ordonnance
                </a>
            </div>

            <div class="action-row">
                <button class="btn btn-outline">Sauvegarder brouillon</button>
                <button class="btn btn-primary" onclick="imprimerOrdonnance()">Imprimer Ordonnance</button>
                @if($nextRdv && $nextRdv->date_heure->isToday())
                    <button class="btn btn-success" onclick="demanderTerminer()">Terminer la consultation</button>
                @else
                    <button class="btn btn-success" style="background:#94a3b8; cursor:not-allowed;" title="Possible uniquement le jour du rendez-vous" disabled>Terminer la consultation</button>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- ── MODAL FIN DE CONSULTATION ── --}}
<div class="fin-overlay" id="modal-fin" onclick="if(event.target===this)fermerFin()">
    <div class="fin-box">
        <div class="fin-icon">
            <svg width="26" height="26" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="fin-title">Terminer la consultation ?</div>
        <div class="fin-desc">Confirmez-vous la clôture de cette consultation ?<br>Le dossier sera sauvegardé et vous serez redirigé vers le tableau de bord.</div>
        <div class="fin-actions">
            <button class="btn-fin-cancel" onclick="fermerFin()">Annuler</button>
            <button class="btn-fin-ok" id="btn-fin-ok">Confirmer &amp; Clôturer</button>
        </div>
    </div>
</div>

{{-- ── TOASTS ── --}}
<div id="c-toast-wrap"></div>

@push('scripts')
<script>
    /* ── IMPRIMER ORDONNANCE ── */
    function imprimerOrdonnance() {
        afficherToast(
            'Impression lancée',
            "L'ordonnance a été envoyée à l'impression.",
            'success'
        );
        setTimeout(() => window.print(), 500);
    }

    /* ── TERMINER LA CONSULTATION ── */
    function demanderTerminer() {
        document.getElementById('modal-fin').classList.add('open');
    }
    function fermerFin() {
        document.getElementById('modal-fin').classList.remove('open');
    }
    document.getElementById('btn-fin-ok').addEventListener('click', function () {
        @if($nextRdv)
            this.disabled = true;
            this.textContent = 'Clôture en cours…';
            
            fetch("{{ route('medecin.consultation.cloturer', ['id' => $nextRdv->id]) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    afficherToast('Consultation clôturée', 'Le dossier a été sauvegardé avec succès.', 'success');
                    setTimeout(() => {
                        window.location.href = "{{ route('medecin.dashboard') }}";
                    }, 1200);
                }
            })
            .catch(error => {
                this.disabled = false;
                this.textContent = 'Confirmer & Clôturer';
                afficherToast('Erreur', 'Impossible de clôturer la consultation.', 'warning');
            });
        @endif
    });

    /* ── TOAST ── */
    function afficherToast(titre, desc, type) {
        const wrap = document.getElementById('c-toast-wrap');
        const t = document.createElement('div');
        t.className = 'c-toast' + (type === 'warning' ? ' warning' : '');

        const color = type === 'warning' ? '#f59e0b' : '#22c55e';
        const path  = type === 'warning'
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>';

        t.innerHTML = `
            <div class="c-toast-icon">
                <svg width="18" height="18" fill="none" stroke="${color}" stroke-width="2.5" viewBox="0 0 24 24">${path}</svg>
            </div>
            <div>
                <div class="c-toast-title">${titre}</div>
                <div class="c-toast-desc">${desc}</div>
            </div>`;
        wrap.appendChild(t);
        setTimeout(() => {
            t.style.animation = 'toastOut .3s ease-in forwards';
            setTimeout(() => t.remove(), 300);
        }, 4000);
    }
</script>
@endpush
@endsection
