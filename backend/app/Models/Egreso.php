<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;
    protected $table = 'egresos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'bodega_id',
        'cargamento',
    ];

    public function bodega(){
        return $this->belongsTo(Bodega::class, 'bodega_id');
    }

    public function bebidas(){
        return $this->belongsToMany(Bebida::class, 'detalle_egresos', 'egreso_id', 'bebida_id')->withPivot('cantidad');
    }
}
