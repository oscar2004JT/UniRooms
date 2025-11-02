<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model {
    protected $table = 'zona';
    public $timestamps = false;
    
    public function pensiones()
    {
        return $this->hasMany(Pension::class, 'id_zona');
    }
}