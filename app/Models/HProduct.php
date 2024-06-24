<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HProduct extends Model
{
    use HasFactory;

    protected $table = 'hproducts';

    // Campos que pueden ser asignados de forma masiva
    protected $fillable = [
        'producto_id',
    ];

    /**
     * Define la relación belongsTo con el modelo Product.
     */
    public function product()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
