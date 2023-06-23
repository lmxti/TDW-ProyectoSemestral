<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definicion de la clase "Bodega" que extiende de la clase "Model".
class Bodega extends Model
{
    // HasFactory habilita la funcionalidad de factoria para generar registros de bodegas.
    use HasFactory;
    // Especificacion del nombre de la tabla en la base de datos.
    protected $table = 'bodegas';
    // Especificacion del nombre de la clave primaria en la tabla "bodegas".
    protected $primaryKey = 'id';
    // Definicion para mantener las marcas de tiempo de creacion y actualizacion de los registros.
    public $timestamps = true;


    // Definicion de los "nombres" de los atributos del modelo "Bodega", que ademas pueden ser asignados en masa (mass assignable).
    protected $fillable = [
        "nombre"
    ];

    /* Relacion de muchos a muchos[N:N] entre el modelo "Bodega" y el modelo "Bebida". 
        Esto indica que una bodega puede tener varias bebidas y una bebida puede pertener a varias bodegas.

        (Se establece en la tabla pivote "stock_bodegas" y se especifican las claves externas utilizadas en la relacion)
    */
    public function bebida(){
        return $this->belongsToMany(Bebida::class, 'stock_bodegas', 'bodega_id', 'bebida_id', 'nombre')->withPivot('cantidad');
    }

}
