<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $fillable = [
        'id_user',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'numero_documento',
        'id_documento',
        'id_sexo',
    ];

    /**
     * Cada persona pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relación con el tipo de documento.
     */
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_documento');
    }

    /**
     * Relación con el sexo.
     */
    public function sexo()
    {
        return $this->belongsTo(SexoPersona::class, 'id_sexo');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'id_persona');
    }
    public function propietario()
    {
        return $this->hasOne(Propietario::class, 'id_persona');
    }
}
