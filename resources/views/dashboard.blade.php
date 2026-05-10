<x-app-layout>
    <div class="min-h-screen bg-slate-50/50">
        <!-- Hero & Search Section -->
        <div class="bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="animate-fade-in">
                        <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900">
                            Bonjour, <span class="text-medical-600">{{ Auth::user()->name }}</span> 👋
                        </h1>
                        <p class="text-slate-500 mt-1 font-medium">Prenez soin de votre santé aujourd'hui.</p>
                    </div>

                    <!-- Quick Search Bar -->
                    <div class="w-full md:w-96 relative group animate-fade-in-up">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-medical-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </div>
                        <input type="text" 
                               placeholder="Trouver un médecin, une spécialité..." 
                               class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-medical-500/20 focus:bg-white transition-all shadow-sm font-medium text-slate-600">
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
                <div class="bg-white p-5 rounded-3xl shadow-soft border border-slate-100 card-hover animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="w-12 h-12 bg-medical-50 rounded-2xl flex items-center justify-center text-medical-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Rendez-vous</p>
                    <h3 class="text-2xl font-display font-extrabold text-slate-900 mt-1">2</h3>
                </div>

                <div class="bg-white p-5 rounded-3xl shadow-soft border border-slate-100 card-hover animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8"/><path d="M8 13h6"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Messages</p>
                    <h3 class="text-2xl font-display font-extrabold text-slate-900 mt-1">5</h3>
                </div>

                <div class="bg-white p-5 rounded-3xl shadow-soft border border-slate-100 card-hover animate-fade-in-up" style="animation-delay: 0.3s">
                    <div class="w-12 h-12 bg-trust-green-50 rounded-2xl flex items-center justify-center text-trust-green-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Documents</p>
                    <h3 class="text-2xl font-display font-extrabold text-slate-900 mt-1">12</h3>
                </div>

                <div class="bg-white p-5 rounded-3xl shadow-soft border border-slate-100 card-hover animate-fade-in-up" style="animation-delay: 0.4s">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-bold uppercase tracking-wider">Favoris</p>
                    <h3 class="text-2xl font-display font-extrabold text-slate-900 mt-1">8</h3>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Appointments Section -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-display font-bold text-slate-900">Vos prochains rendez-vous</h2>
                        <a href="#" class="text-medical-600 font-bold text-sm hover:underline">Voir tout</a>
                    </div>

                    <!-- Appointment Card 1 -->
                    <div class="bg-white p-6 rounded-3xl shadow-soft border border-slate-100 card-hover group">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 overflow-hidden">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=doctor1" alt="Dr. Kouassi" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-bold text-slate-900">Dr. Jean Kouassi</h4>
                                    <span class="badge badge-info">Confirmé</span>
                                </div>
                                <p class="text-medical-600 font-medium text-sm">Cardiologue</p>
                                
                                <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500 font-medium">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        Lundi 12 Mai, 2024
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        14:30
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        Clinique de l'Espoir, Cotonou
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <button class="flex-1 py-3 px-4 bg-medical-50 text-medical-600 rounded-xl font-bold text-sm hover:bg-medical-100 transition-colors">Modifier</button>
                            <button class="flex-1 py-3 px-4 bg-slate-50 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors">Annuler</button>
                        </div>
                    </div>

                    <!-- Appointment Card 2 -->
                    <div class="bg-white p-6 rounded-3xl shadow-soft border border-slate-100 card-hover group opacity-75 grayscale-[0.5] hover:grayscale-0 hover:opacity-100 transition-all">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 overflow-hidden">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=doctor2" alt="Dr. Amoussou" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg font-bold text-slate-900">Dr. Sophie Amoussou</h4>
                                    <span class="badge badge-warning">En attente</span>
                                </div>
                                <p class="text-medical-600 font-medium text-sm">Dentiste</p>
                                
                                <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500 font-medium">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        Jeudi 15 Mai, 2024
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        09:15
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-8">
                    <!-- Health Tips -->
                    <div class="bg-medical-900 rounded-3xl p-6 text-white overflow-hidden relative group">
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold mb-2">Conseil du jour</h3>
                            <p class="text-medical-100 text-sm leading-relaxed mb-6">
                                Boire 1,5L d'eau par jour aide à maintenir une bonne hydratation et améliore la concentration.
                            </p>
                            <button class="w-full py-3 px-4 bg-medical-500 text-white rounded-xl font-bold text-sm hover:bg-medical-400 transition-colors">
                                En savoir plus
                            </button>
                        </div>
                        <!-- Decorative element -->
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-medical-800 rounded-full blur-3xl group-hover:bg-medical-700 transition-colors"></div>
                    </div>

                    <!-- Recent Practitioners -->
                    <div>
                        <h2 class="text-xl font-display font-bold text-slate-900 mb-6">Praticiens récents</h2>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 group cursor-pointer">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden group-hover:ring-2 group-hover:ring-medical-500 transition-all">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=doctor3" alt="Dr. Zinsou" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-slate-900 group-hover:text-medical-600 transition-colors">Dr. Marc Zinsou</h5>
                                    <p class="text-xs text-slate-500">Pédiatre</p>
                                </div>
                                <div class="ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 group-hover:text-medical-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 group cursor-pointer">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden group-hover:ring-2 group-hover:ring-medical-500 transition-all">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=doctor4" alt="Dr. Toko" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-slate-900 group-hover:text-medical-600 transition-colors">Dr. Alice Toko</h5>
                                    <p class="text-xs text-slate-500">Gynécologue</p>
                                </div>
                                <div class="ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 group-hover:text-medical-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

