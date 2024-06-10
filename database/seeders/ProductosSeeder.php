<?php

namespace Database\Seeders;

use App\Models\Unidad;
use App\Models\Producto;
use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener categorías
        $categoriaFrutas = Categoria::where('nombre', 'Frutas')->first();
        $categoriaVerduras = Categoria::where('nombre', 'Verduras')->first();

        // Obtener unidades
        $unidadCajas = Unidad::where('nombre', 'cajas')->first();
        $unidadSacos = Unidad::where('nombre', 'sacos')->first();
        $unidadKilos = Unidad::where('nombre', 'kilos')->first();

        // Insertar productos de frutas
        Producto::create(['nombre' => 'Manzana', 'unidad_id' => $unidadCajas->id, 'categoria_id' => $categoriaFrutas->id]);
        Producto::create(['nombre' => 'Pera', 'unidad_id' => $unidadCajas->id, 'categoria_id' => $categoriaFrutas->id]);
        Producto::create(['nombre' => 'Plátano', 'unidad_id' => $unidadKilos->id, 'categoria_id' => $categoriaFrutas->id]);
        Producto::create(['nombre' => 'Naranja', 'unidad_id' => $unidadKilos->id, 'categoria_id' => $categoriaFrutas->id]);
        Producto::create(['nombre' => 'Uva', 'unidad_id' => $unidadSacos->id, 'categoria_id' => $categoriaFrutas->id]);

        // Insertar productos de verduras
        Producto::create(['nombre' => 'Tomate', 'unidad_id' => $unidadCajas->id, 'categoria_id' => $categoriaVerduras->id]);
        Producto::create(['nombre' => 'Zanahoria', 'unidad_id' => $unidadCajas->id, 'categoria_id' => $categoriaVerduras->id]);
        Producto::create(['nombre' => 'Lechuga', 'unidad_id' => $unidadKilos->id, 'categoria_id' => $categoriaVerduras->id]);
        Producto::create(['nombre' => 'Papa', 'unidad_id' => $unidadSacos->id, 'categoria_id' => $categoriaVerduras->id]);
        Producto::create(['nombre' => 'Pepino', 'unidad_id' => $unidadKilos->id, 'categoria_id' => $categoriaVerduras->id]);
    }
}
