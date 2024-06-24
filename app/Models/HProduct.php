<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;




class HProduct extends Model
{
    use HasFactory, SoftDeletes; // Usa el trait SoftDeletes

    protected $table = 'hproducts';
    protected $dates = ['deleted_at']; // Asegúrat

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
