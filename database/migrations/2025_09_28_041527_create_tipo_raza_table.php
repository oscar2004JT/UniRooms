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
        Schema::create('tipo_raza', function (Blueprint $table) {
            $table->id();
            $table->enum('raza', [
                // Lecheras
                'Holstein',
                'Jersey',
                'Pardo Suizo',
                'Guernsey',
                'Ayrshire',
                'Frisona',
                'Normando',

                // Cárnicas
                'Angus',
                'Hereford',
                'Shorthorn',
                'Limousin',
                'Charolais',
                'Simmental',
                'Brahman',
                'Santa Gertrudis',
                'Beefmaster',
                'Blonde dAquitaine',

                // Doble propósito (carne + leche)
                'Normando',
                'Simmental',
                'Brown Swiss',
                'Criollo Colombiano',
                'Romosinuano',
                'Costeño con Cuernos',
                'Sanmartinero',
                'Blanco Orejinegro (BON)',

                // Cebú y derivados
                'Brahman',
                'Gyr',
                'Guzerá',
                'Indo-Brasil',
                'Nelore',

                // Otras razas reconocidas
                'Chianina',
                'Piemontese',
                'Murray Grey',
                'Texas Longhorn',
                'Wagyu',
                'Brangus',
                'Charbray'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_raza');
    }
};
