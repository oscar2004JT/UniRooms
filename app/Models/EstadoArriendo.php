<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoArriendo extends Model
{
    use HasFactory;

    protected $table = 'estadoarriendo'; // nombre exacto de la tabla

    protected $fillable = [
        'nombre',
    ];

    /**
     * Un estado puede pertenecer a muchos arriendos.
     */
    public function arriendos()
    {
        return $this->hasMany(Arriendo::class, 'id_estado');
    }
}
