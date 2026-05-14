<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorita extends Model
{
    use HasFactory;

    protected $table = 'favorita'; // nombre exacto de la tabla

    protected $fillable = [
        'id_estudiante',
        'id_pension',
    ];

    /**
     * Relación con el modelo Estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    /**
     * Relación con el modelo Pension
     */
    public function pension()
    {
        return $this->belongsTo(Pension::class, 'id_pension');
    }
}
