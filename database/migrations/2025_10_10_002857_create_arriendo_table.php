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

            // Relación con estudiante
            $table->unsignedBigInteger('id_estudiante');
            $table->foreign('id_estudiante')
                  ->references('id')->on('estudiante')
                  ->onDelete('cascade');

            // Relación con pensión
            $table->unsignedBigInteger('id_pension');
            $table->foreign('id_pension')
                  ->references('id')->on('pension')
                  ->onDelete('cascade');

            // Relación con estadoarriendo
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->foreign('id_estado')
                  ->references('id')->on('estadoarriendo')
                  ->onDelete('set null');

            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->text('mensaje')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arriendo', function (Blueprint $table) {
            $table->dropForeign(['id_estudiante']);
            $table->dropForeign(['id_pension']);
            $table->dropForeign(['id_estado']);
        });

        Schema::dropIfExists('arriendo');
    }
};
