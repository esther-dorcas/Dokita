<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer(['layouts.dokita', 'layouts.medecin'], function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->isPatient()) {
                    $view->with('upcomingCount', \App\Models\RendezVous::where('patient_id', $user->id)
                        ->whereIn('statut', ['en_attente', 'confirme'])
                        ->where('date_heure', '>', now())
                        ->count());
                } elseif ($user->isMedecin() && $user->medecin) {
                    $view->with('todayRdvCount', \App\Models\RendezVous::where('medecin_id', $user->medecin->id)
                        ->whereDate('date_heure', now())
                        ->count());
                    $view->with('pendingUrgenceCount', \App\Models\Urgence::where('statut', 'en_cours')->count());
                }
            }
        });
    }
}
