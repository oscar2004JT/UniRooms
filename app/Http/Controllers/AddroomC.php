<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Actions\AddRoom;
use App\Actions\UploadRoomImage;
use Illuminate\Validation\ValidationException;

// Modelos
use App\Models\Pension;
use App\Models\TipoHabitacion;
use App\Models\Zona;
use App\Models\Favorita;

class AddroomC extends Controller
{
    /**
     * Página de búsqueda/listado de habitaciones (pensiones) para estudiantes.
     */
    public function index()
    {
        $usuario = Auth::user();

        // Si no es estudiante, redirige a /inicio
        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Traer SOLO pensiones publicadas con sus relaciones
        $pensiones = Pension::with(['tipoHabitacion', 'zona', 'servicios', 'estado'])
            ->whereHas('estado', function ($q) {
                $q->where('nombre', 'publicada');   // ajusta si tu estado se llama distinto
            })
            ->get();

        // Traer tipos de habitación y zonas para los filtros
        $tiposHabitacion = TipoHabitacion::all();
        $zonas = Zona::all();

        // Calcular rangos de precio para los sliders
        $minPrecio = $pensiones->min('precio') ?? 0;
        $maxPrecio = $pensiones->max('precio') ?? 1000;

        // Vista buscarroom
        return view('buscarroom', compact(
            'usuario',
            'pensiones',
            'tiposHabitacion',
            'zonas',
            'minPrecio',
            'maxPrecio'
        ));
    }

    /**
     * Formulario para registrar una nueva habitación/pensión (vista addroom.blade.php).
     */
    public function create()
    {
        $usuario = Auth::user();

        // (Opcional) restringir a propietarios
        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
         return redirect()->route('inicio');
        }

        $tiposHabitacion = TipoHabitacion::all();
        $zonas = Zona::all();

        return view('addroom', compact('usuario', 'tiposHabitacion', 'zonas'));
    }

    /**
     * Ver detalle de una pensión / habitación.
     */
    public function show(Pension $pension)
    {
        $usuario = Auth::user(); // estudiante logueado

        if (!$usuario || $usuario->rol->nombre !== 'estudiante') {
            return redirect()->route('inicio');
        }

        // Cargar relaciones necesarias para la pensión
        $pension->load(['tipoHabitacion', 'zona', 'servicios', 'estado']);

        // (Opcional) impedir ver borradores directamente
        if ($pension->estado && strtolower($pension->estado->nombre) !== 'publicada') {
            abort(404);
        }

        // 🔹 Sacar el propietario REAL a partir de pension.id_propietario
        $propietario = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->join('users', 'persona.id_user', '=', 'users.id')
            ->leftJoin('telefono', 'telefono.id_usuario', '=', 'users.id')
            ->select(
                'propietario.id as propietario_id',
                'users.id as user_id',
                'users.name',
                'users.email',
                'telefono.numero as telefono'
            )
            ->where('propietario.id', $pension->id_propietario)
            ->first();

        // 🔹 Saber si esta pensión YA ES favorita del estudiante actual
        $yaEsFavorita = false;

        // Buscar el estudiante del usuario actual
        $estudiante = DB::table('estudiante')
            ->join('persona', 'estudiante.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->select('estudiante.id')
            ->first();

        if ($estudiante) {
            $yaEsFavorita = Favorita::where('id_estudiante', $estudiante->id)
                ->where('id_pension', $pension->id)
                ->exists();
        }

        // 🔹 Zonas para el footer
        $zonas = Zona::all();

        // Si no hay propietario, la vista mostrará "Perfil no disponible"
        return view('detalle-room', compact(
            'pension',
            'usuario',
            'propietario',
            'yaEsFavorita',
            'zonas'
        ));
    }

    /**
     * Registrar nueva habitación/pensión.
     */
    public function store(Request $request, AddRoom $addRoom, UploadRoomImage $uploadRoomImage)
    {
        try {
            $request->validate([
                'nombre'               => 'required|string|max:255',
                'descripcion'          => 'required|string',
                'precio'               => 'required|numeric|min:0',
                'capacidad'            => 'required|integer|min:1',
                'ubicacion_especifica' => 'required|string|max:255',
                'imagenes.*'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            ]);

            // Subir imágenes y obtener URLs
            $urls = [];
            if ($request->hasFile('imagenes')) {
                // Debe devolver array de URLs de las imágenes
                $urls = $uploadRoomImage->handle($request->file('imagenes'));
            }

            // Crear habitación/pensión
            $pension = $addRoom->handle(Auth::user(), [
                ...$request->all(),
                'link_foto' => $urls, // aquí guardas el array de URLs en el JSON
            ]);

            return back()->with('success', 'Habitación registrada correctamente.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator->errors())
                ->withInput();

        } catch (\Exception $e) {
            return back()->with(
                'error',
                'Ocurrió un error al registrar la habitación: ' . $e->getMessage()
            );
        }
    }
}
