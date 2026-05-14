<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioPension extends Model
{
    protected $table = 'servicio_pension';
    public $timestamps = true;

    protected $fillable = [
        'id_pension',
        'id_servicio',
    ];

    /**
     * Relación con el modelo Pension
     */
    public function pension()
    {
        return $this->belongsTo(Pension::class, 'id_pension');
    }

    /**
     * Relación con el modelo TipoServicio
     */
    public function servicio()
    {
        return $this->belongsTo(TipoServicio::class, 'id_servicio');
    }
}
