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
}
