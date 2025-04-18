<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Vérifie que l'utilisateur est connecté
        if (!$user) {
            abort(403, 'Utilisateur non connecté.');
        }

        // Vérifie si l'utilisateur a le rôle "admin"
        $school = $user->schools()->wherePivot('role', 'admin')->first();

        if (!$school) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}