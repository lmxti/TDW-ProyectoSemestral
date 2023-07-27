<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definicion de la clase "Ingreso" que extiende de la clase "Model".
class Ingreso extends Model
{
    // HasFactory habilita la funcionalidad de factoria para generar registros de ingresos.
    use HasFactory;
    // Especificacion del nombre de la tabla en la base de datos.
    protected $table = 'ingresos';
    // Especificacion del nombre de la clave primaria en la tabla "ingresos".
    protected $primaryKey = 'id';
    // Definicion para mantener las marcas de tiempo de creacion y actualizacion de los registros.
    public $timestamps = true;

    // Definicion de los "nombres" de los atributos del modelo "Ingreso", que ademas pueden ser asignados en masa (mass assignable).
    protected $fillable = [
        'bodega_id',
        'cargamento',
    ];

    /*------------------------------------------------------------------------------------------------------------------------
      Relacion de muchos a uno[N:1] entre el modelo "Ingreso" y el modelo "Bodega". 
        Esto indica que un ingreso puede pertenecer a una bodega y una bodega puede tener varios ingresos.

        (Se establece en la tabla "ingresos" y se especifica la clave externa utilizada en la relacion)*/
    public function bodega(){
        return $this->belongsTo(Bodega::class, 'bodega_id');
    }

    /*------------------------------------------------------------------------------------------------------------------------ 
      Relacion de muchos a muchos[N:N] entre el modelo "Ingreso" y el modelo "Bebida". 
        Esto indica que un ingreso puede tener varias bebidas y una bebida puede pertener a varios ingresos.

        (Se establece en la tabla pivote "detalle_ingresos" y se especifican las claves externas utilizadas en la relacion)*/
    public function bebidas(){
        return $this->belongsToMany(Bebida::class, 'detalle_ingresos', 'ingreso_id', 'bebida_id')->withPivot('cantidad');
    }
}
