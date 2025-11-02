<?php

namespace App\Actions;

use App\Models\Pension;
use Illuminate\Validation\ValidationException;

class Addroom
{
    public function handle($user, array $input)
    {

        $nombre = trim($input['nombre'] ?? '');
        $precio = trim($input['precio'] ?? '');
        $capacidad = trim($input['capacidad'] ?? '');
        $ubicacion_especifica = trim($input['ubicacion_especifica'] ?? '');
        $descripcion = trim($input['descripcion'] ?? '');
        $id_tipo_habitacion = trim($input['id_tipo_habitacion'] ?? '');
        $id_zona = trim($input['id_zona'] ?? '');
        $id_estado = trim($input['id_estado'] ?? '');
        $id_servicio = $input['amenities'] ?? [];

        // Validaciones
        if (empty($nombre)) {
            throw ValidationException::withMessages(['nombre' => 'El nombre es obligatorio']);
        }

        if (empty($capacidad) || !is_numeric($capacidad) || $capacidad <= 0) {
            throw ValidationException::withMessages(['capacidad' => 'Debe ser un número entero positivo']);
        }

        if (empty($precio) || !is_numeric($precio) || $precio < 0) {
            throw ValidationException::withMessages(['precio' => 'Debe ser un número positivo']);
        }

        if (empty($ubicacion_especifica)) {
            throw ValidationException::withMessages(['ubicacion_especifica' => 'Obligatorio']);
        }

        // Crear pensión
        $pension = Pension::create([
            'id_propietario' => $user->persona->propietario->id ?? null,
            'nombre' => $nombre,
            'precio' => $precio,
            'capacidad' => $capacidad,
            'ubicacion_especifica' => $ubicacion_especifica,
            'disponible' => $input['disponible'] ?? true,
            'link_foto' => $input['link_foto'] ?? '',
            'id_tipo_habitacion' => $id_tipo_habitacion,
            'id_zona' => $id_zona,
            'id_estado' => $id_estado,
            'descripcion' => $descripcion,
        ]);

        // Asociar servicios si los hay
        if (!empty($id_servicio)) {
            $pension->servicios()->attach($id_servicio);
        }
        return $pension;
    }
}
