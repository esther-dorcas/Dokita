@extends('layouts.medecin')

@section('title', 'Paramètres — Dokita PRO')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .4s ease-out; }

    .page-header { background: #fff; border-radius: var(--radius-xl); padding: 24px 30px; margin-bottom: 24px; border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,.02); }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    .settings-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    @media (max-width: 1024px) { .settings-grid { grid-template-columns: 1fr; } }
    
    .settings-card { background: #fff; border-radius: var(--radius-xl); border: 1px solid #e8edf5; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,.02); }
    
    .section-title { font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
    
    /* ── SCHEDULE FORM ── */
    .schedule-item { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px; }
    .sch-day { width: 90px; font-size: 13px; font-weight: 700; color: #475569; }
    .sch-inputs { display: flex; align-items: center; gap: 8px; flex: 1; }
    .sch-inputs input[type="time"] { padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px; color: #0f172a; outline: none; transition: .2s; }
    .sch-inputs input[type="time"]:focus { border-color: var(--blue); }
    .sch-sep { font-size: 12px; font-weight: 800; color: #cbd5e1; }

    /* Override Laravel Breeze Form inside settings-card */
    .settings-card h2 { font-size: 16px !important; font-weight: 800 !important; color: #0f172a !important; margin-bottom: 8px !important; }
    .settings-card p { font-size: 13px !important; color: #64748b !important; }
    .settings-card label { font-size: 11px !important; font-weight: 800 !important; color: #475569 !important; text-transform: uppercase; letter-spacing: 0.5px; }
    .settings-card input[type="password"] { width: 100%; padding: 12px 16px !important; border-radius: 12px !important; border: 1px solid #e2e8f0 !important; font-size: 14px !important; background: #f8fafc !important; margin-top: 6px !important; transition: .2s; }
    .settings-card input[type="password"]:focus { background: #fff !important; border-color: var(--blue) !important; box-shadow: 0 0 0 3px rgba(37,99,235,.1) !important; outline: none; }
    .settings-card .bg-gray-800 { background: var(--blue) !important; color: #fff; border-radius: 10px !important; font-weight: 800 !important; text-transform: uppercase; font-size: 12px !important; padding: 12px 24px !important; border: none !important; cursor: pointer; }
    .settings-card .bg-gray-800:hover { background: #1d4ed8 !important; }

    .btn-save { background: var(--blue); color: #fff; padding: 12px 24px; border-radius: 10px; font-size: 12px; font-weight: 800; text-transform: uppercase; border: none; cursor: pointer; transition: .2s; }
    .btn-save:hover { background: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="animate-up">
    
    <div class="page-header">
        <h1 class="page-title">Paramètres & Sécurité</h1>
        <p class="page-desc">Gérez vos disponibilités de consultation et la sécurité de votre espace médical.</p>
    </div>

    <div class="settings-grid">
        
        {{-- HORAIRES --}}
        <div class="settings-card">
            <h2 class="section-title">Horaires de Consultation</h2>
            <p style="font-size:13px; color:#64748b; margin-bottom:20px;">Définissez les plages horaires de votre cabinet.</p>

            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Horaires mis à jour avec succès !');">
                <div class="schedule-item">
                    <div class="sch-day">Lundi</div>
                    <div class="sch-inputs">
                        <input type="time" value="08:00"> <span class="sch-sep">à</span> <input type="time" value="17:00">
                    </div>
                </div>
                <div class="schedule-item">
                    <div class="sch-day">Mardi</div>
                    <div class="sch-inputs">
                        <input type="time" value="08:00"> <span class="sch-sep">à</span> <input type="time" value="17:00">
                    </div>
                </div>
                <div class="schedule-item">
                    <div class="sch-day">Mercredi</div>
                    <div class="sch-inputs">
                        <input type="time" value="08:00"> <span class="sch-sep">à</span> <input type="time" value="12:00">
                    </div>
                </div>
                <div class="schedule-item">
                    <div class="sch-day">Jeudi</div>
                    <div class="sch-inputs">
                        <input type="time" value="08:00"> <span class="sch-sep">à</span> <input type="time" value="17:00">
                    </div>
                </div>
                <div class="schedule-item">
                    <div class="sch-day">Vendredi</div>
                    <div class="sch-inputs">
                        <input type="time" value="08:00"> <span class="sch-sep">à</span> <input type="time" value="15:00">
                    </div>
                </div>

                <div style="margin-top: 24px; text-align:right;">
                    <button type="submit" class="btn-save">Enregistrer</button>
                </div>
            </form>
        </div>

        {{-- MOT DE PASSE --}}
        <div class="settings-card">
            @include('profile.partials.update-password-form')
        </div>

    </div>

</div>
@endsection
