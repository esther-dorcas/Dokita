@extends('layouts.dokita')

@section('title', $hopital->nom . ' — Dokita')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
    :root { --blue:#2563eb; --dark:#0c2340; --radius-xl:20px; --radius-lg:14px; }

    @keyframes slideUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes pulse   { 0%,100%{opacity:1} 50%{opacity:.3} }
    .animate-up { animation:slideUp .45s ease-out; }

    /* ── BACK BTN ── */
    .back-btn {
        display:inline-flex;align-items:center;gap:7px;
        font-size:12px;font-weight:600;color:#64748b;
        background:#fff;border:1px solid #e2e8f0;
        padding:8px 14px;border-radius:9px;
        cursor:pointer;transition:.15s;text-decoration:none;
        margin-bottom:20px;
    }
    .back-btn:hover { color:var(--blue);border-color:#bfdbfe;background:#eff6ff; }

    /* ── FLASH ── */
    .flash-ok {
        background:#f0fdf4;border:1px solid #bbf7d0;
        border-radius:12px;padding:12px 16px;
        display:flex;align-items:center;gap:10px;
        font-size:13px;font-weight:600;color:#166534;
        margin-bottom:20px;
    }

    /* ── HERO ── */
    .hero-img {
        height:360px;border-radius:var(--radius-xl);
        overflow:hidden;position:relative;margin-bottom:24px;
    }
    .hero-img img { width:100%;height:100%;object-fit:cover;transition:transform .5s; }
    .hero-img:hover img { transform:scale(1.03); }
    .hero-overlay {
        position:absolute;inset:0;
        background:linear-gradient(to top, rgba(12,35,64,.9) 0%, rgba(12,35,64,.3) 50%, transparent 100%);
        display:flex;flex-direction:column;justify-content:flex-end;
        padding:28px 32px;
    }
    .hero-tags { display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px; }
    .hero-tag-open  { background:#22c55e;color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:.5px; }
    .hero-tag-close { background:#ef4444;color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:.5px; }
    .hero-tag-partner { background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px; }
    .hero-title { font-size:28px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:6px; }
    .hero-addr  { display:flex;align-items:center;gap:6px;font-size:13px;color:rgba(255,255,255,.65); }

    /* ── MAIN GRID ── */
    .detail-grid {
        display:grid;
        grid-template-columns:minmax(0,1fr) 340px;
        gap:20px;align-items:start;
    }
    .left-col  { display:flex;flex-direction:column;gap:16px; }
    .right-col { display:flex;flex-direction:column;gap:16px; }

    /* ── CARDS ── */
    .d-card {
        background:#fff;border:1px solid #e8edf5;
        border-radius:var(--radius-xl);padding:24px;
    }
    .d-card-title {
        font-size:16px;font-weight:800;color:#0f172a;
        margin-bottom:16px;display:flex;align-items:center;gap:8px;
    }
    .d-card-title-dot { width:6px;height:6px;border-radius:50%;background:var(--blue);flex-shrink:0; }

    /* ── SPECIALITES ── */
    .spec-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px; }
    .spec-item {
        display:flex;flex-direction:column;align-items:center;
        padding:16px 12px;background:#f8fafc;border:1px solid #f1f5f9;
        border-radius:12px;text-align:center;transition:.15s;cursor:default;
    }
    .spec-item:hover { border-color:#bfdbfe;background:#eff6ff; }
    .spec-icon {
        width:40px;height:40px;border-radius:10px;background:#fff;
        display:flex;align-items:center;justify-content:center;
        margin-bottom:8px;border:1px solid #e2e8f0;
    }
    .spec-name { font-size:12px;font-weight:700;color:#0f172a; }

    /* ── MÉDECINS ── */
    .doc-row {
        display:flex;align-items:center;justify-content:space-between;gap:12px;
        padding:14px 16px;border-radius:12px;
        border:1px solid #f1f5f9;background:#f8fafc;
        transition:.15s;
    }
    .doc-row:hover { border-color:#bfdbfe;background:#fff;box-shadow:0 4px 14px rgba(37,99,235,.06); }
    .doc-avatar {
        width:44px;height:44px;border-radius:10px;
        background:#eff6ff;color:#1d4ed8;
        font-size:13px;font-weight:800;
        display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .doc-name { font-size:13px;font-weight:700;color:#0f172a; }
    .doc-spec { font-size:11px;color:#64748b;margin-top:1px; }
    .btn-rdv-doc {
        padding:7px 14px;border-radius:9px;
        font-size:11px;font-weight:700;
        border:1px solid #e2e8f0;background:#fff;color:#0f172a;
        cursor:pointer;transition:.15s;flex-shrink:0;
    }
    .btn-rdv-doc:hover,
    .btn-rdv-doc.selected { background:var(--blue);color:#fff;border-color:var(--blue); }

    /* ── BOOKING FORM ── */
    .booking-section {
        border-top:1px solid #f1f5f9;
        margin-top:20px;padding-top:20px;
        display:none;
    }
    .booking-section.open { display:block; }
    .booking-title { font-size:14px;font-weight:700;color:#0f172a;margin-bottom:14px; }
    .date-input {
        display:flex;align-items:center;gap:10px;
        background:#f8fafc;border:1px solid #e2e8f0;
        border-radius:10px;padding:0 14px;
        max-width:220px;margin-bottom:18px;
    }
    .date-input:focus-within { border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.08); }
    .date-input input { border:none;outline:none;background:transparent;font-size:13px;font-weight:600;color:#0f172a;padding:11px 0;cursor:pointer; }

    .slots-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:18px; }
    .slot-btn {
        padding:10px 6px;border-radius:9px;
        font-size:12px;font-weight:700;text-align:center;
        border:1px solid #e2e8f0;background:#fff;color:#0f172a;
        cursor:pointer;transition:.15s;
    }
    .slot-btn:not([disabled]):hover { border-color:var(--blue);color:var(--blue);background:#eff6ff; }
    .slot-btn.picked  { background:var(--blue);color:#fff;border-color:var(--blue); }
    .slot-btn[disabled] { background:#f8fafc;color:#cbd5e1;text-decoration:line-through;cursor:not-allowed; }

    .btn-confirm {
        width:100%;padding:12px;background:var(--blue);color:#fff;
        border-radius:10px;font-size:13px;font-weight:700;
        border:none;cursor:pointer;transition:.15s;
    }
    .btn-confirm:hover:not(:disabled) { background:#1d4ed8; }
    .btn-confirm:disabled { background:#bfdbfe;cursor:not-allowed; }
    .slot-empty { grid-column:1/-1;text-align:center;padding:20px;background:#f8fafc;border-radius:10px;font-size:13px;color:#94a3b8; }

    /* ── RIGHT COL : INFO CARD ── */
    .info-card {
        background:var(--dark);border-radius:var(--radius-xl);
        padding:22px;position:relative;overflow:hidden;
    }
    .info-card::before { content:"";position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:rgba(37,99,235,.18); }
    .info-card::after  { content:"";position:absolute;bottom:-50px;left:-30px;width:120px;height:120px;border-radius:50%;background:rgba(37,99,235,.1); }
    .ic-title { font-size:15px;font-weight:800;color:#fff;margin-bottom:20px;position:relative;z-index:2; }
    .ic-row   { display:flex;align-items:flex-start;gap:12px;margin-bottom:16px;position:relative;z-index:2; }
    .ic-row:last-of-type { margin-bottom:0; }
    .ic-icon  { width:36px;height:36px;border-radius:9px;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .ic-label { font-size:10px;font-weight:700;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.6px;margin-bottom:2px; }
    .ic-val   { font-size:14px;font-weight:700;color:#fff; }
    .ic-divider { height:1px;background:rgba(255,255,255,.08);margin:18px 0;position:relative;z-index:2; }
    .btn-ic-w {
        display:block;width:100%;padding:11px;background:#fff;color:var(--dark);
        border-radius:9px;font-size:12px;font-weight:700;text-align:center;
        border:none;cursor:pointer;transition:.15s;margin-bottom:8px;
        text-decoration:none;position:relative;z-index:2;
    }
    .btn-ic-w:hover { background:#eff6ff;color:var(--blue); }
    .btn-ic-r {
        display:block;width:100%;padding:11px;background:#dc2626;color:#fff;
        border-radius:9px;font-size:12px;font-weight:700;text-align:center;
        border:none;cursor:pointer;transition:.15s;
        text-decoration:none;position:relative;z-index:2;
    }
    .btn-ic-r:hover { background:#b91c1c;color:#fff; }

    /* ── REVIEWS ── */
    .review-item { padding-bottom:14px;border-bottom:1px solid #f1f5f9;margin-bottom:14px; }
    .review-item:last-child { padding-bottom:0;border-bottom:none;margin-bottom:0; }
    .review-stars { display:flex;gap:2px;margin-bottom:6px; }
    .review-text  { font-size:12px;color:#64748b;line-height:1.7;font-style:italic;margin-bottom:5px; }
    .review-auth  { font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px; }
    .rating-badge { display:flex;align-items:center;gap:4px;background:#fff7ed;padding:4px 10px;border-radius:9px; }
    .rating-badge span { font-size:14px;font-weight:800;color:#c2410c; }

    /* ── MAP ── */
    .map-wrap { height:220px;border-radius:12px;overflow:hidden;border:1px solid #f1f5f9; }
    #hosp-map  { width:100%;height:100%; }
    .leaflet-popup-content-wrapper { border-radius:10px!important;box-shadow:0 8px 24px rgba(0,0,0,.1)!important; }
    .leaflet-popup-content { margin:12px 14px!important;font-family:inherit!important; }
    .pop-name { font-size:13px;font-weight:700;color:#0f172a; }
    .pop-addr { font-size:11px;color:#64748b;margin-top:2px; }

    /* ── RESPONSIVE ── */
    @media (max-width:1024px) {
        .detail-grid { grid-template-columns:1fr; }
    }
    @media (max-width:640px) {
        .slots-grid  { grid-template-columns:repeat(3,1fr); }
        .hero-title  { font-size:22px; }
        .hero-img    { height:260px; }
    }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- BACK --}}
    <button onclick="history.back()" class="back-btn">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Retour aux résultats
    </button>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="flash-ok">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- HERO --}}
    @php
        $photos = [
            'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=1600',
            'https://images.unsplash.com/photo-1581056771107-24ca5f033842?auto=format&fit=crop&q=80&w=1600',
            'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=1600',
            'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&q=80&w=1600',
            'https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&q=80&w=1600',
            'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&q=80&w=1600',
        ];
        $heroPhoto = $photos[$hopital->id % count($photos)];
    @endphp

    <div class="hero-img">
        <img src="{{ $heroPhoto }}" alt="{{ $hopital->nom }}" loading="eager">
        <div class="hero-overlay">
            <div class="hero-tags">
                @if(method_exists($hopital, 'isOuvert') && $hopital->isOuvert())
                    <span class="hero-tag-open">Ouvert</span>
                @else
                    <span class="hero-tag-close">Fermé</span>
                @endif
                <span class="hero-tag-partner">Partenaire agréé</span>
            </div>
            <h1 class="hero-title">{{ $hopital->nom }}</h1>
            <div class="hero-addr">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $hopital->adresse ?? 'Cotonou, Bénin' }}
            </div>
        </div>
    </div>

    {{-- DETAIL GRID --}}
    <div class="detail-grid">

        {{-- ══ LEFT ══ --}}
        <div class="left-col">

            {{-- À PROPOS --}}
            <div class="d-card">
                <div class="d-card-title">
                    <span class="d-card-title-dot"></span> À propos de l'établissement
                </div>
                <p style="font-size:13px;color:#475569;line-height:1.8">
                    {{ $hopital->description ?: 'Cet établissement propose des consultations médicales personnalisées et des créneaux rapides pour vos besoins de santé. Notre équipe de médecins dévoués assure une prise en charge complète et humaine, avec les meilleures technologies disponibles au Bénin.' }}
                </p>
            </div>

            {{-- SPÉCIALITÉS --}}
            @if($hopital->specialites->count())
            <div class="d-card">
                <div class="d-card-title">
                    <span class="d-card-title-dot"></span> Spécialités &amp; Services
                </div>
                <div class="spec-grid">
                    @foreach($hopital->specialites as $spec)
                    <div class="spec-item">
                        <div class="spec-icon">
                            <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                            </svg>
                        </div>
                        <span class="spec-name">{{ $spec->nom_specialite }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- MÉDECINS + BOOKING --}}
            <div class="d-card">
                <div class="d-card-title">
                    <span class="d-card-title-dot"></span> Médecins disponibles
                </div>

                <div style="display:flex;flex-direction:column;gap:8px">
                    @forelse($hopital->medecins as $doc)
                    <div class="doc-row" id="doc-{{ $doc->id }}">
                        <div style="display:flex;align-items:center;gap:12px;flex:1">
                            <div class="doc-avatar">
                                {{ strtoupper(substr($doc->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="doc-name">Dr. {{ $doc->user->name }}</div>
                                <div class="doc-spec">{{ $doc->specialite ?? 'Médecin généraliste' }}</div>
                            </div>
                        </div>
                        <button class="btn-rdv-doc {{ isset($medecin) && $medecin->id === $doc->id ? 'selected' : '' }}"
                                onclick="selectDoctor({{ $doc->id }}, '{{ addslashes($doc->user->name) }}')">
                            {{ isset($medecin) && $medecin->id === $doc->id ? '✓ Sélectionné' : 'Prendre RDV' }}
                        </button>
                    </div>
                    @empty
                    <div style="text-align:center;padding:24px;background:#f8fafc;border-radius:10px;font-size:13px;color:#94a3b8">
                        Aucun médecin disponible pour le moment.
                    </div>
                    @endforelse
                </div>

                {{-- BOOKING FORM --}}
                <div class="booking-section {{ isset($medecin) ? 'open' : '' }}" id="booking-form-section">
                    <div class="booking-title" id="booking-doctor-label">
                        Réserver avec Dr. {{ $medecin->user->name ?? '—' }}
                    </div>

                    {{-- DATE PICKER --}}
                    <form method="GET" action="{{ route('hopitaux.show', $hopital->id) }}" id="date-form">
                        <input type="hidden" name="medecin_id" id="hidden-medecin-id"
                               value="{{ $medecin->id ?? '' }}">
                        <div class="date-input" style="margin-bottom:16px">
                            <svg width="14" height="14" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8"  y1="2" x2="8"  y2="6"/>
                                <line x1="3"  y1="10" x2="21" y2="10"/>
                            </svg>
                            <input type="date" name="date" value="{{ $date }}"
                                   min="{{ date('Y-m-d') }}"
                                   onchange="this.form.submit()">
                        </div>
                    </form>

                    {{-- CRÉNEAUX --}}
                    <div class="slots-grid">
                        @forelse($creneaux as $slot)
                            <button type="button"
                                    class="slot-btn {{ !$slot['libre'] ? '' : '' }}"
                                    data-heure="{{ $slot['heure'] }}"
                                    {{ !$slot['libre'] ? 'disabled' : '' }}>
                                {{ $slot['heure'] }}
                            </button>
                        @empty
                            <div class="slot-empty">
                                Aucun créneau disponible ce jour. Choisissez une autre date.
                            </div>
                        @endforelse
                    </div>

                    {{-- CONFIRM --}}
                    <form method="POST" action="{{ route('rdv.store') }}" id="confirm-form">
                        @csrf
                        <input type="hidden" name="medecin_id" id="confirm-medecin-id"
                               value="{{ $medecin->id ?? '' }}">
                        <input type="hidden" name="date"  value="{{ $date }}">
                        <input type="hidden" name="heure" id="confirm-heure" value="">
                        <input type="hidden" name="motif" value="Consultation médicale">
                        <button type="submit" class="btn-confirm" id="confirm-btn" disabled>
                            Confirmer le rendez-vous
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ══ RIGHT ══ --}}
        <div class="right-col">

            {{-- INFO CARD --}}
            <div class="info-card">
                <div class="ic-title">Informations utiles</div>

                <div class="ic-row">
                    <div class="ic-icon">
                        <svg width="16" height="16" fill="none" stroke="rgba(255,255,255,.6)" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.81 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ic-label">Téléphone</div>
                        <div class="ic-val">{{ $hopital->telephone ?? '+229 21 00 00 00' }}</div>
                    </div>
                </div>

                <div class="ic-row">
                    <div class="ic-icon">
                        <svg width="16" height="16" fill="none" stroke="rgba(255,255,255,.6)" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ic-label">Horaires</div>
                        <div class="ic-val">{{ $hopital->horaires ?? '08h – 18h' }}</div>
                    </div>
                </div>

                <div class="ic-row">
                    <div class="ic-icon">
                        <svg width="16" height="16" fill="none" stroke="rgba(255,255,255,.6)" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ic-label">Consultation</div>
                        <div class="ic-val">
                            À partir de
                            {{ number_format(method_exists($hopital,'tarifMin') ? ($hopital->tarifMin() ?: 10000) : 10000, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                </div>

                <div class="ic-divider"></div>

                <button class="btn-ic-w"
                        onclick="document.getElementById('booking-form-section').classList.add('open');document.getElementById('booking-form-section').scrollIntoView({behavior:'smooth'})">
                    Prendre rendez-vous
                </button>
                <a href="{{ route('urgence.create') }}" class="btn-ic-r">
                    Déclarer une urgence
                </a>
            </div>

            {{-- AVIS --}}
            <div class="d-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                    <div class="d-card-title" style="margin-bottom:0">
                        <span class="d-card-title-dot"></span> Avis patients
                    </div>
                    <div class="rating-badge">
                        <span>4.8</span>
                        <svg width="13" height="13" fill="#f59e0b" viewBox="0 0 24 24">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                </div>

                @foreach([
                    'Très bon accueil, prise en charge rapide. Je recommande vivement !',
                    'Médecins compétents et personnel très attentionné. Merci.',
                ] as $review)
                <div class="review-item">
                    <div class="review-stars">
                        @for($i=0;$i<5;$i++)
                        <svg width="12" height="12" fill="#f59e0b" viewBox="0 0 24 24">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="review-text">"{{ $review }}"</p>
                    <div class="review-auth">— Patient vérifié</div>
                </div>
                @endforeach
            </div>

            {{-- CARTE --}}
            @if($hopital->latitude && $hopital->longitude)
            <div class="d-card">
                <div class="d-card-title">
                    <span class="d-card-title-dot"></span> Localisation
                </div>
                <div class="map-wrap">
                    <div id="hosp-map"></div>
                </div>
                <a href="https://www.google.com/maps?q={{ $hopital->latitude }},{{ $hopital->longitude }}"
                   target="_blank"
                   style="display:flex;align-items:center;justify-content:center;gap:6px;
                          margin-top:10px;font-size:12px;font-weight:600;color:var(--blue);
                          text-decoration:none">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Ouvrir dans Google Maps
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/* ── CARTE LEAFLET ── */
@if($hopital->latitude && $hopital->longitude)
document.addEventListener('DOMContentLoaded', function () {

    const map = L.map('hosp-map', { zoomControl: true })
        .setView([{{ $hopital->latitude }}, {{ $hopital->longitude }}], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors', maxZoom: 18
    }).addTo(map);

    const hospIcon = L.divIcon({
        html: `<div style="
            width:36px;height:36px;border-radius:50%;
            background:#0c2340;border:3px solid #fff;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 4px 12px rgba(0,0,0,.25);font-size:16px
        ">🏥</div>`,
        iconSize: [36,36], iconAnchor: [18,36], className: ''
    });

    L.marker([{{ $hopital->latitude }}, {{ $hopital->longitude }}], { icon: hospIcon })
        .addTo(map)
        .bindPopup(`<div class="pop-name">{{ addslashes($hopital->nom) }}</div>
                    <div class="pop-addr">{{ addslashes($hopital->adresse ?? 'Cotonou, Bénin') }}</div>`)
        .openPopup();

    /* Marqueur position utilisateur */
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const userIcon = L.divIcon({
                html: `<div style="
                    width:14px;height:14px;border-radius:50%;
                    background:#2563eb;border:3px solid #fff;
                    box-shadow:0 0 0 5px rgba(37,99,235,.25)
                "></div>`,
                iconSize: [14,14], iconAnchor: [7,7], className: ''
            });
            L.marker([pos.coords.latitude, pos.coords.longitude], { icon: userIcon })
                .addTo(map)
                .bindPopup('<div class="pop-name">📍 Votre position</div>');
        }, () => {});
    }

    setTimeout(() => map.invalidateSize(), 200);
});
@endif

/* ── SÉLECTION MÉDECIN ── */
let currentDocId = @json($medecin?->id ?? null);

function selectDoctor(id, name) {
    /* Reset tous les boutons */
    document.querySelectorAll('.btn-rdv-doc').forEach(b => {
        b.classList.remove('selected');
        b.textContent = 'Prendre RDV';
    });

    /* Activer le bouton sélectionné */
    const row = document.getElementById('doc-' + id);
    if (row) {
        const btn = row.querySelector('.btn-rdv-doc');
        btn.classList.add('selected');
        btn.textContent = '✓ Sélectionné';
    }

    /* Mettre à jour les inputs */
    document.getElementById('hidden-medecin-id').value  = id;
    document.getElementById('confirm-medecin-id').value = id;
    document.getElementById('booking-doctor-label').textContent = 'Réserver avec Dr. ' + name;

    /* Ouvrir la section */
    document.getElementById('booking-form-section').classList.add('open');

    /* Recharger la page avec le medecin_id pour charger les créneaux */
    const url = new URL(window.location.href);
    url.searchParams.set('medecin_id', id);
    if (!url.searchParams.get('date')) {
        url.searchParams.set('date', new Date().toISOString().slice(0, 10));
    }
    window.location.href = url.toString();
}

/* ── SÉLECTION CRÉNEAU ── */
const slots      = document.querySelectorAll('.slot-btn:not([disabled])');
const confirmHeure = document.getElementById('confirm-heure');
const confirmBtn   = document.getElementById('confirm-btn');

slots.forEach(btn => {
    btn.addEventListener('click', () => {
        slots.forEach(s => s.classList.remove('picked'));
        btn.classList.add('picked');
        confirmHeure.value  = btn.dataset.heure;
        confirmBtn.disabled = false;
    });
});

/* ── SCROLL AUTO VERS LE BOOKING SI MEDECIN DÉJÀ SÉLECTIONNÉ ── */
@if(isset($medecin))
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.getElementById('booking-form-section')
            ?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }, 400);
});
@endif
</script>
@endpush