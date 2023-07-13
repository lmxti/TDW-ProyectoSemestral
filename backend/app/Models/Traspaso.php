<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definicion de la clase "Traspaso" que extiende de la clase "Model".
class Traspaso extends Model
{
    // HasFactory habilita la funcionalidad de factoria para generar registros de traspasos.
    use HasFactory;
    // Especificacion del nombre de la tabla en la base de datos.
    protected $table = 'traspaso';
    // Especificacion del nombre de la clave primaria en la tabla "traspaso".
    protected $primaryKey = 'id';
    // Definicion para mantener las marcas de tiempo de creacion y actualizacion de los registros.
    public $timestamps = true;

    // Definicion de los "nombres" de los atributos del modelo "Traspaso", que ademas pueden ser asignados en masa (mass assignable).
    protected $fillable = [
        'bodega_origen_id',
        'bodega_destino_id',
        'cargamento',
    ];

    public function bodegaOrigen(){
        return $this->belongsTo(Bodega::class, 'bodega_origen_id');
    }

    public function bodegaDestino(){
        return $this->belongsTo(Bodega::class, 'bodega_destino_id');
    }

    public function bebidas(){
        return $this->belongsToMany(Bebida::class, 'detalle_traspasos', 'traspaso_id', 'bebida_id')->withPivot('cantidad');
    }
}
