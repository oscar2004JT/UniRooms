<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Modelos
use App\Models\Pension;
use App\Models\Zona;
use App\Models\Arriendo;
use App\Models\TipoHabitacion;
use App\Models\EstadoArriendo;
// Acciones
use App\Actions\UploadRoomImage;

class PropietarioController extends Controller
{
    /**
     * Perfil público del propietario
     */
    public function perfil($id)
    {
        // Traemos toda la cadena: propietario -> persona -> users -> telefono
        $row = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->join('users', 'persona.id_user', '=', 'users.id')
            ->leftJoin('telefono', 'telefono.id_usuario', '=', 'users.id')
            ->select(
                'propietario.id as propietario_id',
                'users.id as user_id',
                'users.name',
                'users.email',
                'telefono.numero as telefono',
                'persona.apellido',
                'persona.numero_documento',
                'persona.id_documento',
                'persona.id_sexo',
                'persona.fecha_nacimiento'
            )
            ->where('propietario.id', $id)
            ->first();

        if (!$row) {
            abort(404);
        }

        // Mapear id_documento
        $tipoDocumento = match ($row->id_documento) {
            1       => 'CC',
            2       => 'TI',
            3       => 'CE',
            4       => 'PA',
            5       => 'RC',
            default => '',
        };

        // Mapear sexo
        $sexo = match ($row->id_sexo) {
            1       => 'M',
            2       => 'F',
            3       => 'O',
            default => '',
        };

        // Objeto limpio para la vista
        $propietario = (object) [
            'propietario_id'   => $row->propietario_id,
            'user_id'          => $row->user_id,
            'name'             => $row->name,
            'apellido'         => $row->apellido,
            'email'            => $row->email,
            'telefono'         => $row->telefono,
            'documento'        => $row->numero_documento,
            'tipo_documento'   => $tipoDocumento,
            'sexo'             => $sexo,
            'fecha_nacimiento' => $row->fecha_nacimiento,
        ];

        $zonas = Zona::all();

        return view('perfil', compact('propietario', 'zonas'));
    }

    /**
     * Habitaciones publicadas por el propietario logueado
     */
    public function misHabitaciones()
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Obtener id_propietario desde la tabla propietario/persona
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId) {
            abort(403, 'No se encontró el propietario asociado a este usuario.');
        }

        // Pensiones de este propietario
        $pensiones = Pension::with(['zona', 'tipoHabitacion'])
            ->where('id_propietario', $propietarioId)
            ->latest()
            ->get();

        // Zonas para el footer
        $zonas = Zona::all();

        return view('propietario-habitaciones', compact('pensiones', 'zonas', 'usuario'));
    }

    /**
     * 🔹 Ver detalle de una pensión como PROPIETARIO
     *     (usa la vista resources/views/ver-dellates.blade.php)
     */
    public function verDetalle(Pension $pension)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Obtener id_propietario del usuario logueado
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId) {
            abort(403, 'No se encontró el propietario asociado a este usuario.');
        }

        // Verificar que la pensión pertenece a este propietario
        if ((int) $pension->id_propietario !== (int) $propietarioId) {
            abort(403, 'No tienes permiso para ver esta habitación.');
        }

        // Cargar relaciones necesarias
        $pension->load(['zona', 'tipoHabitacion', 'servicios', 'estado']);

        // Zonas para el footer
        $zonas = Zona::all();

        // Vista de detalle para propietario
        return view('ver-dellates', compact('pension', 'usuario', 'zonas'));
    }

    /**
     * 🔹 EDITAR HABITACIÓN (mostrar formulario)
     *     Vista: resources/views/pension-edit.blade.php
     */
    public function edit(Pension $pension)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Verificar propietario
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId || (int) $pension->id_propietario !== (int) $propietarioId) {
            abort(403, 'No tienes permiso para editar esta habitación.');
        }

        // Cargar relaciones necesarias
        $pension->load(['zona', 'tipoHabitacion', 'servicios']);

        // Zonas y tipos de habitación para selects
        $zonas = Zona::all();
        $tiposHabitacion = TipoHabitacion::all();

        // IDs de servicios/amenities seleccionados (los usará la vista)
        $amenitiesSeleccionadas = $pension->servicios
            ? $pension->servicios->pluck('id')->toArray()
            : [];

        return view(
            'pension-edit',
            compact('pension', 'usuario', 'zonas', 'tiposHabitacion', 'amenitiesSeleccionadas')
        );
    }

    /**
     * 🔹 ACTUALIZAR HABITACIÓN (guardar cambios)
     */
    public function update(Request $request, Pension $pension, UploadRoomImage $uploadRoomImage)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Verificar propietario
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId || (int) $pension->id_propietario !== (int) $propietarioId) {
            abort(403, 'No tienes permiso para actualizar esta habitación.');
        }

        // ✅ Validación
        $data = $request->validate([
            'nombre'               => 'required|string|max:255',
            'precio'               => 'required|numeric|min:0',
            'id_zona'              => 'required|integer',
            'ubicacion_especifica' => 'required|string|max:255',
            'id_tipo_habitacion'   => 'required|integer',
            'capacidad'            => 'required|integer|min:1|max:6',
            'descripcion'          => 'required|string|min:10',
            'amenities'            => 'nullable|array',
            'amenities.*'          => 'integer',
            'id_estado'            => 'required|integer',
            'imagenes.*'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // ✅ Asignar campos básicos
        $pension->nombre               = $data['nombre'];
        $pension->precio               = $data['precio'];
        $pension->id_zona              = $data['id_zona'];
        $pension->ubicacion_especifica = $data['ubicacion_especifica'];
        $pension->id_tipo_habitacion   = $data['id_tipo_habitacion'];
        $pension->capacidad            = $data['capacidad'];
        $pension->descripcion          = $data['descripcion'];
        $pension->id_estado            = $data['id_estado'];

        // ✅ Manejo de imágenes con Cloudinary (solo si suben nuevas)
        if ($request->hasFile('imagenes')) {
            $urls = $uploadRoomImage->handle($request->file('imagenes'));
            $pension->link_foto = $urls;
        }

        $pension->save();

        // ✅ Actualizar relación muchos-a-muchos con servicios/amenities
        $pension->servicios()->sync($data['amenities'] ?? []);

        return redirect()
            ->route('pension.edit', $pension)
            ->with('success', 'Habitación actualizada correctamente.');
    }

    /**
     * Solicitudes de reservas (arriendos) recibidas para las habitaciones del propietario
     */
    public function solicitudesReservas()
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Obtener id_propietario
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId) {
            abort(403, 'No se encontró el propietario asociado a este usuario.');
        }

        // Ids de las pensiones del propietario
        $pensionesIds = Pension::where('id_propietario', $propietarioId)->pluck('id');

        // Todas las solicitudes (arriendos) para esas pensiones
        $solicitudes = Arriendo::with(['pension.zona', 'pension.tipoHabitacion', 'estado'])
            ->whereIn('id_pension', $pensionesIds)
            ->orderByDesc('created_at')
            ->get();

        $zonas = Zona::all();

        return view('propietario-solicitudes', compact('solicitudes', 'zonas', 'usuario'));
    }

    /**
     * Habitaciones reservadas (arriendos activos: sin fecha_fin) del propietario
     */
    public function habitacionesReservadas()
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Obtener id_propietario
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId) {
            abort(403, 'No se encontró el propietario asociado a este usuario.');
        }

        // Ids de las pensiones del propietario
        $pensionesIds = Pension::where('id_propietario', $propietarioId)->pluck('id');

        // Arriendos activos (sin fecha_fin) de esas pensiones
        $arriendosActivos = Arriendo::with(['pension.zona', 'pension.tipoHabitacion'])
            ->whereIn('id_pension', $pensionesIds)
            ->whereNull('fecha_fin')
            ->orderByDesc('created_at')
            ->get();

        $zonas = Zona::all();

        //return view('propietario-habitaciones-reservadas', compact('arriendosActivos', 'zonas', 'usuario'));
    }

    /**
     * Solicitudes de reservas RECHAZADAS (id_estado = rechazado)
     */
    public function solicitudesRechazadas()
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Obtener id_propietario
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId) {
            abort(403, 'No se encontró el propietario asociado a este usuario.');
        }

        // Id del estado "rechazado"
        $estadoRechazadoId = EstadoArriendo::where('nombre', 'rechazado')->value('id');

        // Ids de las pensiones del propietario
        $pensionesIds = Pension::where('id_propietario', $propietarioId)->pluck('id');

        // Arriendos RECHAZADOS de esas pensiones
        $solicitudes = Arriendo::with(['pension.zona', 'pension.tipoHabitacion', 'estado'])
            ->whereIn('id_pension', $pensionesIds)
            ->where('id_estado', $estadoRechazadoId)
            ->orderByDesc('created_at')
            ->get();

        $zonas = Zona::all();

        // Usamos la misma vista, sólo que ahora $solicitudes son las rechazadas
        return view('propietario-solicitudes', compact('solicitudes', 'zonas', 'usuario'));
    }

    /**
     * Cambiar el estado de una solicitud de arriendo (aceptar / rechazar)
     */
    public function cambiarEstadoSolicitud(Request $request, Arriendo $arriendo)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== 'propietario') {
            return redirect()->route('inicio');
        }

        // Verificar que la solicitud pertenece a una pensión de este propietario
        $propietarioId = DB::table('propietario')
            ->join('persona', 'propietario.id_persona', '=', 'persona.id')
            ->where('persona.id_user', $usuario->id)
            ->value('propietario.id');

        if (!$propietarioId) {
            abort(403, 'No se encontró el propietario asociado a este usuario.');
        }

        // Asegurar que la pensión de este arriendo es del propietario
        $arriendo->loadMissing('pension');

        if ((int) $arriendo->pension->id_propietario !== (int) $propietarioId) {
            abort(403, 'No tienes permiso para modificar esta solicitud.');
        }

        $request->validate([
            'accion' => 'required|in:aceptar,rechazar',
        ]);

        if ($request->accion === 'aceptar') {
            $nuevoEstadoId = EstadoArriendo::where('nombre', 'aceptado')->value('id');
        } else {
            $nuevoEstadoId = EstadoArriendo::where('nombre', 'rechazado')->value('id');
        }

        $arriendo->id_estado = $nuevoEstadoId;
        $arriendo->save();

        return back()->with('success', 'El estado de la solicitud se actualizó correctamente.');
    }
    /**
 * Ver el perfil del estudiante + detalles de la reserva
 * para una pensión específica del propietario.
 *
 * Ruta: propietario.habitacion.perfilestudiante
 */public function perfilEstudiante(Pension $pension)
{
    $usuario = Auth::user();

    // Solo propietarios
    if (!$usuario || $usuario->rol->nombre !== 'propietario') {
        return redirect()->route('inicio');
    }

    // Obtener id_propietario del usuario logueado
    $propietarioId = DB::table('propietario')
        ->join('persona', 'propietario.id_persona', '=', 'persona.id')
        ->where('persona.id_user', $usuario->id)
        ->value('propietario.id');

    if (!$propietarioId) {
        abort(403, 'No se encontró el propietario asociado a este usuario.');
    }

    // Verificar que la pensión pertenece a este propietario
    if ((int) $pension->id_propietario !== (int) $propietarioId) {
        abort(403, 'No tienes permiso para ver esta reserva.');
    }

    // Buscar el arriendo más reciente de esta pensión
    $arriendo = Arriendo::with('estado')
        ->where('id_pension', $pension->id)
        ->orderByDesc('created_at')
        ->first();

    if (!$arriendo) {
        abort(404, 'No se encontró ninguna reserva para esta habitación.');
    }

    // Traer datos del estudiante: estudiante -> persona -> users -> telefono
    $row = DB::table('estudiante')
        ->join('persona', 'estudiante.id_persona', '=', 'persona.id')
        ->join('users', 'persona.id_user', '=', 'users.id')
        ->leftJoin('telefono', 'telefono.id_usuario', '=', 'users.id')
        ->select(
            'estudiante.id as estudiante_id',
            'users.id as user_id',
            'users.name',
            'users.email',
            'telefono.numero as telefono',
            'persona.apellido',
            'persona.numero_documento',
            'persona.id_documento',
            'persona.id_sexo',
            'persona.fecha_nacimiento'
        )
        ->where('estudiante.id', $arriendo->id_estudiante)
        ->first();

    if (!$row) {
        abort(404, 'No se encontró información del estudiante asociado a esta reserva.');
    }

    // Mapear tipo de documento
    $tipoDocumento = match ($row->id_documento) {
        1       => 'CC',
        2       => 'TI',
        3       => 'CE',
        4       => 'PA',
        5       => 'RC',
        default => '',
    };

    // Mapear sexo
    $sexo = match ($row->id_sexo) {
        1       => 'M',
        2       => 'F',
        3       => 'O',
        default => '',
    };

    // Objeto "estudiante" limpio para la vista
    $estudiante = (object) [
        'estudiante_id'    => $row->estudiante_id,
        'user_id'          => $row->user_id,
        'name'             => $row->name,
        'apellido'         => $row->apellido,
        'email'            => $row->email,
        'telefono'         => $row->telefono,
        'documento'        => $row->numero_documento,
        'tipo_documento'   => $tipoDocumento,
        'sexo'             => $sexo,
        'fecha_nacimiento' => $row->fecha_nacimiento,
    ];

    // Cargar relaciones de la pensión
    $pension->loadMissing(['zona', 'tipoHabitacion']);

    // 🔹 Zonas para el footer
    $zonas = Zona::all();

    return view('perfil-estudiante', [
        'estudiante' => $estudiante,
        'arriendo'   => $arriendo,
        'pension'    => $pension,
        'usuario'    => $usuario,
        'zonas'      => $zonas,
    ]);
}

}
