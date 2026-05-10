@extends('layouts.dokita')

@section('title', 'Historique des Consultations — Dokita')
@section('page-title') Historique des Consultations @endsection
@section('page-subtitle', 'Consultez vos consultations passées et vos documents médicaux.')

@section('content')
<div class="space-y-8">

    {{-- Filtres --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-900">Filtrer les consultations</h3>
            <div class="flex items-center gap-3">
                <select class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-medical-500 focus:border-medical-500">
                    <option>Toutes les spécialités</option>
                    <option>Cardiologie</option>
                    <option>Dermatologie</option>
                    <option>Généraliste</option>
                </select>
                <select class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-medical-500 focus:border-medical-500">
                    <option>Tous les statuts</option>
                    <option>Terminée</option>
                    <option>Annulée</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Liste des consultations --}}
    <div class="space-y-4">
        {{-- Consultation 1 --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-lg font-bold text-slate-900">Dr. Marie Dupont</h4>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Terminée</span>
                        </div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Cardiologue • Hôpital Central</p>
                        <p class="text-sm text-slate-500 mb-3">15 Décembre 2023 • 14:30 - 15:00</p>
                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-sm text-slate-700">
                                <strong>Diagnostic:</strong> Contrôle annuel satisfaisant. Tension artérielle normale. Recommandations: Continuer le traitement actuel et revenir dans 6 mois.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </button>
                    <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Consultation 2 --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-lg font-bold text-slate-900">Dr. Jean Martin</h4>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Terminée</span>
                        </div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Généraliste • Clinique Saint-Joseph</p>
                        <p class="text-sm text-slate-500 mb-3">02 Novembre 2023 • 10:00 - 10:30</p>
                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-sm text-slate-700">
                                <strong>Diagnostic:</strong> Grippe saisonnière. Prescription d'antiviraux et repos. Suivi dans 5 jours si symptômes persistent.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </button>
                    <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Consultation 3 --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-lg font-bold text-slate-900">Dr. Sophie Leroy</h4>
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">Annulée</span>
                        </div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Dermatologue • Centre Médical Nord</p>
                        <p class="text-sm text-slate-500 mb-3">18 Octobre 2023 • 16:00 - 16:30</p>
                        <div class="bg-red-50 p-4 rounded-2xl border border-red-100">
                            <p class="text-sm text-red-700">
                                <strong>Raison de l'annulation:</strong> Indisponibilité du médecin. Rendez-vous reporté au 25 octobre.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-sm font-medium text-slate-600">Affichage de 1 à 3 sur 12 consultations</p>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 transition-colors" disabled>
                Précédent
            </button>
            <button class="px-4 py-2 bg-medical-500 text-white rounded-xl text-sm font-medium hover:bg-medical-600 transition-colors">
                1
            </button>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                2
            </button>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                3
            </button>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                Suivant
            </button>
        </div>
    </div>

</div>
@endsection