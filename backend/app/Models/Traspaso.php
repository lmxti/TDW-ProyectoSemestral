<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    use HasFactory;

    protected $table = 'traspaso';
    protected $primaryKey = 'id';
    public $timestamps = true;

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
}
