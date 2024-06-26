<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'unidad_id',
        'categoria_id',
        'dividendo',
        'porcentaje_min',
        'porcentaje_max',
    ];

    // Relación con unidades
    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }

    // Relación con categorías
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con historial de precios
    public function historialPrecios()
    {
        return $this->hasMany(HistorialPrecio::class);
    }
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
