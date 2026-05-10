@extends('layouts.dokita')

@section('title', 'Consultation Vidéo — Dokita')
@section('page-title') Consultation Vidéo @endsection
@section('page-subtitle', 'Connectez-vous avec votre médecin pour une consultation à distance.')

@section('content')
<div class="space-y-8">

    {{-- Consultation Info --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Consultation avec Dr. Marie Dupont</h3>
                    <p class="text-sm font-medium text-slate-600">Cardiologue • Hôpital Central</p>
                    <p class="text-sm text-slate-500">Début dans 2 minutes • Durée estimée: 30 min</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-2 bg-green-100 text-green-800 rounded-xl">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-bold">En ligne</span>
                </div>
                <button class="px-4 py-2 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition-colors">
                    Quitter
                </button>
            </div>
        </div>
    </div>

    {{-- Video Interface --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Video --}}
        <div class="lg:col-span-2">
            <div class="bg-slate-900 rounded-3xl overflow-hidden shadow-2xl relative">
                {{-- Doctor Video --}}
                <div class="aspect-video bg-slate-800 flex items-center justify-center relative">
                    <div class="text-center text-white">
                        <div class="w-24 h-24 bg-gradient-to-br from-medical-500 to-medical-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-2">Dr. Marie Dupont</h4>
                        <p class="text-slate-300">Connexion en cours...</p>
                    </div>
                    {{-- Connection Status --}}
                    <div class="absolute top-4 left-4 bg-slate-800/80 backdrop-blur-sm px-3 py-2 rounded-xl">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                            <span class="text-xs font-medium text-white">Connexion...</span>
                        </div>
                    </div>
                </div>

                {{-- Patient Self Video --}}
                <div class="absolute bottom-4 right-4 w-48 h-32 bg-slate-700 rounded-xl overflow-hidden border-2 border-white shadow-lg">
                    <div class="w-full h-full bg-slate-600 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="w-8 h-8 bg-slate-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <p class="text-xs font-medium">Vous</p>
                        </div>
                    </div>
                </div>

                {{-- Controls --}}
                <div class="bg-slate-800 p-4">
                    <div class="flex items-center justify-center gap-4">
                        <button class="w-12 h-12 bg-slate-700 hover:bg-slate-600 rounded-full flex items-center justify-center transition-colors" title="Couper le micro">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                            </svg>
                        </button>
                        <button class="w-12 h-12 bg-slate-700 hover:bg-slate-600 rounded-full flex items-center justify-center transition-colors" title="Couper la caméra">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                        <button class="w-16 h-12 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors font-bold text-white" title="Terminer l'appel">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.684A1 1 0 008.28 3H5z"/>
                            </svg>
                        </button>
                        <button class="w-12 h-12 bg-slate-700 hover:bg-slate-600 rounded-full flex items-center justify-center transition-colors" title="Partager écran">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </button>
                        <button class="w-12 h-12 bg-slate-700 hover:bg-slate-600 rounded-full flex items-center justify-center transition-colors" title="Plus d'options">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Chat --}}
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Messages</h4>
                <div class="space-y-4 max-h-64 overflow-y-auto">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-medical-500 to-medical-700 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-white">Dr</span>
                        </div>
                        <div class="bg-slate-100 p-3 rounded-2xl max-w-xs">
                            <p class="text-sm text-slate-700">Bonjour ! Comment allez-vous aujourd'hui ?</p>
                            <p class="text-xs text-slate-500 mt-1">14:25</p>
                        </div>
                    </div>
                    <div class="flex gap-3 justify-end">
                        <div class="bg-medical-500 p-3 rounded-2xl max-w-xs">
                            <p class="text-sm text-white">Bonjour Docteur, je vais bien merci. J'ai quelques questions concernant mon traitement.</p>
                            <p class="text-xs text-medical-100 mt-1">14:26</p>
                        </div>
                        <div class="w-8 h-8 bg-slate-300 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-slate-700">V</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex gap-2">
                    <input type="text" placeholder="Tapez votre message..." class="flex-1 px-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-medical-500 focus:border-medical-500">
                    <button class="px-4 py-2 bg-medical-500 text-white rounded-xl hover:bg-medical-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Notes --}}
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Notes de consultation</h4>
                <textarea placeholder="Prenez des notes pendant la consultation..." class="w-full h-32 px-4 py-3 border border-slate-200 rounded-xl text-sm resize-none focus:ring-2 focus:ring-medical-500 focus:border-medical-500" rows="4"></textarea>
                <button class="mt-3 w-full px-4 py-2 bg-medical-500 text-white rounded-xl font-bold hover:bg-medical-600 transition-colors">
                    Sauvegarder
                </button>
            </div>

            {{-- Documents --}}
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Documents partagés</h4>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-900">Ordonnance.pdf</p>
                            <p class="text-xs text-slate-500">Reçu il y a 2 min</p>
                        </div>
                        <button class="text-medical-500 hover:text-medical-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button class="mt-3 w-full px-4 py-2 border-2 border-dashed border-slate-300 text-slate-500 rounded-xl hover:border-medical-500 hover:text-medical-500 transition-colors">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Partager un document
                </button>
            </div>

        </div>

    </div>

</div>
@endsection