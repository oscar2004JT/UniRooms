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
        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['Cedula de Ciudadania', 'Tarjeta de Identidad', 'Pasaporte'])->unique();
            $table->timestamps();
        });

        // Inserción automática de registros
        DB::table('tipo_documento')->insert([
            ['nombre' => 'Cedula de Ciudadania', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de Identidad', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pasaporte', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_documento');
    }
};
