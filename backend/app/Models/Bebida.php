<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definicion de la clase "Bebida" que extiende de la clase "Model".
class Bebida extends Model
{
    // HasFactory habilita la funcionalidad de factoria para generar registros de bebidas.
    use HasFactory;
    // Especificacion del nombre de la tabla en la base de datos.
    protected $table = 'bebidas';
    // Especificacion del nombre de la clave primaria en la tabla "bebidas".
    protected $primaryKey = 'id';
    // Definicion para mantener las marcas de tiempo de creacion y actualizacion de los registros.
    public $timestamps = true;

    // Definicion de los "nombres" de los atributos del modelo "Bebida", que ademas pueden ser asignados en masa (mass assignable).
    protected $fillable = [
        "nombre",
        "sabor",
        "tamano"
    ];

    /* Relacion de muchos a muchos[N:N] entre el modelo "Bebida" y el modelo "Bodega". 
        Esto indica que una bebida puede pertenecer a varias bodegas y una bodega puede tener varias bebidas.

        (Se establece en la tabla pivote "stock_bodegas" y se especifican las claves externas utilizadas en la relacion)
    */
    public function bodega(){
        return $this->belongsToMany(Bodega::class, 'stock_bodegas', 'bebida_id', 'bodega_id', 'nombre')->withPivot('cantidad');
    }

    /* Relacion de muchos a muchos[N:N] entre el modelo "Bebida" y el modelo "Ingreso".
        Esto indica que una bebida puede estar presente en varios ingresos y un ingreso puede tener varias bebidas.

        (Se establece en la tabla pivote "detalle_ingresos" y se especifican las claves externas utilizadas en la relacion)
    */
    public function ingresos(){
        return $this->belongsToMany(Ingreso::class, 'detalle_ingresos', 'bebida_id', 'ingreso_id', 'nombre')->withPivot('cantidad');
    }

    public function traspasos(){
        return $this->belongsToMany(Traspaso::class, 'detalle_traspasos', 'bebida_id', 'traspaso_id', 'nombre')->withPivot('cantidad');
    }
}
