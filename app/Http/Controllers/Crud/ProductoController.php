<?php
//
namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;
use Inertia\Inertia;
use App\Models\Categoria;

use App\Models\Unidad;

use App\Rules\MinLessThanMax;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtén los productos paginados
        $productos = Producto::paginate(10); // Cambia el número 10 por la cantidad de productos por página que desees

        // Pasa los productos paginados a la vista
        return Inertia::render('App/Crud/Product/Index', [
            'productos' => $productos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('App/Crud/Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:productos,nombre',
            'category' => 'required|exists:categorias,id',
            'unit' => 'required|exists:unidades,id',
            'price' => 'required|numeric',
            'percentage_min' => ['required', 'numeric', 'min:0', 'max:100', new MinLessThanMax],
            'percentage_max' => 'nullable|numeric|min:0|max:100',
        ]);

        $producto = new Producto();
        $producto->nombre = $validatedData['name'];
        $producto->categoria_id = $validatedData['category'];
        $producto->unidad_id = $validatedData['unit'];
        $producto->dividendo = $validatedData['price'];
        $producto->porcentaje_min = $validatedData['percentage_min'];
        $producto->porcentaje_max = $validatedData['percentage_max'];
        $producto->save();

        return response()->json(['message' => 'Producto creado exitosamente']);
    }

    public function getCategorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    public function getUnidades()
    {
        $unidades = Unidad::all();
        return response()->json($unidades);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('App/Crud/Product/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('App/Crud/Product/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function search(Request $request)
    {
        // Validate the search query
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        // Retrieve the search query from the request
        $query = $request->input('query');

        // Search for products where the name contains the search query
        $products = Producto::where('nombre', 'LIKE', "%{$query}%")->get();

        // Return the search results as a JSON response
        return response()->json($products);
    }
}
