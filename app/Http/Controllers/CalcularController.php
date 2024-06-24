<?php

namespace App\Http\Controllers;

use App\Models\HProduct;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalcularController extends Controller
{
    public function index()
    {
        // Obtener todos los IDs de productos desde la tabla hproducts
        $productoIds = HProduct::pluck('producto_id');
        
        // Obtener los productos que coinciden con los IDs obtenidos de hproducts
        $calculate_productos = Producto::whereIn('id', $productoIds)->get();

        // Obtener los últimos 15 productos actualizados
        $list_productos = Producto::orderByDesc('updated_at')
                                                  ->take(15)
                                                  ->get();

        return Inertia::render('App/Calculate/Index', [
            'calculate_productos' => $calculate_productos,
            'list_productos' => $list_productos,
        ]);
    }
}
