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
        Schema::create('registro_pension', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_propietario');
            $table->foreign('id_propietario')->references('id')->on('propietario')->onDelete('cascade');
            $table->unsignedInteger('id_pension');
            $table->foreign('id_pension')->references('id')->on('pension')->onDelete('cascade');
            $table->unsignedInteger('id_accion');
            $table->foreign('id_accion')->references('id')->on('tipo_accion')->onDelete('cascade');
            $table->date('fecha_registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_pension');
    }
};
