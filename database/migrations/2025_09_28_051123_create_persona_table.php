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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('numero_documento', 20)->unique();
            $table->unsignedInteger('id_documento');
            $table->foreign('id_documento')->references('id')->on('tipo_documento')->onDelete('cascade');
            $table->unsignedInteger('id_sexo');
            $table->foreign('id_sexo')->references('id')->on('sexo_persona')->onDelete('cascade');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
