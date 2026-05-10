<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(2);
$user->password = bcrypt('password');
$user->email_verified_at = now();
$user->save();

echo 'Utilisateur mis à jour avec succès';