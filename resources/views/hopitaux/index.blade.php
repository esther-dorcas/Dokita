@extends('layouts.dokita')

@section('title', 'Trouver un hôpital — Dokita')
@section('page-title', 'Trouver un hôpital')
@section('page-subtitle', 'Découvrez les établissements de santé les mieux notés près de chez vous.')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')
<div class="space-y-8 pt-4">

    {{-- Actions & Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <button onclick="history.back()" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-medical-600 transition-colors group w-fit">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Retour
        </button>
        
        <button onclick="locateUser()" class="inline-flex items-center justify-center gap-2 bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 hover:border-medical-300 transition-all w-full sm:w-auto">
            <svg class="w-5 h-5 text-medical-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Autour de moi
        </button>
    </div>

    {{-- Search + Filters --}}
    <form method="GET" action="{{ route('hopitaux.index') }}">
        <div class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative w-full md:flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher par nom, ville ou spécialité..." class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 bg-white font-medium text-slate-900 shadow-sm focus:border-medical-500 focus:ring-4 focus:ring-medical-500/10 outline-none transition-all">
            </div>
            
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 custom-scrollbar shrink-0">
                @php
                    $cats = ['Tous','Général','Spécialisé','Urgences 24/7','Maternité'];
                @endphp
                @foreach($cats as $cat)
                    @php
                        $isActive = ($cat === 'Tous' && !($specialite ?? null)) || ($specialite ?? null) === $cat;
                    @endphp
                    <a href="{{ route('hopitaux.index', $cat !== 'Tous' ? ['specialite' => $cat, 'q' => $q ?? ''] : []) }}"
                       class="shrink-0 px-5 py-3 rounded-xl text-sm font-bold border transition-all duration-200 {{ $isActive ? 'bg-medical-600 text-white border-medical-600 shadow-md shadow-medical-500/20' : 'bg-white text-slate-600 border-slate-200 hover:border-medical-300' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </form>

    {{-- Grid --}}
    @if($hopitaux->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($hopitaux as $h)
        @php
            $photos = [
                'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1581056771107-24ca5f033842?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1504439468489-c8920d796a29?auto=format&fit=crop&q=80&w=600',
            ];
            $photo = $photos[$h->id % count($photos)];
            $rating = number_format(4.0 + ($h->id % 10) * 0.09, 1);
            $reviews = 40 + ($h->id * 17) % 180;
        @endphp
        <a href="{{ route('hopitaux.show', $h->id) }}" class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
            <div class="h-48 relative overflow-hidden shrink-0">
                <img src="{{ $photo }}" alt="{{ $h->nom }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl text-sm font-bold text-medical-700 flex items-center gap-1.5 shadow-lg">
                    {{ $rating }}
                    <svg class="w-3.5 h-3.5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
            </div>
            <div class="p-5 flex flex-col flex-1">
                <h3 class="text-base font-bold text-slate-900 mb-1 line-clamp-1" title="{{ $h->nom }}">{{ $h->nom }}</h3>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-4">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="truncate">{{ $h->adresse ?? 'Cotonou, Bénin' }}</span>
                </div>
                <div class="flex flex-wrap gap-1.5 mb-5">
                    @foreach($h->specialites->take(3) as $spec)
                        <span class="px-2.5 py-1 rounded-lg bg-medical-50 text-medical-700 text-[10px] font-bold uppercase tracking-wider">{{ $spec->nom_specialite }}</span>
                    @endforeach
                </div>
                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div class="text-xs text-slate-500">
                        <strong class="text-medical-600 font-bold">{{ $reviews }}</strong> avis
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-medical-50 text-medical-600 flex items-center justify-center group-hover:bg-medical-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-3xl border border-slate-100 py-16 px-6 text-center shadow-sm">
        <div class="text-5xl mb-4">🔍</div>
        <p class="text-lg font-bold text-slate-900 mb-2">Aucun hôpital trouvé</p>
        <p class="text-slate-500">Ajustez votre recherche ou sélectionnez une autre spécialité.</p>
    </div>
    @endif

    {{-- Map callout --}}
    <div class="bg-gradient-to-br from-medical-700 to-medical-900 rounded-[32px] p-8 lg:p-12 text-white relative overflow-hidden shadow-xl shadow-medical-900/20 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5" style="clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);"></div>
        <div class="absolute -bottom-10 -right-10 w-48 h-48 rounded-full border-2 border-white/10"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl lg:text-4xl font-display font-bold mb-4 leading-tight">Préférez<br>la vue carte ?</h2>
            <p class="text-medical-100 font-medium leading-relaxed mb-8 text-sm lg:text-base">Localisez les centres de santé ouverts autour de vous en temps réel. Notre carte interactive regroupe plus de 200 cliniques référencées au Bénin.</p>
            <button onclick="document.getElementById('leaflet-map').scrollIntoView({behavior:'smooth'})" class="bg-white text-medical-800 px-8 py-4 rounded-2xl font-bold hover:bg-slate-50 transition-colors shadow-lg">
                Explorer la carte interactive
            </button>
        </div>
        
        <div class="relative z-10 h-[320px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10">
            <div id="leaflet-map" class="w-full h-full"></div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('leaflet-map').setView([6.3654, 2.4183], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const userIcon = L.divIcon({
        html: '<div style="width:16px;height:16px;border-radius:50%;background:#0ea5e9;border:3px solid #fff;box-shadow:0 0 0 4px rgba(14,165,233,.3)"></div>',
        iconSize:[16,16],iconAnchor:[8,8],className:''
    });
    
    const hospIcon = L.divIcon({
        html: '<div class="w-10 h-10 rounded-full bg-medical-600 text-white flex items-center justify-center text-lg shadow-lg border-2 border-white">🏥</div>',
        iconSize:[40,40],iconAnchor:[20,40],className:''
    });

    window.locateUser = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                map.setView([pos.coords.latitude, pos.coords.longitude], 14, {animate:true});
                document.getElementById('leaflet-map').scrollIntoView({behavior:'smooth'});
            });
        }
    };

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            L.marker([pos.coords.latitude, pos.coords.longitude], {icon: userIcon})
                .addTo(map).bindPopup('<strong class="font-sans">📍 Votre position</strong>');
        });
    }

    @php
    $hopitauxJson = $hopitaux->map(function($h) {
        return [
            'id'       => $h->id,
            'nom'      => $h->nom,
            'adresse'  => $h->adresse ?? 'Cotonou, Bénin',
            'lat'      => $h->latitude,
            'lng'      => $h->longitude,
        ];
    })->values()->toArray();
    @endphp

    var data = {!! json_encode($hopitauxJson) !!};
    data.forEach(function(h) {
        if (h.lat && h.lng) {
            L.marker([h.lat, h.lng], {icon: hospIcon}).addTo(map)
                .bindPopup('<div class="p-1 font-sans"><div class="font-bold text-slate-900 mb-1">'+h.nom+'</div><div class="text-xs text-slate-500 mb-3">'+h.adresse+'</div><a href="/hopitaux/'+h.id+'" class="block w-full text-center bg-medical-600 text-white py-2 rounded-lg text-xs font-bold no-underline hover:bg-medical-700">📅 Prendre RDV</a></div>');
        }
    });
});
</script>
@endpush