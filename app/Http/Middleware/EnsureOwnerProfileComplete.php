<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOwnerProfileComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Debe ser propietario
        if (!$user->rol || $user->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Debe tener persona + propietario
        $persona     = $user->persona ?? null;
        $propietario = $persona?->propietario ?? null;

        if (!$persona || !$propietario) {
            return redirect()
                ->route('profile.show')
                ->with('error', 'Por favor completa tu información de perfil de propietario antes de publicar habitaciones.');
        }

        return $next($request);
    }
}
