<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dokita') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&family=outfit:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

        .left-panel {
            background: linear-gradient(135deg, #020617 0%, #0f172a 50%, #134e4a 100%);
        }

        /* Decorative glows */
        .glow-1 {
            position: absolute; top: -100px; right: -100px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(13, 148, 136, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }
        .glow-2 {
            position: absolute; bottom: -100px; left: -100px;
            width: 350px; height: 350px; border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Premium Form Card */
        .right-panel { background: #fafcff; }
        .form-card {
            background: #ffffff;
            border: 1px solid rgba(13, 148, 136, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
        }

        .feat-icon {
            width: 44px; height: 44px; border-radius: 14px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .panel-divider {
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(15, 23, 42, 0.1) 20%, rgba(15, 23, 42, 0.1) 80%, transparent);
        }
    </style>
</head>
<body class="antialiased">
<div class="min-h-screen flex">

    {{-- ═══ PANNEAU GAUCHE — Branding ═══ --}}
    <div class="hidden lg:flex flex-col justify-between w-5/12 xl:w-2/5 left-panel p-12 text-white relative overflow-hidden">

        <div class="glow-1" aria-hidden="true"></div>
        <div class="glow-2" aria-hidden="true"></div>

        {{-- Grille de points --}}
        <div class="absolute inset-0 opacity-10" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dots" width="24" height="24" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="rgba(255,255,255,0.5)"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#dots)"/>
            </svg>
        </div>

        {{-- Logo --}}
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </div>
            <div>
                <a href="/" class="inline-block">
                    <span class="text-2xl font-display font-bold tracking-tight text-white">Dokita.</span>
                </a>
            </div>
        </div>

        {{-- Contenu central --}}
        <div class="relative z-10 space-y-10 mt-8">
            <div>
                <h2 class="text-4xl font-display font-bold leading-[1.2] text-white">La santé accessible<br>à tous au Bénin.</h2>
                <p class="mt-4 text-base text-slate-300 font-light leading-relaxed max-w-md">Trouvez un médecin qualifié, réservez votre créneau et gérez votre parcours de santé en toute simplicité.</p>
            </div>

            <div class="space-y-6">
                <div class="flex items-start gap-4 group">
                    <div class="feat-icon group-hover:bg-medical-600/30 transition-colors">
                        <svg class="h-5 w-5 text-medical-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Réseau d'établissements</p>
                        <p class="text-sm mt-1 text-slate-400">Plus de 120 hôpitaux et cliniques partenaires à travers tout le Bénin.</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-4 group">
                    <div class="feat-icon group-hover:bg-medical-600/30 transition-colors">
                        <svg class="h-5 w-5 text-medical-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Réservation instantanée</p>
                        <p class="text-sm mt-1 text-slate-400">Prenez rendez-vous en quelques clics, 24h/24 et 7j/7 sans attendre.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 group">
                    <div class="feat-icon group-hover:bg-medical-600/30 transition-colors">
                        <svg class="h-5 w-5 text-medical-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Données sécurisées</p>
                        <p class="text-sm mt-1 text-slate-400">Votre dossier médical est protégé selon les normes de sécurité les plus strictes.</p>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/10 mt-10">
                <div>
                    <p class="text-2xl font-display font-bold text-white">120+</p>
                    <p class="text-xs mt-1 text-slate-400 font-medium uppercase tracking-wider">Hôpitaux</p>
                </div>
                <div>
                    <p class="text-2xl font-display font-bold text-white">850+</p>
                    <p class="text-xs mt-1 text-slate-400 font-medium uppercase tracking-wider">Médecins</p>
                </div>
                <div>
                    <p class="text-2xl font-display font-bold text-white">100%</p>
                    <p class="text-xs mt-1 text-slate-400 font-medium uppercase tracking-wider">Sécurisé</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative z-10 mt-12">
            <p class="text-xs text-slate-500 font-medium">© {{ date('Y') }} Dokita Technologies. Tous droits réservés.</p>
        </div>
    </div>

    {{-- Séparateur --}}
    <div class="panel-divider hidden lg:block"></div>

    {{-- ═══ PANNEAU DROIT — Formulaire ═══ --}}
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 lg:px-16 right-panel">

        {{-- Logo mobile --}}
        <div class="lg:hidden mb-10 text-center flex flex-col items-center">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-medical-500 to-medical-700 flex items-center justify-center shadow-lg mb-3">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </div>
            <a href="/">
                <span class="text-2xl font-display font-bold tracking-tight text-slate-900">Dokita.</span>
            </a>
            <p class="text-sm mt-1 text-slate-500 font-medium">Votre santé, notre priorité</p>
        </div>

        <div class="w-full max-w-md">
            <div class="form-card">
                {{ $slot }}
            </div>
        </div>
    </div>

</div>
</body>
</html>
