<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id', 'producto_id', 'cantidad', 'precio_compra_total',
        'precio_venta_kilo_min', 'precio_venta_kilo_max', 'precio_general'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
