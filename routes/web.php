<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HopitalController;
use App\Http\Controllers\RendezvousController;
use App\Http\Controllers\UrgenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\PatientApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Hopital;

// ─── Auth routes (login, register, password reset…) ───────────────────────────
require __DIR__.'/auth.php';

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
    Route::get('/historique', function() {
        $completedRendezVous = collect([]);
        return view('patient.history', compact('completedRendezVous'));
    })->name('history');
});

// ─── Routes communes authentifiées ────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profil', fn() => view('patient.profil'))->name('profil.index');

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
    Route::get('/dashboard',        fn() => view('hopital.dashboard'))->name('dashboard');
    Route::get('/rdv',              fn() => view('hopital.rdv'))->name('rdv');
    Route::get('/medecins',         fn() => view('hopital.medecins'))->name('medecins');
    Route::get('/medecins/ajouter', fn() => view('hopital.medecins-create'))->name('medecins.create');
    Route::get('/urgences',         fn() => view('hopital.urgences'))->name('urgences');
    Route::get('/parametres',       fn() => view('hopital.parametres'))->name('parametres');
});

// ─── Routes Médecin ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/dashboard',    fn() => view('medecin.dashboard'))->name('dashboard');
    Route::get('/rdv',          fn() => view('medecin.rdv'))->name('rdv');
    Route::get('/planning',     fn() => view('medecin.planning'))->name('planning');
    Route::get('/profil',       fn() => view('medecin.profil'))->name('profil');
    Route::get('/consultation', fn() => view('medecin.consultation'))->name('consultation');
    Route::get('/parametres',   fn() => view('medecin.settings'))->name('settings');
});

// ─── API Routes Patient ────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('api/patient')->name('api.patient.')->group(function () {
    Route::get('/dashboard',                 [PatientApiController::class, 'dashboard'])->name('dashboard');
    Route::get('/rendez-vous',               [PatientApiController::class, 'rendezVous'])->name('rendezvous');
    Route::get('/notifications',             [PatientApiController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/read',  [PatientApiController::class, 'markNotificationAsRead'])->name('notifications.read');
});
