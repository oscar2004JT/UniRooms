<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    protected $table = 'tipo_habitacion';
    public $timestamps = false;

    function pensiones()
    {
        return $this->hasMany(Pension::class, 'id_tipo_habitacion');
    }
}