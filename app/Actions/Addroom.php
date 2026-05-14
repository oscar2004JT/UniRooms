<?php

namespace App\Actions;

use App\Models\Pension;
use Illuminate\Validation\ValidationException;

class Addroom
{
    public function handle($user, array $input)
    {
        $nombre               = trim($input['nombre'] ?? '');
        $precio               = trim($input['precio'] ?? '');
        $capacidad            = trim($input['capacidad'] ?? '');
        $ubicacion            = trim($input['ubicacion_especifica'] ?? '');
        $descripcion          = trim($input['descripcion'] ?? '');
        $id_tipo_habitacion   = $input['id_tipo_habitacion'] ?? null;
        $id_zona              = $input['id_zona'] ?? null;
        $id_estado            = $input['id_estado'] ?? null;
        $servicios            = $input['amenities'] ?? [];

        // 🔹 URLs reales enviadas desde el controlador
        $linkFoto = $input['link_foto'] ?? [];

        // Validaciones
        if (!$nombre) {
            throw ValidationException::withMessages(['nombre' => 'El nombre es obligatorio']);
        }
        if (!$precio || !is_numeric($precio)) {
            throw ValidationException::withMessages(['precio' => 'Precio inválido']);
        }
        if (!$capacidad || !is_numeric($capacidad)) {
            throw ValidationException::withMessages(['capacidad' => 'Capacidad inválida']);
        }
        if (!$ubicacion) {
            throw ValidationException::withMessages(['ubicacion_especifica' => 'La ubicación es obligatoria']);
        }

        // Crear pensión
        $pension = Pension::create([
            'id_propietario'        => $user->persona->propietario->id ?? null,
            'nombre'                => $nombre,
            'precio'                => $precio,
            'capacidad'             => $capacidad,
            'ubicacion_especifica'  => $ubicacion,
            'descripcion'           => $descripcion,
            'disponible'            => $input['disponible'] ?? true,

            // 👇 Dejamos que Eloquent haga el json_encode según el cast
            'link_foto'             => !empty($linkFoto) ? $linkFoto : null,

            'id_tipo_habitacion'    => $id_tipo_habitacion,
            'id_zona'               => $id_zona,
            'id_estado'             => $id_estado,
        ]);

        // Asociar servicios
        if (!empty($servicios)) {
            $pension->servicios()->attach($servicios);
        }

        return $pension;
    }
}
