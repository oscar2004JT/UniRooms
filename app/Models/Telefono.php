<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;

    protected $table = 'telefono';

    protected $fillable = [
        'numero',
        'id_usuario',
        'id_tipo_telefono',
        'id_codigo_pais',
    ];

    /**
     * Relación con el modelo User.
     * Cada teléfono pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    //Relación con el tipo de teléfono.

    public function tipoTelefono()
    {
        return $this->belongsTo(TipoTelefono::class, 'id_tipo_telefono');
    }

    // Relación con el código de país.
    public function codigoPais()
    {
        return $this->belongsTo(CodigoPais::class, 'id_codigo_pais');
    }
}
