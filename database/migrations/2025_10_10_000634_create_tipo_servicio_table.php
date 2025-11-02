<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_servicio', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', [
                'Wi-Fi',
                'Escritorio',
                'Closet',
                'Calefacción',
                'Cocina',
                'Baño Privado',
                'Lavandería',
                'Parqueadero',
                'Sala Común',
                'Jardín',
                'Gimnasio',
                'Sala de Estudio',
            ])->unique();
            $table->timestamps();
        });

        // 👇 Esto va afuera del Schema::create
        DB::table('tipo_servicio')->insert([
            ['nombre' => 'Wi-Fi', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Escritorio', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Closet', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Calefacción', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cocina', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Baño Privado', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Lavandería', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Parqueadero', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sala Común', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jardín', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gimnasio', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sala de Estudio', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_servicio');
    }
};
