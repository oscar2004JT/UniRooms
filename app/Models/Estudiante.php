<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
    ];

    /**
     * Cada estudiante pertenece a una persona.
     */
    public function persona()
    {
        return $this->hasOne(Persona::class, 'id_persona');
    }
}
