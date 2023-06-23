<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabla pivote "stock_bodegas" que relaciona las tablas "bodegas" y "bebidas".
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_bodegas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bodega_id')->constrained('bodegas');
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
        Schema::dropIfExists('stock_bodegas');
    }
};
