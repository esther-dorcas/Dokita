@extends('layouts.dokita')

@section('title', $hopital->nom . ' — Dokita')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')
<div class="space-y-8 pt-4 pb-12">

    {{-- Actions & Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <button onclick="history.back()" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-medical-600 transition-colors group w-fit">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Retour aux résultats
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3 text-sm font-bold text-green-700 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
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
    <div class="relative h-[400px] rounded-[40px] overflow-hidden shadow-2xl shadow-slate-200/50 mb-8">
        <img src="{{ $heroPhoto }}" alt="{{ $hopital->nom }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent flex flex-col justify-end p-8 md:p-12">
            <div class="flex flex-wrap gap-2 mb-4">
                @if($hopital->isOuvert())
                    <span class="bg-green-500 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Ouvert</span>
                @else
                    <span class="bg-red-500 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Fermé</span>
                @endif
                <span class="bg-white/20 backdrop-blur-md text-white text-[11px] font-bold px-3 py-1 rounded-full border border-white/20 shadow-lg">Partenaire Agréé</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2 leading-tight">{{ $hopital->nom }}</h1>
            <div class="flex items-center gap-2 text-medical-100 font-medium">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $hopital->adresse ?? 'Cotonou, Bénin' }}
            </div>
        </div>
    </div>

    {{-- DETAIL GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

        {{-- LEFT COLUMN --}}
        <div class="space-y-8">
            {{-- À propos --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-4 font-display">À propos de l'établissement</h2>
                <p class="text-slate-600 leading-relaxed font-medium text-[15px]">{{ $hopital->description ?: 'Cet établissement propose des consultations médicales personnalisées et des créneaux rapides pour vos besoins de santé. Notre équipe de médecins dévoués assure une prise en charge complète et humaine, avec les meilleures technologies disponibles au Bénin.' }}</p>
            </div>

            {{-- Spécialités --}}
            @if($hopital->specialites->count())
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 font-display">Spécialités & Services</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($hopital->specialites as $spec)
                    <div class="flex flex-col items-center p-5 bg-slate-50 border border-slate-100 rounded-2xl hover:border-medical-200 hover:bg-medical-50 transition-colors text-center group">
                        <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-medical-600 mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700">{{ $spec->nom_specialite }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Médecins + réservation --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 font-display">Médecins disponibles</h2>

                <div class="space-y-3">
                    @forelse($hopital->medecins as $doc)
                    <div class="flex items-center justify-between gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-medical-200 hover:shadow-md transition-all group" id="doc-{{ $doc->id }}">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-medical-100 text-medical-700 font-bold text-lg flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($doc->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-base font-bold text-slate-900 group-hover:text-medical-700 transition-colors">Dr. {{ $doc->user->name }}</div>
                                <div class="text-sm font-medium text-slate-500">{{ $doc->specialite ?? 'Médecin généraliste' }}</div>
                            </div>
                        </div>
                        <button class="shrink-0 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-medical-600 hover:text-white hover:border-medical-600 transition-colors btn-rdv-doc" onclick="selectDoctor({{ $doc->id }}, '{{ addslashes($doc->user->name) }}')">
                            Prendre RDV
                        </button>
                    </div>
                    @empty
                    <p class="text-slate-500 font-medium p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">Aucun médecin disponible pour le moment.</p>
                    @endforelse
                </div>

                {{-- Booking form (shown after selecting a doctor) --}}
                <div id="booking-form-section" class="hidden mt-8 pt-8 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900 mb-5" id="booking-doctor-label">Réserver avec Dr. —</h3>

                    <form method="GET" action="{{ route('hopitaux.show', $hopital->id) }}" id="date-form" class="mb-6">
                        <input type="hidden" name="medecin_id" id="hidden-medecin-id" value="{{ $medecin->id ?? '' }}">
                        <div class="relative max-w-sm">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <input type="date" name="date" value="{{ $date }}" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-medical-500/10 focus:border-medical-500 outline-none transition-all font-medium text-slate-900 cursor-pointer" onchange="this.form.submit()">
                        </div>
                    </form>

                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-6">
                        @forelse($creneaux as $slot)
                            <button type="button"
                                class="slot-btn py-3 px-2 rounded-xl text-sm font-bold border transition-all text-center {{ $slot['libre'] ? 'bg-white border-slate-200 text-slate-700 hover:border-medical-500 hover:text-medical-600 hover:bg-medical-50' : 'bg-slate-50 border-slate-100 text-slate-400 line-through cursor-not-allowed' }}"
                                data-heure="{{ $slot['heure'] }}"
                                {{ $slot['libre'] ? '' : 'disabled' }}>
                                {{ $slot['heure'] }}
                            </button>
                        @empty
                            <div class="col-span-full p-6 text-center text-slate-500 font-medium bg-slate-50 border border-slate-100 rounded-2xl">
                                Aucun créneau disponible ce jour. Veuillez choisir une autre date.
                            </div>
                        @endforelse
                    </div>

                    <form method="POST" action="{{ route('rdv.store') }}" id="confirm-form">
                        @csrf
                        <input type="hidden" name="medecin_id" id="confirm-medecin-id" value="{{ $medecin->id ?? '' }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="heure" id="confirm-heure" value="">
                        <input type="hidden" name="motif" value="Consultation médicale">
                        <button type="submit" class="w-full py-4 bg-medical-600 text-white rounded-xl font-bold shadow-lg shadow-medical-600/30 hover:bg-medical-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none" id="confirm-btn" disabled>
                            Confirmer le rendez-vous
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="space-y-8">
            {{-- Info card --}}
            <div class="bg-gradient-to-br from-medical-800 to-medical-950 rounded-[32px] p-8 text-white shadow-xl shadow-medical-900/20 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl"></div>
                <h3 class="text-2xl font-bold font-display mb-8">Informations utiles</h3>

                <div class="space-y-6 relative z-10">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-medical-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.81 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-medical-300 uppercase tracking-widest mb-1">Téléphone</div>
                            <div class="text-lg font-bold">{{ $hopital->telephone ?? '+229 21 00 00 00' }}</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-medical-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-medical-300 uppercase tracking-widest mb-1">Horaires</div>
                            <div class="text-lg font-bold">{{ $hopital->horaires ?? '08h – 18h' }}</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-medical-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-medical-300 uppercase tracking-widest mb-1">Consultation</div>
                            <div class="text-lg font-bold">À partir de {{ number_format($hopital->tarifMin() ?: 10000, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 space-y-3 relative z-10">
                    <button class="w-full bg-white text-medical-900 py-4 rounded-xl font-bold shadow-lg hover:bg-slate-50 transition-colors" onclick="document.getElementById('booking-form-section').scrollIntoView({behavior:'smooth'})">
                        Prendre rendez-vous
                    </button>
                    <a href="{{ route('urgence.create') }}" class="block w-full bg-red-500 text-white py-4 rounded-xl font-bold shadow-lg shadow-red-500/20 text-center hover:bg-red-600 transition-colors">
                        DÉCLARER UNE URGENCE
                    </a>
                </div>
            </div>

            {{-- Reviews --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 font-display">Avis patients</h3>
                    <div class="flex items-center gap-1 bg-orange-50 px-3 py-1 rounded-lg">
                        <span class="font-bold text-orange-600">4.8</span>
                        <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                </div>
                
                <div class="space-y-6">
                    @foreach(['"Très bon accueil, prise en charge rapide. Je recommande !"', '"Médecins compétents et personnel attentionné."'] as $review)
                    <div class="pb-6 border-b border-slate-100 last:border-0 last:pb-0">
                        <div class="flex gap-1 mb-2">
                            @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-orange-400" fill="currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor
                        </div>
                        <p class="text-[14px] text-slate-600 italic leading-relaxed mb-2">{{ $review }}</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">— Patient vérifié</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Map --}}
            @if($hopital->latitude && $hopital->longitude)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h3 class="text-xl font-bold text-slate-900 font-display mb-6">Localisation</h3>
                <div id="hosp-map" class="h-[240px] rounded-2xl overflow-hidden shadow-inner border border-slate-100"></div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Map
@if($hopital->latitude && $hopital->longitude)
const map = L.map('hosp-map').setView([{{ $hopital->latitude }}, {{ $hopital->longitude }}], 15);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

const hospIcon = L.divIcon({
    html: '<div class="w-10 h-10 rounded-full bg-medical-600 text-white flex items-center justify-center text-lg shadow-lg border-2 border-white">🏥</div>',
    iconSize:[40,40],iconAnchor:[20,40],className:''
});

L.marker([{{ $hopital->latitude }}, {{ $hopital->longitude }}], {icon: hospIcon})
    .addTo(map)
    .bindPopup('<strong class="font-sans">{{ addslashes($hopital->nom) }}</strong>').openPopup();
@endif

// Doctor selection
let currentDocId = @json($medecin?->id ?? null);

@if($medecin)
// A doctor is already selected (from URL param) — open the booking section
document.getElementById('booking-form-section').classList.remove('hidden');
document.getElementById('booking-doctor-label').textContent = 'Réserver avec Dr. {{ $medecin->user->name }}';
const docRow = document.getElementById('doc-{{ $medecin->id }}');
if (docRow) {
    const btn = docRow.querySelector('.btn-rdv-doc');
    btn.classList.add('bg-medical-600', 'text-white');
    btn.classList.remove('bg-white', 'text-slate-700');
}
@endif

function selectDoctor(id, name) {
    // Reset previous
    document.querySelectorAll('.btn-rdv-doc').forEach(b => {
        b.classList.remove('bg-medical-600', 'text-white', 'border-medical-600');
        b.classList.add('bg-white', 'text-slate-700');
    });
    // Activate
    const row = document.getElementById('doc-' + id);
    if (row) {
        const btn = row.querySelector('.btn-rdv-doc');
        btn.classList.remove('bg-white', 'text-slate-700');
        btn.classList.add('bg-medical-600', 'text-white', 'border-medical-600');
    }
    // Update hidden inputs
    document.getElementById('hidden-medecin-id').value = id;
    document.getElementById('confirm-medecin-id').value = id;
    // Update label
    document.getElementById('booking-doctor-label').textContent = 'Réserver avec Dr. ' + name;
    // Show section
    const section = document.getElementById('booking-form-section');
    section.classList.remove('hidden');
    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    // Reload page with medecin_id
    const url = new URL(window.location.href);
    url.searchParams.set('medecin_id', id);
    window.location.href = url.toString();
}

// Time slot selection
const slots = document.querySelectorAll('.slot-btn:not([disabled])');
const confirmHeure = document.getElementById('confirm-heure');
const confirmBtn = document.getElementById('confirm-btn');

slots.forEach(btn => {
    btn.addEventListener('click', () => {
        slots.forEach(s => {
            s.classList.remove('bg-medical-600', 'text-white', 'border-medical-600', 'shadow-md');
            s.classList.add('bg-white', 'text-slate-700');
        });
        btn.classList.remove('bg-white', 'text-slate-700');
        btn.classList.add('bg-medical-600', 'text-white', 'border-medical-600', 'shadow-md');
        confirmHeure.value = btn.dataset.heure;
        confirmBtn.disabled = false;
    });
});
</script>
@endpush
