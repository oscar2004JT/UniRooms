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
        Schema::create('tipo_estado', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['borrador', 'publicada'])->default('borrador');
            $table->timestamps();
        });

        DB::table('tipo_estado')->insert([
            ['nombre' => 'borrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'publicada', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_estado');
    }
};
