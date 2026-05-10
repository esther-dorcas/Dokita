@extends('layouts.dokita')

@section('title', 'Urgence médicale — Dokita')

@section('content')
<div class="max-w-4xl mx-auto pt-4">
    <!-- Header d'urgence -->
    <div class="mb-10 text-center relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="inline-flex items-center gap-3 mb-5 relative">
            <div class="flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-red-500 to-red-700 shadow-lg shadow-red-500/30 animate-pulse">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
            </div>
        </div>
        <h1 class="text-4xl font-display font-bold text-slate-900 mb-3 relative">Urgence Médicale</h1>
        <p class="text-lg text-slate-600 font-medium relative">Remplissez ce formulaire pour une prise en charge immédiate</p>
        <div class="mt-6 inline-flex items-center gap-3 px-6 py-3 bg-red-50 border border-red-200/60 rounded-2xl shadow-sm relative">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
            <p class="text-red-800 font-bold text-sm">
                En cas d'urgence vitale, composez directement le <span class="text-lg">122</span> (SAMU)
            </p>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-[32px] border border-slate-100 p-6 md:p-10 shadow-xl shadow-slate-200/20">
        <form method="POST" action="{{ route('urgence.store') }}" class="space-y-8">
            @csrf

            <!-- Type d'urgence -->
            <div>
                <label class="block text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Type d'urgence
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['Cardiaque', 'Respiratoire', 'Traumatisme', 'Brûlure', 'Hémorragie', 'Intoxication', 'Accident', 'Autre'] as $type)
                        <label class="relative cursor-pointer group h-full">
                            <input type="radio" name="type_urgence" value="{{ $type }}" class="peer sr-only" required>
                            <div class="h-full rounded-2xl border-2 border-slate-100 bg-slate-50 p-4 text-center transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-md hover:border-slate-300 flex items-center justify-center">
                                <span class="text-sm font-bold text-slate-700 peer-checked:text-red-700">{{ $type }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-base font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Description de la situation
                </label>
                <textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-base font-medium text-slate-900 outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all resize-none" placeholder="Décrivez les symptômes et la situation en détail..." required></textarea>
            </div>

            <!-- Localisation -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-base font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Localisation actuelle
                    </label>
                    <div class="relative">
                        <input type="text" id="location-input" name="localisation" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3.5 pl-11 text-base font-medium text-slate-900 outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all" placeholder="Adresse complète ou lieu" required>
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <button type="button" onclick="getLocation()" class="mt-3 text-sm text-red-600 hover:text-red-700 font-bold flex items-center gap-2 bg-red-50 px-4 py-2 rounded-xl w-fit transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                        Utiliser mon GPS
                    </button>
                </div>
                <div>
                    <label class="block text-base font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Téléphone de contact
                    </label>
                    <input type="tel" name="telephone" value="{{ Auth::user()->telephone ?? old('telephone') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3.5 text-base font-medium text-slate-900 outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all" placeholder="+229 XX XX XX XX" required>
                </div>
            </div>

            <!-- Coordonnées GPS cachées -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <!-- Informations patient -->
            <div class="border-t border-slate-100 pt-8 mt-4">
                <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    Informations patient
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nom complet</label>
                        <input type="text" name="nom_patient" value="{{ Auth::user()->name }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3.5 text-base font-medium text-slate-900 outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Âge approximatif</label>
                        <input type="number" name="age" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3.5 text-base font-medium text-slate-900 outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all" placeholder="Âge du patient" required>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-bold text-lg py-5 rounded-2xl hover:from-red-700 hover:to-red-800 transition-all shadow-xl shadow-red-600/30 flex items-center justify-center gap-3 hover:-translate-y-1">
                    <svg class="h-6 w-6 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                    DÉCLARER L'URGENCE MAINTENANT
                </button>
                <p class="text-sm font-medium text-slate-500 text-center mt-4">
                    Une équipe médicale vous contactera dans les plus brefs délais pour vous guider.
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function getLocation() {
    const locationInput = document.getElementById('location-input');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    if (navigator.geolocation) {
        locationInput.value = "Localisation en cours...";
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                latInput.value = lat;
                lngInput.value = lng;
                locationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                
                // Optionnel: Reverse geocoding avec OpenStreetMap
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            locationInput.value = data.display_name;
                        }
                    })
                    .catch(() => {});
            },
            (error) => {
                locationInput.value = "";
                alert("Impossible d'obtenir votre position. Veuillez entrer votre adresse manuellement.");
            }
        );
    } else {
        alert("La géolocalisation n'est pas supportée par votre navigateur.");
    }
}
</script>
@endpush