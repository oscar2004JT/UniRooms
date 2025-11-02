<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    protected $table = 'propietario';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
    ];
    /**
     * Cada propietario pertenece a una persona.
     */
    public function persona()
    {
        return $this->hasOne(Persona::class, 'id_persona');
    }

    /**
     * Un propietario puede tener muchas pensiones.
     */
    public function pensiones()
    {
        return $this->hasMany(Pension::class, 'id_propietario');
    }
}
