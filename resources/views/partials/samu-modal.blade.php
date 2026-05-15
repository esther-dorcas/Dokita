{{-- ══ BOUTON URGENCE FLOTTANT (Ouvre la Modale) ══ --}}
<button type="button" onclick="openSamuModal()" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; width: 65px; height: 65px; background-color: #dc2626; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(220,38,38,0.6); border: none; cursor: pointer; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
    <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
</button>

{{-- ══ MODALE SAMU ══ --}}
<div id="samuModal" class="fixed inset-0 hidden items-center justify-center px-4" style="z-index: 999999; background-color: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px);">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all" style="position: relative; z-index: 1000000;">
        <div class="bg-red-600 px-6 py-4 flex items-center justify-between">
            <h3 class="text-white font-black text-lg flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Alerter le SAMU (112)
            </h3>
            <button onclick="closeSamuModal()" class="text-white/80 hover:text-white transition" type="button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <form action="{{ route('urgence.publique') }}" method="POST" class="p-6" id="samuForm" onsubmit="submitSamuForm(event)">
            @csrf
            <p class="text-sm text-slate-500 mb-6 font-medium">Cette alerte sera envoyée directement aux services d'urgence avec votre position géographique exacte.</p>
            
            {{-- Status Géoloc --}}
            <div id="geolocStatus" class="mb-5 flex items-center gap-3 p-3 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-sm font-semibold">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Recherche de votre position exacte...
            </div>

            <input type="hidden" name="latitude" id="samu_lat" required>
            <input type="hidden" name="longitude" id="samu_lng" required>

            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nature de l'urgence *</label>
                <select name="description" required class="w-full border-slate-200 rounded-xl focus:border-red-500 focus:ring-red-500 bg-slate-50">
                    <option value="">Sélectionnez le type d'urgence</option>
                    <option value="Accident de la route">Accident de la route</option>
                    <option value="Malaise grave">Malaise grave (cardiaque, respiratoire...)</option>
                    <option value="Blessure / Chute">Blessure grave / Chute</option>
                    <option value="Incendie / Brûlure">Incendie / Brûlure</option>
                    <option value="Autre">Autre urgence vitale</option>
                </select>
            </div>

            <button type="submit" id="btnSubmitSamu" disabled class="w-full bg-slate-300 text-slate-500 cursor-not-allowed font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
                Alerter les secours
            </button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('samuModal');
    const statusBox = document.getElementById('geolocStatus');
    const btnSubmit = document.getElementById('btnSubmitSamu');
    const latInput = document.getElementById('samu_lat');
    const lngInput = document.getElementById('samu_lng');

    function openSamuModal() {
        modal.style.display = 'flex';
        // Lancer la géolocalisation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    latInput.value = position.coords.latitude;
                    lngInput.value = position.coords.longitude;
                    
                    statusBox.className = "mb-5 flex items-center gap-3 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-semibold";
                    statusBox.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Position exacte capturée avec succès.`;
                    
                    btnSubmit.disabled = false;
                    btnSubmit.className = "w-full bg-red-600 hover:bg-red-700 text-white font-black py-3 px-4 rounded-xl shadow-lg transition flex items-center justify-center gap-2";
                },
                function(error) {
                    statusBox.className = "mb-5 flex items-center gap-3 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm font-semibold";
                    statusBox.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Veuillez autoriser la localisation pour alerter le SAMU.`;
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            statusBox.innerHTML = "Votre navigateur ne supporte pas la géolocalisation.";
        }
    }

    function closeSamuModal() {
        modal.style.display = 'none';
    }

    async function submitSamuForm(event) {
        event.preventDefault();
        
        if (!latInput.value || !lngInput.value) {
            alert("La position géographique est obligatoire pour déclencher une alerte SAMU.");
            return;
        }

        const form = event.target;
        const formData = new FormData(form);
        const originalBtnText = btnSubmit.innerHTML;
        btnSubmit.innerHTML = 'Envoi de la position...';
        btnSubmit.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                // Remplacer le contenu du form par un message de succès
                form.innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="text-2xl font-black text-slate-900 mb-3">Alerte Transmise !</h4>
                        <p class="text-slate-600 font-medium mb-8 leading-relaxed">Le SAMU a reçu votre position exacte (GPS) et le motif de l'urgence. Les secours ont été dépêchés sur les lieux. <br><strong class="text-red-600">Restez calme et sécurisez la zone si possible.</strong></p>
                        <button type="button" onclick="closeSamuModal()" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-slate-800 transition shadow-lg">Fermer la fenêtre</button>
                    </div>
                `;
            } else {
                throw new Error('Erreur réseau');
            }
        } catch (error) {
            btnSubmit.innerHTML = originalBtnText;
            btnSubmit.disabled = false;
            alert('Une erreur est survenue lors de l\'envoi. Veuillez appeler directement le 112 par téléphone.');
        }
    }
</script>
