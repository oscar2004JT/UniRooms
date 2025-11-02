<?php

namespace App\Actions\Profile;

use App\Models\Persona;
use App\Models\Telefono;
use App\Models\Estudiante;
use App\Models\Propietario;
use Illuminate\Validation\ValidationException;

class CreateOrUpdateAdditionalProfileData
{
    public function handle($user, array $input)
    {
        // Limpiar y validar campos obligatorios
        $name = trim($input['name'] ?? '');
        $apellido = trim($input['apellido'] ?? '');
        $documento = trim($input['documento'] ?? '');
        $tipoDocumento = trim($input['tipo_documento'] ?? '');
        $sexo = trim($input['sexo'] ?? '');
        $telefono = trim($input['telefono'] ?? '');
        $tipoTelefono = trim($input['tipo_telefono'] ?? 'movil');

        if (empty($name)) {
            throw ValidationException::withMessages(['name' => 'El nombre es obligatorio.']);
        }

        if (empty($apellido)) {
            throw ValidationException::withMessages(['apellido' => 'El apellido es obligatorio.']);
        }

        if (empty($documento)) {
            throw ValidationException::withMessages(['documento' => 'El número de documento es obligatorio.']);
        }

        if (empty($tipoDocumento)) {
            throw ValidationException::withMessages(['tipo_documento' => 'El tipo de documento es obligatorio.']);
        }

        if (empty($sexo)) {
            throw ValidationException::withMessages(['sexo' => 'El sexo es obligatorio.']);
        }

        // Crear o actualizar persona
        $persona = Persona::updateOrCreate(
            ['id_user' => $user->id],
            [
                'nombre' => $input['name'],
                'apellido' => $input['apellido'],
                'numero_documento' => $input['documento'],
                'id_documento' => $this->mapTipoDocumento($input['tipo_documento']),
                'id_sexo' => $this->mapSexo($input['sexo']),
            ]
        );

        // Crear o actualizar teléfono (opcional)
        if (!empty($telefono)) {
            Telefono::updateOrCreate(
                ['id_usuario' => $user->id],
                [
                    'numero' => $telefono,
                    'id_codigo_pais' => 1, // Por defecto +57 (Colombia)
                    'id_tipo_telefono' => $this->mapTipoTelefono($tipoTelefono),
                ]
            );
        }

        // 🔹 Crear Estudiante o Propietario según el rol del usuario
        if ($user->id_rol === 1) {
            // Rol: Estudiante
            Estudiante::updateOrCreate(
                ['id_persona' => $persona->id],
            );
        } elseif ($user->id_rol === 2) {
            // Rol: Propietario
            Propietario::updateOrCreate(
                ['id_persona' => $persona->id],
            );
        }
    }

    private function mapTipoDocumento(string $tipo): int
    {
        return match (strtoupper($tipo)) {
            'CC' => 1,
            'TI' => 2,
            'CE' => 3,
            'PA' => 4,
            'RC' => 5,
            default => throw new \InvalidArgumentException('Tipo de documento inválido'),
        };
    }

    private function mapSexo(string $sexo): int
    {
        return match (strtoupper($sexo)) {
            'M' => 1,
            'F' => 2,
            'O' => 3,
            default => throw new \InvalidArgumentException('Sexo inválido'),
        };
    }

    private function mapTipoTelefono(string $tipo): int
    {
        return match (strtoupper($tipo)) {
            'MOVIL', '1' => 1,
            'FIJO', '2' => 2,
            default => 1,
        };
    }
}
