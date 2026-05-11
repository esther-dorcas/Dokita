<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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
            'upcomingRendezVous',
            'upcomingCount',
            'completedCount',
            'confirmedCount',
            'notifCount'
        ));
    }
}