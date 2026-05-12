@extends('layouts.dokita')

@section('title', 'Tableau de bord — Dokita')

@push('head')
<style>
    :root { --radius-xl: 20px; --radius-lg: 14px; }

    @keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse   { 0%,100% { opacity: 1; } 50% { opacity: .3; } }
    .animate-up { animation: slideUp .45s ease-out; }

    /* ── HERO ── */
    .hero {
        background: #0c2340;
        border-radius: var(--radius-xl);
        padding: 38px 32px 82px;
        position: relative; overflow: hidden;
        margin-bottom: 0;
    }
    .hero-deco1 { position:absolute; top:-60px; right:-60px; width:260px; height:260px; border-radius:50%; background:rgba(37,99,235,.18); }
    .hero-deco2 { position:absolute; bottom:-80px; right:60px; width:180px; height:180px; border-radius:50%; background:rgba(37,99,235,.10); }
    .hero-deco3 { position:absolute; top:20px; right:200px; width:80px; height:80px; border-radius:50%; background:rgba(255,255,255,.03); }
    .hero-content { position:relative; z-index:2; max-width:540px; }

    .hero-tag {
        display:inline-flex; align-items:center; gap:6px;
        background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12);
        padding:4px 12px; border-radius:20px;
        font-size:11px; font-weight:600; color:#93c5fd; margin-bottom:16px;
    }
    .hero-dot { width:6px; height:6px; border-radius:50%; background:#22d3ee; animation:pulse 2s infinite; }
    .hero-title { font-size:26px; font-weight:800; color:#fff; line-height:1.3; margin-bottom:10px; }
    .hero-title span { color:#93c5fd; }
    .hero-sub { font-size:13px; color:rgba(255,255,255,.5); line-height:1.7; margin-bottom:22px; }
    .hero-actions { display:flex; gap:10px; flex-wrap:wrap; }

    .btn-hero-w {
        display:inline-flex; align-items:center; gap:7px;
        background:#fff; color:#0c2340; padding:10px 18px;
        border-radius:10px; font-size:12px; font-weight:700;
        text-decoration:none; border:none; cursor:pointer; transition:.15s;
    }
    .btn-hero-w:hover { background:#eff6ff; color:#0c2340; }
    .btn-hero-r {
        display:inline-flex; align-items:center; gap:7px;
        background:#dc2626; color:#fff; padding:10px 18px;
        border-radius:10px; font-size:12px; font-weight:700;
        text-decoration:none; border:none; cursor:pointer; transition:.15s;
    }
    .btn-hero-r:hover { background:#b91c1c; color:#fff; }

    /* ── STATS FLOTTANTES ── */
    .stats-float {
        display:grid; grid-template-columns:repeat(4, minmax(0,1fr));
        gap:12px; margin-top:-44px; position:relative; z-index:10;
        padding:0 2px; margin-bottom:24px;
    }
    .sf {
        background:#fff; border:1px solid #e2e8f0;
        border-radius:var(--radius-lg); padding:16px 18px; transition:.2s;
    }
    .sf:hover { transform:translateY(-3px); border-color:#bfdbfe; box-shadow:0 8px 24px rgba(37,99,235,.07); }
    .sf-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; margin-bottom:10px; }
    .sf-label { font-size:10px; color:#94a3b8; letter-spacing:.4px; font-weight:600; text-transform:uppercase; }
    .sf-val { font-size:22px; font-weight:800; color:#0f172a; margin-top:3px; line-height:1; }
    .sf-val small { font-size:13px; font-weight:500; color:#94a3b8; }
    .sf-pill { display:inline-flex; align-items:center; gap:3px; font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; margin-top:7px; }
    .p-green  { background:#f0fdf4; color:#166534; }
    .p-blue   { background:#eff6ff; color:#1e40af; }
    .p-slate  { background:#f8fafc; color:#94a3b8; }
    .p-amber  { background:#fff7ed; color:#9a3412; }

    /* ── MAIN GRID ── */
    .main-grid { display:grid; grid-template-columns:minmax(0,1.65fr) minmax(0,1fr); gap:16px; }

    /* ── SECTION TITLE ── */
    .sec-title {
        display:flex; align-items:center; gap:8px;
        font-size:11px; font-weight:700; color:#94a3b8;
        text-transform:uppercase; letter-spacing:.7px; margin-bottom:10px;
    }
    .sec-dot { width:6px; height:6px; border-radius:50%; background:#2563eb; flex-shrink:0; }

    /* ── TIMELINE CARD ── */
    .tl-card { background:#fff; border-radius:var(--radius-xl); border:1px solid #e8edf5; overflow:hidden; }
    .tl-hd {
        padding:14px 20px; border-bottom:1px solid #f1f5f9;
        display:flex; align-items:center; justify-content:space-between;
    }
    .tl-hd h3 { font-size:14px; font-weight:700; color:#0f172a; margin:0; }
    .tl-link { font-size:12px; color:#1d4ed8; font-weight:600; text-decoration:none; }
    .tl-link:hover { text-decoration:underline; }

    .countdown {
        display:flex; align-items:center; gap:8px;
        background:#eff6ff; border-radius:9px;
        padding:9px 16px; margin:12px 20px;
        font-size:12px; color:#1e40af; font-weight:600;
    }

    .tl-body { padding:20px; position:relative; }
    .tl-line {
        position:absolute; left:32px; top:28px; bottom:28px;
        width:2px; background:#f1f5f9; border-radius:2px;
    }
    .tl-item { display:flex; align-items:flex-start; gap:12px; padding-bottom:18px; position:relative; z-index:2; }
    .tl-item:last-child { padding-bottom:0; }
    .tl-dot-w { width:26px; display:flex; justify-content:center; flex-shrink:0; padding-top:4px; }
    .tl-dot {
        width:12px; height:12px; border-radius:50%;
        background:#fff; border:2.5px solid #2563eb; flex-shrink:0;
    }
    .tl-dot.active { background:#2563eb; }
    .tl-content {
        flex:1; background:#f8fafc; border-radius:12px;
        padding:13px 15px; transition:.15s; cursor:pointer;
        border:1px solid transparent;
    }
    .tl-content:hover { background:#fff; border-color:#e2e8f0; box-shadow:0 4px 12px rgba(0,0,0,.03); }
    .tl-date  { font-size:10px; font-weight:700; color:#2563eb; text-transform:uppercase; letter-spacing:.4px; margin-bottom:3px; }
    .tl-doc   { font-size:13px; font-weight:700; color:#0f172a; }
    .tl-motif { font-size:11px; color:#64748b; margin-top:2px; }
    .tl-time  {
        background:#0c2340; color:#fff; padding:7px 12px;
        border-radius:9px; font-size:14px; font-weight:800;
        flex-shrink:0; align-self:center;
        font-variant-numeric:tabular-nums;
    }
    .tl-badge { font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; flex-shrink:0; align-self:center; }
    .b-conf { background:#f0fdf4; color:#166534; }
    .b-att  { background:#eff6ff; color:#1e40af; }
    .tl-empty { padding:40px 20px; text-align:center; }
    .tl-empty p { font-size:13px; color:#94a3b8; }
    .tl-empty a { font-size:13px; font-weight:700; color:#1d4ed8; text-decoration:none; display:inline-block; margin-top:6px; }

    /* ── SIDEBAR ── */
    .side-col { display:flex; flex-direction:column; gap:14px; }

    /* ── ASSISTANT ── */
    .assist {
        background:#0c2340; border-radius:var(--radius-lg);
        padding:20px; position:relative; overflow:hidden;
    }
    .assist::before {
        content:""; position:absolute; top:-30px; right:-30px;
        width:120px; height:120px; border-radius:50%;
        background:rgba(37,99,235,.2);
    }
    .assist-badge {
        display:inline-flex; align-items:center; gap:6px;
        background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.1);
        padding:3px 10px; border-radius:20px;
        font-size:10px; font-weight:700; color:#93c5fd;
        margin-bottom:12px; position:relative; z-index:2;
    }
    .assist-live { width:5px; height:5px; border-radius:50%; background:#22d3ee; animation:pulse 2s infinite; }
    .assist h4 { font-size:14px; font-weight:700; color:#fff; margin-bottom:6px; position:relative; z-index:2; }
    .assist p  { font-size:12px; color:rgba(255,255,255,.5); line-height:1.7; position:relative; z-index:2; }
    .assist-footer {
        margin-top:14px; padding-top:12px;
        border-top:1px solid rgba(255,255,255,.08);
        display:flex; justify-content:space-between; align-items:center;
        position:relative; z-index:2;
    }
    .assist-src  { font-size:10px; color:rgba(255,255,255,.25); letter-spacing:.5px; }
    .assist-lien { font-size:11px; color:#93c5fd; font-weight:600; text-decoration:none; }
    .assist-lien:hover { color:#fff; }

    /* ── VIGILANCE ── */
    .vig-card { background:#fff; border-radius:var(--radius-lg); border:1px solid #e8edf5; overflow:hidden; }
    .vig-hd {
        padding:12px 16px; border-bottom:1px solid #f1f5f9;
        display:flex; align-items:center; gap:7px;
    }
    .vig-hd span { font-size:13px; font-weight:700; color:#0f172a; }
    .vig-pulse { width:7px; height:7px; border-radius:50%; background:#dc2626; animation:pulse 2s infinite; flex-shrink:0; }
    .vig-body  { padding:12px 16px; display:flex; flex-direction:column; gap:8px; }
    .vig-tag {
        display:flex; align-items:center; gap:10px;
        background:#fef2f2; border:1px solid #fecaca;
        border-radius:10px; padding:10px 13px;
    }
    .vig-tag-name { font-size:12px; font-weight:700; color:#991b1b; }
    .vig-tag-type { font-size:10px; color:#ef4444; margin-top:1px; }
    .vig-empty    { padding:14px 16px; font-size:13px; color:#94a3b8; }

    /* ── CTA ── */
    .cta-box { background:#0c2340; border-radius:var(--radius-lg); padding:20px; }
    .cta-box h4 { font-size:14px; font-weight:700; color:#fff; margin-bottom:6px; }
    .cta-box p  { font-size:12px; color:rgba(255,255,255,.4); line-height:1.7; margin-bottom:14px; }
    .btn-w {
        display:block; width:100%; padding:11px;
        background:#fff; color:#0c2340; border-radius:9px;
        font-size:13px; font-weight:700; text-align:center;
        text-decoration:none; border:none; cursor:pointer; transition:.15s;
    }
    .btn-w:hover { background:#eff6ff; }
    .cta-link2 {
        display:block; text-align:center; font-size:11px;
        font-weight:600; color:rgba(255,255,255,.3);
        margin-top:9px; text-decoration:none;
    }
    .cta-link2:hover { color:rgba(255,255,255,.65); }

    /* ── RESPONSIVE ── */
    @media (max-width: 1100px) {
        .main-grid    { grid-template-columns: 1fr; }
        .stats-float  { grid-template-columns: repeat(2,1fr); margin-top:16px; }
        .hero         { padding-bottom:40px; }
    }
    @media (max-width: 640px) {
        .stats-float  { grid-template-columns: repeat(2,1fr); }
        .hero-title   { font-size:20px; }
        .hero-actions .btn-hero-w span { display:none; }
    }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- ══ HERO ══ --}}
    <div class="hero">
        <div class="hero-deco1"></div>
        <div class="hero-deco2"></div>
        <div class="hero-deco3"></div>
        <div class="hero-content">
           
            <h1 class="hero-title">
                Votre santé,<br>
                <span>notre priorité absolue.</span>
            </h1>
            <p class="hero-sub">
                Bonjour {{ explode(' ', Auth::user()->name)[0] }}, ravi de vous revoir.
                @if($upcomingRendezVous->isNotEmpty())
                    Votre prochain rendez-vous est
                    <strong style="color:rgba(255,255,255,.75)">{{ $upcomingRendezVous->first()->date_heure->diffForHumans() }}</strong>
                    avec Dr. {{ $upcomingRendezVous->first()->medecin->user->name }}.
                @else
                    Vous n'avez aucun rendez-vous prévu pour le moment.
                @endif
            </p>
            <div class="hero-actions">
                <a href="{{ route('hopitaux.index') }}" class="btn-hero-w">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Prendre rendez-vous</span>
                </a>
                <a href="{{ route('urgence.create') }}" class="btn-hero-r">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    SOS Urgence
                </a>
            </div>
        </div>
    </div>

    {{-- ══ STATS FLOTTANTES ══ --}}
    <div class="stats-float">
        <div class="sf">
            <div class="sf-icon" style="background:#eff6ff">
                <svg width="16" height="16" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <div class="sf-label">Groupe sanguin</div>
            <div class="sf-val">{{ $patient->groupe_sanguin ?? '--' }}</div>
            <span class="sf-pill {{ $patient->groupe_sanguin ? 'p-green' : 'p-slate' }}">
                {{ $patient->groupe_sanguin ? '✓ Vérifié' : 'Non renseigné' }}
            </span>
        </div>
        <div class="sf">
            <div class="sf-icon" style="background:#fff7ed">
                <svg width="16" height="16" fill="none" stroke="#c2410c" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="sf-label">Tension artérielle</div>
            <div class="sf-val">{{ $patient->tension ?? '--/--' }}</div>
            <span class="sf-pill p-blue">Normal</span>
        </div>
        <div class="sf">
            <div class="sf-icon" style="background:#f0fdf4">
                <svg width="16" height="16" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div class="sf-label">Consultations</div>
            <div class="sf-val">{{ $completedCount + $confirmedCount }}</div>
            <span class="sf-pill p-slate">Au total</span>
        </div>
        <div class="sf">
            <div class="sf-icon" style="background:#fef2f2">
                <svg width="16" height="16" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                </svg>
            </div>
            <div class="sf-label">Dernier poids</div>
            <div class="sf-val">{{ $patient->poids ?? '--' }} <small>kg</small></div>
            <span class="sf-pill p-amber">À jour</span>
        </div>
    </div>

    {{-- ══ MAIN GRID ══ --}}
    <div class="main-grid">

        {{-- COLONNE GAUCHE : PARCOURS DE SOINS --}}
        <div>
            <div class="sec-title"><span class="sec-dot"></span> Parcours de soins</div>
            <div class="tl-card">
                <div class="tl-hd">
                    <h3>Mes prochains rendez-vous</h3>
                    <a href="{{ route('rdv.index') }}" class="tl-link">Voir tout →</a>
                </div>

                @if($upcomingRendezVous->isNotEmpty())
                    <div class="countdown">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Prochain RDV :&nbsp;
                        <strong>{{ $upcomingRendezVous->first()->date_heure->diffForHumans() }}</strong>
                        &nbsp;— Dr. {{ $upcomingRendezVous->first()->medecin->user->name }}
                    </div>
                @endif

                <div class="tl-body">
                    <div class="tl-line"></div>

                    @forelse($upcomingRendezVous as $loop => $rdv)
                    <div class="tl-item">
                        <div class="tl-dot-w">
                            <div class="tl-dot {{ $loop === 0 ? 'active' : '' }}"></div>
                        </div>
                        <a href="{{ route('rdv.index') }}" class="tl-content" style="text-decoration:none">
                            <div class="tl-date">
                                {{ $rdv->date_heure->translatedFormat('D d M Y') }}
                            </div>
                            <div class="tl-doc">Dr. {{ $rdv->medecin->user->name }}</div>
                            <div class="tl-motif">{{ $rdv->motif ?? 'Consultation générale' }}</div>
                        </a>
                        <div class="tl-time">{{ $rdv->date_heure->format('H:i') }}</div>
                        <span class="tl-badge {{ $rdv->statut === 'confirme' ? 'b-conf' : 'b-att' }}">
                            {{ $rdv->statut === 'confirme' ? 'Confirmé' : 'En attente' }}
                        </span>
                    </div>
                    @empty
                    <div class="tl-empty">
                        <p>Aucun rendez-vous prévu pour le moment.</p>
                        <a href="{{ route('hopitaux.index') }}">Prendre rendez-vous →</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE --}}
        <div class="side-col">
            <div class="sec-title"><span class="sec-dot"></span> Assistant &amp; vigilance</div>

            {{-- ASSISTANT IA --}}
            <div class="assist">
                <div class="assist-badge">
                    <span class="assist-live"></span> Assistant Dokita
                </div>
                <h4>Conseil préventif</h4>
                <p>
                    @if($upcomingRendezVous->isNotEmpty())
                        Votre prochain RDV est
                        {{ $upcomingRendezVous->first()->date_heure->diffForHumans() }}.
                        Pensez à noter vos symptômes avant la consultation.
                    @else
                        Pensez à planifier une consultation de routine.
                        La prévention reste le meilleur soin !
                    @endif
                </p>
                <div class="assist-footer">
                    <span class="assist-src">Source : OMS Bénin</span>
                    <a href="{{ route('hopitaux.index') }}" class="assist-lien">En savoir plus →</a>
                </div>
            </div>

            {{-- ALLERGIES ── --}}
            <div class="vig-card">
                <div class="vig-hd">
                    <span class="vig-pulse"></span>
                    <span>Allergies &amp; Vigilances</span>
                </div>
                <div class="vig-body">
                    {{--
                        Quand tu auras la table patients avec allergies :
                        @forelse($allergies as $allergie)
                            <div class="vig-tag">
                                <svg width="16" height="16" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                <div>
                                    <div class="vig-tag-name">{{ $allergie['nom'] }}</div>
                                    <div class="vig-tag-type">{{ $allergie['type'] }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="vig-empty">Aucune allergie renseignée.</div>
                        @endforelse
                    --}}

                    {{-- Valeurs statiques en attendant la table patients --}}
                    <div class="vig-tag">
                        <svg width="16" height="16" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <div>
                            <div class="vig-tag-name">Pénicilline</div>
                            <div class="vig-tag-type">Allergie médicamenteuse</div>
                        </div>
                    </div>
                    <div class="vig-tag">
                        <svg width="16" height="16" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <div>
                            <div class="vig-tag-name">Arachides</div>
                            <div class="vig-tag-type">Allergie alimentaire</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="cta-box">
                <h4>Besoin d'aide ?</h4>
                <p>Trouvez un hôpital à proximité ou contactez un médecin en urgence.</p>
                <a href="{{ route('urgence.create') }}" class="btn-w">Signaler une urgence</a>
                <a href="{{ route('hopitaux.index') }}" class="cta-link2">Trouver un hôpital →</a>
            </div>

        </div>
    </div>

</div>
@endsection