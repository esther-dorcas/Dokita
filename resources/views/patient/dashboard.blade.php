@extends('layouts.dokita')

@section('title', 'Tableau de bord — Dokita')
@section('page-title') Bienvenue, {{ Auth::user()->name }} 👋 @endsection
@section('page-subtitle', 'Gérez votre santé et vos rendez-vous en un coup d\'œil.')

@section('content')
<div class="space-y-8">

    {{-- Actions principales --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="#" class="inline-flex items-center gap-2 bg-[#00a6a0] text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-teal-600/30 hover:bg-teal-700 hover:shadow-teal-700/40 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Consultation vidéo
            </a>
            <a href="{{ route('rdv.create') }}" class="inline-flex items-center gap-2 bg-slate-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-slate-600/30 hover:bg-slate-700 hover:shadow-slate-700/40 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nouveau RDV
            </a>
        </div>
        <a href="{{ route('urgence.create') }}" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-red-600/30 hover:bg-red-700 hover:shadow-red-700/40 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Signaler une URGENCE
        </a>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Prochain RDV --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Prochain rendez-vous</p>
            <p class="text-2xl font-display font-bold text-slate-900">
                @if($upcomingRendezVous->first())
                    {{ $upcomingRendezVous->first()->date_heure->isoFormat('D MMM, HH:mm') }}
                @else
                    Aucun prévu
                @endif
            </p>
            <p class="text-xs font-medium text-slate-400 mt-2">
                @if($upcomingRendezVous->first())
                    Dr. {{ $upcomingRendezVous->first()->medecin->user->name }}
                @else
                    Prenez un rendez-vous
                @endif
            </p>
        </div>

        {{-- Consultations --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Consultations totales</p>
            <p class="text-2xl font-display font-bold text-slate-900">{{ $completedCount + $confirmedCount }}</p>
            <p class="text-xs font-medium text-slate-400 mt-2">Depuis Janvier {{ date('Y') }}</p>
        </div>

        {{-- Hôpitaux favoris --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Hôpitaux favoris</p>
            <p class="text-2xl font-display font-bold text-slate-900">{{ $recentHopitaux->count() ?: 3 }}</p>
            <p class="text-xs font-medium text-slate-400 mt-2">Vues récentes</p>
        </div>
    </div>

    {{-- Content grid 2/3 + 1/3 --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Section Gauche : Rendez-vous --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h2 class="text-base font-bold text-slate-900">Rendez-vous récents</h2>
                    <a href="{{ route('rdv.index') }}" class="text-sm font-bold text-medical-600 hover:text-medical-700 transition-colors">Voir tout</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($upcomingRendezVous as $rdv)
                        @php
                            $badgeClasses = match($rdv->statut) {
                                'confirme'   => 'bg-green-100 text-green-700 border-green-200',
                                'en_attente' => 'bg-blue-100 text-blue-700 border-blue-200',
                                default      => 'bg-red-100 text-red-700 border-red-200',
                            };
                            $badgeLabel = match($rdv->statut) {
                                'confirme'   => 'Confirmé',
                                'en_attente' => 'En attente',
                                default      => 'Annulé',
                            };
                        @endphp
                        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $rdv->motif ?? 'Consultation médicale' }}</p>
                                    <p class="text-sm text-slate-500 mt-0.5">Dr. {{ $rdv->medecin->user->name }} &middot; {{ $rdv->medecin->hopital->nom ?? 'Hôpital' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-6 sm:w-auto">
                                <span class="text-sm font-semibold text-slate-700">{{ $rdv->date_heure->isoFormat('D MMM YYYY') }}</span>
                                <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $badgeClasses }}">{{ $badgeLabel }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-300 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-700 mb-1">Aucun rendez-vous récent</p>
                            <a href="{{ route('hopitaux.index') }}" class="text-sm font-bold text-medical-600 hover:text-medical-700">Réserver un RDV &rarr;</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Section Droite : Sidebar --}}
        <div class="space-y-6">
            {{-- Conseil du jour --}}
            <div class="bg-gradient-to-br from-medical-600 to-medical-800 rounded-3xl p-8 relative overflow-hidden shadow-lg shadow-medical-500/20">
                <svg class="absolute -top-6 -right-6 w-32 h-32 text-white/10 rotate-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                <div class="relative z-10">
                    <h3 class="text-xl font-display font-bold text-white mb-3">Conseil du jour</h3>
                    <p class="text-sm text-medical-100 font-medium leading-relaxed mb-6">Lavez-vous les mains régulièrement et buvez au moins 1.5L d'eau par jour pour rester en bonne santé en cette période de chaleur.</p>
                    <button onclick="document.getElementById('tipModal').classList.remove('hidden')" class="bg-white text-medical-700 text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-colors w-full sm:w-auto text-center">
                        En savoir plus
                    </button>
                </div>
            </div>

            {{-- Hôpitaux à proximité --}}
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 mb-5">Hôpitaux à proximité</h3>
                <div class="space-y-5">
                    @if($recentHopitaux->count())
                        @foreach($recentHopitaux as $h)
                        <div class="flex items-center justify-between group cursor-pointer">
                            <div>
                                <p class="text-sm font-bold text-slate-900 group-hover:text-medical-600 transition-colors">{{ $h->nom }}</p>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $h->adresse ?? 'Cotonou' }}
                                </div>
                            </div>
                            <div class="bg-orange-50 text-orange-600 text-xs font-bold px-2.5 py-1.5 rounded-lg border border-orange-100 shrink-0">
                                4.5 ⭐
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach([['CHU HKM','2.5 km','4.8'],['Clinique Internationale','3.1 km','4.5'],['Hôpital de Zone Calavi','5.8 km','4.2']] as [$n,$d,$r])
                        <div class="flex items-center justify-between group cursor-pointer">
                            <div>
                                <p class="text-sm font-bold text-slate-900 group-hover:text-medical-600 transition-colors">{{ $n }}</p>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $d }}
                                </div>
                            </div>
                            <div class="bg-orange-50 text-orange-600 text-xs font-bold px-2.5 py-1.5 rounded-lg border border-orange-100 shrink-0">
                                {{ $r }} ⭐
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL CONSEIL ── --}}
<div id="tipModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="this.parentElement.classList.add('hidden')"></div>

    <div class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white p-8 text-left shadow-2xl transition-all border border-slate-100">
        <div class="flex items-start justify-between mb-6">
            <div class="w-12 h-12 rounded-2xl bg-medical-50 text-medical-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <button type="button" onclick="document.getElementById('tipModal').classList.add('hidden')" class="rounded-full w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors focus:outline-none">
                <span class="sr-only">Fermer</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <h3 class="text-2xl font-display font-bold text-slate-900 mb-3" id="modal-title">Conseils d'Hydratation</h3>
        <div class="text-sm text-slate-600 space-y-4 mb-8">
            <p class="font-medium">En cette période de forte chaleur au Bénin, voici quelques recommandations essentielles de Dokita pour rester en forme :</p>
            <ul class="space-y-3 list-disc list-inside">
                <li><strong class="text-slate-800">Hydratation :</strong> Buvez au moins 1.5L à 2L d'eau par jour, même sans sensation de soif.</li>
                <li><strong class="text-slate-800">Alimentation :</strong> Privilégiez les fruits locaux riches en eau (pastèque, oranges, papaye).</li>
                <li><strong class="text-slate-800">Protection :</strong> Évitez les expositions prolongées au soleil entre 11h et 16h.</li>
                <li><strong class="text-slate-800">Vêtements :</strong> Portez des vêtements légers en coton pour faciliter la transpiration.</li>
            </ul>
        </div>
        
        <button type="button" onclick="document.getElementById('tipModal').classList.add('hidden')" class="w-full btn-primary text-center">
            J'ai compris, merci !
        </button>
    </div>
</div>
@endsection