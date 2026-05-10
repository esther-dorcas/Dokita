<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Urgence médicale — Dokita</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:#f9fafb;color:#111827;min-height:100vh}

/* ── NAVBAR ── */
.navbar{position:sticky;top:0;z-index:50;width:100%;background:#fff;border-bottom:1px solid #f3f4f6;box-shadow:0 1px 3px rgba(0,0,0,.05)}
.navbar-inner{padding:0 24px;display:flex;align-items:center;justify-content:space-between;height:64px}
.navbar-logo{display:flex;align-items:center;gap:8px;text-decoration:none}
.logo-icon{width:36px;height:36px;background:#2563eb;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.logo-text{font-size:20px;font-weight:800;color:#111827;letter-spacing:-.03em}
.navbar-links{display:flex;align-items:center;gap:28px}
.nav-text-link{font-size:14px;font-weight:500;color:#6b7280;text-decoration:none;transition:.15s}
.nav-text-link:hover{color:#2563eb}
.navbar-user{display:flex;align-items:center;gap:12px}
.user-dash-link{font-size:13px;font-weight:700;color:#2563eb;text-decoration:none}
.user-dash-link:hover{text-decoration:underline}
.user-avatar{width:32px;height:32px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#2563eb;flex-shrink:0}
.user-avatar svg{width:18px;height:18px}
.user-name{font-size:13px;font-weight:500;color:#374151}
.logout-btn{background:none;border:none;cursor:pointer;padding:4px;color:#9ca3af;transition:.15s;display:flex;align-items:center}
.logout-btn:hover{color:#ef4444}
.logout-btn svg{width:18px;height:18px}

/* ── PAGE LAYOUT ── */
.page-wrapper{display:flex;width:100%}

/* ── SIDEBAR ── */
.sidebar{width:256px;border-right:1px solid #f3f4f6;background:#fff;display:flex;flex-direction:column;height:calc(100vh - 64px);position:sticky;top:64px;padding:16px;gap:4px;flex-shrink:0}
.sidebar-link{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;font-size:14px;font-weight:500;color:#6b7280;text-decoration:none;transition:.15s}
.sidebar-link:hover{background:#f9fafb;color:#111827}
.sidebar-link.active{background:#eff6ff;color:#1d4ed8;font-weight:600}
.sidebar-link svg{width:18px;height:18px;flex-shrink:0}
.sidebar-link.urgence{color:#ef4444;background:#fef2f2;font-weight:700}
.sidebar-link.urgence:hover{background:#fee2e2}

/* ── MAIN ── */
.main{flex:1;padding:32px;min-width:0}

/* ── EMERGENCY CARD ── */
.em-wrap{width:100%}
.back-btn{display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:700;color:#64748b;text-decoration:none;margin-bottom:28px;cursor:pointer;background:none;border:none;font-family:'Inter',sans-serif;transition:.15s}
.back-btn:hover{color:#2563eb}
.back-btn svg{width:18px;height:18px;transition:.15s}
.back-btn:hover svg{transform:translateX(-3px)}
.em-card{background:#fff;border-radius:24px;border:1px solid #f3f4f6;padding:40px;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.em-icon-wrap{text-align:center;margin-bottom:40px}
.em-icon{width:80px;height:80px;background:#dc2626;border-radius:24px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 12px 32px rgba(220,38,38,.35);animation:emPulse 1.5s ease-in-out infinite}
.em-icon svg{width:40px;height:40px}
.em-title{font-size:28px;font-weight:800;color:#111827;text-transform:uppercase;letter-spacing:-.02em;margin-bottom:6px}
.em-subtitle{font-size:14px;color:#6b7280}

/* ── FORM ── */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
@media(max-width:640px){.form-grid{grid-template-columns:1fr}}
.field-label{display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:8px}
.field-select{width:100%;padding:16px;background:#fef2f2;border:1px solid #fecaca;border-radius:16px;color:#991b1b;font-weight:700;font-size:14px;font-family:'Inter',sans-serif;outline:none;appearance:none;cursor:pointer}
.field-select:focus{border-color:#f87171;box-shadow:0 0 0 4px rgba(239,68,68,.08)}
.loc-wrap{position:relative}
.loc-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#ef4444;pointer-events:none}
.field-input{width:100%;padding:16px 16px 16px 44px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;font-size:14px;font-family:'Inter',sans-serif;outline:none;color:#111827}
.field-input:focus{border-color:#93c5fd;box-shadow:0 0 0 4px rgba(37,99,235,.06)}
.field-textarea{width:100%;padding:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;font-size:14px;font-family:'Inter',sans-serif;outline:none;min-height:120px;resize:none;color:#111827;margin-bottom:20px}
.field-textarea:focus{border-color:#93c5fd;box-shadow:0 0 0 4px rgba(37,99,235,.06)}

/* ── WARNING BOX ── */
.warn-box{background:#fff7ed;border:1px solid #fed7aa;border-radius:24px;padding:20px 24px;display:flex;align-items:flex-start;gap:14px;margin-bottom:28px}
.warn-box svg{width:22px;height:22px;color:#ea580c;flex-shrink:0;margin-top:1px}
.warn-text{font-size:13px;color:#9a3412;font-weight:500;line-height:1.7}

/* ── BUTTONS ── */
.btn-alert{width:100%;background:#dc2626;color:#fff;border:none;border-radius:16px;padding:20px;font-size:18px;font-weight:800;cursor:pointer;font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;gap:12px;box-shadow:0 8px 28px rgba(220,38,38,.3);transition:.15s;text-transform:uppercase;letter-spacing:.03em}
.btn-alert:hover{background:#b91c1c;box-shadow:0 12px 36px rgba(220,38,38,.4)}
.btn-alert svg{width:22px;height:22px}
.btn-call{display:block;width:100%;margin-top:14px;padding:14px;background:none;border:none;font-size:13px;font-weight:600;color:#9ca3af;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
.btn-call:hover{color:#6b7280}

/* ── SUCCESS STATE ── */
.success-state{display:none;text-align:center;padding:40px 0;animation:fadeIn .4s ease-out}
.success-circle{width:96px;height:96px;background:#22c55e;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 32px;box-shadow:0 16px 40px rgba(34,197,94,.3)}
.success-circle svg{width:48px;height:48px}
.success-title{font-size:30px;font-weight:800;color:#0c2340;margin-bottom:14px}
.success-text{font-size:16px;color:#6b7280;line-height:1.7;margin-bottom:8px}
.success-num{font-size:16px;font-weight:700;color:#dc2626;margin-bottom:36px}
.btn-track{background:#0c2340;color:#fff;border:none;border-radius:50px;padding:16px 40px;font-size:15px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;box-shadow:0 8px 28px rgba(12,35,64,.2);transition:.15s}
.btn-track:hover{background:#0f172a}
.back-dash{display:block;margin-top:20px;font-size:13px;color:#64748b;text-decoration:none;font-weight:500}
.back-dash:hover{color:#2563eb}

@keyframes emPulse{0%,100%{box-shadow:0 12px 32px rgba(220,38,38,.35)}50%{box-shadow:0 12px 48px rgba(220,38,38,.6)}}
@keyframes fadeIn{0%{opacity:0;transform:scale(.95)}100%{opacity:1;transform:scale(1)}}
</style>
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo">
            <div class="logo-icon">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>
            <span class="logo-text">Dokita</span>
        </a>

        <div class="navbar-user">
            <a href="{{ route('patient.dashboard') }}" class="user-dash-link">Dashboard</a>
            <div class="user-avatar">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <span class="user-name">{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" title="Se déconnecter">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ── PAGE ── --}}
<div class="page-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">
        <a href="{{ route('patient.dashboard') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Vue d'ensemble
        </a>
        <a href="{{ route('hopitaux.index') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Hôpitaux
        </a>
        <a href="{{ route('rdv.index') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Rendez-vous
        </a>
        <a href="{{ route('profil.index') }}" class="sidebar-link">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
            Paramètres
        </a>
        <a href="{{ route('urgence.create') }}" class="sidebar-link urgence active">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            URGENCE
        </a>
    </aside>

    {{-- ── MAIN ── --}}
    <main class="main">
        <div class="em-wrap">

            {{-- Back button --}}
            <button class="back-btn" onclick="history.back()">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Retour
            </button>

            {{-- Emergency card --}}
            <div class="em-card">

                {{-- FORM STATE --}}
                <div id="form-state">
                    <div class="em-icon-wrap">
                        <div class="em-icon">
                            <svg fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.81 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <h1 class="em-title">Signalement d'Urgence</h1>
                        <p class="em-subtitle">Réponse prioritaire en moins de 5 minutes.</p>
                    </div>

                    <form id="urgence-form" action="{{ route('urgence.store') }}" method="POST" onsubmit="handleSubmit(event)">
                        @csrf

                        <div class="form-grid">
                            <div>
                                <label class="field-label">Type d'urgence</label>
                                <select name="description" class="field-select" required>
                                    <option value="Accident de la route">Accident de la route</option>
                                    <option value="Malaise cardiaque">Malaise cardiaque</option>
                                    <option value="Détresse respiratoire">Détresse respiratoire</option>
                                    <option value="Accouchement imminent">Accouchement imminent</option>
                                    <option value="Autre urgence grave">Autre urgence grave</option>
                                </select>
                            </div>
                            <div>
                                <label class="field-label">Votre position</label>
                                <div class="loc-wrap">
                                    <svg class="loc-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <input type="text" name="localisation" id="loc-input" placeholder="Auto-détection..." class="field-input">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="field-label">Description rapide</label>
                            <textarea class="field-textarea" placeholder="Ex: Patient inconscient, saignements importants..."></textarea>
                        </div>

                        <input type="hidden" name="latitude" id="lat-input">
                        <input type="hidden" name="longitude" id="lng-input">

                        <div class="warn-box">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <p class="warn-text">En validant ce formulaire, les secours les plus proches seront alertés immédiatement. Préparez-vous à recevoir un appel.</p>
                        </div>

                        <button type="submit" class="btn-alert">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="transform:rotate(45deg)"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Alerter les Secours
                        </button>

                        <button type="button" class="btn-call" onclick="window.location.href='tel:122'">
                            Appeler directement le 122
                        </button>
                    </form>
                </div>

                {{-- SUCCESS STATE --}}
                <div id="success-state" class="success-state">
                    <div class="success-circle">
                        <svg fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <h2 class="success-title">Alerte Transmise !</h2>
                    <p class="success-text">Les secours sont en route vers votre position.<br>Gardez votre téléphone à portée de main.</p>
                    <p class="success-num">Numéro de suivi : #EM-{{ rand(9000,9999) }}</p>
                    <button class="btn-track" onclick="alert('Suivi en temps réel bientôt disponible. Les secours ont bien reçu votre alerte.')">
                        Suivre en temps réel
                    </button>
                    <a href="{{ route('patient.dashboard') }}" class="back-dash">Retour au tableau de bord</a>
                </div>

            </div>
        </div>
    </main>
</div>

<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        document.getElementById('lat-input').value = pos.coords.latitude;
        document.getElementById('lng-input').value = pos.coords.longitude;
        document.getElementById('loc-input').placeholder = 'Position détectée ✓';
    });
}

function handleSubmit(e) {
    e.preventDefault();
    document.getElementById('form-state').style.display = 'none';
    var s = document.getElementById('success-state');
    s.style.display = 'block';
    var form = document.getElementById('urgence-form');
    var data = new FormData(form);
    fetch(form.action, { method: 'POST', body: data, headers: { 'X-Requested-With': 'XMLHttpRequest' } }).catch(function(){});
}
</script>
</body>
</html>
