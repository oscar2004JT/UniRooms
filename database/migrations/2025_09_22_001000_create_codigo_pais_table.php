<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('codigo_pais', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo', 5)->unique();
            $table->timestamps();
        });

         // Inserciones iniciales
        DB::table('codigo_pais')->insert([
            ['nombre' => 'Colombia', 'codigo' => '+57', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Estados Unidos', 'codigo' => '+1', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'España', 'codigo' => '+34', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'México', 'codigo' => '+52', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Argentina', 'codigo' => '+54', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Chile', 'codigo' => '+56', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Perú', 'codigo' => '+51', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Venezuela', 'codigo' => '+58', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigo_pais');
    }
};
