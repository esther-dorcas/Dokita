<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the patient-specific profile information (Santé & Constantes).
     */
    public function updatePatientProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Mise à jour des informations de base (User)
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
        $user->telephone = $request->input('telephone', $user->telephone);
        // Si le birth_date existe dans la table users (souvent oui dans les apps médicales)
        // $user->birth_date = $request->input('birth_date', $user->birth_date);
        $user->save();

        // Mise à jour ou création du profil Patient
        $patient = clone $user->patient() ?? new \App\Models\Patient(['user_id' => $user->id]);
        
        $user->patient()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'groupe_sanguin'      => $request->input('groupe_sanguin'),
                'taille'              => $request->input('taille'),
                'poids'               => $request->input('poids'),
                'tension'             => $request->input('tension'),
                'allergies'           => $request->input('allergies'),
                'contact_urgence_nom' => $request->input('contact_urgence_nom'),
                'contact_urgence_tel' => $request->input('contact_urgence_tel'),
            ]
        );

        return Redirect::route('profil.index')->with('success', 'Vos constantes et informations médicales ont été mises à jour avec succès.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
