<?php
//todavía no hacer nada
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPrecio extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'user_id',
        'precio_compra_total',
        'cantidad',
        'precio_compra_producto',
        'dividendo',
        'porcentaje_min',
        'porcentaje_max',
        'precio_venta'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    /**
     * Define la relación belongsTo con el modelo Producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Define la relación belongsTo con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
