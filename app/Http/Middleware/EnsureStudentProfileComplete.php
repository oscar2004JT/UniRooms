<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStudentProfileComplete
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

        // Debe ser estudiante
        if (!$user->rol || $user->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Debe tener persona + estudiante
        $persona    = $user->persona ?? null;
        $estudiante = $persona?->estudiante ?? null;

        if (!$persona || !$estudiante) {
            // Redirige a la página de perfil (o a la que uses para completar datos)
            return redirect()
                ->route('profile.show')
                ->with('error', 'Por favor completa tu información de perfil de estudiante antes de buscar o reservar habitaciones.');
        }

        return $next($request);
    }
}
