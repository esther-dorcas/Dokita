@php
    $nameParts = explode(' ', $rdv->patient->name ?? 'Anonyme');
    $initials  = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1] ?? '', 0, 1));
@endphp
<tr>
    <td>
        <div class="patient-cell">
            <div class="patient-av">{{ $initials }}</div>
            <div>
                <div class="patient-name">{{ $rdv->patient->name ?? 'Patient Inconnu' }}</div>
                <div class="patient-motif">{{ Str::limit($rdv->motif ?? 'Non précisé', 35) }}</div>
            </div>
        </div>
    </td>
    <td>
        <div style="font-weight: 700; color: #0f172a;">{{ $rdv->date_heure ? $rdv->date_heure->format('d/m/Y') : 'Non définie' }}</div>
        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">{{ $rdv->date_heure ? $rdv->date_heure->format('H:i') : '' }}</div>
    </td>
    <td>
        <div style="font-weight: 700; color: #0f172a;">Dr. {{ $rdv->medecin->user->name ?? 'Non assigné' }}</div>
        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">{{ $rdv->medecin->specialite ?? 'Généraliste' }}</div>
    </td>
    <td>
        @if($rdv->statut === 'confirme')
            <span class="status-badge confirme">Confirmé</span>
        @elseif($rdv->statut === 'annule')
            <span class="status-badge annule">Annulé</span>
        @else
            <span class="status-badge attente">En attente</span>
        @endif
    </td>
    <td>
        <div style="display: flex; gap: 8px;">
            @if($rdv->date_heure && $rdv->date_heure->isFuture())
                {{-- Confirmer --}}
                @if($rdv->statut !== 'confirme')
                <form action="{{ route('hopital.rdv.statut', $rdv->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="statut" value="confirme">
                    <button type="submit" class="btn-action" style="background: #f0fdf4; color: #16a34a;" title="Confirmer">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                    </button>
                </form>
                @endif

                {{-- Reprogrammer --}}
                <button type="button" class="btn-action" style="background: #eff6ff; color: #2563eb;" title="Modifier" onclick="reprogrammerRDV({{ $rdv->id }}, '{{ $rdv->date_heure ? $rdv->date_heure->format('Y-m-d\TH:i') : '' }}')">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>

                {{-- Annuler --}}
                @if($rdv->statut !== 'annule')
                <button type="button" class="btn-action" style="background: #fef2f2; color: #dc2626;" title="Annuler" onclick="annulerRDV({{ $rdv->id }})">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @endif
            @else
                <span style="font-size: 11px; font-weight: 700; color: #94a3b8; padding: 6px 0;">Terminé</span>
            @endif
        </div>
    </td>
</tr>
