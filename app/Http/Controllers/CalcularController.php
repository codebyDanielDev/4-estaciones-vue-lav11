<?php

namespace App\Http\Controllers;

use App\Models\HProduct;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\HistorialPrecio;
class CalcularController extends Controller
{
    public function index()
    {
        // Obtener todos los IDs de productos desde la tabla hproducts
        $productoIds = HProduct::pluck('producto_id');

        // Obtener los productos que coinciden con los IDs obtenidos de hproducts
        $calculate_productos = Producto::whereIn('id', $productoIds)->get();

        return Inertia::render('App/Calculate/Index', [
            'calculate_productos' => $calculate_productos,
        ]);
    }

    public function getListProductos()
    {
        // Obtener todos los IDs de productos desde la tabla hproducts
        $productoIds = HProduct::pluck('producto_id');

        // Obtener los productos que no están en la tabla hproducts
        $list_productos = Producto::whereNotIn('id', $productoIds)->get();

        if ($list_productos->isEmpty()) {
            return response()->json(['message' => 'No hay productos disponibles'], 204);
        }

        return response()->json($list_productos);
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
    public function calcularYGuardar(Request $request)
    {
        $user_id = auth()->id(); // Obtén el ID del usuario autenticado

        foreach ($request->productos as $productoData) {
            $hproduct = HProduct::find($productoData['id']);

            if (!$hproduct) {
                continue; // Si no se encuentra HProduct, omitir
            }

            $producto = Producto::find($hproduct->producto_id);

            if (!$producto) {
                continue; // Si no se encuentra el Producto, omitir
            }

            // Calcula los valores necesarios
            $cantidad = $productoData['cantidad'];
            $precio_compra_total = $productoData['precio_compra_total'];
            $precio_compra_producto = $precio_compra_total / $cantidad;
            $precio_venta = $precio_compra_producto * (1 + ($producto->porcentaje_min / 100)); // Ejemplo de cálculo de precio de venta mínimo

            // Inserta en la tabla historial_precios
            HistorialPrecio::create([
                'producto_id' => $producto->id,
                'user_id' => $user_id,
                'precio_compra_total' => $precio_compra_total,
                'cantidad' => $cantidad,
                'precio_compra_producto' => $precio_compra_producto,
                'dividendo' => $producto->dividendo,
                'porcentaje_min' => $producto->porcentaje_min,
                'porcentaje_max' => $producto->porcentaje_max,
                'precio_venta' => $precio_venta,
            ]);
        }

        return response()->json(['message' => 'Datos guardados exitosamente']);
    }
}
