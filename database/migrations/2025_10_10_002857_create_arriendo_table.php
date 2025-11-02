<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('arriendo', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_estudiante');
            $table->foreign('id_estudiante')->references('id')->on('estudiante')->onDelete('cascade');
            
            $table->unsignedInteger('id_pension');
            $table->foreign('id_pension')->references('id')->on('pension')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arriendo');
    }
};
