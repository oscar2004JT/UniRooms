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
        Schema::create('pension', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_propietario');
            $table->foreign('id_propietario')->references('id')->on('propietario')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->decimal('precio', 10, 2);
            $table->integer('capacidad');
            $table->string('ubicacion_especifica', 255);
            $table->boolean('disponible')->default(true);
            $table->string('link_foto')->nullable();
            
            $table->unsignedInteger('id_tipo_habitacion');
            $table->foreign('id_tipo_habitacion')->references('id')->on('tipo_habitacion')->onDelete('cascade');

            $table->unsignedInteger('id_zona');
            $table->foreign('id_zona')->references('id')->on('zona')->onDelete('cascade');

            $table->unsignedInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('tipo_estado')->onDelete('cascade');

            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pension');
    }
};
