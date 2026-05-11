@extends('layouts.dokita')

@section('title', 'Trouver un hôpital — Dokita')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; --radius-lg: 14px; }

    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse   { 0%,100%{opacity:1} 50%{opacity:.35} }
    .animate-up { animation: slideUp .4s ease-out; }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 12px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-header h1 { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; }
    .page-header p  { font-size: 13px; color: #64748b; margin-top: 3px; }

    .btn-locate {
        display: inline-flex; align-items: center; gap: 7px;
        background: #fff; border: 1px solid #e2e8f0;
        padding: 9px 16px; border-radius: 10px;
        font-size: 12px; font-weight: 700; color: #0f172a;
        cursor: pointer; transition: .15s; flex-shrink: 0;
    }
    .btn-locate:hover { border-color: #bfdbfe; background: #eff6ff; color: var(--blue); }
    .btn-locate svg   { color: var(--blue); }
    .locate-dot { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; animation: pulse 2s infinite; }

    /* ── SEARCH + FILTERS ── */
    .search-bar {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: var(--radius-lg); padding: 0 16px;
        display: flex; align-items: center; gap: 10px;
        transition: .15s; flex: 1;
    }
    .search-bar:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
    .search-bar input {
        border: none; outline: none; background: transparent;
        font-size: 13px; color: #0f172a; padding: 12px 0;
        width: 100%; font-weight: 500;
    }
    .search-bar input::placeholder { color: #94a3b8; }

    .filter-row {
        display: flex; align-items: center; gap: 8px;
        flex-wrap: wrap; margin-top: 12px; margin-bottom: 24px;
    }
    .filter-chip {
        padding: 7px 16px; border-radius: 20px;
        font-size: 12px; font-weight: 700; border: 1px solid #e2e8f0;
        background: #fff; color: #64748b;
        text-decoration: none; transition: .15s; cursor: pointer;
        white-space: nowrap;
    }
    .filter-chip:hover  { border-color: #bfdbfe; color: var(--blue); }
    .filter-chip.active { background: var(--blue); color: #fff; border-color: var(--blue); }

    .search-form-row { display: flex; gap: 10px; align-items: center; }

    /* ── STATS ROW ── */
    .hop-stats {
        display: grid; grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 12px; margin-bottom: 24px;
    }
    .hs {
        background: #fff; border: 1px solid #e8edf5;
        border-radius: var(--radius-lg); padding: 14px 16px;
        display: flex; align-items: center; gap: 12px;
    }
    .hs-icon {
        width: 38px; height: 38px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .hs-label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
    .hs-val   { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1; margin-top: 2px; }

    /* ── HOSPITAL GRID ── */
    .hop-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px; margin-bottom: 32px;
    }
    .hop-card {
        background: #fff; border-radius: var(--radius-xl);
        border: 1px solid #e8edf5; overflow: hidden;
        display: flex; flex-direction: column;
        transition: .25s; text-decoration: none;
    }
    .hop-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 10px 32px rgba(37,99,235,.09);
        transform: translateY(-3px);
    }
    .hop-img {
        height: 160px; overflow: hidden; position: relative; flex-shrink: 0;
    }
    .hop-img img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s;
    }
    .hop-card:hover .hop-img img { transform: scale(1.05); }
    .hop-rating {
        position: absolute; top: 10px; right: 10px;
        background: rgba(255,255,255,.95);
        padding: 4px 9px; border-radius: 9px;
        font-size: 11px; font-weight: 800; color: #0f172a;
        display: flex; align-items: center; gap: 4px;
    }
    .hop-rating svg { color: #f59e0b; }
    .hop-open {
        position: absolute; top: 10px; left: 10px;
        background: #f0fdf4; color: #16a34a;
        padding: 3px 8px; border-radius: 8px;
        font-size: 10px; font-weight: 700;
    }

    .hop-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .hop-name {
        font-size: 14px; font-weight: 800; color: #0f172a;
        margin-bottom: 5px; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .hop-addr {
        display: flex; align-items: center; gap: 5px;
        font-size: 11px; color: #64748b; margin-bottom: 10px;
    }
    .hop-addr svg { flex-shrink: 0; }
    .hop-specs { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 14px; }
    .spec-tag {
        font-size: 10px; font-weight: 700; padding: 3px 9px;
        border-radius: 20px; background: #eff6ff; color: #1e40af;
        text-transform: uppercase; letter-spacing: .4px;
    }
    .hop-footer {
        margin-top: auto; padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
    }
    .hop-reviews { font-size: 11px; color: #94a3b8; }
    .hop-reviews strong { color: var(--blue); font-weight: 800; }
    .hop-arrow {
        width: 34px; height: 34px; border-radius: 9px;
        background: #eff6ff; color: var(--blue);
        display: flex; align-items: center; justify-content: center;
        transition: .15s;
    }
    .hop-card:hover .hop-arrow { background: var(--blue); color: #fff; }

    /* ── EMPTY STATE ── */
    .empty-hop {
        text-align: center; padding: 60px 20px;
        background: #fff; border-radius: var(--radius-xl);
        border: 1.5px dashed #e2e8f0; margin-bottom: 32px;
    }
    .empty-icon {
        width: 60px; height: 60px; background: #eff6ff;
        border-radius: 14px; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 16px;
    }
    .empty-hop h3 { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
    .empty-hop p  { font-size: 13px; color: #64748b; }

    /* ── MAP SECTION ── */
    .map-section {
        background: var(--dark); border-radius: var(--radius-xl);
        overflow: hidden; display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1.4fr);
    }
    .map-info {
        padding: 32px 28px; display: flex;
        flex-direction: column; justify-content: center;
        position: relative; overflow: hidden;
    }
    .map-info::before {
        content: ""; position: absolute; top: -40px; left: -40px;
        width: 180px; height: 180px; border-radius: 50%;
        background: rgba(37,99,235,.15);
    }
    .map-info::after {
        content: ""; position: absolute; bottom: -60px; right: -20px;
        width: 140px; height: 140px; border-radius: 50%;
        background: rgba(37,99,235,.08);
    }
    .map-tag {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
        padding: 4px 12px; border-radius: 20px;
        font-size: 10px; font-weight: 700; color: #93c5fd;
        margin-bottom: 16px; width: fit-content; position: relative; z-index: 2;
    }
    .map-dot { width: 6px; height: 6px; border-radius: 50%; background: #22d3ee; animation: pulse 2s infinite; }
    .map-info h2 {
        font-size: 22px; font-weight: 800; color: #fff;
        line-height: 1.3; margin-bottom: 10px;
        position: relative; z-index: 2;
    }
    .map-info h2 span { color: #93c5fd; }
    .map-info p {
        font-size: 12px; color: rgba(255,255,255,.45);
        line-height: 1.7; margin-bottom: 20px;
        position: relative; z-index: 2;
    }
    .map-stats {
        display: flex; gap: 16px; margin-bottom: 22px;
        position: relative; z-index: 2;
    }
    .ms { text-align: center; }
    .ms-val   { font-size: 18px; font-weight: 800; color: #fff; line-height: 1; }
    .ms-label { font-size: 10px; color: rgba(255,255,255,.35); margin-top: 2px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
    .ms-sep   { width: 1px; background: rgba(255,255,255,.1); }
    .btn-map {
        display: inline-flex; align-items: center; gap: 7px;
        background: #fff; color: var(--dark);
        padding: 10px 18px; border-radius: 10px;
        font-size: 12px; font-weight: 700;
        border: none; cursor: pointer; transition: .15s;
        width: fit-content; position: relative; z-index: 2;
    }
    .btn-map:hover { background: #eff6ff; }

    .map-frame {
        height: 380px; position: relative;
    }
    #leaflet-map { width: 100%; height: 100%; }

    /* Leaflet popup custom */
    .leaflet-popup-content-wrapper {
        border-radius: 12px !important; border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,.12) !important; padding: 0 !important;
    }
    .leaflet-popup-content { margin: 0 !important; }
    .pop-card { padding: 14px 16px; min-width: 200px; font-family: inherit; }
    .pop-name { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
    .pop-addr { font-size: 11px; color: #64748b; margin-bottom: 10px; }
    .pop-btn  {
        display: block; width: 100%; padding: 8px;
        background: var(--blue); color: #fff;
        border-radius: 8px; font-size: 11px; font-weight: 700;
        text-align: center; text-decoration: none; transition: .15s;
    }
    .pop-btn:hover { background: #1d4ed8; color: #fff; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .map-section { grid-template-columns: 1fr; }
        .map-frame   { height: 280px; }
        .hop-stats   { grid-template-columns: 1fr; }
        .search-form-row { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="animate-up">

    {{-- ══ PAGE HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1>Trouver un hôpital</h1>
            <p>Découvrez les établissements de santé les mieux notés près de chez vous.</p>
        </div>
        <button class="btn-locate" onclick="locateUser()" id="locateBtn">
            <span class="locate-dot" id="locateDot"></span>
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
            <span id="locateLabel">Autour de moi</span>
        </button>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="hop-stats">
        <div class="hs">
            <div class="hs-icon" style="background:#eff6ff">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <div class="hs-label">Hôpitaux</div>
                <div class="hs-val">{{ $hopitaux->count() }}</div>
            </div>
        </div>
        <div class="hs">
            <div class="hs-icon" style="background:#f0fdf4">
                <svg width="18" height="18" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="hs-label">Médecins</div>
                <div class="hs-val">{{ $hopitaux->sum(fn($h) => $h->medecins->count()) }}+</div>
            </div>
        </div>
        <div class="hs">
            <div class="hs-icon" style="background:#fff7ed">
                <svg width="18" height="18" fill="none" stroke="#c2410c" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <div class="hs-label">Spécialités</div>
                <div class="hs-val">{{ $hopitaux->sum(fn($h) => $h->specialites->count()) }}+</div>
            </div>
        </div>
    </div>

    {{-- ══ SEARCH + FILTERS ══ --}}
    <form method="GET" action="{{ route('hopitaux.index') }}">
        <div class="search-form-row">
            <div class="search-bar">
                <svg width="16" height="16" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" value="{{ $q ?? '' }}"
                       placeholder="Rechercher par nom, ville ou spécialité...">
            </div>
            <button type="submit" style="
                background:var(--blue);color:#fff;padding:11px 18px;
                border-radius:10px;font-size:12px;font-weight:700;
                border:none;cursor:pointer;transition:.15s;flex-shrink:0;
            ">Rechercher</button>
        </div>

        <div class="filter-row">
            @php $cats = ['Tous','Général','Spécialisé','Urgences 24/7','Maternité']; @endphp
            @foreach($cats as $cat)
                @php $isActive = ($cat === 'Tous' && !($specialite ?? null)) || ($specialite ?? null) === $cat; @endphp
                <a href="{{ route('hopitaux.index', $cat !== 'Tous' ? ['specialite' => $cat, 'q' => $q ?? ''] : []) }}"
                   class="filter-chip {{ $isActive ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </form>

    {{-- ══ HOSPITAL GRID ══ --}}
    @php
        $photos = [
            'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=600',
            'https://images.unsplash.com/photo-1581056771107-24ca5f033842?auto=format&fit=crop&q=80&w=600',
            'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=600',
            'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&q=80&w=600',
            'https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&q=80&w=600',
            'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&q=80&w=600',
        ];
    @endphp

    @if($hopitaux->count())
    <div class="hop-grid">
        @foreach($hopitaux as $h)
        @php
            $photo   = $photos[$h->id % count($photos)];
            $rating  = number_format(4.0 + ($h->id % 10) * 0.09, 1);
            $reviews = 40 + ($h->id * 17) % 180;
        @endphp
        <a href="{{ route('hopitaux.show', $h->id) }}" class="hop-card">
            <div class="hop-img">
                <img src="{{ $photo }}" alt="{{ $h->nom }}" loading="lazy">
                <div class="hop-rating">
                    {{ $rating }}
                    <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                </div>
                <div class="hop-open">Ouvert</div>
            </div>
            <div class="hop-body">
                <div class="hop-name" title="{{ $h->nom }}">{{ $h->nom }}</div>
                <div class="hop-addr">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $h->adresse ?? 'Cotonou, Bénin' }}
                </div>
                @if($h->specialites->count())
                <div class="hop-specs">
                    @foreach($h->specialites->take(3) as $spec)
                        <span class="spec-tag">{{ $spec->nom_specialite }}</span>
                    @endforeach
                </div>
                @endif
                <div class="hop-footer">
                    <div class="hop-reviews"><strong>{{ $reviews }}</strong> avis</div>
                    <div class="hop-arrow">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @else
    <div class="empty-hop">
        <div class="empty-icon">
            <svg width="26" height="26" fill="none" stroke="#1d4ed8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <h3>Aucun hôpital trouvé</h3>
        <p>Ajustez votre recherche ou sélectionnez une autre catégorie.</p>
    </div>
    @endif

    {{-- ══ MAP SECTION ══ --}}
    <div class="map-section">
        <div class="map-info">
            <div class="map-tag"><span class="map-dot"></span> Carte interactive</div>
            <h2>Préférez<br>la <span>vue carte</span> ?</h2>
            <p>Localisez les centres de santé ouverts autour de vous en temps réel. Notre carte regroupe tous les établissements référencés au Bénin.</p>
            <div class="map-stats">
                <div class="ms">
                    <div class="ms-val">{{ $hopitaux->count() }}</div>
                    <div class="ms-label">Établissements</div>
                </div>
                <div class="ms-sep"></div>
                <div class="ms">
                    <div class="ms-val">{{ $hopitaux->sum(fn($h) => $h->medecins->count()) }}+</div>
                    <div class="ms-label">Médecins</div>
                </div>
                <div class="ms-sep"></div>
                <div class="ms">
                    <div class="ms-val">24/7</div>
                    <div class="ms-label">Disponible</div>
                </div>
            </div>
            <button class="btn-map" onclick="scrollToMap()">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Explorer la carte
            </button>
        </div>

        <div class="map-frame">
            <div id="leaflet-map"></div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── INIT MAP ── */
    const map = L.map('leaflet-map', { zoomControl: true }).setView([6.3654, 2.4183], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    /* ── ICÔNES ── */
    const userIcon = L.divIcon({
        html: `<div style="
            width:18px;height:18px;border-radius:50%;
            background:#2563eb;border:3px solid #fff;
            box-shadow:0 0 0 5px rgba(37,99,235,.25)
        "></div>`,
        iconSize: [18, 18], iconAnchor: [9, 9], className: ''
    });

    const hospIcon = L.divIcon({
        html: `<div style="
            width:36px;height:36px;border-radius:50%;
            background:#0c2340;border:3px solid #fff;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 4px 12px rgba(0,0,0,.2);
            font-size:15px;line-height:1
        ">🏥</div>`,
        iconSize: [36, 36], iconAnchor: [18, 36], className: ''
    });

    /* ── MARQUEUR UTILISATEUR ── */
    let userMarker = null;

    function placeUserMarker(lat, lng) {
        if (userMarker) map.removeLayer(userMarker);
        userMarker = L.marker([lat, lng], { icon: userIcon })
            .addTo(map)
            .bindPopup(`<div class="pop-card">
                <div class="pop-name">📍 Votre position</div>
                <div class="pop-addr">Localisation en temps réel</div>
            </div>`)
            .openPopup();
    }

    /* ── GÉOLOCALISATION AUTO (silencieuse) ── */
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            pos => placeUserMarker(pos.coords.latitude, pos.coords.longitude),
            () => {} // silencieux si refusé
        );
    }

    /* ── BOUTON "AUTOUR DE MOI" ── */
    window.locateUser = function () {
        const btn   = document.getElementById('locateBtn');
        const label = document.getElementById('locateLabel');
        const dot   = document.getElementById('locateDot');

        if (!navigator.geolocation) {
            label.textContent = 'Non supporté';
            return;
        }

        label.textContent = 'Localisation...';
        btn.disabled = true;
        dot.style.background = '#f59e0b';

        navigator.geolocation.getCurrentPosition(
            pos => {
                const { latitude: lat, longitude: lng } = pos.coords;

                /* Centrer la carte sur l'utilisateur */
                map.flyTo([lat, lng], 14, { animate: true, duration: 1.2 });

                /* Placer / déplacer le marqueur */
                placeUserMarker(lat, lng);

                /* Scroller vers la carte */
                document.getElementById('leaflet-map')
                    .closest('.map-section')
                    .scrollIntoView({ behavior: 'smooth', block: 'start' });

                /* Restaurer le bouton */
                label.textContent = 'Position trouvée';
                dot.style.background = '#22c55e';
                btn.disabled = false;

                /* Remettre le label d'origine après 3s */
                setTimeout(() => { label.textContent = 'Autour de moi'; }, 3000);
            },
            err => {
                label.textContent = 'Accès refusé';
                dot.style.background = '#ef4444';
                btn.disabled = false;
                setTimeout(() => {
                    label.textContent = 'Autour de moi';
                    dot.style.background = '#22c55e';
                }, 3000);
            },
            { timeout: 8000, enableHighAccuracy: true }
        );
    };

    /* ── BOUTON "EXPLORER LA CARTE" ── */
    window.scrollToMap = function () {
        const mapElement = document.getElementById('leaflet-map');
        mapElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Sur ordinateur, on fait un petit effet de zoom/dézoom pour montrer que le bouton fonctionne
        if (window.innerWidth > 768) {
            map.setZoom(11, {animate: true});
            setTimeout(() => map.setZoom(12, {animate: true}), 400);
        }
    };

    /* ── MARQUEURS HÔPITAUX ── */
    @php
        $hopitauxJson = $hopitaux->map(fn($h) => [
            'id'      => $h->id,
            'nom'     => $h->nom,
            'adresse' => $h->adresse ?? 'Cotonou, Bénin',
            'lat'     => $h->latitude,
            'lng'     => $h->longitude,
            'url'     => route('hopitaux.show', $h->id),
        ])->values()->toArray();
    @endphp

    const hopitaux = {!! json_encode($hopitauxJson) !!};

    hopitaux.forEach(function (h) {
        if (!h.lat || !h.lng) return;
        L.marker([h.lat, h.lng], { icon: hospIcon })
            .addTo(map)
            .bindPopup(`<div class="pop-card">
                <div class="pop-name">${h.nom}</div>
                <div class="pop-addr">${h.adresse}</div>
                <a href="${h.url}" class="pop-btn">Prendre rendez-vous →</a>
            </div>`);
    });

    /* ── INVALIDATION TAILLE (évite la carte grise) ── */
    setTimeout(() => map.invalidateSize(), 200);
});
</script>
@endpush