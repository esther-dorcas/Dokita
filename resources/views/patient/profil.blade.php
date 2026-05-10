@extends('layouts.dokita')

@section('title', 'Mon profil — Dokita')
@section('page-title', 'Mon profil')
@section('page-subtitle', 'Consultez et gérez vos informations personnelles.')

@section('content')
<div class="space-y-6 max-w-3xl">

    <!-- En-tête profil -->
    <div class="rounded-3xl border border-slate-100 bg-white p-6 md:p-8 shadow-sm">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-5">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-medical-600 to-medical-800 text-white text-3xl font-display font-bold shadow-lg shadow-medical-600/30 flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-display font-bold text-slate-900">{{ Auth::user()->name }}</h1>
                    <p class="text-sm font-medium text-slate-500 mt-1">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-2 rounded-xl border border-medical-200 bg-medical-50 px-5 py-2.5 text-sm font-bold text-medical-700 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-medical-500 animate-pulse"></span>
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </div>

    <!-- Informations personnelles -->
    <div class="rounded-3xl border border-slate-100 bg-white p-6 md:p-8 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            Informations personnelles
        </h2>
        
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-5 border border-slate-100 hover:border-slate-200 transition-colors">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nom complet</p>
                <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-5 border border-slate-100 hover:border-slate-200 transition-colors">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Adresse e-mail</p>
                <p class="text-sm font-bold text-slate-900">{{ Auth::user()->email }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-5 border border-slate-100 hover:border-slate-200 transition-colors">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Téléphone</p>
                <p class="text-sm font-bold text-slate-900">{{ Auth::user()->telephone ?? 'Non renseigné' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-5 border border-slate-100 hover:border-slate-200 transition-colors">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Rôle</p>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                    <p class="text-sm font-bold text-slate-900">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Préférences -->
    <div class="rounded-3xl border border-slate-100 bg-white p-6 md:p-8 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-medical-50 text-medical-600 flex items-center justify-center">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
            </div>
            Préférences
        </h2>
        <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 p-8 text-center flex flex-col items-center justify-center">
            <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 text-slate-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-500">Les options de notification et de rappel pour vos rendez-vous seront disponibles prochainement.</p>
        </div>
    </div>
</div>
@endsection
