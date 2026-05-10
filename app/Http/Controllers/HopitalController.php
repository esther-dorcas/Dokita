<?php
namespace App\Http\Controllers;

use App\Models\Hopital;
use Illuminate\Http\Request;

class HopitalController extends Controller
{
    public function index(Request $request)
    {
        $specialite = $request->get('specialite');
        $q          = $request->get('q');

        $hopitaux = Hopital::with('specialites','medecins')
            ->when($q, fn($query) =>
                $query->where('nom','like',"%$q%")
                      ->orWhere('adresse','like',"%$q%")
            )
            ->when($specialite, fn($query) =>
                $query->whereHas('specialites', fn($s) =>
                    $s->where('nom_specialite', $specialite)
                )
            )
            ->get();

        $specialites = \App\Models\Specialite::select('nom_specialite')
            ->distinct()->pluck('nom_specialite');

        return view('hopitaux.index', compact('hopitaux','specialites','specialite','q'));
    }

    public function show($id)
    {
        $hopital = Hopital::with([
            'specialites',
            'medecins.user',
            'medecins.rendezVous'
        ])->findOrFail($id);

        $date     = request('date', now()->format('Y-m-d'));
        $medecinId = request('medecin_id');

        $medecin   = $medecinId
            ? $hopital->medecins->find($medecinId)
            : $hopital->medecins->first();

        $creneaux  = $medecin
            ? $medecin->creneauxDisponibles($date)
            : [];

        return view('hopitaux.show', compact('hopital','date','medecin','creneaux'));
    }
}