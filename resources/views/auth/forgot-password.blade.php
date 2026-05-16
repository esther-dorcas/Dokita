<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié - Dokita</title>
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
            background-image: linear-gradient(160deg, rgba(10,30,60,0.93) 0%, rgba(8,145,178,0.85) 100%),
                              url('/images/noi1.jpg');
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
        .form-header p { color: #64748b; font-size: 1rem; line-height: 1.6; }

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

        /* ══ BOUTON ══ */
        .btn-submit {
            width:100%; padding:1.1rem;
            background:#0f2d52; color:#fff;
            border-radius:1rem; font-weight:800; font-size:1.1rem;
            border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center; gap:0.75rem;
            transition: all 0.3s;
            margin-top: 1rem;
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
                    <a href="{{ route('home') }}" class="nav-link">Qui sommes-nous ?</a>
                    <a href="{{ route('faq') }}"  class="nav-link">Besoin d'aide ?</a>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('login') }}"    class="rounded-lg border-2 border-white/60 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Se connecter</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="padding-top:72px;">
        <div class="split-layout">
            
            {{-- GAUCHE : Image medunis --}}
            <div class="left-side">
                <h1>Mot de passe oublié ?</h1>
                <p>Ne vous inquiétez pas, cela arrive à tout le monde. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien pour sécuriser à nouveau votre compte.</p>
            </div>

            {{-- DROITE : Formulaire --}}
            <div class="right-side">
                <div class="form-container">
                    
                    <div class="form-header">
                        <h2>Réinitialisation</h2>
                        <p>Recevez un lien par email pour créer un nouveau mot de passe.</p>
                    </div>

                    {{-- Message de succès --}}
                    @if (session('status'))
                        <div style="margin-bottom:2rem; padding:1rem; background:#f0fdf4; border:1px solid #dcfce7; border-radius:1rem; color:#16a34a; font-size:0.9rem; font-weight:600; display:flex; gap:10px; align-items:center;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div style="margin-bottom:2rem; padding:1rem; background:#fef2f2; border:1px solid #fee2e2; border-radius:1rem; color:#b91c1c; font-size:0.9rem;">
                            <ul style="list-style:none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="field-group">
                            <label for="email">Adresse email du compte</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="votre@email.com" required autofocus>
                        </div>

                        <button type="submit" class="btn-submit">
                            Envoyer le lien
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </button>

                        <div class="register-link">
                            Je me souviens de mon mot de passe ! <a href="{{ route('login') }}">Retour à la connexion</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')
    @include('partials.samu-modal')
</body>
</html>
