<?php

namespace App\Http\Controllers;

use App\Models\Favorita;
use App\Models\Pension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Zona;

class FavoritaController extends Controller
{
    /**
     * Listar las habitaciones favoritas del estudiante logueado
     */
    public function index()
    {
        $user = Auth::user();

        if (! $user || $user->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Buscar el id_estudiante a partir del user actual
        $estudiante = DB::table('estudiante')
            ->join('persona', 'estudiante.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $user->id)
            ->select('estudiante.id')
            ->first();

        if (! $estudiante) {
            // No tiene registro en estudiante
            $favoritas = collect();
        } else {
            $favoritas = Favorita::with(['pension.zona', 'pension.tipoHabitacion'])
                ->where('id_estudiante', $estudiante->id)
                ->get();
        }
        
        $zonas = Zona::all();

        return view('favorita', compact('favoritas', 'user', 'zonas'));
    }

    /**
     * Guardar una pensión en favoritos
     */
    public function store(Pension $pension)
    {
        $user = Auth::user();

        if (! $user || $user->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Buscar el estudiante del usuario actual
        $estudiante = DB::table('estudiante')
            ->join('persona', 'estudiante.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $user->id)
            ->select('estudiante.id')
            ->first();

        if (! $estudiante) {
            return back()->with('error', 'No se pudo identificar el estudiante asociado al usuario.');
        }

        // Verificar si YA está en favoritos
        $yaExiste = Favorita::where('id_estudiante', $estudiante->id)
            ->where('id_pension', $pension->id)
            ->exists();

        if ($yaExiste) {
            return back()->with('info', 'Esta habitación ya está en tus favoritas.');
        }

        // Crear el registro en favorita
        Favorita::create([
            'id_estudiante' => $estudiante->id,
            'id_pension'    => $pension->id,
        ]);

        return back()->with('success', 'Habitación guardada en tus favoritas.');
    }

    /**
     * Eliminar una pensión de favoritos
     */
    public function destroy(Pension $pension)
    {
        $user = Auth::user();

        if (! $user || $user->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        $estudiante = DB::table('estudiante')
            ->join('persona', 'estudiante.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $user->id)
            ->select('estudiante.id')
            ->first();

        if ($estudiante) {
            Favorita::where('id_estudiante', $estudiante->id)
                ->where('id_pension', $pension->id)
                ->delete();
        }

        return back()->with('success', 'Habitación eliminada de tus favoritas.');
    }
}
