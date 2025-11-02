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
        Schema::create('telefono', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('id_tipo_telefono');
            $table->foreign('id_tipo_telefono')->references('id')->on('tipo_telefono')->onDelete('cascade');


            $table->unsignedInteger('id_codigo_pais');
            $table->foreign('id_codigo_pais')->references('id')->on('codigo_pais')->onDelete('cascade');

            $table->string('numero', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefono');
    }
};
