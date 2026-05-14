<?php

namespace App\Http\Controllers;

use App\Models\Arriendo;
use App\Models\Pension;
use App\Models\EstadoArriendo;
use App\Models\Zona; // 👈 IMPORTANTE: zonas para el footer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArriendoController extends Controller
{
    /**
     * Listar arriendos del estudiante logueado.
     */
    public function index()
    {
        $usuario = Auth::user();

        // Solo estudiantes
        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Obtener id_estudiante desde la relación User -> Persona -> Estudiante
        $estudianteId = $usuario->persona?->estudiante?->id;

        if (!$estudianteId) {
            abort(403, 'No se encontró información de estudiante para este usuario.');
        }

        $arriendos = Arriendo::with(['pension.zona', 'pension.tipoHabitacion', 'estado'])
            ->where('id_estudiante', $estudianteId)
            ->latest()
            ->get();

        // 👇 Para el footer de mis-reservas.blade.php
        $zonas = Zona::all();

        return view('mis-reservas', compact('arriendos', 'usuario', 'zonas'));
    }

    /**
     * Mostrar formulario para reservar una pensión específica.
     */
    public function create(Pension $pension)
    {
        $usuario = Auth::user();

        // Solo estudiantes
        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Cargar relaciones que usas en la vista
        $pension->load(['tipoHabitacion', 'zona']);

        // 👇 Si en reservar-habitacion también usas el footer con zonas
        $zonas = Zona::all();

        return view('reservar-habitacion', compact('pension', 'usuario', 'zonas'));
    }

    /**
     * Guardar la solicitud de arriendo en la base de datos.
     * Por defecto, el estado será "rechazado".
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        // Solo estudiantes
        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Obtener id_estudiante desde la relación User -> Persona -> Estudiante
        $estudianteId = $usuario->persona?->estudiante?->id;

        if (!$estudianteId) {
            return back()->withErrors([
                'general' => 'No se pudo asociar la reserva al estudiante actual.',
            ])->withInput();
        }

        // Validación
        $validated = $request->validate([
            'id_pension'    => 'required|exists:pension,id',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after:fecha_inicio',
            'mensaje'       => 'nullable|string|max:1000',
        ]);

        // Comprobar si ya tiene un arriendo activo en esa pensión
        $yaExiste = Arriendo::where('id_estudiante', $estudianteId)
            ->where('id_pension', $validated['id_pension'])
            ->whereNull('fecha_fin')
            ->exists();

        if ($yaExiste) {
            return back()->withErrors([
                'general' => 'Ya tienes un arriendo activo para esta habitación.',
            ])->withInput();
        }

        // Obtener id del estado "rechazado" (desde la tabla estadoarriendo)
        $estadoRechazadoId = EstadoArriendo::where('nombre', 'rechazado')->value('id');

        // Crear registro en tabla arriendo con estado "rechazado" por defecto
        Arriendo::create([
            'id_estudiante' => $estudianteId,
            'id_pension'    => $validated['id_pension'],
            'id_estado'     => $estadoRechazadoId,   // 👈 Estado por defecto
            'fecha_inicio'  => $validated['fecha_inicio'],
            'fecha_fin'     => $validated['fecha_fin'] ?? null,
            'mensaje'       => $validated['mensaje'] ?? null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Tu solicitud de reserva se ha registrado correctamente. El propietario se pondrá en contacto contigo.');
    }

    /**
     * Mostrar un arriendo específico.
     */
    public function show(Arriendo $arriendo)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Asegurar que el arriendo pertenece a este estudiante
        $estudianteId = $usuario->persona?->estudiante?->id;

        if (!$estudianteId || $arriendo->id_estudiante !== $estudianteId) {
            abort(403);
        }

        $arriendo->load(['pension.zona', 'pension.tipoHabitacion', 'estado']);

        // Si esta vista usa footer con zonas, descomenta estas dos líneas:
        // $zonas = Zona::all();
        // return view('arriendos.show', compact('arriendo', 'usuario', 'zonas'));

        return view('arriendos.show', compact('arriendo', 'usuario'));
    }

    /**
     * Cancelar / eliminar un arriendo.
     */
    public function destroy(Arriendo $arriendo)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        $estudianteId = $usuario->persona?->estudiante?->id;

        if (!$estudianteId || $arriendo->id_estudiante !== $estudianteId) {
            abort(403);
        }

        $arriendo->delete();

        return redirect()
            ->back()
            ->with('success', 'El arriendo ha sido cancelado correctamente.');
    }
}
