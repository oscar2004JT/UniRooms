<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estadoarriendo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // aceptado / rechazado
            $table->timestamps();
        });

        // Insertar datos por defecto
        DB::table('estadoarriendo')->insert([
            ['nombre' => 'aceptado'],
            ['nombre' => 'rechazado'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estadoarriendo');
    }
};
