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

            <form action="{{ route('medecin.settings.update') }}" method="POST">
                @csrf
                @php
                    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                    $dispos = Auth::user()->medecin->disponibilites ?? [];
                @endphp

                @foreach($jours as $jour)
                    @php
                        $key = strtolower($jour);
                        $debut = $dispos[$key]['debut'] ?? '';
                        $fin = $dispos[$key]['fin'] ?? '';
                    @endphp
                    <div class="schedule-item">
                        <div class="sch-day">{{ $jour }}</div>
                        <div class="sch-inputs">
                            <input type="time" name="dispo[{{ $key }}][debut]" value="{{ $debut }}"> 
                            <span class="sch-sep">à</span> 
                            <input type="time" name="dispo[{{ $key }}][fin]" value="{{ $fin }}">
                        </div>
                    </div>
                @endforeach

                <div style="margin-top: 24px; text-align:right;">
                    <button type="submit" class="btn-save">Enregistrer</button>
                </div>
            </form>
        </div>

        {{-- SUPPRIMER MON COMPTE --}}
        <div>
            <div class="settings-card" style="margin-bottom: 24px;">
                @include('profile.partials.update-password-form')
            </div>

            <div class="settings-card">
                <form action="{{ route('medecin.destroy') }}" method="POST" id="delete-account-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="document.getElementById('modal-delete').style.display='flex'" style="background: #ef4444; color: #fff; padding: 12px 24px; border-radius: 10px; font-size: 13px; font-weight: 800; border: none; cursor: pointer; width: 100%;">
                        Supprimer mon Compte
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

{{-- MODAL DE CONFIRMATION --}}
<div id="modal-delete" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:32px; max-width:420px; width:90%; box-shadow:0 25px 60px rgba(0,0,0,0.2); text-align:center;">
        <div style="width:56px;height:56px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="28" height="28" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin-bottom:8px;">Supprimer votre compte ?</h3>
        <p style="font-size:13px;color:#64748b;margin-bottom:24px;">Cette action est <strong>irréversible</strong>. Toutes vos données (profil, plannings, rendez-vous) seront définitivement supprimées.</p>
        <div style="display:flex;gap:12px;">
            <button onclick="document.getElementById('modal-delete').style.display='none'" style="flex:1;padding:12px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;font-size:13px;font-weight:700;cursor:pointer;color:#475569;">Annuler</button>
            <button onclick="document.getElementById('delete-account-form').submit()" style="flex:1;padding:12px;border-radius:10px;border:none;background:#ef4444;color:#fff;font-size:13px;font-weight:800;cursor:pointer;">Oui, supprimer</button>
        </div>
    </div>
</div>

@endsection
