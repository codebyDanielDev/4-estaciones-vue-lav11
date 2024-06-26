<?php

namespace App\Http\Controllers;

use App\Models\HProduct;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\HistorialPrecio;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

use App\Events\TransactionCreated;


use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\TransactionDetailsExport;

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
    // public function calcularYGuardar(Request $request)
    // {
    //     $user_id = auth()->id(); // Obtén el ID del usuario autenticado

    //     // Obtener los IDs de productos desde la tabla hproducts
    //     $hProductIds = HProduct::pluck('producto_id');


    //     // foreach ($request->productos as $productoData) {
    //     //     $hproduct = HProduct::find($productoData['id']);

    //     //     if (!$hproduct) {
    //     //         continue; // Si no se encuentra HProduct, omitir
    //     //     }

    //     //     $producto = Producto::find($hproduct->producto_id);

    //     //     if (!$producto) {
    //     //         continue; // Si no se encuentra el Producto, omitir
    //     //     }

    //     //     // Calcula los valores necesarios
    //     //     $cantidad = $productoData['cantidad'];
    //     //     $precio_compra_total = $productoData['precio_compra_total'];
    //     //     $precio_compra_producto = $precio_compra_total / $cantidad;
    //     //     $precio_venta = $precio_compra_producto * (1 + ($producto->porcentaje_min / 100)); // Ejemplo de cálculo de precio de venta mínimo

    //     //     // Inserta en la tabla historial_precios
    //     //     HistorialPrecio::create([
    //     //         'producto_id' => $producto->id,
    //     //         'user_id' => $user_id,
    //     //         'precio_compra_total' => $precio_compra_total,
    //     //         'cantidad' => $cantidad,
    //     //         'precio_compra_producto' => $precio_compra_producto,
    //     //         'dividendo' => $producto->dividendo,
    //     //         'porcentaje_min' => $producto->porcentaje_min,
    //     //         'porcentaje_max' => $producto->porcentaje_max,
    //     //         'precio_venta' => $precio_venta,
    //     //     ]);
    //     // }

    //     $productos = Producto::whereIn('id', $hProductIds)->get();

    //     return response()->json([
    //         'message' => 'Datos obtenidos exitosamente',
    //         'productos' => $productos
    //     ]);
    //  }

    public function calcularYGuardar(Request $request)
    {
        $user_id = auth()->id(); // Obtén el ID del usuario autenticado

        DB::beginTransaction();

        try {
            // Crear una nueva transacción
            $transaction = Transaction::create([
                'user_id' => $user_id,
            ]);

            // Obtener los IDs de productos desde la tabla hproducts
            $hProductIds = HProduct::pluck('producto_id');

            // Obtener los productos que coincidan con esos IDs
            $productos = Producto::whereIn('id', $hProductIds)->get();

            // Obtener los datos adicionales enviados desde el front
            $additionalData = $request->input('productos', []);

            // Añadir los datos adicionales a los productos y crear detalles de transacción
            $productos = $productos->map(function ($producto) use ($additionalData, $transaction) {
                foreach ($additionalData as $data) {
                    if ($data['id'] == $producto->id) {
                        $cantidad = $data['cantidad'] ?? null;
                        $precio_compra_total = $data['precio_compra_total'] ?? null;

                        if ($cantidad && $precio_compra_total) {
                            // Calcular precio_unitario
                            $precio_unitario = $precio_compra_total / $cantidad;

                            // Calcular precio_venta_kilo
                            $precio_venta_kilo = $precio_unitario / $producto->dividendo;

                            // Calcular precio_venta_kilo_min y precio_venta_kilo_max
                            $precio_venta_kilo_min = $precio_venta_kilo + ($precio_venta_kilo * $producto->porcentaje_min / 100);
                            $precio_venta_kilo_max = $precio_venta_kilo + ($precio_venta_kilo * $producto->porcentaje_max / 100);

                            // Guardar en TransactionDetail
                            TransactionDetail::create([
                                'transaction_id' => $transaction->id,
                                'producto_id' => $producto->id,
                                'cantidad' => $cantidad,
                                'precio_compra_total' => $precio_compra_total,
                                'precio_venta_kilo_min' => $precio_venta_kilo_min,
                                'precio_venta_kilo_max' => $precio_venta_kilo_max,
                                'precio_general' => $precio_unitario,
                            ]);
                        }
                    }
                }
                return $producto;
            });

            DB::commit();
            // Despachar el evento TransactionCreated
            event(new TransactionCreated($transaction));


            return response()->json([
                'message' => 'Datos obtenidos y guardados exitosamente',
                'productos' => $productos
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar los datos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportTransactionDetails($transactionId)
    {
        return Excel::download(new TransactionDetailsExport($transactionId), 'transaction_details.xlsx');
    }
}
