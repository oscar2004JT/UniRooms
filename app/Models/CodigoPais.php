<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoPais extends Model
{
    protected $table = 'codigo_pais';

    public $timestamps = false;

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'id_codigo_pais');
    }
}
