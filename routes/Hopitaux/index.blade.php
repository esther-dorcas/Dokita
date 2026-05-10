<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dokita — Trouver un hôpital</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap');
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Sora',sans-serif;background:#F4F8FE;color:#0D2B5E;min-height:100vh;display:flex;flex-direction:column}
:root{--navy:#0D2B5E;--blue:#1E7CE8;--teal:#00C896;--grad:linear-gradient(135deg,#1E7CE8,#00C896);--border:#D8E8F8;--muted:#5C7A9E;--bg:#F4F8FE;--light:#EAF4FE;--light-teal:#E0FAF3;--red:#E53935}
.nav{height:64px;background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 32px;flex-shrink:0}
.logo{display:flex;align-items:center;gap:10px}
.logo-icon{width:36px;height:36px;background:var(--grad);border-radius:11px;display:flex;align-items:center;justify-content:center}
.logo-text{font-size:22px;font-weight:700;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.nav-tabs{display:flex;gap:0;border:1px solid var(--border);border-radius:10px;overflow:hidden}
.nt{padding:8px 18px;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;background:#fff;border-right:1px solid var(--border);text-decoration:none;display:block}
.nt:last-child{border-right:none}
.nt.on{background:var(--light);color:var(--blue)}
.nav-r{display:flex;gap:10px;align-items:center}
.urgence-btn{display:flex;align-items:center;gap:7px;padding:9px 18px;background:#FEF2F2;color:var(--red);border:1.5px solid #FECACA;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;animation:pulse 2s infinite;text-decoration:none}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(229,57,53,.35)}50%{box-shadow:0 0 0 8px rgba(229,57,53,0)}}
.btn-rdv{padding:9px 18px;background:var(--grad);color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Sora',sans-serif}
.page-body{display:grid;grid-template-columns:380px 1fr;flex:1;overflow:hidden;height:calc(100vh - 64px)}
.left{background:#fff;border-right:1px solid var(--border);display:flex;flex-direction:column;overflow:hidden}
.search-zone{padding:18px;border-bottom:1px solid var(--border)}
.search-bar{display:flex;gap:8px;margin-bottom:12px}
.search-input{flex:1;padding:11px 16px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-family:'Sora',sans-serif;color:var(--navy);outline:none;background:#fff}
.search-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(30,124,232,.1)}
.search-btn{padding:11px 18px;background:var(--grad);color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Sora',sans-serif}
.filters{display:flex;gap:7px;flex-wrap:wrap}
.ftag{padding:5px 12px;border-radius:20px;font-size:11px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);color:var(--muted);background:#fff;transition:.15s;text-decoration:none;display:inline-block}
.ftag:hover{border-color:var(--blue);color:var(--blue)}
.ftag.on{background:var(--light);color:var(--blue);border-color:var(--blue)}
.ftag.urgence{background:#FEF2F2;color:var(--red);border-color:#FECACA}
.results-zone{flex:1;overflow-y:auto;padding:16px}
.rlabel{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px;display:flex;align-items:center;gap:6px}
.rcount{background:var(--grad);color:#fff;border-radius:20px;padding:2px 8px;font-size:10px}
.hcard{border-radius:14px;border:1.5px solid var(--border);margin-bottom:12px;overflow:hidden;cursor:pointer;transition:.2s;background:#fff}
.hcard:hover{border-color:var(--blue);box-shadow:0 4px 16px rgba(30,124,232,.1);transform:translateY(-1px)}
.hc-top{padding:14px 16px;display:flex;gap:12px}
.hc-ico{width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,var(--light),var(--light-teal));display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0}
.hc-info{flex:1}
.hc-name{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:3px}
.hc-specs{font-size:11px;color:var(--blue);font-weight:600;margin-bottom:4px}
.hc-meta{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.hc-open{font-size:11px;font-weight:700;color:var(--teal)}
.hc-time{font-size:11px;color:var(--muted)}
.hc-price{font-size:11px;color:var(--muted)}
.hc-dist{font-size:12px;font-weight:700;color:var(--blue);white-space:nowrap}
.hc-btns{padding:10px 14px;background:var(--bg);border-top:1px solid var(--border);display:flex;gap:8px}
.hb{flex:1;padding:8px;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;text-align:center;border:1.5px solid var(--border);background:#fff;color:var(--navy);font-family:'Sora',sans-serif;transition:.15s;text-decoration:none;display:block}
.hb:hover{border-color:var(--blue);color:var(--blue)}
.hb.rdv{background:var(--grad);color:#fff;border-color:transparent}
.hb.wa{background:#E8FDF4;color:#059669;border-color:#A7F3D0}
#map{flex:1;z-index:1}
.urgence-bar{position:absolute;bottom:0;left:380px;right:0;background:#fff;border-top:2px solid #FECACA;padding:14px 24px;display:flex;align-items:center;justify-content:space-between;z-index:15}
.ub-left{display:flex;align-items:center;gap:14px}
.ub-ico{width:44px;height:44px;border-radius:12px;background:#FEF2F2;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0}
.ub-title{font-size:14px;font-weight:700;color:var(--red)}
.ub-sub{font-size:11px;color:var(--muted);margin-top:2px}
.ub-btn{padding:11px 24px;background:linear-gradient(135deg,#E53935,#EF5350);color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Sora',sans-serif;box-shadow:0 4px 14px rgba(229,57,53,.3);animation:pulse 2s infinite;text-decoration:none}
</style>
</head>
<body>

<nav class="nav">
  <div class="logo">
    <div class="logo-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round">
        <path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>
      </svg>
    </div>
    <div class="logo-text">Dokita</div>
  </div>
  <div class="nav-tabs">
    <a href="{{ route('hopitaux.index') }}" class="nt on">Trouver un hôpital</a>
    <a href="{{ route('rdv.index') }}" class="nt">Mes rendez-vous</a>
    <a href="{{ route('profil.index') }}" class="nt">Mon profil</a>
  </div>
  <div class="nav-r">
    <a href="{{ route('urgence.index') }}" class="urgence-btn">⚡ Urgence médicale</a>
    <a href="{{ route('hopitaux.index') }}" class="btn-rdv">📅 Prendre RDV</a>
  </div>
</nav>

<div class="page-body" style="position:relative">
  {{-- PANNEAU GAUCHE --}}
  <div class="left">
    <div class="search-zone">
      <form method="GET" action="{{ route('hopitaux.index') }}">
        <div class="search-bar">
          <input class="search-input" type="text" name="q"
                 value="{{ $q }}"
                 placeholder="Hôpital, médecin, spécialité..."/>
          <button class="search-btn" type="submit">🔍 Chercher</button>
        </div>
        <div class="filters">
          <a href="{{ route('hopitaux.index') }}"
             class="ftag {{ !$specialite ? 'on' : '' }}">Toutes</a>
          @foreach($specialites as $spec)
            <a href="{{ route('hopitaux.index', ['specialite'=>$spec]) }}"
               class="ftag {{ $specialite==$spec ? 'on' : '' }}">
              {{ $spec }}
            </a>
          @endforeach
          <a href="{{ route('urgence.index') }}" class="ftag urgence">🚨 Urgences</a>
        </div>
      </form>
    </div>

    <div class="results-zone">
      <div class="rlabel">
        <span>Hôpitaux près de vous</span>
        <span class="rcount">{{ $hopitaux->count() }} résultat(s)</span>
      </div>

      @forelse($hopitaux as $h)
        <div class="hcard" onclick="focusHopital({{ $h->latitude }}, {{ $h->longitude }}, '{{ $h->nom }}')">
          <div class="hc-top">
            <div class="hc-ico">🏥</div>
            <div class="hc-info">
              <div class="hc-name">{{ $h->nom }}</div>
              <div class="hc-specs">
                {{ $h->specialites->pluck('nom_specialite')->take(3)->join(' · ') }}
              </div>
              <div class="hc-meta">
                <div class="hc-open">● {{ $h->isOuvert() ? 'Ouvert' : 'Fermé' }}</div>
                <div class="hc-time">{{ $h->horaires }}</div>
                <div class="hc-price">Dès {{ number_format($h->tarifMin(), 0, ',', ' ') }} FCFA</div>
              </div>
            </div>
          </div>
          <div class="hc-btns">
            <a href="{{ route('hopitaux.show', $h->id) }}" class="hb rdv">📅 Prendre RDV</a>
            @if($h->whatsapp)
              <a href="https://wa.me/{{ $h->whatsapp }}" target="_blank" class="hb wa">📱 WhatsApp</a>
            @endif
            <a href="{{ route('hopitaux.show', $h->id) }}" class="hb">Voir fiche</a>
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:40px 20px;color:var(--muted)">
          <div style="font-size:48px;margin-bottom:12px">🏥</div>
          <div style="font-size:14px;font-weight:600">Aucun hôpital trouvé</div>
          <a href="{{ route('hopitaux.index') }}" style="color:var(--blue);font-size:13px">Voir tous les hôpitaux</a>
        </div>
      @endforelse
    </div>
  </div>

  {{-- CARTE LEAFLET --}}
  <div id="map"></div>

  {{-- BARRE URGENCE --}}
  <div class="urgence-bar">
    <div class="ub-left">
      <div class="ub-ico">🚨</div>
      <div>
        <div class="ub-title">Signaler une urgence médicale</div>
        <div class="ub-sub">Votre localisation est transmise automatiquement · Orientation immédiate</div>
      </div>
    </div>
    <a href="{{ route('urgence.index') }}" class="ub-btn">⚡ Signaler une urgence maintenant</a>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([6.3654, 2.4183], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

// Marqueur position utilisateur
const userIcon = L.divIcon({
    html: '<div style="width:16px;height:16px;border-radius:50%;background:#1E7CE8;border:3px solid #fff;box-shadow:0 0 0 4px rgba(30,124,232,.25)"></div>',
    iconSize: [16,16], iconAnchor: [8,8], className: ''
});

// Marqueur hôpital
const hospIcon = L.divIcon({
    html: `<div style="width:34px;height:34px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);background:#1E7CE8;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,.2)"><div style="width:13px;height:13px;background:#fff;border-radius:50%;transform:rotate(45deg)"></div></div>`,
    iconSize: [34,34], iconAnchor: [17,34], className: ''
});

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos => {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        L.marker([lat, lng], {icon: userIcon}).addTo(map)
            .bindPopup('<b>📍 Votre position</b>');
        map.setView([lat, lng], 14);
    });
}

// Ajouter les marqueurs des hôpitaux
const hopitaux = @json($hopitaux);
hopitaux.forEach(h => {
    if (h.latitude && h.longitude) {
        L.marker([h.latitude, h.longitude], {icon: hospIcon})
            .addTo(map)
            .bindPopup(`
                <div style="font-family:'Sora',sans-serif;min-width:180px">
                    <div style="font-weight:700;color:#0D2B5E;margin-bottom:4px">${h.nom}</div>
                    <div style="font-size:11px;color:#5C7A9E;margin-bottom:8px">${h.adresse}</div>
                    <a href="/hopitaux/${h.id}"
                       style="display:block;padding:7px;background:linear-gradient(135deg,#1E7CE8,#00C896);color:#fff;text-align:center;border-radius:7px;font-size:12px;font-weight:700;text-decoration:none">
                        📅 Prendre RDV
                    </a>
                </div>
            `);
    }
});

function focusHopital(lat, lng, nom) {
    map.setView([lat, lng], 15);
}
</script>
</body>
</html>