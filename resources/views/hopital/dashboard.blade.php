<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dokita — Espace Hôpital</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:#f8fafc;color:#1e293b;display:flex;min-height:100vh}

/* ── SIDEBAR ── */
.sidebar{width:256px;background:#fff;border-right:1px solid #f1f5f9;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100;box-shadow:0 0 20px rgba(0,0,0,.04)}
.sb-brand{padding:20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px}
.sb-brand-icon{width:36px;height:36px;background:#2563eb;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sb-brand-name{font-size:18px;font-weight:800;color:#0f172a;letter-spacing:-.03em}
.sb-hopital{padding:16px 20px;border-bottom:1px solid #f1f5f9}
.h-avatar{width:44px;height:44px;border-radius:14px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:10px}
.h-name{font-size:13px;font-weight:700;color:#0f172a}
.h-type{font-size:11px;color:#2563eb;font-weight:600;margin-top:1px}
.h-addr{font-size:11px;color:#64748b;margin-top:3px}
.sb-nav{padding:12px 10px;flex:1;overflow-y:auto}
.nav-section{font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;padding:0 10px;margin-top:14px;margin-bottom:6px}
.nav-link{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:10px;font-size:13px;font-weight:500;color:#64748b;text-decoration:none;transition:.15s}
.nav-link:hover{background:#f8fafc;color:#1e293b}
.nav-link.active{background:#eff6ff;color:#2563eb;font-weight:600}
.nav-link.active svg{color:#2563eb}
.nav-link svg{width:16px;height:16px;flex-shrink:0;color:#94a3b8}
.nav-badge{margin-left:auto;background:#ef4444;color:#fff;border-radius:20px;padding:1px 7px;font-size:10px;font-weight:700}
.sb-bottom{padding:12px;border-top:1px solid #f1f5f9}
.logout-btn{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:10px;font-size:13px;color:#64748b;width:100%;border:none;background:none;cursor:pointer;font-family:'Inter',sans-serif}
.logout-btn:hover{background:#fef2f2;color:#ef4444}

/* ── MAIN ── */
.main{flex:1;margin-left:256px;display:flex;flex-direction:column}
.topbar{background:#fff;border-bottom:1px solid #f1f5f9;padding:0 28px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.page-title{font-size:18px;font-weight:700;color:#0f172a}
.page-sub{font-size:12px;color:#64748b;margin-top:2px}
.tb-actions{display:flex;gap:10px}
.btn-add{display:flex;align-items:center;gap:6px;padding:9px 18px;background:#fff;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;font-weight:600;color:#1e293b;cursor:pointer;font-family:'Inter',sans-serif;box-shadow:0 1px 2px rgba(0,0,0,.04)}
.btn-add:hover{background:#f8fafc}
.btn-add svg{width:16px;height:16px;color:#2563eb}
.btn-params{display:flex;align-items:center;gap:6px;padding:9px 18px;background:#0c2340;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;text-decoration:none}
.btn-params:hover{background:#1e3a5f}
.btn-params svg{width:14px;height:14px}
.content{padding:24px 28px}

/* ── STATS ── */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.stat-card{background:#fff;border-radius:24px;border:1px solid #f1f5f9;padding:22px;cursor:pointer;transition:all .2s;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.stat-card:hover{border-color:#bfdbfe;box-shadow:0 4px 16px rgba(37,99,235,.1);transform:translateY(-2px)}
.stat-icon{width:44px;height:44px;background:#f8fafc;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;transition:.2s}
.stat-card:hover .stat-icon{background:#eff6ff}
.stat-icon svg{width:22px;height:22px;color:#2563eb}
.stat-label{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em}
.stat-value{font-size:28px;font-weight:700;color:#0c2340;margin-top:6px}

/* ── GRID 2 COL ── */
.dashboard-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.card{background:#fff;border-radius:24px;border:1px solid #f1f5f9;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.card-title{font-size:16px;font-weight:700;color:#0f172a}
.card-action{font-size:13px;font-weight:600;color:#2563eb;text-decoration:none;cursor:pointer}
.card-action:hover{text-decoration:underline}

/* ── URGENCES ── */
.urgence-badge{background:#fef2f2;color:#ef4444;padding:4px 10px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase}
.urgence-row{display:flex;align-items:center;justify-content:space-between;background:#fef9f9;border:1px solid #fecaca;border-radius:16px;padding:14px 16px;margin-bottom:10px}
.urgence-row:last-child{margin-bottom:0}
.urg-id{font-size:14px;font-weight:700;color:#0f172a}
.urg-meta{font-size:11px;color:#64748b;margin-top:2px}
.btn-attribuer{padding:8px 14px;background:#ef4444;color:#fff;border:none;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
.btn-attribuer:hover{background:#dc2626}

/* ── MÉDECINS STATUS ── */
.doc-row{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f8fafc}
.doc-row:last-child{border-bottom:none}
.doc-info{display:flex;align-items:center;gap:12px}
.doc-av{width:38px;height:38px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#64748b}
.doc-name{font-size:13px;font-weight:600;color:#0f172a}
.doc-status{display:flex;align-items:center;gap:6px;font-size:11px;color:#64748b}
.status-dot{width:8px;height:8px;border-radius:50%}

/* ── MODAL ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(12,35,64,.25);backdrop-filter:blur(4px);z-index:200;align-items:center;justify-content:center;padding:20px}
.modal-overlay.open{display:flex}
.modal{background:#fff;border-radius:32px;padding:32px;max-width:460px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.15);border:1px solid #bfdbfe}
.modal-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px}
.modal-title{font-size:22px;font-weight:700;color:#0c2340}
.modal-sub{font-size:13px;color:#64748b;margin-top:2px}
.modal-close{width:36px;height:36px;border-radius:50%;border:none;background:#f1f5f9;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.modal-close svg{width:16px;height:16px;color:#64748b}
.modal-body{font-size:14px;color:#64748b;line-height:1.7;margin-bottom:24px}
.modal-confirm-btn{width:100%;padding:14px;background:#2563eb;color:#fff;border:none;border-radius:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
.modal-confirm-btn:hover{background:#1d4ed8}

/* Add doctor form */
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:8px}
.form-input{width:100%;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;font-size:14px;color:#0f172a;font-family:'Inter',sans-serif;outline:none;transition:.15s}
.form-input:focus{border-color:#2563eb;background:#fff;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
</style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
  <div class="sb-brand">
    <div class="sb-brand-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
    </div>
    <span class="sb-brand-name">Dokita</span>
  </div>

  <div class="sb-hopital">
    <div class="h-avatar">🏥</div>
    <div class="h-name">{{ Auth::user()->name }}</div>
    <div class="h-type">Établissement de santé</div>
    <div class="h-addr">Cotonou, Bénin</div>
  </div>

  <nav class="sb-nav">
    <div class="nav-section">Gestion</div>
    <a href="{{ route('hopital.dashboard') }}" class="nav-link active">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Tableau de bord
    </a>
    <a href="{{ route('hopital.rdv') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Gérer les RDV
      <span class="nav-badge">8</span>
    </a>
    <a href="{{ route('hopital.medecins') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      Gérer les médecins
    </a>
    <a href="{{ route('hopital.urgences') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      Urgences reçues
      <span class="nav-badge">2</span>
    </a>
    <a href="#" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
      </svg>
      Télémédecine
    </a>
    <div class="nav-section">Configuration</div>
    <a href="{{ route('hopital.parametres') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
      Paramètres
    </a>
  </nav>

  <div class="sb-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout-btn">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Se déconnecter
      </button>
    </form>
  </div>
</aside>

<!-- ── MAIN ── -->
<div class="main">
  <header class="topbar">
    <div>
      <div class="page-title">{{ Auth::user()->name }} 🏥</div>
      <div class="page-sub">Vue d'ensemble de l'établissement et des ressources.</div>
    </div>
    <div class="tb-actions">
      <button class="btn-add" onclick="document.getElementById('add-doctor-modal').classList.add('open')">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Ajouter un médecin
      </button>
      <a href="{{ route('hopital.parametres') }}" class="btn-params">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
        Paramètres
      </a>
    </div>
  </header>

  <div class="content">

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card" onclick="openStatModal('medecins')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div class="stat-label">Médecins Actifs</div>
        <div class="stat-value">24</div>
      </div>
      <div class="stat-card" onclick="openStatModal('rdv')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        <div class="stat-label">RDV / Semaine</div>
        <div class="stat-value">186</div>
      </div>
      <div class="stat-card" onclick="openStatModal('urgences')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
        <div class="stat-label">Urgences traitées</div>
        <div class="stat-value">42</div>
      </div>
      <div class="stat-card" onclick="openStatModal('revenu')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
        <div class="stat-label">Revenu Mensuel (Est.)</div>
        <div class="stat-value">2.4M</div>
      </div>
    </div>

    <!-- DASHBOARD GRID -->
    <div class="dashboard-grid">

      <!-- DERNIÈRES URGENCES -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Dernières Urgences</span>
          <span class="urgence-badge">Prioritaire</span>
        </div>
        <div>
          <div class="urgence-row">
            <div>
              <div class="urg-id">Urg-#9001</div>
              <div class="urg-meta">Accident Domestique • Il y a 12 min</div>
            </div>
            <button class="btn-attribuer" onclick="alert('Attribution de Urg-#9001 à un médecin disponible...')">Attribuer</button>
          </div>
          <div class="urgence-row">
            <div>
              <div class="urg-id">Urg-#9002</div>
              <div class="urg-meta">Malaise cardiaque • Il y a 28 min</div>
            </div>
            <button class="btn-attribuer" onclick="alert('Attribution de Urg-#9002 à un médecin disponible...')">Attribuer</button>
          </div>
          <div class="urgence-row">
            <div>
              <div class="urg-id">Urg-#9003</div>
              <div class="urg-meta">Détresse respiratoire • Il y a 1h</div>
            </div>
            <button class="btn-attribuer" onclick="alert('Attribution de Urg-#9003 à un médecin disponible...')">Attribuer</button>
          </div>
        </div>
      </div>

      <!-- STATUT DES MÉDECINS -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Statut des Médecins</span>
          <a href="{{ route('hopital.medecins') }}" class="card-action">Voir tout</a>
        </div>
        <div>
          <div class="doc-row">
            <div class="doc-info">
              <div class="doc-av" style="background:#dbeafe;color:#2563eb">EM</div>
              <div class="doc-name">Dr. Esther Mensah</div>
            </div>
            <div class="doc-status"><div class="status-dot" style="background:#f97316"></div>En consultation</div>
          </div>
          <div class="doc-row">
            <div class="doc-info">
              <div class="doc-av" style="background:#dcfce7;color:#16a34a">KZ</div>
              <div class="doc-name">Dr. Kodjo Zinsou</div>
            </div>
            <div class="doc-status"><div class="status-dot" style="background:#22c55e"></div>Libre</div>
          </div>
          <div class="doc-row">
            <div class="doc-info">
              <div class="doc-av" style="background:#f1f5f9;color:#64748b">MB</div>
              <div class="doc-name">Dr. Mariam Bio</div>
            </div>
            <div class="doc-status"><div class="status-dot" style="background:#94a3b8"></div>En pause</div>
          </div>
          <div class="doc-row">
            <div class="doc-info">
              <div class="doc-av" style="background:#eff6ff;color:#2563eb">BL</div>
              <div class="doc-name">Dr. Blaise Lawson</div>
            </div>
            <div class="doc-status"><div class="status-dot" style="background:#22c55e"></div>Libre</div>
          </div>
          <div class="doc-row">
            <div class="doc-info">
              <div class="doc-av" style="background:#fef9c3;color:#a16207">FK</div>
              <div class="doc-name">Dr. Fatou Kpodo</div>
            </div>
            <div class="doc-status"><div class="status-dot" style="background:#f97316"></div>En consultation</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ── MODAL STAT ── -->
<div class="modal-overlay" id="stat-modal">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-title" id="modal-title"></div>
      </div>
      <button class="modal-close" onclick="closeStatModal()"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="modal-body" id="modal-body"></div>
    <button class="modal-confirm-btn" onclick="closeStatModal()">Fermer</button>
  </div>
</div>

<!-- ── MODAL AJOUTER MÉDECIN ── -->
<div class="modal-overlay" id="add-doctor-modal">
  <div class="modal" style="max-width:500px">
    <div class="modal-header">
      <div>
        <div class="modal-title">Ajouter un Médecin</div>
        <div class="modal-sub">Formulaire interne de l'établissement</div>
      </div>
      <button class="modal-close" onclick="document.getElementById('add-doctor-modal').classList.remove('open')"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <form onsubmit="submitDoctor(event)">
      <div class="form-group">
        <label class="form-label">Nom complet</label>
        <input type="text" class="form-input" placeholder="Ex: Dr. Marc Koffi" required>
      </div>
      <div class="form-group">
        <label class="form-label">Spécialité</label>
        <input type="text" class="form-input" placeholder="Ex: Cardiologue" required>
      </div>
      <div class="form-group">
        <label class="form-label">Email professionnel</label>
        <input type="email" class="form-input" placeholder="dr.koffi@hopital.bj" required>
      </div>
      <button type="submit" style="width:100%;padding:14px;background:#2563eb;color:#fff;border:none;border-radius:14px;font-size:15px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;margin-top:4px">
        Créer le compte médecin
      </button>
    </form>
  </div>
</div>

<script>
const statData = {
  medecins: { title:'Médecins Actifs', body:'Liste des médecins : Dr. Mensah, Dr. Zinsou, Dr. Bio, Dr. Lawson, etc.' },
  rdv: { title:'Rendez-vous / Semaine', body:"Répartition : Lundi (32), Mardi (45), Mercredi (28), Jeudi (41), Vendredi (40)." },
  urgences: { title:'Urgences traitées', body:"Dernières 24h : 12 cas d'accidents, 8 détresses respiratoires, 22 consultations prioritaires." },
  revenu: { title:'Revenu Mensuel (Est.)', body:"Estimation basée sur les consultations validées et les forfaits d'urgence (F CFA)." },
};

function openStatModal(key) {
  document.getElementById('modal-title').textContent = statData[key].title;
  document.getElementById('modal-body').textContent = statData[key].body;
  document.getElementById('stat-modal').classList.add('open');
}
function closeStatModal() { document.getElementById('stat-modal').classList.remove('open'); }

function submitDoctor(e) {
  e.preventDefault();
  document.getElementById('add-doctor-modal').classList.remove('open');
  alert('Le compte médecin a été créé avec succès.');
}

document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));
</script>
</body>
</html>
