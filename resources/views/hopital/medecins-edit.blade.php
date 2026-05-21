@extends('layouts.hopital')

@section('title', 'Modifier un Médecin — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .4s ease-out; }

    .page-header { margin-bottom: 24px; }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    .form-card { background: #fff; border-radius: var(--radius-xl); border: 1px solid #e8edf5; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,.02); max-width: 700px; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
    
    .field-label { font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    .field-input, .field-select { width: 100%; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; color: #0f172a; font-weight: 600; font-size: 13px; outline: none; transition: 0.2s; }
    .field-input:focus, .field-select:focus { border-color: var(--blue); background: #fff; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

    .btn-submit { background: var(--blue); color: #fff; padding: 14px 28px; border-radius: 12px; font-size: 14px; font-weight: 800; border: none; cursor: pointer; transition: 0.2s; width: 100%; margin-top: 10px; }
    .btn-submit:hover { background: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="animate-up">

    <div class="page-header">
        <h1 class="page-title">Gérer le profil de {{ $medecinUser->name }}</h1>
        <p class="page-desc">Mettez à jour les informations du médecin affilié à votre établissement.</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('hopital.medecins.update', $medecinUser->id) }}">
            @csrf
            @method('PATCH')
            
            <div class="form-grid">
                <div>
                    <label class="field-label">Nom Complet</label>
                    <input type="text" name="name" class="field-input" value="{{ $medecinUser->name }}" required>
                </div>
                <div>
                    <label class="field-label">Spécialité</label>
                    <select name="specialite" class="field-select" required>
                        <option value="Médecine Générale" {{ ($medecinUser->medecin->specialite ?? '') == 'Médecine Générale' ? 'selected' : '' }}>Médecine Générale</option>
                        <option value="Cardiologie" {{ ($medecinUser->medecin->specialite ?? '') == 'Cardiologie' ? 'selected' : '' }}>Cardiologie</option>
                        <option value="Pédiatrie" {{ ($medecinUser->medecin->specialite ?? '') == 'Pédiatrie' ? 'selected' : '' }}>Pédiatrie</option>
                        <option value="Gynécologie" {{ ($medecinUser->medecin->specialite ?? '') == 'Gynécologie' ? 'selected' : '' }}>Gynécologie</option>
                        <option value="Dermatologie" {{ ($medecinUser->medecin->specialite ?? '') == 'Dermatologie' ? 'selected' : '' }}>Dermatologie</option>
                    </select>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label class="field-label">Adresse Email Professionnelle</label>
                    <input type="email" class="field-input" value="{{ $medecinUser->email }}" disabled style="opacity: 0.7;">
                </div>
                <div>
                    <label class="field-label">Numéro de Téléphone</label>
                    <input type="tel" name="telephone" class="field-input" value="{{ $medecinUser->telephone ?? '' }}" required>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label class="field-label">Numéro d'ordre (Licence)</label>
                    <input type="text" class="field-input" value="MED-{{ date('Y') }}-{{ Str::upper(Str::random(3)) }}" disabled style="opacity: 0.7;">
                </div>
                <div>
                    <label class="field-label">Statut</label>
                    <select name="statut" class="field-select">
                        <option value="en_attente" {{ ($medecinUser->medecin->statut ?? '') == 'en_attente' ? 'selected' : '' }}>En attente d'approbation</option>
                        <option value="actif" {{ ($medecinUser->medecin->statut ?? '') == 'actif' ? 'selected' : '' }}>Actif (Approuvé / De garde)</option>
                        <option value="inactif" {{ ($medecinUser->medecin->statut ?? '') == 'inactif' ? 'selected' : '' }}>Absent / Inactif</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <a href="{{ route('hopital.medecins') }}" style="color: #64748b; font-size: 14px; font-weight: 700; text-decoration: none;">&larr; Annuler</a>
                
                <div style="display: flex; gap: 12px;">
                    <button type="button" onclick="document.getElementById('modal-delete').style.display='flex'" style="background: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer;">Exclure / Supprimer</button>
                    <button type="submit" class="btn-submit" style="width: auto; margin-top: 0;">Enregistrer les modifications</button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('hopital.medecins.destroy', $medecinUser->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>

{{-- MODAL DE CONFIRMATION --}}
<div id="modal-delete" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:32px; max-width:420px; width:90%; box-shadow:0 25px 60px rgba(0,0,0,0.2); text-align:center;">
        <div style="width:56px;height:56px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="28" height="28" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin-bottom:8px;">Exclure ce médecin ?</h3>
        <p style="font-size:13px;color:#64748b;margin-bottom:24px;">Êtes-vous sûr de vouloir exclure ce médecin de votre hôpital ? Son compte sera <strong>définitivement supprimé</strong>.</p>
        <div style="display:flex;gap:12px;">
            <button onclick="document.getElementById('modal-delete').style.display='none'" style="flex:1;padding:12px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;font-size:13px;font-weight:700;cursor:pointer;color:#475569;">Annuler</button>
            <button onclick="document.getElementById('delete-form').submit()" style="flex:1;padding:12px;border-radius:10px;border:none;background:#ef4444;color:#fff;font-size:13px;font-weight:800;cursor:pointer;">Oui, l'exclure</button>
        </div>
    </div>
</div>

@endsection
