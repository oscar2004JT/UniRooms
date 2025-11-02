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
        Schema::create('mensaje', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_estudiante');
            $table->foreign('id_estudiante')->references('id')->on('estudiante')->onDelete('cascade');
            $table->unsignedInteger('id_propietario');
            $table->foreign('id_propietario')->references('id')->on('propietario')->onDelete('cascade');
            $table->text('contenido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje');
    }
};
