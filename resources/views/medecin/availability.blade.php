<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dokita — Gestion des Disponibilités</title>
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

/* ── AVAILABILITY ── */
.availability-container{background:#fff;border-radius:24px;border:1px solid #f1f5f9;padding:24px;margin-bottom:24px}
.av-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.av-title{font-size:16px;font-weight:700;color:#0f172a}
.av-subtitle{font-size:12px;color:#64748b}
.day-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:12px;margin-bottom:20px}
.day-card{background:#f8fafc;border-radius:16px;padding:16px;text-align:center;border:1px solid #f1f5f9}
.day-name{font-size:12px;font-weight:600;color:#64748b;margin-bottom:8px}
.day-slots{display:flex;flex-direction:column;gap:4px}
.slot{display:flex;align-items:center;gap:6px;padding:6px 8px;background:#fff;border-radius:8px;font-size:11px;color:#1e293b;border:1px solid #e2e8f0}
.slot.active{background:#dbeafe;border-color:#bfdbfe;color:#2563eb}
.slot-checkbox{margin-right:4px}
.time-inputs{display:flex;gap:12px;margin-top:16px}
.time-group{display:flex;flex-direction:column;gap:4px}
.time-label{font-size:12px;font-weight:600;color:#374151}
.time-input{padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px}
.save-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#2563eb;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;margin-top:20px}
.save-btn:hover{background:#1d4ed8}
</style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
<div class="sb-brand">
<div class="sb-brand-icon">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M2 17L12 22L22 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</div>
<div class="sb-brand-name">Dokita</div>
</div>
<div class="sb-profile">
<div class="doc-av">Dr</div>
<div class="doc-name">Dr. Dupont</div>
<div class="doc-spec">Cardiologue</div>
<div class="doc-status">
<div class="status-dot" style="background:#10b981"></div>
En ligne
</div>
</div>
<div class="sb-nav">
<div class="nav-section">Navigation</div>
<a href="#" class="nav-link">
<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3 7V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V7M3 7V19C3 19.5304 3.21071 20.0391 3.58579 20.4142C3.96086 20.7893 4.46957 21 5 21H19C19.5304 21 20.0391 20.7893 20.4142 20.4142C20.7893 19.5304 21 19 21 19V7M3 7H21M16 14H16.01M16 17H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Tableau de bord
</a>
<a href="#" class="nav-link active">
<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8 7V3M16 7V3M7 11H17M5 21H19C19.5304 21 20.0391 20.7893 20.4142 20.4142C20.7893 20.0391 21 19.5304 21 19V7C21 6.46957 20.7893 5.96086 20.4142 5.58579C20.0391 5.21071 19.5304 5 19 5H5C4.46957 5 3.96086 5.21071 3.58579 5.58579C3.21071 5.96086 3 6.46957 3 7V19C3 19.5304 3.21071 20.0391 3.58579 20.4142C3.96086 20.7893 4.46957 21 5 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Disponibilités
</a>
<a href="#" class="nav-link">
<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.1046 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Rendez-vous
</a>
<a href="#" class="nav-link">
<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16 7C16 5.34315 14.6569 4 13 4H11C9.34315 4 8 5.34315 8 7V9H16V7ZM14 11V13C14 13.5523 13.5523 14 13 14C12.4477 14 12 13.5523 12 13V11H14ZM10 11V13C10 13.5523 9.55228 14 9 14C8.44772 14 8 13.5523 8 13V11H10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Patients
</a>
</div>
<div class="sb-bottom">
<button class="logout-btn">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17 16L21 12M21 12L17 8M21 12H9M13 16V17C13 17.5304 12.7893 18.0391 12.4142 18.4142C12.0391 18.7893 11.5304 19 11 19H7C6.46957 19 5.96086 18.7893 5.58579 18.4142C5.21071 17.5304 5 17 5 16V8C5 7.46957 5.21071 6.96086 5.58579 6.58579C5.96086 6.21071 6.46957 6 7 6H11C11.5304 6 12.0391 6.21071 12.4142 6.58579C12.7893 6.96086 13 7.46957 13 8V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Déconnexion
</button>
</div>
</div>

<!-- Main Content -->
<div class="main">
<div class="topbar">
<div>
<div class="page-title">Gestion des Disponibilités</div>
<div class="page-sub">Configurez vos horaires de consultation</div>
</div>
<div class="tb-actions">
<button class="btn-status">
<div class="status-dot" style="background:#10b981"></div>
Disponible
</button>
<a href="#" class="btn-settings">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.325 4.317C10.751 2.561 13.249 2.561 13.675 4.317C13.956 5.522 15.346 6.156 16.501 5.517C18.129 4.581 19.871 6.323 18.935 7.951C18.296 9.106 18.962 10.496 20.167 10.777C21.923 11.203 21.923 13.701 20.167 14.127C18.962 14.408 18.296 15.798 18.935 16.953C19.871 18.581 18.129 20.323 16.501 19.387C15.346 18.748 13.956 19.382 13.675 20.587C13.249 22.343 10.751 22.343 10.325 20.587C10.044 19.382 8.654 18.748 7.499 19.387C5.871 20.323 4.129 18.581 5.065 16.953C5.704 15.798 5.038 14.408 3.833 14.127C2.077 13.701 2.077 11.203 3.833 10.777C5.038 10.496 5.704 9.106 5.065 7.951C4.129 6.323 5.871 4.581 7.499 5.517C8.654 6.156 10.044 5.522 10.325 4.317Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Paramètres
</a>
</div>
</div>

<div class="content">
<div class="availability-container">
<div class="av-header">
<div>
<div class="av-title">Disponibilités de la semaine</div>
<div class="av-subtitle">Sélectionnez vos créneaux horaires pour chaque jour</div>
</div>
</div>

<div class="day-grid">
<div class="day-card">
<div class="day-name">Lundi</div>
<div class="day-slots">
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
08:00 - 12:00
</label>
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
14:00 - 18:00
</label>
</div>
</div>

<div class="day-card">
<div class="day-name">Mardi</div>
<div class="day-slots">
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
08:00 - 12:00
</label>
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
14:00 - 18:00
</label>
</div>
</div>

<div class="day-card">
<div class="day-name">Mercredi</div>
<div class="day-slots">
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
08:00 - 12:00
</label>
<label class="slot">
<input type="checkbox" class="slot-checkbox">
14:00 - 18:00
</label>
</div>
</div>

<div class="day-card">
<div class="day-name">Jeudi</div>
<div class="day-slots">
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
08:00 - 12:00
</label>
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
14:00 - 18:00
</label>
</div>
</div>

<div class="day-card">
<div class="day-name">Vendredi</div>
<div class="day-slots">
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
08:00 - 12:00
</label>
<label class="slot">
<input type="checkbox" class="slot-checkbox" checked>
14:00 - 18:00
</label>
</div>
</div>

<div class="day-card">
<div class="day-name">Samedi</div>
<div class="day-slots">
<label class="slot">
<input type="checkbox" class="slot-checkbox">
09:00 - 13:00
</label>
</div>
</div>

<div class="day-card">
<div class="day-name">Dimanche</div>
<div class="day-slots">
<div style="font-size:11px;color:#94a3b8;padding:6px 8px;">Fermé</div>
</div>
</div>
</div>

<div class="time-inputs">
<div class="time-group">
<label class="time-label">Durée de consultation (minutes)</label>
<input type="number" class="time-input" value="30" min="15" max="120">
</div>
<div class="time-group">
<label class="time-label">Pause entre consultations (minutes)</label>
<input type="number" class="time-input" value="5" min="0" max="30">
</div>
</div>

<button class="save-btn">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5 13L9 17L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Enregistrer les modifications
</button>
</div>
</div>
</div>
</body>
</html>