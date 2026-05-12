<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $hopitaux = \App\Models\Hopital::all();
        return view('auth.register', compact('hopitaux'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // On adapte le rôle si c'est 'praticien' pour correspondre à 'medecin' dans la DB
        if ($request->user_role === 'praticien') {
            $request->merge(['user_role' => 'medecin']);
        }

        $isHopital = $request->user_role === 'hopital';

        $request->validate([
            'firstname' => [$isHopital ? 'nullable' : 'required', 'string', 'max:255'],
            'lastname'  => [$isHopital ? 'nullable' : 'required', 'string', 'max:255'],
            'hospital_name' => [$isHopital ? 'required' : 'nullable', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'max:20'],
            'user_role' => ['required', 'in:patient,medecin,hopital'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', Rules\Password::defaults()],
        ]);

        $name = $isHopital ? $request->hospital_name : ($request->firstname . ' ' . $request->lastname);

        $user = User::create([
            'name'                 => $name,
            'telephone'            => $request->phone,
            'role'                 => $request->user_role,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'specialty'            => $request->specialty,
            'license_number'       => $request->license_number,
            'hospital_affiliation' => $request->hospital_affiliation,
        ]);

        // Création des records associés selon le rôle
        if ($user->role === 'medecin') {
            \App\Models\Medecin::create([
                'user_id' => $user->id,
                'hopital_id' => $request->hopital_id,
                'specialite' => $request->specialty,
            ]);
        } elseif ($user->role === 'patient') {
            \App\Models\Patient::create([
                'user_id' => $user->id,
            ]);
        } elseif ($user->role === 'hopital') {
            \App\Models\Hopital::create([
                'user_id'   => $user->id,
                'nom'       => $user->name,
                'adresse'   => $request->city,
                'telephone' => $user->telephone,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirection directe selon le rôle
        return match($user->role) {
            'medecin' => redirect()->route('medecin.dashboard'),
            'hopital' => redirect()->route('hopital.dashboard'),
            default   => redirect()->route('patient.dashboard'),
        };
    }
}
