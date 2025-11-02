<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pension extends Model
{

    use HasFactory;

    protected $table = 'pension';

    protected $fillable = [
        'id_propietario',
        'nombre',
        'precio',
        'capacidad',
        'direccion',
        'ubicacion_especifica',
        'disponible',
        'link_foto',
        'id_tipo_habitacion',
        'id_zona',
        'id_estado',
        'descripcion',
    ];


    /**
     * Cada pensión pertenece a un propietario (persona).
     */
    public function propietario(){
        return $this->belongsTo(Propietario::class, 'id_propietario');
    }

    public function tipoHabitacion(){
        return $this->belongsTo(TipoHabitacion::class, 'id_tipo_habitacion');
    }


    public function zona(){
        return $this->belongsTo(Zona::class, 'id_zona');
    }

    public function estado(){
        return $this->belongsTo(TipoEstado::class, 'id_estado');
    }

    public function servicios(){
        return $this->belongsToMany(TipoServicio::class, 'servicio_pension', 'id_pension', 'id_servicio');
    }
}