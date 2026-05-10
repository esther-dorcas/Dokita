<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Vérifie toutes les heures les RDV du lendemain et envoie les rappels email
Schedule::command('rdv:send-reminders')->dailyAt('08:00');
