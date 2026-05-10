<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-10">
        <div class="bg-gradient-to-br from-medical-500 to-medical-700 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-medical-500/30">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
        </div>
        <h2 class="text-3xl font-display font-bold text-slate-900">Mot de passe oublié ?</h2>
        <p class="text-slate-500 mt-2 font-light">Pas de panique ! Entrez votre email et on vous enverra un lien pour le réinitialiser.</p>
    </div>

    {{-- Message de succès --}}
    @if (session('status'))
        <div class="mb-8 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
        </div>
    @endif

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div class="mb-8 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <ul class="text-sm text-red-700 font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="input-primary pl-11 text-slate-900" placeholder="nom@exemple.com">
            </div>
        </div>

        {{-- Bouton submit --}}
        <button type="submit" class="w-full btn-primary mt-8">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    {{-- Lien retour connexion --}}
    <div class="mt-8 pt-8 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-500">
            Vous vous souvenez de votre mot de passe ?
            <a href="{{ route('login') }}" class="text-medical-600 font-bold hover:text-medical-700 transition-colors ml-1">Se connecter</a>
        </p>
    </div>
</x-guest-layout>