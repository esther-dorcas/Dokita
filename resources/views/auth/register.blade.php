<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription - Dokita</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&family=outfit:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
            background: linear-gradient(160deg, rgba(10,30,60,0.88) 0%, rgba(8,100,150,0.72) 100%),
                        url('/images/doctor-globe.jpg') center/100% no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5rem 4rem;
            color: white;
            position: sticky;
            top: 72px;
            height: calc(100vh - 72px);
        }
        .left-side h1 { font-family:'Outfit',sans-serif; font-size:3.2rem; font-weight:800; line-height:1.12; margin-bottom:1.5rem; }
        .left-side p  { font-size:1.05rem; color:rgba(255,255,255,0.80); line-height:1.65; max-width:380px; }

        /* Côté droit — formulaire */
        .right-side {
            width: 50%;
            padding: 56px 5rem 60px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
        }
        .form-container { width:100%; max-width:640px; }

        /* ══ SÉLECTEUR DE RÔLE (style capture) ══ */
        .role-row { display:flex; gap:1.25rem; margin-bottom:2.5rem; }
        .role-card {
            flex:1; display:flex; flex-direction:column; align-items:center; gap:0.75rem;
            padding:1.5rem 1rem 1.25rem;
            border:2px solid #e8edf5;
            border-radius:1.25rem;
            cursor:pointer;
            transition:all 0.25s;
            background:#fff;
            position:relative;
        }
        .role-card:hover { border-color:#b8cde0; transform:translateY(-3px); box-shadow:0 8px 24px rgba(15,45,82,0.08); }
        .role-card.active { border-color:#0f2d52; box-shadow:0 12px 36px rgba(15,45,82,0.14); }
        .role-card input { position:absolute; opacity:0; pointer-events:none; }

        .role-icon {
            width:52px; height:52px; border-radius:14px;
            display:flex; align-items:center; justify-content:center;
            background:#f0f4f8; color:#94a3b8;
            transition:all 0.25s;
        }
        .role-card.active .role-icon { background:#0f2d52; color:#fff; }

        .role-label { font-weight:800; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.10em; color:#94a3b8; transition:color 0.25s; }
        .role-card.active .role-label { color:#0f2d52; }

        /* ══ CHAMPS ══ */
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.1rem; }
        .form-full  { grid-column:span 2; }

        .field-group label { display:block; font-size:0.72rem; font-weight:800; text-transform:uppercase; letter-spacing:0.07em; color:#64748b; margin-bottom:0.45rem; }
        .form-input {
            width:100%; padding:0.9rem 1.1rem;
            border:1.5px solid #e2e8f0; border-radius:0.875rem;
            font-size:0.93rem; color:#0f172a;
            background:#f8fafc; outline:none;
            transition:border-color .2s, box-shadow .2s, background .2s;
        }
        .form-input:focus { border-color:#0f2d52; background:#fff; box-shadow:0 0 0 3px rgba(15,45,82,0.08); }
        .form-input::placeholder { color:#cbd5e1; }

        /* ══ TERMS ══ */
        .terms-row { display:flex; align-items:center; gap:0.75rem; margin:1.5rem 0 1.25rem; font-size:0.87rem; color:#64748b; }
        .terms-row input { width:18px; height:18px; accent-color:#0f2d52; cursor:pointer; flex-shrink:0; border-radius:4px; }
        .terms-row a { color:#0891b2; font-weight:700; text-decoration:none; }

        /* ══ BOUTON ══ */
        .btn-submit {
            width:100%; padding:1rem 1.5rem;
            background:#0f2d52; color:#fff;
            border-radius:1rem; font-weight:800; font-size:1rem;
            border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center; gap:0.75rem;
            transition:background .2s, transform .15s, box-shadow .2s;
        }
        .btn-submit:hover { background:#1a3d6b; transform:translateY(-2px); box-shadow:0 16px 32px rgba(15,45,82,0.22); }

        .login-link { text-align:center; margin-top:1.75rem; font-size:0.88rem; color:#64748b; }
        .login-link a { color:#0f2d52; font-weight:800; text-decoration:none; }
        .login-link a:hover { text-decoration:underline; }

        /* ══ RESPONSIVE ══ */
        @media(max-width:1024px){
            .left-side { display:none; }
            .right-side { width:100%; padding:100px 2rem 60px; }
        }
        @media(max-width:640px){
            .form-grid { grid-template-columns:1fr; }
            .form-full { grid-column:span 1; }
        }
    </style>
</head>
<body x-data="registerForm">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerForm', () => ({
                role: 'patient',
                hopitaux: {!! json_encode($hopitaux) !!},
                fields() {
                    const base = [
                        { type: 'text',     name: 'firstname', label: 'Prénom',        placeholder: 'Jean',              required: true,  full: false },
                        { type: 'text',     name: 'lastname',  label: 'Nom',           placeholder: 'Dossou',            required: true,  full: false },
                        { type: 'email',    name: 'email',     label: 'Adresse email', placeholder: 'jean@email.com',    required: true,  full: true  },
                        { type: 'tel',      name: 'phone',     label: 'Téléphone',     placeholder: '+229 90 00 00 00',  required: true,  full: true  },
                        { type: 'password', name: 'password',  label: 'Mot de passe',  placeholder: '••••••••',          required: true,  full: true  },
                    ];
                    const praticien = [
                        { type: 'text',   name: 'specialty',         label: 'Spécialité',            placeholder: 'Cardiologie, Généraliste…',  required: true,  full: true  },
                        { type: 'select', name: 'hopital_id',        label: 'Hôpital d\'affiliation', placeholder: 'Choisir un établissement…', required: true,  full: true, options: this.hopitaux },
                        { type: 'text',   name: 'license_number',    label: 'N° d\'inscription',     placeholder: 'Médecin n°…',               required: false, full: false },
                    ];
                    const hopital = [
                        { type: 'text',  name: 'hospital_name',  label: 'Nom de l\'hôpital',      placeholder: 'Centre Hospitalier…',       required: true,  full: true  },
                        { type: 'text',  name: 'director',        label: 'Directeur',              placeholder: 'Dr. Kossi',                 required: false, full: false },
                        { type: 'text',  name: 'city',            label: 'Ville',                  placeholder: 'Cotonou',                   required: true,  full: false },
                        { type: 'email', name: 'email',           label: 'Adresse email',          placeholder: 'contact@hopital.bj',        required: true,  full: true  },
                        { type: 'tel',   name: 'phone',           label: 'Téléphone',              placeholder: '+229 21 XX XX XX',          required: true,  full: true  },
                        { type: 'password', name: 'password',     label: 'Mot de passe',           placeholder: '••••••••',                  required: true,  full: true  },
                    ];
                    if (this.role === 'patient')    return base;
                    if (this.role === 'praticien')  return [ ...base.slice(0,4), ...praticien, base[4] ];
                    if (this.role === 'hopital')    return hopital;
                    return base;
                }
            }))
        })
    </script>

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
                    <a href="{{ route('faq') }}"   class="nav-link">Besoin d'aide&nbsp;?</a>
                    <a href="{{ route('professional') }}" class="nav-link">Espace professionnel</a>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}"    class="rounded-lg border-2 border-white/60 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10 hover:border-white">Se connecter</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-[#0284c7]">S'inscrire</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-[#0891b2] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#0284c7]">Mon espace</a>
                    @endguest
                </div>
                <button class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/30 text-white"
                        onclick="document.getElementById('mob-menu').classList.toggle('hidden')">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <div id="mob-menu" class="hidden border-t border-white/10 bg-[#0f2d52] px-4 py-5 lg:hidden">
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Qui sommes-nous&nbsp;?</a>
                <a href="{{ route('faq') }}"   class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Besoin d'aide&nbsp;?</a>
                <a href="{{ route('professional') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">Espace professionnel</a>
            </div>
            <div class="mt-4 flex flex-col gap-3 pt-4 border-t border-white/10">
                @guest
                    <a href="{{ route('login') }}"    class="block rounded-lg border-2 border-white/50 px-4 py-3 text-center text-sm font-bold text-white">Se connecter</a>
                    <a href="{{ route('register') }}" class="block rounded-lg bg-[#0891b2] px-4 py-3 text-center text-sm font-bold text-white">S'inscrire</a>
                @else
                    <a href="{{ route('dashboard') }}" class="block rounded-lg bg-[#0891b2] px-4 py-3 text-center text-sm font-bold text-white">Mon espace</a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- ══ CONTENU PRINCIPAL ══ --}}
    <div style="padding-top:72px;">
        <div class="split-layout">

            {{-- GAUCHE : image + texte --}}
            <div class="left-side">
                <h1>Rejoignez le<br>réseau Dokita.</h1>
                <p style="margin-top:1.5rem;">Plus de 10 000 patients et 500 praticiens nous font confiance au Bénin.</p>

                {{-- Stats --}}
                <div style="display:flex; gap:2.5rem; margin-top:3rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,0.15);">
                    <div>
                        <p style="font-size:2rem; font-weight:900; color:#fff;">+120</p>
                        <p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:rgba(255,255,255,0.55); margin-top:4px;">Hôpitaux</p>
                    </div>
                    <div style="border-left:1px solid rgba(255,255,255,0.15); padding-left:2.5rem;">
                        <p style="font-size:2rem; font-weight:900; color:#fff;">100%</p>
                        <p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:rgba(255,255,255,0.55); margin-top:4px;">Sécurisé </p>
                    </div>
                    <div style="border-left:1px solid rgba(255,255,255,0.15); padding-left:2.5rem;">
                        <p style="font-size:2rem; font-weight:900; color:#fff;">24/7</p>
                        <p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:rgba(255,255,255,0.55); margin-top:4px;">Disponible</p>
                    </div>
                </div>
            </div>

            {{-- DROITE : formulaire --}}
            <div class="right-side">
                <div class="form-container">

                    {{-- Titre --}}
                    <div style="margin-bottom:2rem;">
                        <h2 style="font-size:1.8rem; font-weight:900; color:#0f172a; margin-bottom:0.4rem;">Créer un compte</h2>
                        <p style="font-size:0.9rem; color:#64748b;">Choisissez votre profil et remplissez le formulaire.</p>
                        
                        @if ($errors->any())
                            <div style="margin-top:1rem; padding:1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:12px; color:#b91c1c; font-size:0.85rem;">
                                <ul style="list-style:none;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Sélecteur de rôle --}}
                    <div class="role-row">
                        {{-- Patient --}}
                        <label class="role-card" :class="{ 'active': role === 'patient' }">
                            <input type="radio" name="role_select" value="patient" x-model="role">
                            <div class="role-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                            </div>
                            <span class="role-label">Patient</span>
                        </label>

                        {{-- Praticien --}}
                        <label class="role-card" :class="{ 'active': role === 'praticien' }">
                            <input type="radio" name="role_select" value="praticien" x-model="role">
                            <div class="role-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                            </div>
                            <span class="role-label">Praticien</span>
                        </label>

                        {{-- Hôpital --}}
                        <label class="role-card" :class="{ 'active': role === 'hopital' }">
                            <input type="radio" name="role_select" value="hopital" x-model="role">
                            <div class="role-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                            </div>
                            <span class="role-label">Hôpital</span>
                        </label>
                    </div>

                    {{-- Erreurs de validation --}}
                    @if ($errors->any())
                        <div style="margin-bottom:1.5rem; padding:1rem 1.25rem; background:#fef2f2; border:1.5px solid #fecaca; border-radius:1rem; display:flex; align-items:flex-start; gap:0.75rem;">
                            <svg width="20" height="20" fill="none" stroke="#ef4444" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <ul style="list-style:none; font-size:0.88rem; color:#b91c1c; font-weight:600; line-height:1.6;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulaire dynamique --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="user_role" :value="role">

                        <div class="form-grid">
                            <template x-for="f in fields()" :key="f.name + role">
                                <div class="field-group" :class="{ 'form-full': f.full }">
                                    <label x-text="f.label"></label>
                                    
                                    <template x-if="f.type === 'select'">
                                        <select :name="f.name" :required="f.required" class="form-input" style="appearance: auto;">
                                            <option value="" disabled selected x-text="f.placeholder"></option>
                                            <template x-for="opt in f.options" :key="opt.id">
                                                <option :value="opt.id" x-text="opt.nom"></option>
                                            </template>
                                        </select>
                                    </template>
                                    
                                    <template x-if="f.type !== 'select'">
                                        <div x-data="{ showPass: false }" style="position: relative;">
                                            <input
                                                :type="f.type === 'password' ? (showPass ? 'text' : 'password') : f.type"
                                                :name="f.name"
                                                :placeholder="f.placeholder"
                                                :required="f.required"
                                                class="form-input"
                                                :style="f.type === 'password' ? 'padding-right: 3rem;' : ''"
                                            >
                                            <template x-if="f.type === 'password'">
                                                <button type="button" @click="showPass = !showPass" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b;">
                                                    {{-- Œil fermé --}}
                                                    <svg x-show="!showPass" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                                    {{-- Œil ouvert --}}
                                                    <svg x-show="showPass" x-cloak width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <div class="terms-row">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">J'accepte les <a href="{{ route('conditions') }}" target="_blank">conditions d'utilisation</a> et la <a href="{{ route('confidentialite') }}" target="_blank">politique de confidentialité</a>.</label>
                        </div>

                        <button type="submit" class="btn-submit">
                            S'inscrire gratuitement
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>

                        <div class="login-link">
                            Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>{{-- fin split-layout --}}
    </div>

    @include('partials.footer')
    @include('partials.samu-modal')
</body>
</html>