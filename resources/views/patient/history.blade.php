@extends('layouts.dokita')

@section('title', 'Historique Médical — Dokita')

@push('head')
<style>
    :root { --blue:#2563eb; --dark:#0c2340; --radius-xl:20px; --radius-lg:14px; }

    @keyframes slideUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes pulse   { 0%,100%{opacity:1} 50%{opacity:.3} }
    .animate-up { animation:slideUp .45s ease-out; }

    /* ── HERO ── */
    .hero {
        background:var(--dark); border-radius:var(--radius-xl);
        padding:32px 28px 76px; position:relative;
        overflow:hidden; margin-bottom:0;
    }
    .hero-deco1 { position:absolute;top:-50px;right:-50px;width:220px;height:220px;border-radius:50%;background:rgba(37,99,235,.18); }
    .hero-deco2 { position:absolute;bottom:-70px;right:80px;width:160px;height:160px;border-radius:50%;background:rgba(37,99,235,.1); }
    .hero-content { position:relative;z-index:2;max-width:600px; }
    .hero-tag {
        display:inline-flex;align-items:center;gap:6px;
        background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
        padding:3px 12px;border-radius:20px;
        font-size:10px;font-weight:700;color:#93c5fd;
        margin-bottom:14px;
    }
    .hero-dot { width:6px;height:6px;border-radius:50%;background:#22d3ee;animation:pulse 2s infinite; }
    .hero-title { font-size:22px;font-weight:800;color:#fff;margin-bottom:6px; }
    .hero-sub   { font-size:13px;color:rgba(255,255,255,.45);line-height:1.6;margin-bottom:20px; }

    /* ── SEARCH HERO ── */
    .search-hero {
        display:flex;align-items:center;gap:10px;
        background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);
        border-radius:10px;padding:0 14px;max-width:500px;
        transition:.15s;
    }
    .search-hero:focus-within { background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3); }
    .search-hero input {
        background:transparent;border:none;outline:none;
        color:#fff;font-size:13px;font-weight:500;
        padding:11px 0;width:100%;
    }
    .search-hero input::placeholder { color:rgba(255,255,255,.4); }

    /* ── STATS FLOTTANTES ── */
    .stats-float {
        display:grid;grid-template-columns:repeat(3,minmax(0,1fr));
        gap:12px;margin-top:-44px;position:relative;z-index:10;
        padding:0 2px;margin-bottom:28px;
    }
    .sf {
        background:#fff;border:1px solid #e2e8f0;
        border-radius:var(--radius-lg);padding:16px 18px;
        transition:.2s;
    }
    .sf:hover { transform:translateY(-2px);border-color:#bfdbfe;box-shadow:0 6px 20px rgba(37,99,235,.07); }
    .sf-icon  { width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:9px; }
    .sf-label { font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px; }
    .sf-val   { font-size:20px;font-weight:800;color:#0f172a;margin-top:3px;line-height:1; }

    /* ── FILTERS ── */
    .filter-row { display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:20px; }
    .filter-chip {
        padding:6px 14px;border-radius:20px;
        font-size:12px;font-weight:700;
        border:1px solid #e2e8f0;background:#fff;color:#64748b;
        cursor:pointer;transition:.15s;
    }
    .filter-chip:hover  { border-color:#bfdbfe;color:var(--blue); }
    .filter-chip.active { background:var(--blue);color:#fff;border-color:var(--blue); }

    /* ── TIMELINE ── */
    .tl-wrapper { position:relative;padding-left:36px; }
    .tl-wrapper::before {
        content:"";position:absolute;left:14px;top:8px;bottom:8px;
        width:2px;background:#e8edf5;border-radius:2px;
    }

    /* ── HISTORY CARD ── */
    .hc {
        background:#fff;border-radius:var(--radius-xl);
        border:1px solid #e8edf5;padding:22px 24px;
        margin-bottom:14px;position:relative;transition:.2s;
    }
    .hc:hover { border-color:#bfdbfe;box-shadow:0 8px 24px rgba(37,99,235,.07);transform:translateY(-2px); }
    .hc::before {
        content:"";position:absolute;left:-27px;top:28px;
        width:12px;height:12px;border-radius:50%;
        background:#fff;border:3px solid var(--blue);
        box-shadow:0 0 0 4px rgba(37,99,235,.1);z-index:2;
    }

    .hc-layout { display:grid;grid-template-columns:1fr auto;gap:20px;align-items:flex-start; }
    .hc-date   { font-size:10px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.6px;margin-bottom:5px; }
    .hc-doc    { font-size:16px;font-weight:800;color:#0f172a;margin-bottom:4px; }
    .hc-hosp   {
        display:inline-flex;align-items:center;gap:5px;
        font-size:12px;color:#64748b;margin-bottom:12px;
    }
    .hc-motif  {
        font-size:12px;color:#475569;background:#f8fafc;
        border:1px solid #f1f5f9;border-radius:9px;
        padding:10px 14px;line-height:1.6;
    }
    .hc-motif strong { color:#0f172a;font-weight:700; }

    .hc-status {
        display:inline-flex;align-items:center;gap:5px;
        font-size:10px;font-weight:700;padding:3px 9px;
        border-radius:20px;margin-bottom:12px;
    }
    .s-done { background:#f0fdf4;color:#166534; }
    .s-ann  { background:#fef2f2;color:#991b1b; }

    /* ── DOC BADGES ── */
    .doc-badges { display:flex;flex-direction:column;gap:7px;flex-shrink:0; }
    .doc-badge {
        display:inline-flex;align-items:center;gap:7px;
        background:#f8fafc;border:1px solid #e2e8f0;
        border-radius:9px;padding:7px 12px;
        font-size:11px;font-weight:700;color:#475569;
        text-decoration:none;transition:.15s;white-space:nowrap;
    }
    .doc-badge:hover { background:#eff6ff;color:var(--blue);border-color:#bfdbfe; }

    /* ── EMPTY ── */
    .empty-state {
        text-align:center;padding:60px 24px;
        background:#fff;border-radius:var(--radius-xl);
        border:1.5px dashed #e2e8f0;
    }
    .empty-icon {
        width:60px;height:60px;background:#eff6ff;border-radius:14px;
        display:flex;align-items:center;justify-content:center;
        margin:0 auto 16px;
    }
    .empty-state h3 { font-size:16px;font-weight:800;color:#0f172a;margin-bottom:6px; }
    .empty-state p  { font-size:13px;color:#64748b;margin-bottom:20px; }
    .empty-state a  {
        display:inline-flex;align-items:center;gap:6px;
        background:var(--dark);color:#fff;
        padding:10px 20px;border-radius:10px;
        font-size:12px;font-weight:700;text-decoration:none;transition:.15s;
    }
    .empty-state a:hover { background:#1e3a5f; }

    /* ── YEAR SEPARATOR ── */
    .year-sep {
        display:flex;align-items:center;gap:10px;
        margin-bottom:16px;margin-top:8px;
        font-size:11px;font-weight:700;color:#94a3b8;
        text-transform:uppercase;letter-spacing:.8px;
    }
    .year-sep::after { content:"";flex:1;height:1px;background:#e8edf5; }

    /* ── RESPONSIVE ── */
    @media (max-width:640px) {
        .hc-layout  { grid-template-columns:1fr; }
        .doc-badges { flex-direction:row;flex-wrap:wrap; }
        .stats-float{ grid-template-columns:1fr; }
        .tl-wrapper { padding-left:24px; }
        .hc::before { left:-17px; }
    }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- ══ HERO ══ --}}
    <div class="hero">
        <div class="hero-deco1"></div>
        <div class="hero-deco2"></div>
        <div class="hero-content">
            <h1 class="hero-title">Historique médical</h1>
            <p class="hero-sub">Retrouvez toutes vos consultations passées et vos documents médicaux.</p>
            <div class="search-hero">
                <svg width="15" height="15" fill="none" stroke="rgba(255,255,255,.5)" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput"
                       placeholder="Rechercher un médecin, une date, un motif...">
            </div>
        </div>
    </div>

    {{-- ══ STATS FLOTTANTES ══ --}}
    @php
        $total    = $completedRendezVous->count();
        $annules  = $completedRendezVous->where('statut', 'annule')->count();
        $termines = $completedRendezVous->where('statut', 'termine')->count();
        $medecins = $completedRendezVous->pluck('medecin_id')->unique()->count();
    @endphp
    <div class="stats-float">
        <div class="sf">
            <div class="sf-icon" style="background:#eff6ff">
                <svg width="16" height="16" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="sf-label">Consultations</div>
            <div class="sf-val">{{ $total }}</div>
        </div>
        <div class="sf">
            <div class="sf-icon" style="background:#f0fdf4">
                <svg width="16" height="16" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="sf-label">Terminées</div>
            <div class="sf-val">{{ $termines }}</div>
        </div>
        <div class="sf">
            <div class="sf-icon" style="background:#fff7ed">
                <svg width="16" height="16" fill="none" stroke="#c2410c" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="sf-label">Médecins vus</div>
            <div class="sf-val">{{ $medecins }}</div>
        </div>
    </div>

    {{-- ══ FILTERS ══ --}}
    <div class="filter-row">
        <button class="filter-chip active" onclick="filterCards('tous', this)">Tous</button>
        <button class="filter-chip" onclick="filterCards('termine', this)">Terminés</button>
        <button class="filter-chip" onclick="filterCards('annule', this)">Annulés</button>
    </div>

    {{-- ══ TIMELINE ══ --}}
    @if($completedRendezVous->count())

    @php
        $grouped = $completedRendezVous->sortByDesc('date_heure')->groupBy(fn($r) => $r->date_heure->year);
    @endphp

    <div class="tl-wrapper" id="timeline">

        @foreach($grouped as $year => $rdvs)

        <div class="year-sep" data-year="{{ $year }}">{{ $year }}</div>

        @foreach($rdvs as $rdv)
        @php
            $isDone = $rdv->statut === 'termine';
            $isAnn  = $rdv->statut === 'annule';
        @endphp

        <div class="hc" data-statut="{{ $rdv->statut }}"
             data-search="{{ strtolower($rdv->medecin->user->name . ' ' . ($rdv->motif ?? '') . ' ' . $rdv->date_heure->format('d/m/Y')) }}">

            <div class="hc-layout">
                <div>
                    {{-- Date --}}
                    <div class="hc-date">
                        {{ $rdv->date_heure->translatedFormat('l d F Y') }}
                        &nbsp;·&nbsp; {{ $rdv->date_heure->format('H:i') }}
                    </div>

                    {{-- Médecin --}}
                    <div class="hc-doc">Dr. {{ $rdv->medecin->user->name }}</div>

                    {{-- Hôpital --}}
                    @if($rdv->medecin->hopital)
                    <div class="hc-hosp">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $rdv->medecin->hopital->nom }}
                    </div>
                    @endif

                    {{-- Statut --}}
                    @if($isDone)
                    <span class="hc-status s-done">
                        <span style="width:5px;height:5px;border-radius:50%;background:currentColor"></span>
                        Consultation terminée
                    </span>
                    @elseif($isAnn)
                    <span class="hc-status s-ann">
                        <span style="width:5px;height:5px;border-radius:50%;background:currentColor"></span>
                        Annulé
                    </span>
                    @endif

                    {{-- Motif --}}
                    <div class="hc-motif">
                        <strong>Motif :</strong>
                        {{ $rdv->motif ?? 'Consultation de routine. Aucun problème particulier signalé.' }}
                    </div>

                    {{-- Spécialité --}}
                    @if($rdv->medecin->specialite)
                    <div style="margin-top:8px;font-size:11px;color:#64748b;display:flex;align-items:center;gap:5px">
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ $rdv->medecin->specialite }}
                    </div>
                    @endif
                </div>

                {{-- DOC BADGES --}}
                <div class="doc-badges">
                    <a href="#" class="doc-badge">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Compte-rendu
                    </a>
                    <a href="#" class="doc-badge">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        Ordonnance
                    </a>
                    @if(!$isAnn)
                    <a href="{{ route('hopitaux.show', $rdv->medecin->hopital_id) }}" class="doc-badge">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reprendre RDV
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @endforeach
        @endforeach

        {{-- Empty filtered --}}
        <div id="emptyFilter" style="display:none" class="empty-state">
            <div class="empty-icon">
                <svg width="26" height="26" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <h3>Aucun résultat</h3>
            <p>Essayez avec d'autres termes ou changez de filtre.</p>
        </div>

    </div>

    @else

    {{-- EMPTY STATE --}}
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="26" height="26" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3>Dossier vierge</h3>
        <p>Vous n'avez pas encore d'historique de consultations sur la plateforme.</p>
        <a href="{{ route('hopitaux.index') }}">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Planifier une consultation
        </a>
    </div>

    @endif

</div>

@push('scripts')
<script>
/* ── FILTRE PAR STATUT ── */
function filterCards(filter, btn) {
    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    applyFilters();
}

/* ── RECHERCHE LIVE ── */
document.getElementById('searchInput').addEventListener('input', applyFilters);

function applyFilters() {
    const search = document.getElementById('searchInput').value.toLowerCase().trim();
    const active = document.querySelector('.filter-chip.active')?.textContent.trim().toLowerCase();

    const filterMap = { 'tous': null, 'terminés': 'termine', 'annulés': 'annule' };
    const statut    = filterMap[active] ?? null;

    let visibleCount = 0;

    document.querySelectorAll('.hc').forEach(card => {
        const cardStatut = card.dataset.statut;
        const cardSearch = card.dataset.search;

        const matchStatut = !statut || cardStatut === statut;
        const matchSearch = !search || cardSearch.includes(search);

        const show = matchStatut && matchSearch;
        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });

    /* Séparateurs d'année : cacher si aucune carte visible sous eux */
    document.querySelectorAll('.year-sep').forEach(sep => {
        let next = sep.nextElementSibling;
        let hasVisible = false;
        while (next && !next.classList.contains('year-sep')) {
            if (next.classList.contains('hc') && next.style.display !== 'none') {
                hasVisible = true; break;
            }
            next = next.nextElementSibling;
        }
        sep.style.display = hasVisible ? '' : 'none';
    });

    /* Empty state */
    document.getElementById('emptyFilter').style.display = visibleCount === 0 ? '' : 'none';
}
</script>
@endpush

@endsection