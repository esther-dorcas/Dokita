<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'medecin') {
            return redirect()->route('medecin.dashboard');
        }

        if ($user->role === 'hopital') {
            return redirect()->route('hopital.dashboard');
        }

        $patient = \App\Models\Patient::firstOrCreate(['user_id' => $user->id]);

        $upcomingRendezVous = $user->rendezVous()
            ->where('date_heure', '>=', now())
            ->where('statut', '!=', 'annule')
            ->orderBy('date_heure')
            ->with('medecin.user')
            ->take(5)
            ->get();

        $upcomingCount  = $upcomingRendezVous->count();
        $completedCount = $user->rendezVous()->where('statut', 'termine')->count();
        $confirmedCount = $user->rendezVous()->where('statut', 'confirme')->count();
        $notifCount     = 0; // à brancher quand tu auras les notifications

        return view('patient.dashboard', compact(
            'patient',
            'upcomingRendezVous',
            'upcomingCount',
            'completedCount',
            'confirmedCount',
            'notifCount'
        ));
    }

    public function history()
    {
        $user = Auth::user();
        $completedRendezVous = $user->rendezVous()
            ->where('statut', 'termine')
            ->orderBy('date_heure', 'desc')
            ->with('medecin.user')
            ->get();

        return view('patient.history', compact('completedRendezVous'));
    }
}