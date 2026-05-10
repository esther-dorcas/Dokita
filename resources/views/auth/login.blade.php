<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Dokita</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&family=outfit:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter', sans-serif; background:#fff; }

        /* ══ NAV ══ */
        #main-nav { background:#0f2d52; box-shadow:0 2px 20px rgba(0,0,0,0.25); }
        .nav-link { color:rgba(255,255,255,0.85); font-weight:600; font-size:0.875rem; transition:color 0.2s; position:relative; padding-bottom:2px; margin:0 1.5rem; text-decoration:none; }
        .nav-link:hover { color:#fff; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#22d3ee; transition:width 0.25s ease; }
        .nav-link:hover::after { width:100%; }

        /* ══ SPLIT LAYOUT ══ */
        .split-layout { display:flex; min-height:calc(100vh - 72px); }

        /* Côté gauche — image + texte */
        .left-side {
            width: 50%;
            background-color: #0f172a;
            background-image: linear-gradient(160deg, rgba(10,30,60,0.93) 0%, rgba(8,100,150,0.85) 100%),
                              url('/images/medunis.jpg');
            background-position: center;
            background-size: 100%;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5rem 4rem;
            color: #ffffff;
            position: sticky;
            top: 72px;
            height: calc(100vh - 72px);
        }
        .left-side h1 { font-family:'Outfit',sans-serif; font-size:3.5rem; font-weight:800; line-height:1.1; margin-bottom:1.5rem; text-shadow: 0 18px 35px rgba(0,0,0,0.45); }
        .left-side p  { font-size:1.15rem; color:#f8fafc; line-height:1.7; max-width:420px; text-shadow: 0 12px 28px rgba(0,0,0,0.32); }

        /* Côté droit — formulaire */
        .right-side {
            width: 50%;
            padding: 80px 5rem 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
        }
        .form-container { width:100%; max-width:480px; }

        /* ══ TITRE ══ */
        .form-header { margin-bottom: 2.5rem; }
        .form-header h2 { font-size: 2.2rem; font-weight: 900; color: #0f172a; margin-bottom: 0.5rem; letter-spacing: -0.02em; }
        .form-header p { color: #64748b; font-size: 1rem; }

        /* ══ CHAMPS ══ */
        .field-group { margin-bottom: 1.5rem; }
        .field-group label { display:block; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.07em; color:#64748b; margin-bottom:0.6rem; }
        .form-input {
            width:100%; padding:1.1rem 1.25rem;
            border:1.5px solid #e2e8f0; border-radius:1rem;
            font-size:1rem; color:#0f172a;
            background:#f8fafc; outline:none;
            transition: all 0.2s;
        }
        .form-input:focus { border-color:#0f2d52; background:#fff; box-shadow:0 0 0 4px rgba(15,45,82,0.08); }
        .form-input::placeholder { color:#cbd5e1; }

        /* ══ OPTIONS ══ */
        .options-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; font-size:0.9rem; }
        .remember-me { display:flex; align-items:center; gap:0.6rem; color:#64748b; cursor:pointer; }
        .remember-me input { width:18px; height:18px; accent-color:#0f2d52; cursor:pointer; }
        .forgot-pass { color:#0891b2; font-weight:700; text-decoration:none; transition: color 0.2s; }
        .forgot-pass:hover { color:#0e7490; }

        /* ══ BOUTON ══ */
        .btn-submit {
            width:100%; padding:1.1rem;
            background:#0f2d52; color:#fff;
            border-radius:1rem; font-weight:800; font-size:1.1rem;
            border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center; gap:0.75rem;
            transition: all 0.3s;
        }
        .btn-submit:hover { background:#1a3d6b; transform:translateY(-2px); box-shadow:0 15px 30px rgba(15,45,82,0.2); }

        .register-link { text-align:center; margin-top:2.5rem; font-size:1rem; color:#64748b; }
        .register-link a { color:#0f2d52; font-weight:800; text-decoration:none; margin-left: 0.5rem; }
        .register-link a:hover { text-decoration:underline; }

        /* ══ RESPONSIVE ══ */
        @media(max-width:1024px){
            .left-side { display:none; }
            .right-side { width:100%; padding:100px 2rem 60px; }
        }
    </style>
</head>
<body>

    {{-- ══ NAVBAR ══ --}}
    <nav id="main-nav" class="fixed top-0 inset-x-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-[72px] items-center justify-between">
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center border-2 border-white px-4 py-2 rounded-lg">
                        <span class="text-white font-black text-xl tracking-tight">Dokita</span>
                    </span>
                </a>
                <div class="hidden lg:flex items-center">
                    <a href="{{ route('home') }}" class="nav-link">Qui sommes-nous&nbsp;?</a>
                    <a href="{{ route('faq') }}"  class="nav-link">Besoin d'aide&nbsp;?</a>
                    <a href="{{ route('professional') }}" class="nav-link">Espace professionnel</a>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('login') }}"    class="rounded-lg border-2 border-white/60 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Se connecter</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-[#0284c7]">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="padding-top:72px;">
        <div class="split-layout">
            
            {{-- GAUCHE : Image medunis --}}
            <div class="left-side">
                <h1>Bon retour<br>parmi nous.</h1>
                <p>Accédez à votre espace santé sécurisé et gérez vos rendez-vous médicaux en toute simplicité.</p>
            </div>

            {{-- DROITE : Formulaire --}}
            <div class="right-side">
                <div class="form-container">
                    
                    <div class="form-header">
                        <h2>Se connecter</h2>
                        <p>Veuillez entrer vos identifiants pour continuer.</p>
                    </div>

                    @if ($errors->any())
                        <div style="margin-bottom:2rem; padding:1rem; background:#fef2f2; border:1px solid #fee2e2; border-radius:1rem; color:#b91c1c; font-size:0.9rem;">
                            <ul style="list-style:none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="field-group">
                            <label for="email">Adresse email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="votre@email.com" required autofocus>
                        </div>

                        <div class="field-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                        </div>

                        <div class="options-row">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                <span>Se souvenir de moi</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-pass">Mot de passe oublié ?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn-submit">
                            Se connecter
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>

                        <div class="register-link">
                            Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous gratuitement</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- ══ FOOTER ══ --}}
    <footer class="bg-slate-950 text-slate-300 w-full border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 lg:grid-cols-4">
                <div>
                    <span class="inline-flex items-center justify-center border-2 border-white/30 px-3 py-1.5 rounded-lg">
                        <span class="text-white font-black text-lg">Dokita</span>
                    </span>
                    <p class="mt-4 text-sm leading-7 text-slate-400">Plateforme e-santé pour la prise de rendez-vous et la géolocalisation d'hôpitaux au Bénin.</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Navigation</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}#hospitaux"   class="hover:text-white transition">Hôpitaux</a></li>
                        <li><a href="{{ route('home') }}#medecins"    class="hover:text-white transition">Médecins</a></li>
                        <li><a href="{{ route('faq') }}"              class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Contact</h3>
                    <p class="text-sm text-slate-400">support@dokita.bj</p>
                    <p class="mt-3 text-sm text-slate-400">+229 90 00 00 00</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 mb-5">Réseaux</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="#" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/10 transition">FB</a>
                        <a href="#" class="rounded-lg border border-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/10 transition">TW</a>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-slate-900 pt-8 text-xs text-slate-600 text-center">© {{ date('Y') }} Dokita. Tous droits réservés.</div>
        </div>
    </footer>

</body>
</html>