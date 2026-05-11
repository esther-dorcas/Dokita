@extends('layouts.medecin')

@section('title', 'Nouvelle ordonnance — Dokita PRO')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
    :root { --blue:#2563eb; --dark:#0c2340; }

    @keyframes fadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .animate-in { animation:fadeIn .35s ease-out }

    /* ── PAGE HEADER ── */
    .page-header {
        background:var(--dark); border-radius:20px;
        padding:24px 28px; margin-bottom:24px;
        display:flex; align-items:center; justify-content:space-between;
        position:relative; overflow:hidden;
    }
    .page-header::before { content:''; position:absolute; top:-50px; right:-50px; width:200px; height:200px; border-radius:50%; background:rgba(37,99,235,.15); pointer-events:none; }
    .ph-title { font-size:20px; font-weight:800; color:#fff; position:relative; z-index:1; }
    .ph-sub   { font-size:13px; color:rgba(255,255,255,.4); margin-top:3px; position:relative; z-index:1; }

    /* ── ORDONNANCE FORM ── */
    .ord-form {
        background:#fff; border-radius:20px;
        border:1px solid #e8edf5;
        max-width:780px; margin:0 auto;
        box-shadow:0 8px 32px rgba(0,0,0,.04);
        overflow:hidden;
    }

    /* En-tête de l'ordonnance */
    .ord-form-header {
        background:var(--dark); color:#fff;
        padding:22px 32px;
        display:flex; align-items:center; justify-content:space-between;
    }
    .ord-form-header .logo { font-size:22px; font-weight:900; letter-spacing:-0.5px; }
    .ord-form-header .logo span { color:#60a5fa; }
    .ord-form-header .doc-info { text-align:right; font-size:12px; line-height:1.7; color:rgba(255,255,255,.7); }
    .ord-form-header .doc-name { font-size:14px; font-weight:800; color:#fff; }

    /* Corps du formulaire */
    .ord-body { padding:32px; }

    /* Séparateur de section */
    .section-sep {
        font-size:10px; font-weight:800; text-transform:uppercase;
        letter-spacing:.12em; color:#94a3b8;
        margin:24px 0 14px; display:flex; align-items:center; gap:10px;
    }
    .section-sep::after { content:''; flex:1; height:1px; background:#f1f5f9; }

    /* Ligne de champ inline */
    .field-row { display:flex; gap:14px; margin-bottom:14px; }
    .field-col  { display:flex; flex-direction:column; gap:5px; flex:1; }
    .field-col.narrow { flex:0 0 140px; }
    .field-col.medium { flex:0 0 180px; }

    .field-label {
        font-size:11px; font-weight:800; color:#64748b;
        text-transform:uppercase; letter-spacing:.07em;
    }
    .field-input {
        padding:10px 13px; border:1.5px solid #e2e8f0; border-radius:10px;
        font-size:13px; font-weight:600; color:#0f172a; background:#f8fafc;
        outline:none; font-family:inherit; transition:.15s; width:100%;
    }
    .field-input:focus { background:#fff; border-color:var(--blue); box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .field-input::placeholder { color:#cbd5e1; font-weight:400; }
    textarea.field-input { resize:none; min-height:72px; }

    /* ── LIGNE MÉDICAMENT ── */
    .med-section { background:#fafcff; border:1.5px solid #e8edf5; border-radius:14px; padding:20px; margin-bottom:10px; position:relative; transition:.15s; }
    .med-section:focus-within { border-color:#bfdbfe; background:#f0f7ff; }
    .med-num {
        position:absolute; top:16px; left:-14px;
        width:28px; height:28px; border-radius:50%;
        background:var(--blue); color:#fff; font-size:12px; font-weight:800;
        display:flex; align-items:center; justify-content:center;
        box-shadow:0 2px 8px rgba(37,99,235,.3);
    }
    .med-row1 { display:grid; grid-template-columns:1fr 130px 150px; gap:10px; margin-bottom:10px; }
    .med-row2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; }

    .med-del {
        position:absolute; top:14px; right:14px;
        width:28px; height:28px; border-radius:8px; border:none;
        background:transparent; color:#cbd5e1; cursor:pointer;
        display:flex; align-items:center; justify-content:center; transition:.15s;
    }
    .med-del:hover { background:#fef2f2; color:#ef4444; }

    /* ── ADD MED BUTTON ── */
    .add-med {
        width:100%; padding:12px; border-radius:12px;
        border:1.5px dashed #bfdbfe; background:#f0f7ff;
        color:var(--blue); font-size:13px; font-weight:700;
        display:flex; align-items:center; justify-content:center; gap:8px;
        cursor:pointer; transition:.15s; margin-bottom:24px;
    }
    .add-med:hover { background:#dbeafe; border-color:var(--blue); }

    /* ── FOOTER ACTIONS ── */
    .ord-footer {
        padding:20px 32px; background:#f8fafc;
        border-top:1px solid #f1f5f9;
        display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;
    }
    .btn {
        display:inline-flex; align-items:center; gap:7px;
        padding:11px 20px; border-radius:10px; font-size:13px; font-weight:700;
        cursor:pointer; border:none; transition:.2s; font-family:inherit;
        text-decoration:none;
    }
    .btn-ghost   { background:transparent; color:#64748b; border:1.5px solid #e2e8f0; }
    .btn-ghost:hover { background:#f1f5f9; }
    .btn-primary { background:var(--blue); color:#fff; }
    .btn-primary:hover { background:#1d4ed8; transform:translateY(-1px); box-shadow:0 8px 20px rgba(37,99,235,.25); }
    .btn-dark    { background:var(--dark); color:#fff; }
    .btn-dark:hover { background:#1e3a5f; transform:translateY(-1px); }

    .counter { font-size:12px; color:#94a3b8; font-weight:600; }

    /* ── PRINT ── */
    @media print {
        body > * { display:none !important; }
        .print-target { display:block !important; position:fixed; inset:0; background:#fff; z-index:9999; padding:30px 40px; }
    }
    .print-target { display:none; }
</style>
@endpush

@section('content')
<div class="animate-in" x-data="{
    patient: '{{ request('patient') }}',
    age: '',
    date: '{{ date('Y-m-d') }}',
    diagnostic: '',
    notes: '',
    meds: [
        { nom:'', dosage:'', duree:'', matin:'', midi:'', soir:'', soir2:'' }
    ],
    addMed() {
        this.meds.push({ nom:'', dosage:'', duree:'', matin:'', midi:'', soir:'' });
        this.$nextTick(() => document.querySelectorAll('.input-nom').item(this.meds.length - 1)?.focus());
    },
    removeMed(i) { if(this.meds.length > 1) this.meds.splice(i, 1); },
    reset() {
        this.patient=''; this.age=''; this.date='{{ date('Y-m-d') }}';
        this.diagnostic=''; this.notes='';
        this.meds=[{ nom:'', dosage:'', duree:'', matin:'', midi:'', soir:'' }];
    },
    get canPrint() { return this.patient.trim() && this.meds.some(m => m.nom.trim()); }
}">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="ph-title">Nouvelle ordonnance</div>
            <div class="ph-sub">Remplissez le formulaire, puis imprimez ou sauvegardez.</div>
        </div>
        <button class="btn btn-dark" @click="canPrint ? window.print() : null"
            :style="!canPrint ? 'opacity:.4;cursor:not-allowed;' : ''"
            style="background:rgba(255,255,255,.1); border:1.5px solid rgba(255,255,255,.2); color:#fff;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.056 48.056 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/></svg>
            Imprimer
        </button>
    </div>

    {{-- Formulaire ordonnance --}}
    <div class="ord-form" style="padding-left:14px;">

        {{-- En-tête médecin --}}
        <div class="ord-form-header">
            <div>
                <div class="logo">Doki<span>ta</span></div>
                <div style="font-size:11px; color:rgba(255,255,255,.45); margin-top:2px;">Plateforme médicale — Bénin</div>
            </div>
            <div class="doc-info">
                <div class="doc-name">Dr. {{ Auth::user()->name }}</div>
                <div>{{ Auth::user()->specialty ?? 'Médecine générale' }}</div>
                <div>support@dokita.bj</div>
            </div>
        </div>

        <div class="ord-body">

            {{-- ─── PATIENT ─── --}}
            <div class="section-sep">Informations patient</div>

            <div class="field-row">
                <div class="field-col">
                    <label class="field-label">Nom complet du patient <span style="color:#ef4444">*</span></label>
                    <input class="field-input" type="text" x-model="patient" placeholder="Ex : SOGLO Jean-Paul" autofocus>
                </div>
                <div class="field-col narrow">
                    <label class="field-label">Âge</label>
                    <input class="field-input" type="text" x-model="age" placeholder="Ex : 35 ans">
                </div>
                <div class="field-col narrow">
                    <label class="field-label">Date <span style="color:#ef4444">*</span></label>
                    <input class="field-input" type="date" x-model="date">
                </div>
            </div>

            {{-- ─── DIAGNOSTIC ─── --}}
            <div class="section-sep">Diagnostic</div>

            <div class="field-col" style="margin-bottom:0;">
                <label class="field-label">Diagnostic / Motif</label>
                <textarea class="field-input" x-model="diagnostic" placeholder="Ex : Paludisme simple, Grippe saisonnière…"></textarea>
            </div>

            {{-- ─── MÉDICAMENTS ─── --}}
            <div class="section-sep" style="margin-top:28px;">
                Médicaments prescrits
                <span class="counter" x-text="meds.length + ' ligne' + (meds.length > 1 ? 's' : '')"></span>
            </div>

            <template x-for="(med, i) in meds" :key="i">
                <div class="med-section">
                    <div class="med-num" x-text="i + 1"></div>
                    <button class="med-del" @click="removeMed(i)" x-show="meds.length > 1" title="Supprimer">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="med-row1">
                        <div class="field-col">
                            <label class="field-label">Médicament</label>
                            <input class="field-input input-nom" type="text" x-model="med.nom"
                                placeholder="Ex : Paracétamol 1000mg" list="drug-list">
                        </div>
                        <div class="field-col">
                            <label class="field-label">Dosage</label>
                            <input class="field-input" type="text" x-model="med.dosage" placeholder="500mg">
                        </div>
                        <div class="field-col">
                            <label class="field-label">Durée</label>
                            <input class="field-input" type="text" x-model="med.duree" placeholder="7 jours">
                        </div>
                    </div>

                    <div class="med-row2">
                        <div class="field-col">
                            <label class="field-label">Posologie</label>
                            <input class="field-input" type="text" x-model="med.matin"
                                placeholder="Ex : 1 cp matin, midi et soir après les repas">
                        </div>
                        <div class="field-col">
                            <label class="field-label">Remarque / Instruction</label>
                            <input class="field-input" type="text" x-model="med.soir"
                                placeholder="Ex : Éviter l'alcool, prendre à jeun…">
                        </div>
                    </div>
                </div>
            </template>

            <datalist id="drug-list">
                <option value="Paracétamol 500mg"><option value="Paracétamol 1000mg">
                <option value="Amoxicilline 250mg"><option value="Amoxicilline 500mg"><option value="Amoxicilline 1g">
                <option value="Ibuprofène 200mg"><option value="Ibuprofène 400mg">
                <option value="Oméprazole 20mg"><option value="Oméprazole 40mg">
                <option value="Métronidazole 250mg"><option value="Métronidazole 500mg">
                <option value="Cotrimoxazole 960mg">
                <option value="Artémether/Luméfantrine 20/120mg">
                <option value="Doxycycline 100mg">
                <option value="Ciprofloxacine 500mg">
                <option value="Azithromycine 250mg"><option value="Azithromycine 500mg">
                <option value="Loratadine 10mg">
                <option value="Vitamine C 500mg">
                <option value="Fer + Acide folique">
                <option value="Zinc 20mg">
            </datalist>

            <button class="add-med" @click="addMed">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Ajouter un médicament
            </button>

            {{-- ─── NOTES ─── --}}
            <div class="section-sep">Notes complémentaires</div>

            <div class="field-col">
                <label class="field-label">Instructions générales / Conseils</label>
                <textarea class="field-input" x-model="notes" style="min-height:80px;"
                    placeholder="Ex : Repos recommandé 3 jours. Revenir si fièvre persiste après 48h. Éviter l'exposition au soleil."></textarea>
            </div>

        </div>

        {{-- Footer --}}
        <div class="ord-footer">
            <button class="btn btn-ghost" @click="reset">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                Réinitialiser
            </button>
            <div style="display:flex; gap:10px;">
                <button class="btn btn-ghost">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    Sauvegarder
                </button>
                <button class="btn btn-primary" @click="canPrint ? window.print() : null"
                    :style="!canPrint ? 'opacity:.5;cursor:not-allowed;' : ''">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.056 48.056 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/></svg>
                    Imprimer l'ordonnance
                </button>
            </div>
        </div>

    </div>{{-- fin .ord-form --}}

</div>
@endsection
