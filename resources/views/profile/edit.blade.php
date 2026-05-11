@extends('layouts.dokita')

@section('title', 'Paramètres du compte — Dokita')

@push('head')
<style>
    :root { --blue: #2563eb; --dark: #0c2340; --radius-xl: 20px; --radius-lg: 14px; }
    @keyframes slideUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
    .animate-up { animation: slideUp .45s ease-out; }

    .page-header {
        margin-bottom: 30px;
    }
    .page-header h1 { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; }
    .page-header p { font-size: 14px; color: #64748b; margin: 0; }

    .settings-grid {
        display: grid; gap: 24px; max-width: 800px;
    }
    
    .settings-card {
        background: #fff; border-radius: var(--radius-xl);
        border: 1px solid #e8edf5; padding: 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,.02);
    }
    
    /* Override Laravel Default Form Styles to match Dokita Premium */
    .settings-card h2 { font-size: 18px !important; font-weight: 800 !important; color: #0f172a !important; margin-bottom: 8px !important; }
    .settings-card p { font-size: 13px !important; color: #64748b !important; }
    
    .settings-card input[type="text"],
    .settings-card input[type="email"],
    .settings-card input[type="password"] {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        font-size: 14px !important;
        background: #f8fafc !important;
        box-shadow: none !important;
        transition: 0.2s !important;
        width: 100% !important;
        margin-top: 6px !important;
    }
    .settings-card input:focus {
        border-color: var(--blue) !important;
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(37,99,235,.1) !important;
        outline: none !important;
    }
    .settings-card label {
        font-size: 12px !important; font-weight: 800 !important; color: #475569 !important; margin-bottom: 6px !important; display: block; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .settings-card button {
        border-radius: 10px !important;
        font-weight: 800 !important;
        padding: 10px 20px !important;
        text-transform: uppercase !important; letter-spacing: 0.5px !important;
        font-size: 12px !important;
    }
    .settings-card .bg-gray-800 {
        background-color: var(--blue) !important;
    }
    .settings-card .bg-gray-800:hover {
        background-color: #1d4ed8 !important;
    }
    .settings-card .bg-red-600 {
        background-color: #dc2626 !important;
    }
    .settings-card .bg-red-600:hover {
        background-color: #b91c1c !important;
    }
    .settings-card .text-red-600 {
        color: #dc2626 !important;
    }
</style>
@endpush

@section('content')
<div class="animate-up">
    
    <div class="page-header">
        <h1>Paramètres du compte</h1>
        <p>Gérez vos informations de connexion et la sécurité de votre compte.</p>
    </div>

    <div class="settings-grid">
        <div class="settings-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="settings-card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="settings-card" style="border-color: #fecaca; background-color: #fef2f2;">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
    
</div>
@endsection
