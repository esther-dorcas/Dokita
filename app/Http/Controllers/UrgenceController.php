<?php

namespace App\Http\Controllers;

use App\Models\Urgence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrgenceController extends Controller
{
    public function create()
    {
        return view('patient.urgence');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description'  => ['required', 'string', 'max:1000'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'latitude'     => ['nullable', 'numeric'],
            'longitude'    => ['nullable', 'numeric'],
        ]);

        Urgence::create([
            'patient_id'   => Auth::id(),
            'description'  => $request->description,
            'localisation' => $request->localisation,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'statut'       => 'en_cours',
        ]);

        return back()->with('success', 'Votre demande d\'urgence a été envoyée. Les services médicaux vous contacteront rapidement.');
    }

    public function storePublic(Request $request)
    {
        $request->validate([
            'nom_appelant' => ['nullable', 'string', 'max:255'],
            'telephone'    => ['nullable', 'string', 'max:30'],
            'description'  => ['required', 'string', 'max:1000'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'latitude'     => ['nullable', 'numeric'],
            'longitude'    => ['nullable', 'numeric'],
        ]);

        Urgence::create([
            'patient_id'   => null,
            'nom_appelant' => $request->nom_appelant ?? 'Alerte SAMU (Anonyme)',
            'telephone'    => $request->telephone ?? 'Non spécifié',
            'description'  => $request->description,
            'localisation' => $request->localisation ?? 'Géolocalisation GPS',
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'statut'       => 'en_cours',
        ]);

        return response()->json(['success' => true]);
    }
}
