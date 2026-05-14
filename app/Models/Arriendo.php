<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arriendo extends Model
{
    use HasFactory;

    // Nombre de la tabla (porque no sigue la convención plural)
    protected $table = 'arriendo';

    // Clave primaria (por defecto ya es "id", esto es opcional)
    protected $primaryKey = 'id';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'id_estudiante',
        'id_pension',
        'id_estado',   // <-- AGREGADO
        'fecha_inicio',
        'fecha_fin',
        'mensaje',
    ];

    // Conversiones automáticas
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    /* ================= RELACIONES ================= */

    // Un arriendo pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    // Un arriendo pertenece a una pensión/habitación
    public function pension()
    {
        return $this->belongsTo(Pension::class, 'id_pension');
    }

    // Un arriendo pertenece a un estado (aceptado / rechazado)
    public function estado()
    {
        return $this->belongsTo(EstadoArriendo::class, 'id_estado');
    }
}
