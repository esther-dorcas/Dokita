@extends('layouts.dokita')

@section('title', 'Mes rendez-vous — Dokita')
@section('page-title', 'Suivez vos consultations')
@section('page-subtitle', 'Gérez vos réservations et consultez les détails de vos prochains rendez-vous.')

@section('content')
<div class="space-y-6">

    <!-- En-tête -->
    <div class="flex items-center justify-between mb-8">
        <div></div>
        <a href="{{ route('hopitaux.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-medical-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-medical-700 shadow-lg shadow-medical-600/30 flex-shrink-0">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouveau RDV
        </a>
    </div>

    <!-- Liste des rendez-vous -->
    @forelse($rendezVous as $rdv)
        @php
            $statut = $rdv->statut;
            $borderClass = match($statut) {
                'confirme' => 'border-l-green-500',
                'en_attente' => 'border-l-blue-500',
                default => 'border-l-red-500'
            };
            $badgeClass = match($statut) {
                'confirme' => 'bg-green-50 text-green-700 border border-green-200',
                'en_attente' => 'bg-blue-50 text-blue-700 border border-blue-200',
                default => 'bg-red-50 text-red-700 border border-red-200'
            };
            $badgeLabel = match($statut) {
                'confirme' => '✓ Confirmé',
                'en_attente' => '⏳ En attente',
                default => '✕ Annulé'
            };
            $iconBg = match($statut) {
                'confirme' => 'bg-green-100 text-green-600',
                'en_attente' => 'bg-blue-100 text-blue-600',
                default => 'bg-red-100 text-red-600'
            };
        @endphp
        <article class="rounded-3xl border border-slate-100 border-l-[6px] {{ $borderClass }} bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1">
            <div class="grid gap-6 sm:grid-cols-[1fr_auto]">
                <div class="flex items-start gap-5">
                    <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl {{ $iconBg }} text-2xl shadow-inner">🩺</div>
                    <div class="space-y-1.5">
                        <p class="text-xs font-bold uppercase tracking-widest text-medical-600">{{ $rdv->medecin->specialite ?? 'Consultation' }}</p>
                        <h2 class="text-xl font-bold text-slate-900">Dr. {{ $rdv->medecin->user->name ?? 'Médecin' }}</h2>
                        <p class="flex items-center gap-2 text-sm text-slate-500 font-medium mt-2">
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $rdv->date_heure->isoFormat('dddd D MMMM YYYY [à] HH:mm') }}
                        </p>
                        <p class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                            {{ $rdv->medecin->hopital->nom ?? 'Hôpital inconnu' }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-start sm:items-end justify-between gap-4">
                    <span class="rounded-full px-4 py-1.5 text-xs font-bold {{ $badgeClass }} shadow-sm">{{ $badgeLabel }}</span>
                    @if($rdv->statut !== 'annule')
                        <form method="POST" action="{{ route('rdv.annuler', $rdv->id) }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-2.5 text-sm font-bold text-red-600 transition hover:bg-red-50 hover:border-red-300">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Annuler
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </article>
    @empty
        <div class="rounded-3xl border border-slate-100 bg-white p-16 text-center shadow-sm">
            <div class="text-5xl mb-4">📅</div>
            <p class="text-xl font-bold text-slate-900">Aucun rendez-vous trouvé</p>
            <p class="mt-2 text-sm font-medium text-slate-500">Réservez votre premier rendez-vous pour le voir apparaître ici.</p>
            <a href="{{ route('hopitaux.index') }}"
                class="mt-8 inline-flex items-center gap-2 rounded-xl bg-medical-600 px-8 py-3 text-sm font-bold text-white transition hover:bg-medical-700 shadow-lg shadow-medical-600/30">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Réserver maintenant
            </a>
        </div>
    @endforelse
</div>
@endsection
