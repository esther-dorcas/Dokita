@extends('layouts.dokita')

@section('title', 'Prendre un rendez-vous — Dokita')
@section('page-title', 'Prendre un rendez-vous')
@section('page-subtitle', 'Choisissez un médecin et réservez votre consultation en quelques clics.')

@section('content')
<div class="max-w-4xl pt-4">

    <form action="{{ route('rdv.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Sélection du médecin -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                Choisir un praticien
            </h2>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($medecins as $medecin)
                    <label class="relative group cursor-pointer h-full">
                        <input type="radio" name="medecin_id" value="{{ $medecin->id }}" class="sr-only peer" required>
                        <div class="h-full p-5 bg-slate-50 border-2 border-slate-100 rounded-2xl peer-checked:border-medical-500 peer-checked:bg-medical-50/50 peer-checked:shadow-md transition-all duration-200 hover:border-medical-300">
                            <div class="flex items-start gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-medical-600 font-bold text-lg shrink-0 group-hover:scale-105 transition-transform">
                                    {{ substr($medecin->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-tight mb-1">{{ $medecin->user->name }}</p>
                                    <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">{{ $medecin->hopital->nom }}</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-1.5 mt-auto pt-2">
                                <span class="inline-block bg-white border border-slate-200 px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-600 uppercase tracking-wider">{{ $medecin->specialite }}</span>
                            </div>
                            
                            <!-- Checked indicator -->
                            <div class="absolute top-4 right-4 w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-medical-500 peer-checked:bg-medical-500 flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            @error('medecin_id')
                <p class="mt-3 text-sm font-medium text-red-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Date et heure -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                Date et heure
            </h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="date" class="block text-sm font-bold text-slate-700 mb-2">Date souhaitée</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <input type="date" id="date" name="date" min="{{ date('Y-m-d') }}" required
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-medical-500/10 focus:border-medical-500 outline-none transition-all font-medium text-slate-900">
                    </div>
                    @error('date')
                        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="heure" class="block text-sm font-bold text-slate-700 mb-2">Heure</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <input type="time" id="heure" name="heure" required
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-medical-500/10 focus:border-medical-500 outline-none transition-all font-medium text-slate-900">
                    </div>
                    @error('heure')
                        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Motif -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                </div>
                Motif de la consultation
            </h2>

            <div>
                <textarea name="motif" rows="4" placeholder="Décrivez brièvement vos symptômes ou la raison de votre visite (ex: consultation de routine, fièvre, douleurs)..."
                          class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-medical-500/10 focus:border-medical-500 outline-none transition-all font-medium text-slate-900 resize-none"></textarea>
                @error('motif')
                    <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <button type="submit" class="sm:flex-1 btn-primary text-center justify-center text-base py-3.5 rounded-xl shadow-lg shadow-medical-600/20">
                Confirmer la réservation
            </button>
            <a href="{{ route('patient.dashboard') }}" class="sm:flex-none px-8 py-3.5 border-2 border-slate-200 bg-white text-slate-700 rounded-xl font-bold hover:bg-slate-50 hover:border-slate-300 transition-colors text-center">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection