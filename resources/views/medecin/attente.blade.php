@extends('layouts.medecin')

@section('title', 'Compte en attente de validation')

@section('content')
<div style="min-height: calc(100vh - 150px); display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #fff; border-radius: 24px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #e8edf5;">
        
        <div style="width: 80px; height: 80px; border-radius: 50%; background: #fffbeb; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <svg width="40" height="40" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">En attente de validation</h1>
        
        <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 24px;">
            Votre compte a bien été créé. Cependant, pour des raisons de sécurité, l'administration de <strong>{{ Auth::user()->medecin->hopital->nom ?? 'votre hôpital' }}</strong> doit valider votre identité et votre affectation avant que vous puissiez accéder à votre espace praticien.
        </p>

        <div style="background: #f8fafc; padding: 16px; border-radius: 12px; margin-bottom: 24px; text-align: left;">
            <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Étape suivante</div>
            <div style="font-size: 14px; font-weight: 600; color: #0f172a;">Veuillez contacter l'administration de la clinique pour accélérer l'activation de votre compte.</div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: #0f172a; color: #fff; border: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: 0.2s;">
                Se déconnecter en attendant
            </button>
        </form>

    </div>
</div>
@endsection
