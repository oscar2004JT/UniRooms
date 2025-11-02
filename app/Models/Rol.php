<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Rol extends Model
{
    protected $table = 'roles';
    public $timestamps = false;

    /**
     * Un rol puede tener muchos usuarios.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}
