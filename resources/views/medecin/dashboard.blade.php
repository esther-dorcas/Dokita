<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dokita — Espace Médecin</title>
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
.sb-profile{padding:16px 20px;border-bottom:1px solid #f1f5f9}
.doc-av{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#0891b2);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:14px;margin-bottom:10px}
.doc-name{font-size:13px;font-weight:700;color:#0f172a}
.doc-spec{font-size:11px;color:#2563eb;font-weight:600;margin-top:1px}
.doc-status{display:flex;align-items:center;gap:5px;font-size:11px;color:#64748b;margin-top:4px}
.status-dot{width:7px;height:7px;border-radius:50%}
.sb-nav{padding:12px 10px;flex:1;overflow-y:auto}
.nav-section{font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;padding:0 10px;margin-top:14px;margin-bottom:6px}
.nav-link{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:10px;font-size:13px;font-weight:500;color:#64748b;text-decoration:none;transition:.15s}
.nav-link:hover{background:#f8fafc;color:#1e293b}
.nav-link.active{background:#eff6ff;color:#2563eb;font-weight:600}
.nav-link.active svg{color:#2563eb}
.nav-link svg{width:16px;height:16px;flex-shrink:0;color:#94a3b8}
.nav-badge{margin-left:auto;background:#ef4444;color:#fff;border-radius:20px;padding:1px 7px;font-size:10px;font-weight:700}
.sb-bottom{padding:12px;border-top:1px solid #f1f5f9}
.logout-btn{display:flex;align-items:center;gap:9px;padding:9px 12px;border-radius:10px;font-size:13px;color:#64748b;text-decoration:none;width:100%;border:none;background:none;cursor:pointer;font-family:'Inter',sans-serif}
.logout-btn:hover{background:#fef2f2;color:#ef4444}

/* ── MAIN ── */
.main{flex:1;margin-left:256px;display:flex;flex-direction:column;min-height:100vh}
.topbar{background:#fff;border-bottom:1px solid #f1f5f9;padding:0 28px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.tb-actions{display:flex;gap:10px;align-items:center}
.btn-status{display:flex;align-items:center;gap:8px;padding:8px 16px;background:#fff;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;font-weight:600;color:#1e293b;cursor:pointer;font-family:'Inter',sans-serif;box-shadow:0 1px 2px rgba(0,0,0,.04)}
.btn-status:hover{background:#f8fafc}
.btn-settings{display:flex;align-items:center;gap:6px;padding:8px 16px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;font-size:13px;font-weight:600;color:#2563eb;cursor:pointer;font-family:'Inter',sans-serif;text-decoration:none}
.btn-settings:hover{background:#dbeafe}
.page-title{font-size:18px;font-weight:700;color:#0f172a}
.page-sub{font-size:12px;color:#64748b;margin-top:2px}
.content{padding:24px 28px;flex:1}

/* ── STATS ── */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.stat-card{background:#fff;border-radius:24px;border:1px solid #f1f5f9;padding:20px;cursor:pointer;transition:all .2s;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.stat-card:hover{border-color:#bfdbfe;box-shadow:0 4px 16px rgba(37,99,235,.1);transform:translateY(-2px)}
.stat-icon{width:44px;height:44px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;transition:.2s}
.stat-card:hover .stat-icon{background:#dbeafe}
.stat-icon svg{width:22px;height:22px;color:#2563eb}
.stat-label{font-size:12px;font-weight:500;color:#64748b}
.stat-bottom{display:flex;align-items:flex-end;justify-content:space-between;margin-top:4px}
.stat-value{font-size:24px;font-weight:700;color:#0f172a}
.stat-badge{font-size:11px;font-weight:700;color:#16a34a;background:#f0fdf4;padding:3px 8px;border-radius:8px}

/* ── LAYOUT 2/3 + 1/3 ── */
.dashboard-grid{display:grid;grid-template-columns:1fr 320px;gap:20px}
.card{background:#fff;border-radius:24px;border:1px solid #f1f5f9;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.card-header{padding:18px 22px;border-bottom:1px solid #f8fafc;display:flex;justify-content:space-between;align-items:center}
.card-title{font-size:15px;font-weight:700;color:#0f172a}
.card-header svg{width:18px;height:18px;color:#2563eb}

/* ── PLANNING ── */
.planning-row{display:flex;align-items:center;justify-content:space-between;padding:16px 22px;transition:.15s;border-bottom:1px solid #f8fafc}
.planning-row:last-child{border-bottom:none}
.planning-row:hover{background:#fafcff}
.planning-time{font-size:16px;font-weight:800;color:#0c2340;min-width:54px}
.planning-divider{width:1px;height:38px;background:#e2e8f0;margin:0 16px;flex-shrink:0}
.planning-patient{font-size:14px;font-weight:700;color:#0f172a}
.planning-type{font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-top:2px}
.planning-right{display:flex;align-items:center;gap:12px}
.badge{padding:4px 10px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase}
.badge-green{background:#f0fdf4;color:#16a34a}
.badge-red{background:#fef2f2;color:#ef4444}
.btn-detail{width:32px;height:32px;border-radius:8px;border:none;background:#f8fafc;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:.15s}
.btn-detail:hover{background:#eff6ff}
.btn-detail svg{width:16px;height:16px;color:#94a3b8}
.btn-detail:hover svg{color:#2563eb}

/* ── RAPPELS ── */
.rappel-item{display:flex;align-items:flex-start;gap:10px;padding:12px;border-radius:14px;transition:.15s;cursor:pointer;border:1px solid transparent}
.rappel-item:hover{background:#f8fafc;border-color:#f1f5f9}
.rappel-ico{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.rappel-ico svg{width:16px;height:16px}
.rappel-title{font-size:13px;font-weight:700;color:#0f172a}
.rappel-msg{font-size:11px;color:#64748b;margin-top:2px;line-height:1.4}

/* ── CTA CARD ── */
.cta-card{background:#0c2340;border-radius:24px;padding:24px;color:#fff;margin-top:16px}
.cta-title{font-size:17px;font-weight:700;margin-bottom:8px}
.cta-sub{font-size:13px;color:#93c5fd;line-height:1.6;margin-bottom:20px}
.cta-btn{display:block;width:100%;padding:14px;background:#fff;color:#0c2340;border-radius:14px;font-size:14px;font-weight:700;text-align:center;text-decoration:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s;box-shadow:0 4px 12px rgba(0,0,0,.2)}
.cta-btn:hover{background:#eff6ff}

/* ── MODAL ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(12,35,64,.25);backdrop-filter:blur(4px);z-index:200;align-items:center;justify-content:center;padding:20px}
.modal-overlay.open{display:flex}
.modal{background:#fff;border-radius:32px;padding:32px;max-width:440px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.15);border:1px solid #bfdbfe}
.modal-icon{width:48px;height:48px;background:#eff6ff;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px}
.modal-icon svg{width:24px;height:24px;color:#2563eb}
.modal-close{width:36px;height:36px;border-radius:50%;border:none;background:#f1f5f9;cursor:pointer;display:flex;align-items:center;justify-content:center;float:right}
.modal-close svg{width:16px;height:16px;color:#64748b}
.modal-title{font-size:20px;font-weight:700;color:#0c2340;margin-bottom:10px;clear:both}
.modal-body{font-size:14px;color:#64748b;line-height:1.7;margin-bottom:16px}
.modal-items{display:flex;flex-direction:column;gap:8px;margin-bottom:24px}
.modal-item{display:flex;align-items:center;gap:10px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:12px 14px;font-size:13px;font-weight:700;color:#1e4976}
.modal-item svg{width:16px;height:16px;color:#2563eb;flex-shrink:0}
.modal-confirm-btn{width:100%;padding:14px;background:#2563eb;color:#fff;border:none;border-radius:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
.modal-confirm-btn:hover{background:#1d4ed8}

/* Appointment modal */
.appt-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px}
.appt-av{width:56px;height:56px;background:#eff6ff;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:#2563eb;flex-shrink:0}
.appt-name{font-size:20px;font-weight:700;color:#0f172a;margin-bottom:2px}
.appt-meta{font-size:13px;font-weight:600;color:#2563eb}
.appt-info-box{background:#f8fafc;border-radius:20px;padding:18px;margin-bottom:16px}
.appt-info-row{display:flex;align-items:center;gap:10px;font-size:13px;font-weight:600;color:#374151;margin-bottom:12px}
.appt-info-row:last-child{margin-bottom:0}
.appt-info-row svg{width:18px;height:18px;color:#94a3b8}
.motif-label{font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px}
.motif-text{font-size:13px;color:#374151;line-height:1.6;background:#eff6ff;padding:14px;border-radius:14px;border:1px solid #bfdbfe}
.appt-actions{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:20px}
.btn-cancel-appt{padding:14px;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;border-radius:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
.btn-cancel-appt:hover{background:#fee2e2}
.btn-accept-appt{padding:14px;background:#2563eb;color:#fff;border:none;border-radius:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.15s}
.btn-accept-appt:hover{background:#1d4ed8}
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

  <div class="sb-profile">
    <div class="doc-av">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
    <div class="doc-name">Dr. {{ Auth::user()->name }}</div>
    <div class="doc-spec">Médecin</div>
    <div class="doc-status">
      <div class="status-dot" id="sidebar-dot" style="background:#22c55e"></div>
      <span id="sidebar-status-text">Disponible</span>
    </div>
  </div>

  <nav class="sb-nav">
    <div class="nav-section">Planning</div>
    <a href="{{ route('medecin.dashboard') }}" class="nav-link active">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Tableau de bord
    </a>
    <a href="{{ route('medecin.rdv') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Mes rendez-vous
      <span class="nav-badge">5</span>
    </a>
    <a href="{{ route('medecin.planning') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Mon planning
    </a>
    <a href="#" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
      </svg>
      Consultations vidéo
    </a>
    <div class="nav-section">Compte</div>
    <a href="{{ route('medecin.profil') }}" class="nav-link">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Mon profil
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
      <div class="page-title">Bienvenue, Dr. {{ Auth::user()->name }} 🩺</div>
      <div class="page-sub">Vous avez 3 rendez-vous prévus pour aujourd'hui.</div>
    </div>
    <div class="tb-actions">
      <button class="btn-status" onclick="toggleStatus(this)">
        <div class="status-dot" id="topbar-dot" style="background:#22c55e;animation:pulse 2s infinite"></div>
        <span id="topbar-status-text">Statut : Disponible</span>
      </button>
      <a href="{{ route('medecin.profil') }}" class="btn-settings">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
        Paramètres
      </a>
    </div>
  </header>

  <div class="content">

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card" onclick="openStatModal('rdv')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        <div class="stat-label">RDV Aujourd'hui</div>
        <div class="stat-bottom"><span class="stat-value">8</span><span class="stat-badge">+2</span></div>
      </div>
      <div class="stat-card" onclick="openStatModal('patients')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div class="stat-label">Patients Totaux</div>
        <div class="stat-bottom"><span class="stat-value">245</span><span class="stat-badge">+15</span></div>
      </div>
      <div class="stat-card" onclick="openStatModal('satisfaction')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <div class="stat-label">Satisfaction</div>
        <div class="stat-bottom"><span class="stat-value">4.9/5</span><span class="stat-badge" style="background:#eff6ff;color:#2563eb">↔ 0.0</span></div>
      </div>
      <div class="stat-card" onclick="openStatModal('temps')">
        <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div class="stat-label">Temps Moyen</div>
        <div class="stat-bottom"><span class="stat-value">25 min</span><span class="stat-badge">-5 min</span></div>
      </div>
    </div>

    <!-- DASHBOARD GRID -->
    <div class="dashboard-grid">

      <!-- PLANNING DU JOUR -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Planning du jour</span>
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
          <div class="planning-row" onclick="openApptModal('Imourane Alimi','09:00','Consultation Générale','confirmé','Fièvre persistante depuis 3 jours, maux de tête.','+229 90 00 00 01','28 ans')">
            <div style="display:flex;align-items:center;flex:1">
              <div class="planning-time">09:00</div>
              <div class="planning-divider"></div>
              <div><div class="planning-patient">Imourane Alimi</div><div class="planning-type">Consultation Générale</div></div>
            </div>
            <div class="planning-right">
              <span class="badge badge-green">Confirmé</span>
              <button class="btn-detail"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
            </div>
          </div>
          <div class="planning-row" onclick="openApptModal('Mariette Dossou','10:30','Contrôle tension','confirmé','Suivi post-traitement hypertension, contrôle routine.','+229 90 00 00 02','54 ans')">
            <div style="display:flex;align-items:center;flex:1">
              <div class="planning-time">10:30</div>
              <div class="planning-divider"></div>
              <div><div class="planning-patient">Mariette Dossou</div><div class="planning-type">Contrôle tension</div></div>
            </div>
            <div class="planning-right">
              <span class="badge badge-green">Confirmé</span>
              <button class="btn-detail"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
            </div>
          </div>
          <div class="planning-row" onclick="openApptModal('Sébastien Houngbo','14:00','Vaccination','confirmé','Rappel vaccin hépatite B.','+229 90 00 00 03','12 ans')">
            <div style="display:flex;align-items:center;flex:1">
              <div class="planning-time">14:00</div>
              <div class="planning-divider"></div>
              <div><div class="planning-patient">Sébastien Houngbo</div><div class="planning-type">Vaccination</div></div>
            </div>
            <div class="planning-right">
              <span class="badge badge-green">Confirmé</span>
              <button class="btn-detail"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
            </div>
          </div>
          <div class="planning-row" onclick="openApptModal('Yasmine Bio','15:30','Suivi post-op','annulé','Contrôle cicatrisation après appendicectomie.','+229 90 00 00 04','32 ans')">
            <div style="display:flex;align-items:center;flex:1">
              <div class="planning-time" style="color:#94a3b8">15:30</div>
              <div class="planning-divider"></div>
              <div><div class="planning-patient" style="color:#94a3b8;text-decoration:line-through">Yasmine Bio</div><div class="planning-type">Suivi post-op</div></div>
            </div>
            <div class="planning-right">
              <span class="badge badge-red">Annulé</span>
              <button class="btn-detail"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
            </div>
          </div>
        </div>
      </div>

      <!-- SIDEBAR DROITE -->
      <div>
        <!-- Rappels -->
        <div class="card" style="padding:20px">
          <div class="card-title" style="margin-bottom:16px">Prochains Rappels</div>
          <div style="display:flex;flex-direction:column;gap:4px">
            <div class="rappel-item">
              <div class="rappel-ico" style="background:#fff7ed"><svg fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg></div>
              <div>
                <div class="rappel-title">Patient #001</div>
                <div class="rappel-msg">Suivi post-traitement de Mme Dossou.</div>
              </div>
            </div>
            <div class="rappel-item">
              <div class="rappel-ico" style="background:#eff6ff"><svg fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg></div>
              <div>
                <div class="rappel-title">Patient #002</div>
                <div class="rappel-msg">Vérifier résultats d'analyses de M. Alimi.</div>
              </div>
            </div>
            <div class="rappel-item">
              <div class="rappel-ico" style="background:#f0fdf4"><svg fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg></div>
              <div>
                <div class="rappel-title">Patient #003</div>
                <div class="rappel-msg">Appel confirmation bloc opératoire.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="cta-card">
          <div class="cta-title">Gérer vos dispos</div>
          <p class="cta-sub">Mettez à jour vos créneaux pour permettre aux patients de réserver.</p>
          <a href="{{ route('medecin.planning') }}" class="cta-btn">Ouvrir le calendrier</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ── MODAL STAT ── -->
<div class="modal-overlay" id="stat-modal">
  <div class="modal">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px">
      <div class="modal-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="modal-icon-svg"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
      <button class="modal-close" onclick="closeStatModal()"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="modal-title" id="modal-title"></div>
    <div class="modal-body" id="modal-body"></div>
    <div class="modal-items" id="modal-items"></div>
    <button class="modal-confirm-btn" onclick="closeStatModal()">Fermer</button>
  </div>
</div>

<!-- ── MODAL APPOINTMENT ── -->
<div class="modal-overlay" id="appt-modal">
  <div class="modal" style="max-width:480px">
    <div class="appt-header">
      <div style="display:flex;align-items:center;gap:14px">
        <div class="appt-av" id="appt-av"></div>
        <div>
          <div class="appt-name" id="appt-name"></div>
          <div class="appt-meta" id="appt-meta"></div>
        </div>
      </div>
      <button class="modal-close" onclick="closeApptModal()"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="appt-info-box">
      <div class="appt-info-row"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg><span id="appt-time-label"></span></div>
      <div class="appt-info-row"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg><span id="appt-type-label"></span></div>
    </div>
    <div class="motif-label">Motif de consultation</div>
    <div class="motif-text" id="appt-reason"></div>
    <div class="appt-actions">
      <button class="btn-cancel-appt" onclick="closeApptModal()">Annuler le RDV</button>
      <button class="btn-accept-appt" onclick="closeApptModal()">Accepter</button>
    </div>
  </div>
</div>

<style>@keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}</style>
<script>
const statData = {
  rdv: { title:'Détails des Rendez-vous', body:"Vous avez 8 rendez-vous prévus aujourd'hui, dont 5 le matin et 3 l'après-midi.", items:['Consultations : 6','Interventions : 1','Urgences : 1'] },
  patients: { title:'Base de Patients', body:'Votre base de patients a grandi de 6% ce mois-ci.', items:['Nouveaux patients : +15','Patients récurrents : 180','Moyenne d\'âge : 34 ans'] },
  satisfaction: { title:'Retours Patients', body:'Basé sur les 50 derniers avis laissés après consultation.', items:['Ponctualité : 4.8/5','Écoute : 5.0/5','Qualité des soins : 4.9/5'] },
  temps: { title:"Efficacité du Cabinet", body:'Temps moyen par consultation pour optimiser votre flux de travail.', items:['Préparation : 5 min','Examen : 15 min','Rédaction : 5 min'] },
};

function openStatModal(key) {
  const d = statData[key];
  document.getElementById('modal-title').textContent = d.title;
  document.getElementById('modal-body').textContent = d.body;
  document.getElementById('modal-items').innerHTML = d.items.map(i => `
    <div class="modal-item"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>${i}</div>
  `).join('');
  document.getElementById('stat-modal').classList.add('open');
}
function closeStatModal() { document.getElementById('stat-modal').classList.remove('open'); }

function openApptModal(name, time, type, status, reason, phone, age) {
  document.getElementById('appt-av').textContent = name.charAt(0);
  document.getElementById('appt-name').textContent = name;
  document.getElementById('appt-meta').textContent = age + ' • ' + phone;
  document.getElementById('appt-time-label').textContent = "Aujourd'hui à " + time;
  document.getElementById('appt-type-label').textContent = type;
  document.getElementById('appt-reason').textContent = reason;
  document.getElementById('appt-modal').classList.add('open');
}
function closeApptModal() { document.getElementById('appt-modal').classList.remove('open'); }

let isAvailable = true;
function toggleStatus(btn) {
  isAvailable = !isAvailable;
  const dot1 = document.getElementById('topbar-dot');
  const dot2 = document.getElementById('sidebar-dot');
  const txt1 = document.getElementById('topbar-status-text');
  const txt2 = document.getElementById('sidebar-status-text');
  const color = isAvailable ? '#22c55e' : '#ef4444';
  dot1.style.background = color;
  dot2.style.background = color;
  txt1.textContent = 'Statut : ' + (isAvailable ? 'Disponible' : 'Indisponible');
  txt2.textContent = isAvailable ? 'Disponible' : 'Indisponible';
}

document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) { o.classList.remove('open'); } }));
</script>
</body>
</html>
