<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla de "bodegas"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Metodo up() que crea la tabla "bodegas" con los campos "id", "nombre" y "timestamps".
    public function up(): void
    {
        // Metodo create() que utiliza el objeto Blueprint para definir la estructura de la tabla.
        Schema::create('bodegas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodegas');
    }
};
