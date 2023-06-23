<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//  Tabla de "bebidas".
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Metodo up() que crea la tabla "bebidas" con los campos "id", "nombre", "sabor", "tamano" y "timestamps".
    public function up(): void
    {
        // Metodo create() que utiliza el objeto Blueprint para definir la estructura de la tabla.
        Schema::create('bebidas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('sabor', 30);
            $table->string('tamano', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bebidas');
    }
};
