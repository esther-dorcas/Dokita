@extends('layouts.dokita')

@section('title', 'Mes rendez-vous — Dokita')

@push('head')
<style>
    :root { --radius-xl: 20px; --radius-lg: 14px; --blue: #2563eb; }

    @keyframes slideUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse   { 0%,100%{opacity:1} 50%{opacity:.3} }
    .animate-up { animation: slideUp .45s ease-out; }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 16px;
        margin-bottom: 24px;
    }
    .page-header h1 { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; }
    .page-header p  { font-size: 13px; color: #64748b; margin-top: 3px; }
    .btn-new-rdv {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--blue); color: #fff;
        padding: 10px 18px; border-radius: 10px;
        font-size: 12px; font-weight: 700;
        text-decoration: none; transition: .15s; flex-shrink: 0;
    }
    .btn-new-rdv:hover { background: #1d4ed8; color: #fff; }

    /* ── STATS ── */
    .rdv-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 12px; margin-bottom: 24px;
    }
    .rs {
        background: #fff; border: 1px solid #e8edf5;
        border-radius: var(--radius-lg); padding: 16px 18px;
        display: flex; align-items: center; gap: 14px; transition: .2s;
    }
    .rs:hover { border-color: #bfdbfe; box-shadow: 0 4px 16px rgba(37,99,235,.06); }
    .rs-icon {
        width: 42px; height: 42px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .rs-label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .6px; }
    .rs-val   { font-size: 22px; font-weight: 800; color: #0f172a; margin-top: 2px; line-height: 1; }

    /* ── NEXT RDV BANNER ── */
    .next-banner {
        background: #0c2340; border-radius: var(--radius-xl);
        padding: 26px 28px; color: #fff;
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px; position: relative; overflow: hidden;
    }
    .next-banner::before {
        content: ""; position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        border-radius: 50%; background: rgba(37,99,235,.2);
    }
    .next-banner::after {
        content: ""; position: absolute;
        bottom: -60px; right: 100px;
        width: 140px; height: 140px;
        border-radius: 50%; background: rgba(37,99,235,.1);
    }
    .nb-left  { position: relative; z-index: 2; }
    .nb-right { position: relative; z-index: 2; display: flex; align-items: center; gap: 16px; }
    .nb-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.12);
        padding: 3px 10px; border-radius: 20px;
        font-size: 10px; font-weight: 700; color: #93c5fd;
        margin-bottom: 10px;
    }
    .nb-dot { width: 5px; height: 5px; border-radius: 50%; background: #22d3ee; animation: pulse 2s infinite; }
    .nb-doc  { font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 4px; }
    .nb-meta { font-size: 12px; color: rgba(255,255,255,.5); }
    .nb-time-box {
        text-align: right;
    }
    .nb-time  { font-size: 28px; font-weight: 800; color: #fff; line-height: 1; }
    .nb-date  { font-size: 11px; font-weight: 600; color: rgba(255,255,255,.4); text-transform: uppercase; margin-top: 3px; }
    .nb-icon  {
        width: 56px; height: 56px; background: rgba(255,255,255,.08);
        border-radius: 14px; display: flex; align-items: center;
        justify-content: center;
    }

    /* ── TABS ── */
    .rdv-tabs {
        display: flex; gap: 6px; background: #f1f5f9;
        padding: 5px; border-radius: 12px;
        margin-bottom: 20px; width: fit-content;
    }
    .rdv-tab {
        padding: 8px 20px; border-radius: 9px;
        font-size: 13px; font-weight: 600; color: #64748b;
        text-decoration: none; transition: .2s; cursor: pointer; border: none;
        background: transparent;
    }
    .rdv-tab.active {
        background: #fff; color: var(--blue);
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
    }

    /* ── RDV CARDS ── */
    .rdv-list { display: flex; flex-direction: column; gap: 12px; }

    .rdv-card {
        background: #fff; border-radius: var(--radius-xl);
        border: 1px solid #e8edf5;
        display: grid; grid-template-columns: 80px 1fr auto;
        align-items: center; gap: 20px; padding: 20px 22px;
        transition: .25s;
    }
    .rdv-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 8px 28px rgba(37,99,235,.07);
        transform: translateY(-2px);
    }
    .rdv-card.annule { opacity: .65; }

    .rdv-date-box {
        width: 80px; height: 88px; background: #f8fafc;
        border-radius: 14px; display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        border: 1px solid #f1f5f9; flex-shrink: 0;
    }
    .rdv-day   { font-size: 26px; font-weight: 900; color: #0f172a; line-height: 1; }
    .rdv-month { font-size: 10px; font-weight: 800; color: var(--blue); text-transform: uppercase; margin-top: 4px; }
    .rdv-year  { font-size: 10px; font-weight: 600; color: #94a3b8; margin-top: 1px; }

    .rdv-info-col h3 {
        font-size: 16px; font-weight: 800; color: #0f172a;
        margin: 0 0 6px;
    }
    .rdv-meta-row {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: #64748b; margin-bottom: 3px;
    }
    .rdv-meta-row svg { flex-shrink: 0; }

    .rdv-badges { display: flex; align-items: center; gap: 8px; margin-top: 10px; flex-wrap: wrap; }
    .rdv-status {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
    }
    .s-conf    { background: #f0fdf4; color: #166534; }
    .s-att     { background: #eff6ff; color: #1e40af; }
    .s-ann     { background: #fef2f2; color: #991b1b; }
    .s-termine { background: #f8fafc; color: #475569; }
    .rdv-time-pill {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; color: #475569;
        background: #f8fafc; border: 1px solid #e2e8f0;
        padding: 3px 9px; border-radius: 20px;
    }

    .rdv-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
    .btn-act {
        width: 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid #e2e8f0; background: #fff;
        color: #64748b; cursor: pointer; transition: .15s;
        text-decoration: none;
    }
    .btn-act:hover         { background: #f1f5f9; color: #0f172a; }
    .btn-act.danger:hover  { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center; padding: 60px 20px;
        background: #fff; border-radius: var(--radius-xl);
        border: 1.5px dashed #e2e8f0;
    }
    .empty-icon {
        width: 64px; height: 64px; background: #eff6ff;
        border-radius: 16px; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 18px;
    }
    .empty-state h3 { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
    .empty-state p  { font-size: 13px; color: #64748b; }
    .empty-state a  { font-size: 13px; font-weight: 700; color: var(--blue); text-decoration: none; display: inline-block; margin-top: 14px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .rdv-card  { grid-template-columns: 1fr; text-align: center; justify-items: center; }
        .rdv-stats { grid-template-columns: 1fr; }
        .next-banner { flex-direction: column; gap: 20px; }
        .nb-right { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- ══ PAGE HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1>Mes rendez-vous</h1>
            <p>Gérez vos consultations et le suivi de votre parcours.</p>
        </div>
        <a href="{{ route('hopitaux.index') }}" class="btn-new-rdv">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau RDV
        </a>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="rdv-stats">
        <div class="rs">
            <div class="rs-icon" style="background:#eff6ff">
                <svg width="20" height="20" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="rs-label">Total</div>
                <div class="rs-val">{{ $rendezVous->count() }}</div>
            </div>
        </div>
        <div class="rs">
            <div class="rs-icon" style="background:#f0fdf4">
                <svg width="20" height="20" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="rs-label">Confirmés</div>
                <div class="rs-val">{{ $rendezVous->where('statut', 'confirme')->count() }}</div>
            </div>
        </div>
        <div class="rs">
            <div class="rs-icon" style="background:#fff7ed">
                <svg width="20" height="20" fill="none" stroke="#c2410c" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="rs-label">En attente</div>
                <div class="rs-val">{{ $rendezVous->where('statut', 'en_attente')->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ══ NEXT RDV BANNER ══ --}}
    @php
        $nextRdv = $rendezVous
            ->whereIn('statut', ['confirme', 'en_attente'])
            ->where('date_heure', '>', now())
            ->sortBy('date_heure')
            ->first();
    @endphp

    @if($nextRdv)
    <div class="next-banner">
        <div class="nb-left">
            <div class="nb-tag">
                <span class="nb-dot"></span> Rendez-vous imminent
            </div>
            <div class="nb-doc">Dr. {{ $nextRdv->medecin->user->name }}</div>
            <div class="nb-meta">
                {{ $nextRdv->date_heure->diffForHumans() }}
                @if($nextRdv->medecin->hopital)
                    &nbsp;·&nbsp; {{ $nextRdv->medecin->hopital->nom }}
                @endif
                @if($nextRdv->motif)
                    &nbsp;·&nbsp; {{ $nextRdv->motif }}
                @endif
            </div>
        </div>
        <div class="nb-right">
            <div class="nb-time-box">
                <div class="nb-time">{{ $nextRdv->date_heure->format('H:i') }}</div>
                <div class="nb-date">{{ $nextRdv->date_heure->translatedFormat('D d M') }}</div>
            </div>
            <div class="nb-icon">
                <svg width="26" height="26" fill="none" stroke="rgba(255,255,255,.6)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
        </div>
    </div>
    @endif

    {{-- ══ TABS ══ --}}
    <div class="rdv-tabs" id="rdvTabs">
        <button class="rdv-tab active" onclick="filterRdv('tous', this)">Tous</button>
        <button class="rdv-tab" onclick="filterRdv('avenir', this)">À venir</button>
        <button class="rdv-tab" onclick="filterRdv('passes', this)">Passés</button>
        <button class="rdv-tab" onclick="filterRdv('annule', this)">Annulés</button>
    </div>

    {{-- ══ LISTE DES RDV ══ --}}
    <div class="rdv-list" id="rdvList">

        @forelse($rendezVous->sortByDesc('date_heure') as $rdv)
        @php
            $isPast    = $rdv->date_heure->isPast();
            $isCancelled = $rdv->statut === 'annule';
            $statusClass = match($rdv->statut) {
                'confirme'   => 's-conf',
                'en_attente' => 's-att',
                'annule'     => 's-ann',
                'termine'    => 's-termine',
                default      => 's-att',
            };
            $statusLabel = match($rdv->statut) {
                'confirme'   => 'Confirmé',
                'en_attente' => 'En attente',
                'annule'     => 'Annulé',
                'termine'    => 'Terminé',
                default      => $rdv->statut,
            };
        @endphp

        <div class="rdv-card {{ $isCancelled ? 'annule' : '' }}"
             data-statut="{{ $rdv->statut }}"
             data-period="{{ $isPast ? 'passes' : 'avenir' }}">

            {{-- DATE BOX --}}
            <div class="rdv-date-box">
                <span class="rdv-day">{{ $rdv->date_heure->format('d') }}</span>
                <span class="rdv-month">{{ $rdv->date_heure->translatedFormat('M') }}</span>
                <span class="rdv-year">{{ $rdv->date_heure->format('Y') }}</span>
            </div>

            {{-- INFO --}}
            <div class="rdv-info-col">
                <h3>Dr. {{ $rdv->medecin->user->name }}</h3>

                @if($rdv->medecin->hopital)
                <div class="rdv-meta-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    {{ $rdv->medecin->hopital->nom }}
                </div>
                @endif

                @if($rdv->medecin->specialite)
                <div class="rdv-meta-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ $rdv->medecin->specialite }}
                </div>
                @endif

                <div class="rdv-badges">
                    <span class="rdv-status {{ $statusClass }}">
                        <span style="width:6px;height:6px;border-radius:50%;background:currentColor;opacity:.6"></span>
                        {{ $statusLabel }}
                    </span>
                    <span class="rdv-time-pill">
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $rdv->date_heure->format('H:i') }}
                    </span>
                    @if($rdv->motif)
                    <span style="font-size:11px;color:#64748b;background:#f8fafc;border:1px solid #e2e8f0;padding:3px 9px;border-radius:20px">
                        {{ $rdv->motif }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="rdv-actions">
                @if(!$isCancelled && !$isPast)
                <button type="button" class="btn-act danger" title="Annuler" onclick="ouvrirModalAnnulation({{ $rdv->id }})">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                @endif
            </div>
        </div>

        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3>Aucun rendez-vous</h3>
            <p>C'est le moment idéal pour planifier votre prochain bilan.</p>
            <a href="{{ route('hopitaux.index') }}">Parcourir les hôpitaux →</a>
        </div>
        @endforelse

    </div>
</div>

{{-- MODAL ANNULATION PATIENT --}}
<div id="modal-annulation-patient" style="display:none; position:fixed; inset:0; background:rgba(12,35,64,.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:20px; padding:32px; width:100%; max-width:400px; box-shadow:0 20px 40px rgba(0,0,0,.15); text-align:center;">
        <div style="width:52px; height:52px; border-radius:50%; background:#fef2f2; color:#dc2626; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 style="margin:0 0 8px; color:#0f172a; font-size:18px; font-weight:800;">Annuler le rendez-vous ?</h3>
        <p style="font-size:13px; color:#64748b; margin-bottom:24px;">Cette action est irréversible. Le médecin et l'hôpital seront automatiquement informés par email.</p>

        <form id="form-annulation-patient" method="POST">
            @csrf
            <div style="display:flex; justify-content:center; gap:10px;">
                <button type="button" onclick="fermerModalAnnulation()" style="padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; background:#f1f5f9; color:#475569; border:none; cursor:pointer;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Garder le RDV</button>
                <button type="submit" style="padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; background:#dc2626; color:#fff; border:none; cursor:pointer;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">Oui, annuler</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function ouvrirModalAnnulation(rdvId) {
    let form = document.getElementById('form-annulation-patient');
    form.action = `/mes-rdv/${rdvId}/annuler`;
    document.getElementById('modal-annulation-patient').style.display = 'flex';
}

function fermerModalAnnulation() {
    document.getElementById('modal-annulation-patient').style.display = 'none';
}

function filterRdv(filter, btn) {
    document.querySelectorAll('.rdv-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.rdv-card').forEach(card => {
        const statut = card.dataset.statut;
        const period = card.dataset.period;
        let show = false;
        if (filter === 'tous')   show = true;
        if (filter === 'avenir') show = period === 'avenir' && statut !== 'annule';
        if (filter === 'passes') show = period === 'passes' && statut !== 'annule';
        if (filter === 'annule') show = statut === 'annule';
        card.style.display = show ? '' : 'none';
    });

    const visible = [...document.querySelectorAll('.rdv-card')].filter(c => c.style.display !== 'none');
    const empty   = document.getElementById('emptyFilter');
    if (visible.length === 0 && !empty) {
        const div = document.createElement('div');
        div.id = 'emptyFilter';
        div.className = 'empty-state';
        div.innerHTML = `
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3>Aucun rendez-vous dans cette catégorie</h3>
        `;
        document.getElementById('rdvList').appendChild(div);
    } else if (visible.length > 0 && empty) {
        empty.remove();
    }
}
</script>
@endpush

@endsection