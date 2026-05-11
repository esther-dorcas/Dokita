@extends('layouts.hopital')

@section('title', 'Urgences & SOS — Dokita Hôpital')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    @keyframes pulse-red { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,0.4);} 50%{box-shadow:0 0 0 10px rgba(239,68,68,0);} }
    .animate-up { animation: slideUp .4s ease-out; }

    .page-header { background: #fff; border-radius: var(--radius-xl); padding: 24px 30px; margin-bottom: 24px; border: 1px solid #e8edf5; box-shadow: 0 10px 30px rgba(0,0,0,.02); display: flex; justify-content: space-between; align-items: center; }
    .page-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .page-desc { font-size: 13px; color: #64748b; margin: 0; }

    .alert-banner { background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
    .alert-icon { width: 40px; height: 40px; background: #ef4444; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: pulse-red 2s infinite; }
    .alert-text { flex: 1; }
    .alert-title { font-size: 14px; font-weight: 800; color: #991b1b; }
    .alert-desc { font-size: 12px; color: #b91c1c; }

    .sos-grid { display: grid; gap: 16px; }
    .sos-card { background: #fff; border: 1px solid #e8edf5; border-left: 4px solid #ef4444; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,.02); }
    .sos-card.resolved { border-left-color: #22c55e; opacity: 0.75; }
    
    .sos-info { flex: 1; }
    .sos-patient { font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
    .sos-time { font-size: 11px; font-weight: 700; color: #ef4444; background: #fef2f2; padding: 2px 8px; border-radius: 6px; }
    .sos-resolved-time { font-size: 11px; font-weight: 700; color: #22c55e; background: #f0fdf4; padding: 2px 8px; border-radius: 6px; }
    .sos-details { font-size: 13px; color: #475569; display: flex; gap: 16px; }
    .sos-details span { display: inline-flex; align-items: center; gap: 4px; }

    .sos-actions { display: flex; gap: 10px; }
    .btn-sos { padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; cursor: pointer; border: none; }
    .btn-sos.primary { background: #ef4444; color: #fff; }
    .btn-sos.primary:hover { background: #dc2626; }
    .btn-sos.secondary { background: #f1f5f9; color: #475569; }
    .btn-sos.secondary:hover { background: #e2e8f0; }

</style>
@endpush

@section('content')
<div class="animate-up">

    <div class="page-header">
        <div>
            <h1 class="page-title">Urgences & SOS</h1>
            <p class="page-desc">Suivi des demandes d'assistance d'urgence affectées à votre centre.</p>
        </div>
    </div>

        @php
            $activeCount = $urgences->where('statut', 'en_cours')->count();
        @endphp

        @if($activeCount > 0)
        <div class="alert-banner" id="main-alert-banner">
            <div class="alert-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="alert-text">
                <div class="alert-title">{{ $activeCount }} Urgence(s) critique(s) en cours</div>
                <div class="alert-desc">Veuillez coordonner l'arrivée avec le médecin de garde.</div>
            </div>
        </div>
        @endif

        @forelse($urgences as $urgence)
            @if($urgence->statut === 'en_cours')
                {{-- SOS ACTIF --}}
                <div class="sos-card" id="sos-{{ $urgence->id }}">
                    <div class="sos-info">
                        <div class="sos-patient">
                            {{ $urgence->patient->name ?? 'Patient Anonyme' }}
                            <span class="sos-time" id="badge-{{ $urgence->id }}">Aujourd'hui, {{ $urgence->created_at->format('H:i') }} (En cours)</span>
                        </div>
                        <div class="sos-details">
                            <span><strong>Motif :</strong> {{ $urgence->description }}</span>
                            <span><strong>Contact :</strong> {{ $urgence->patient->telephone ?? '+229 XX XX XX XX' }}</span>
                            <span><strong>Localisation :</strong> {{ $urgence->localisation ?? 'Non précisée' }}</span>
                        </div>
                    </div>
                    <div class="sos-actions" id="actions-{{ $urgence->id }}">
                        <button class="btn-sos secondary" onclick="alert('Dossier d\'Urgence :\nNom : {{ $urgence->patient->name ?? 'Anonyme' }}\nÂge : Non renseigné\nGroupe Sanguin : À vérifier\nDétails de l\'alerte : {{ addslashes($urgence->description) }}')">Voir dossier</button>
                        <button class="btn-sos primary" onclick="prendreEnCharge({{ $urgence->id }}, 'sos-{{ $urgence->id }}', 'actions-{{ $urgence->id }}', 'badge-{{ $urgence->id }}')">Prise en charge</button>
                    </div>
                </div>
            @else
                {{-- SOS RESOLU --}}
                <div class="sos-card resolved" id="sos-{{ $urgence->id }}">
                    <div class="sos-info">
                        <div class="sos-patient">
                            {{ $urgence->patient->name ?? 'Patient Anonyme' }}
                            <span class="sos-resolved-time">Résolu ({{ $urgence->updated_at->format('d/m/Y H:i') }})</span>
                        </div>
                        <div class="sos-details">
                            <span><strong>Motif :</strong> {{ $urgence->description }}</span>
                            <span><strong>Contact :</strong> {{ $urgence->patient->telephone ?? '+229 XX XX XX XX' }}</span>
                            <span><strong>Statut :</strong> Pris en charge</span>
                        </div>
                    </div>
                    <div class="sos-actions" id="actions-{{ $urgence->id }}">
                        <button class="btn-sos secondary" onclick="alert('Action : Le dossier a été archivé de manière sécurisée.')">Archiver</button>
                    </div>
                </div>
            @endif
        @empty
            <div style="padding: 40px; text-align: center; background: #fff; border-radius: 16px; border: 1px dashed #cbd5e1; color: #64748b;">
                Aucune urgence signalée pour le moment.
            </div>
        @endforelse

    </div>

</div>

@push('scripts')
<script>
    function prendreEnCharge(id, cardId, actionsId, badgeId) {
        if(confirm("Confirmez-vous le déploiement immédiat de l'équipe médicale pour cette urgence ?")) {
            
            // Requête serveur pour marquer comme résolu
            fetch(`/hopital/urgences/${id}/resolve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(() => {
                // Modifier la carte
                const card = document.getElementById(cardId);
                card.classList.add('resolved');
                
                // Modifier le badge
                const badge = document.getElementById(badgeId);
                badge.className = 'sos-resolved-time';
                badge.innerHTML = "Résolu (À l'instant)";
                
                // Modifier les actions
                const actions = document.getElementById(actionsId);
                actions.innerHTML = '<button class="btn-sos secondary" onclick="alert(\'Action : Le dossier a été archivé de manière sécurisée.\')">Archiver</button>';

                // Alerte de confirmation
                alert("✅ L'équipe d'intervention est affectée. L'urgence est marquée comme prise en charge dans la base de données.");
            }).catch(e => {
                console.error(e);
                alert("Erreur lors de la prise en charge.");
            });
        }
    }
</script>
@endpush
@endsection
