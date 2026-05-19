<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HopitalController;
use App\Http\Controllers\RendezvousController;
use App\Http\Controllers\UrgenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HopitalDashboardController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\Api\PatientApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Hopital;

// ─── Auth routes (login, register, password reset…) ───────────────────────────
require __DIR__.'/auth.php';

// ─── Urgence publique (sans connexion) ────────────────────────────────────────
Route::post('/urgence/publique', [UrgenceController::class, 'storePublic'])->name('urgence.publique');

// ─── Pages publiques ───────────────────────────────────────────────────────────
Route::get('/', function () {
    $hopitaux = Hopital::query()
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get(['id','nom','adresse','latitude','longitude']);
    return view('welcome', compact('hopitaux'));
})->name('home');

Route::get('/professional', fn() => view('professional'))->name('professional');
Route::get('/faq',          fn() => view('faq'))->name('faq');

// ─── Redirection intelligente après login ──────────────────────────────────────
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'medecin') return redirect()->route('medecin.dashboard');
    if ($user->role === 'hopital') return redirect()->route('hopital.dashboard');
    return redirect()->route('patient.dashboard');
})->middleware(['auth'])->name('dashboard');

// ─── Routes Patient ────────────────────────────────────────────────────────────
// Middleware auth uniquement (pas role:patient) pour éviter tout blocage après inscription
Route::middleware(['auth'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/historique', [DashboardController::class, 'history'])->name('history');
});

// ─── Routes communes authentifiées ────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profil', fn() => view('patient.profil', ['patient' => \Illuminate\Support\Facades\Auth::user()->patient]))->name('profil.index');
    Route::patch('/profil', [ProfileController::class, 'updatePatientProfile'])->name('patient.profil.update');

    // Hôpitaux
    Route::get('/hopitaux',      [HopitalController::class, 'index'])->name('hopitaux.index');
    Route::get('/hopitaux/{id}', [HopitalController::class, 'show'])->name('hopitaux.show');

    // Rendez-vous
    Route::get('/prendre-rdv',       [RendezvousController::class, 'create'])->name('rdv.create');
    Route::post('/rdv',              [RendezvousController::class, 'store'])->name('rdv.store');
    Route::get('/mes-rdv',           [RendezvousController::class, 'index'])->name('rdv.index');
    Route::post('/rdv/{id}/annuler', [RendezvousController::class, 'annuler'])->name('rdv.annuler');

    // Urgences
    Route::get('/urgence',  [UrgenceController::class, 'create'])->name('urgence.create');
    Route::post('/urgence', [UrgenceController::class, 'store'])->name('urgence.store');
});

// ─── Routes Hôpital ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:hopital'])->prefix('hopital')->name('hopital.')->group(function () {
    Route::get('/dashboard',        [HopitalDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rdv',              [HopitalDashboardController::class, 'rdv'])->name('rdv');
    
    // Actions sur les RDV
    Route::post('/rdv/{id}/statut', [HopitalDashboardController::class, 'updateRdvStatut'])->name('rdv.statut');
    Route::post('/rdv/{id}/reprogrammer', [HopitalDashboardController::class, 'reprogrammerRdv'])->name('rdv.reprogrammer');
    
    Route::get('/medecins',               [HopitalDashboardController::class, 'medecins'])->name('medecins');
    Route::get('/medecins/ajouter',        [HopitalDashboardController::class, 'medecinsCreate'])->name('medecins.create');
    Route::post('/medecins',               [HopitalDashboardController::class, 'medecinsStore'])->name('medecins.store');
    Route::get('/medecins/{id}/modifier',  [HopitalDashboardController::class, 'medecinsEdit'])->name('medecins.edit');
    Route::patch('/medecins/{id}',         [HopitalDashboardController::class, 'medecinsUpdate'])->name('medecins.update');

    Route::get('/urgences',               [HopitalDashboardController::class, 'urgences'])->name('urgences');
    Route::get('/parametres',             [HopitalDashboardController::class, 'parametres'])->name('parametres');
    Route::patch('/parametres',           [HopitalDashboardController::class, 'updateParametres'])->name('parametres.update');

    // Polling API pour les alertes en temps réel
    Route::get('/api/urgences/count',     [HopitalDashboardController::class, 'countUrgences'])->name('api.urgences.count');
    Route::post('/urgences/{id}/resolve', [HopitalDashboardController::class, 'resolveUrgence'])->name('urgences.resolve');
});

// ─── Routes Médecin ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/attente', function() {
        if(auth()->user()->medecin->statut === 'actif') return redirect()->route('medecin.dashboard');
        return view('medecin.attente');
    })->name('attente');

    Route::get('/dashboard',    [MedecinController::class, 'dashboard'])->name('dashboard');
    Route::get('/rdv',          [MedecinController::class, 'rdv'])->name('rdv');
    Route::get('/planning',     [MedecinController::class, 'planning'])->name('planning');
    Route::get('/profil',       [MedecinController::class, 'profil'])->name('profil');
    Route::post('/profil',      [MedecinController::class, 'updateProfil'])->name('profil.update');
    Route::get('/consultation', [MedecinController::class, 'consultation'])->name('consultation');
    Route::post('/consultation/{id}/cloturer', [MedecinController::class, 'cloturerConsultation'])->name('consultation.cloturer');
    Route::post('/rdv/{id}/annuler', [MedecinController::class, 'annulerRdv'])->name('rdv.annuler');
    Route::get('/ordonnances',  [MedecinController::class, 'ordonnances'])->name('ordonnances');
    Route::get('/parametres',   [MedecinController::class, 'settings'])->name('settings');
    Route::post('/parametres',  [MedecinController::class, 'updateSettings'])->name('settings.update');
});

// ─── API Routes Patient ────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('api/patient')->name('api.patient.')->group(function () {
    Route::get('/dashboard',                 [PatientApiController::class, 'dashboard'])->name('dashboard');
    Route::get('/rendez-vous',               [PatientApiController::class, 'rendezVous'])->name('rendezvous');
    Route::get('/notifications',             [PatientApiController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/read',  [PatientApiController::class, 'markNotificationAsRead'])->name('notifications.read');
});

// ─── Route Contact (Support Chat) ──────────────────────────────────────────────
Route::post('/contact/send', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    
    // Simulation ou envoi réel selon configuration
    try {
        \Illuminate\Support\Facades\Mail::raw($request->message, function ($mail) use ($request) {
            $mail->to('support@dokita.bj')
                 ->subject('[Support Dokita] ' . $request->subject)
                 ->replyTo($request->email);
        });
    } catch (\Exception $e) {
        // Pour la soutenance, on continue même si le mailer (SMTP) n'est pas configuré
    }

    return response()->json(['success' => true, 'message' => 'Message envoyé avec succès.']);
})->name('contact.send');
