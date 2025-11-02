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
        Schema::create('tipo_telefono', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['fijo','movil']);
            $table->timestamps();
        });

         // Inserción automática de valores iniciales
        DB::table('tipo_telefono')->insert([
            ['nombre' => 'fijo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'movil', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_telefono');
    }
};
