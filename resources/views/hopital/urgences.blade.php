@extends('layouts.hopital')

@section('title', 'Urgences & SOS — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse-red { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,0.4);} 50%{box-shadow:0 0 0 10px rgba(239,68,68,0);} }
    @keyframes toastIn { from { opacity:0; transform:translateX(60px); } to { opacity:1; transform:translateX(0); } }
    @keyframes toastOut { from { opacity:1; transform:translateX(0); } to { opacity:0; transform:translateX(60px); } }
    .animate-up { animation: slideUp .4s ease-out; }

    /* ── HEADER ── */
    .page-header { background: #fff; border-radius: var(--radius-xl); padding: 24px 30px; margin-bottom: 24px; border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,.02); display: flex; justify-content: space-between; align-items: center; }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    /* ── BANNER ── */
    .alert-banner { background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
    .alert-icon { width: 40px; height: 40px; background: #ef4444; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; animation: pulse-red 2s infinite; }
    .alert-text { flex: 1; }
    .alert-title { font-size: 14px; font-weight: 800; color: #991b1b; }
    .alert-desc { font-size: 12px; color: #b91c1c; }

    /* ── CARDS ── */
    .sos-grid { display: grid; gap: 16px; }
    .sos-card { background: #fff; border: 1px solid #e8edf5; border-left: 4px solid #ef4444; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,.02); transition: opacity .3s; }
    .sos-card.resolved { border-left-color: #22c55e; opacity: 0.7; }

    .sos-info { flex: 1; min-width: 0; }
    .sos-patient { font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap; }
    .sos-time { font-size: 11px; font-weight: 700; color: #ef4444; background: #fef2f2; padding: 2px 8px; border-radius: 6px; white-space: nowrap; }
    .sos-resolved-time { font-size: 11px; font-weight: 700; color: #22c55e; background: #f0fdf4; padding: 2px 8px; border-radius: 6px; white-space: nowrap; }
    .sos-details { font-size: 13px; color: #475569; display: flex; gap: 16px; flex-wrap: wrap; }
    .sos-details span { display: inline-flex; align-items: center; gap: 4px; }

    .sos-actions { display: flex; gap: 10px; flex-shrink: 0; margin-left: 16px; }
    .btn-sos { padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; cursor: pointer; border: none; transition: background .15s; }
    .btn-sos.primary { background: #ef4444; color: #fff; }
    .btn-sos.primary:hover { background: #dc2626; }
    .btn-sos.secondary { background: #f1f5f9; color: #475569; }
    .btn-sos.secondary:hover { background: #e2e8f0; }
    .btn-sos:disabled { opacity: .5; cursor: not-allowed; }

    /* ── MODAL DOSSIER ── */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 9000; display: flex; align-items: center; justify-content: center; padding: 20px; opacity: 0; pointer-events: none; transition: opacity .2s; }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal-box { background: #fff; border-radius: 20px; width: 100%; max-width: 520px; box-shadow: 0 25px 60px rgba(0,0,0,.15); transform: translateY(10px); transition: transform .2s; }
    .modal-overlay.open .modal-box { transform: translateY(0); }
    .modal-header { padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .modal-header h3 { font-size: 16px; font-weight: 800; color: #0f172a; margin: 0; }
    .modal-close { background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 18px; line-height: 1; transition: background .15s; }
    .modal-close:hover { background: #e2e8f0; color: #0f172a; }
    .modal-body { padding: 20px 24px; }
    .modal-row { display: flex; gap: 10px; margin-bottom: 12px; }
    .modal-field { flex: 1; }
    .modal-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
    .modal-value { font-size: 14px; font-weight: 600; color: #0f172a; background: #f8fafc; border-radius: 8px; padding: 8px 12px; min-height: 38px; display: flex; align-items: center; word-break: break-word; }
    .modal-value.urgence { color: #ef4444; background: #fef2f2; }
    .modal-footer { padding: 16px 24px 20px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; }
    .btn-modal-close { background: var(--blue); color: #fff; border: none; padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-modal-close:hover { background: #1d4ed8; }

    /* ── MODAL CONFIRMATION ── */
    .confirm-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 9100; display: flex; align-items: center; justify-content: center; padding: 20px; opacity: 0; pointer-events: none; transition: opacity .2s; }
    .confirm-overlay.open { opacity: 1; pointer-events: all; }
    .confirm-box { background: #fff; border-radius: 20px; width: 100%; max-width: 420px; padding: 28px 28px 24px; box-shadow: 0 25px 60px rgba(0,0,0,.15); text-align: center; transform: translateY(10px); transition: transform .2s; }
    .confirm-overlay.open .confirm-box { transform: translateY(0); }
    .confirm-icon { width: 56px; height: 56px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .confirm-title { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
    .confirm-desc { font-size: 13px; color: #64748b; margin-bottom: 24px; line-height: 1.6; }
    .confirm-actions { display: flex; gap: 12px; justify-content: center; }
    .btn-confirm-cancel { background: #f1f5f9; color: #475569; border: none; padding: 10px 22px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-confirm-cancel:hover { background: #e2e8f0; }
    .btn-confirm-ok { background: #ef4444; color: #fff; border: none; padding: 10px 22px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-confirm-ok:hover { background: #dc2626; }

    /* ── TOAST ── */
    #toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
    .toast { background: #fff; border-radius: 12px; padding: 14px 18px; box-shadow: 0 8px 30px rgba(0,0,0,.12); display: flex; align-items: center; gap: 12px; min-width: 260px; border-left: 4px solid #22c55e; animation: toastIn .3s ease-out; }
    .toast.error { border-left-color: #ef4444; }
    .toast-icon { width: 32px; height: 32px; border-radius: 8px; background: #f0fdf4; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .toast.error .toast-icon { background: #fef2f2; }
    .toast-text { flex: 1; }
    .toast-title { font-size: 13px; font-weight: 800; color: #0f172a; }
    .toast-desc { font-size: 12px; color: #64748b; }
</style>
@endpush

@section('content')
<div class="animate-up">

    <div class="page-header">
        <div>
            <h1 class="page-title">Urgences & SOS</h1>
            <p class="page-desc">Suivi des demandes d'assistance d'urgence affectées à votre centre.</p>
        </div>
    </div>

    @php $activeCount = $urgences->where('statut', 'en_cours')->count(); @endphp

    <div class="alert-banner" id="main-alert-banner" style="{{ $activeCount === 0 ? 'display:none' : '' }}">
        <div class="alert-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="alert-text">
            <div class="alert-title" id="banner-count-text">{{ $activeCount }} Urgence(s) critique(s) en cours</div>
            <div class="alert-desc">Veuillez coordonner l'arrivée avec le médecin de garde.</div>
        </div>
    </div>

    <div class="sos-grid">
        @forelse($urgences as $urgence)
            @php
                $nom     = $urgence->nom_appelant ?? ($urgence->patient->name ?? 'Patient Anonyme');
                $contact = $urgence->telephone    ?? ($urgence->patient->telephone ?? 'Non renseigné');
                $isAnon  = is_null($urgence->patient_id);
            @endphp

            @if($urgence->statut === 'en_cours')
                <div class="sos-card" id="sos-{{ $urgence->id }}">
                    <div class="sos-info">
                        <div class="sos-patient">
                            {{ $nom }}
                            @if($isAnon)
                                <span style="font-size:10px;background:#fef9c3;color:#92400e;padding:2px 7px;border-radius:5px;font-weight:700;">Appel externe</span>
                            @endif
                            <span class="sos-time" id="badge-{{ $urgence->id }}">{{ $urgence->created_at->format('d/m H:i') }} — En cours</span>
                        </div>
                        <div class="sos-details">
                            <span><strong>Motif :</strong> {{ Str::limit($urgence->description, 60) }}</span>
                            <span><strong>Contact :</strong> {{ $contact }}</span>
                            <span><strong>Localisation :</strong> {{ $urgence->localisation ?? 'Non précisée' }}</span>
                        </div>
                    </div>
                    <div class="sos-actions" id="actions-{{ $urgence->id }}">
                        <button class="btn-sos secondary"
                            onclick="ouvrirDossier({
                                nom: @js($nom),
                                contact: @js($contact),
                                description: @js($urgence->description),
                                localisation: @js($urgence->localisation ?? 'Non précisée'),
                                date: @js($urgence->created_at->format('d/m/Y à H:i')),
                                anon: {{ $isAnon ? 'true' : 'false' }}
                            })">Voir dossier</button>
                        <button class="btn-sos primary" id="btn-charge-{{ $urgence->id }}"
                            onclick="demanderPriseEnCharge({{ $urgence->id }})">Prise en charge</button>
                    </div>
                </div>
            @else
                <div class="sos-card resolved" id="sos-{{ $urgence->id }}">
                    <div class="sos-info">
                        <div class="sos-patient">
                            {{ $nom }}
                            @if($isAnon)
                                <span style="font-size:10px;background:#fef9c3;color:#92400e;padding:2px 7px;border-radius:5px;font-weight:700;">Appel externe</span>
                            @endif
                            <span class="sos-resolved-time">Résolu le {{ $urgence->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="sos-details">
                            <span><strong>Motif :</strong> {{ Str::limit($urgence->description, 60) }}</span>
                            <span><strong>Contact :</strong> {{ $contact }}</span>
                            <span><strong>Statut :</strong> Pris en charge</span>
                        </div>
                    </div>
                    <div class="sos-actions">
                        <button class="btn-sos secondary"
                            onclick="ouvrirDossier({
                                nom: @js($nom),
                                contact: @js($contact),
                                description: @js($urgence->description),
                                localisation: @js($urgence->localisation ?? 'Non précisée'),
                                date: @js($urgence->created_at->format('d/m/Y à H:i')),
                                anon: {{ $isAnon ? 'true' : 'false' }},
                                resolu: true,
                                resoluDate: @js($urgence->updated_at->format('d/m/Y à H:i'))
                            })">Voir dossier</button>
                    </div>
                </div>
            @endif
        @empty
            <div style="padding: 40px; text-align: center; background: #fff; border-radius: 16px; border: 1px dashed #cbd5e1; color: #64748b;">
                Aucune urgence signalée pour le moment.
            </div>
        @endforelse
    </div>

</div>

{{-- ── MODAL DOSSIER ── --}}
<div class="modal-overlay" id="modal-dossier" onclick="if(event.target===this)fermerDossier()">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Dossier d'urgence</h3>
            <button class="modal-close" onclick="fermerDossier()">&#x2715;</button>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="modal-field">
                    <div class="modal-label">Nom / Appelant</div>
                    <div class="modal-value" id="d-nom"></div>
                </div>
                <div class="modal-field">
                    <div class="modal-label">Contact</div>
                    <div class="modal-value" id="d-contact"></div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-field">
                    <div class="modal-label">Date de l'alerte</div>
                    <div class="modal-value" id="d-date"></div>
                </div>
                <div class="modal-field" id="d-statut-field">
                    <div class="modal-label">Statut</div>
                    <div class="modal-value" id="d-statut"></div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-field">
                    <div class="modal-label">Localisation</div>
                    <div class="modal-value" id="d-localisation"></div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-field">
                    <div class="modal-label">Description / Motif de l'urgence</div>
                    <div class="modal-value urgence" id="d-description" style="align-items:flex-start;padding-top:10px;min-height:60px;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="fermerDossier()">Fermer</button>
        </div>
    </div>
</div>

{{-- ── MODAL CONFIRMATION PRISE EN CHARGE ── --}}
<div class="confirm-overlay" id="modal-confirm" onclick="if(event.target===this)fermerConfirm()">
    <div class="confirm-box">
        <div class="confirm-icon">
            <svg width="26" height="26" fill="none" stroke="#ef4444" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="confirm-title">Confirmer la prise en charge</div>
        <div class="confirm-desc">Vous êtes sur le point de déployer l'équipe médicale pour cette urgence.<br>Cette action est irréversible.</div>
        <div class="confirm-actions">
            <button class="btn-confirm-cancel" onclick="fermerConfirm()">Annuler</button>
            <button class="btn-confirm-ok" id="btn-confirm-ok">Confirmer le déploiement</button>
        </div>
    </div>
</div>

{{-- ── TOAST ── --}}
<div id="toast-container"></div>

@push('scripts')
<script>
    let pendingUrgenceId = null;
    let activeCount = {{ $activeCount }};

    /* ─── DOSSIER ─── */
    function ouvrirDossier(data) {
        document.getElementById('d-nom').textContent         = data.nom;
        document.getElementById('d-contact').textContent     = data.contact;
        document.getElementById('d-date').textContent        = data.date;
        document.getElementById('d-localisation').textContent = data.localisation;
        document.getElementById('d-description').textContent  = data.description;

        const statutEl = document.getElementById('d-statut');
        if (data.resolu) {
            statutEl.textContent = 'Résolu le ' + data.resoluDate;
            statutEl.style.color = '#16a34a';
            statutEl.style.background = '#f0fdf4';
        } else {
            statutEl.textContent = 'En cours';
            statutEl.style.color = '#ef4444';
            statutEl.style.background = '#fef2f2';
        }

        document.getElementById('modal-dossier').classList.add('open');
    }

    function fermerDossier() {
        document.getElementById('modal-dossier').classList.remove('open');
    }

    /* ─── CONFIRMATION PRISE EN CHARGE ─── */
    function demanderPriseEnCharge(id) {
        pendingUrgenceId = id;
        document.getElementById('modal-confirm').classList.add('open');
    }

    function fermerConfirm() {
        document.getElementById('modal-confirm').classList.remove('open');
        pendingUrgenceId = null;
    }

    document.getElementById('btn-confirm-ok').addEventListener('click', function () {
        if (!pendingUrgenceId) return;
        const id = pendingUrgenceId;
        fermerConfirm();

        const btnCharge = document.getElementById('btn-charge-' + id);
        if (btnCharge) { btnCharge.disabled = true; btnCharge.textContent = 'Traitement…'; }

        fetch(`/hopital/urgences/${id}/resolve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) throw new Error('Erreur serveur');

            // Carte → résolue
            const card = document.getElementById('sos-' + id);
            card.classList.add('resolved');

            const badge = document.getElementById('badge-' + id);
            badge.className = 'sos-resolved-time';
            badge.textContent = "Résolu à l'instant";

            const actions = document.getElementById('actions-' + id);
            actions.innerHTML = '<button class="btn-sos secondary" disabled>Résolu</button>';

            // Bannière
            activeCount = Math.max(0, activeCount - 1);
            const banner = document.getElementById('main-alert-banner');
            if (activeCount === 0) {
                banner.style.display = 'none';
            } else {
                document.getElementById('banner-count-text').textContent = activeCount + ' Urgence(s) critique(s) en cours';
            }

            afficherToast('Prise en charge confirmée', "L'équipe d'intervention a été déployée.", 'success');
        })
        .catch(() => {
            if (btnCharge) { btnCharge.disabled = false; btnCharge.textContent = 'Prise en charge'; }
            afficherToast('Erreur', 'Impossible de mettre à jour le statut. Réessayez.', 'error');
        });
    });

    /* ─── TOAST ─── */
    function afficherToast(titre, desc, type) {
        const container = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = 'toast' + (type === 'error' ? ' error' : '');

        const iconColor = type === 'error' ? '#ef4444' : '#22c55e';
        const iconPath  = type === 'error'
            ? '<path d="M18 6L6 18M6 6l12 12"/>'
            : '<path d="M5 13l4 4L19 7"/>';

        t.innerHTML = `
            <div class="toast-icon">
                <svg width="18" height="18" fill="none" stroke="${iconColor}" stroke-width="2.5" viewBox="0 0 24 24">${iconPath}</svg>
            </div>
            <div class="toast-text">
                <div class="toast-title">${titre}</div>
                <div class="toast-desc">${desc}</div>
            </div>`;

        container.appendChild(t);
        setTimeout(() => {
            t.style.animation = 'toastOut .3s ease-in forwards';
            setTimeout(() => t.remove(), 300);
        }, 4000);
    }
</script>
@endpush
@endsection
