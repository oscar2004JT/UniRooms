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
        Schema::create('tipo_sexo', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['macho', 'hembra']);
            $table->timestamps();
        });

           // Inserciones iniciales
        DB::table('tipo_sexo')->insert([
            ['nombre' => 'macho', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'hembra', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_sexo');
    }
};
