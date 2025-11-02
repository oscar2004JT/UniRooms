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
        Schema::create('tipo_habitacion', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['individual', 'compartida', 'estudio', 'apartamento']);
            $table->timestamps();
        });

        DB::table('tipo_habitacion')->insert([
            ['nombre' => 'individual', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'compartida', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'estudio', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'apartamento', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_habitacion');
    }
};
