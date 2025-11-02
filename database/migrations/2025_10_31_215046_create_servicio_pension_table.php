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
        Schema::create('servicio_pension', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('id_pension');
            $table->foreign('id_pension')->references('id')->on('pension')->onDelete('cascade');

            $table->unsignedInteger('id_servicio');
            $table->foreign('id_servicio')->references('id')->on('tipo_servicio')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_pension');
    }
};
