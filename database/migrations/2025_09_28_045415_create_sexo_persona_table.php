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
        Schema::create('sexo_persona', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['Masculino', 'Femenino'])->unique();
            $table->timestamps();
        });

        // Inserción automática de valores iniciales
        DB::table('sexo_persona')->insert([
            ['nombre' => 'Masculino', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Femenino', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sexo_persona');
    }
};
