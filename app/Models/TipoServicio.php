<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'tipo_servicio';
    public $timestamps = false;

    function pensiones()
    {
        return $this->belongsToMany(Pension::class, 'servicio_pension','id_servicio', 'id_pension');
    }
}