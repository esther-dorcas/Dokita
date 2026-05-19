<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Accès non autorisé');
        }

        // Vérification de l'approbation du médecin par l'hôpital
        if (auth()->user()->role === 'medecin' && auth()->user()->medecin) {
            $statut = auth()->user()->medecin->statut;
            $currentRouteName = $request->route()->getName();
            
            if ($statut === 'en_attente' && $currentRouteName !== 'medecin.attente') {
                return redirect()->route('medecin.attente');
            }
        }

        return $next($request);
    }
}
