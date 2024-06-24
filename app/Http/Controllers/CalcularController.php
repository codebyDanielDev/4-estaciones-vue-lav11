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
        // ayaayya
        // Obtener todos los IDs de productos desde la tabla hproducts
        $productoIds = HProduct::pluck('producto_id');

        // Obtener los productos que coinciden con los IDs obtenidos de hproducts
        $calculate_productos = Producto::whereIn('id', $productoIds)->get();

        // Obtener los productos que no están en la tabla hproducts
        $list_productos = Producto::whereNotIn('id', $productoIds)->get();

        return Inertia::render('App/Calculate/Index', [
            'calculate_productos' => $calculate_productos,
            'list_productos' => $list_productos,
        ]);
    }

    public function archive($id)
    {
        $hproduct = HProduct::where('producto_id', $id)->first();
        if ($hproduct) {
            $hproduct->delete(); // Esto hará un soft delete
        }

        return response()->json(['message' => 'Producto archivado exitosamente']);
    }
    public function restore($id)
    {
        $hproduct = HProduct::withTrashed()->where('producto_id', $id)->first();
        if ($hproduct) {
            $hproduct->restore(); // Esto restaurará el producto archivado
        }

        return response()->json(['message' => 'Producto restaurado exitosamente']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id'
        ]);

        $hproduct = HProduct::create([
            'producto_id' => $request->producto_id,
        ]);

        return response()->json(['message' => 'Producto agregado exitosamente', 'hproduct' => $hproduct]);
    }
    public function storeMultiple(Request $request)
{
    $request->validate([
        'producto_ids' => 'required|array',
        'producto_ids.*' => 'exists:productos,id',
    ]);

    $productoIds = $request->producto_ids;

    foreach ($productoIds as $productoId) {
        HProduct::create([
            'producto_id' => $productoId,
        ]);
    }

    return response()->json(['message' => 'Productos agregados exitosamente']);
}
}
