<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPrecio extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'precio_compra',
        'cantidad',
        'dividendo',
        'porcentaje',
        'precio_venta'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
