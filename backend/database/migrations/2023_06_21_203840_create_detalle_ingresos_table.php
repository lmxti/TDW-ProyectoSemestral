<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla pivote "detalle_ingresos" que relaciona las tablas "ingresos" y "bebidas".
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingreso_id')->constrained('ingresos');
            $table->foreignId('bebida_id')->constrained('bebidas');
            $table->string('nombre');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ingresos');
    }
};
