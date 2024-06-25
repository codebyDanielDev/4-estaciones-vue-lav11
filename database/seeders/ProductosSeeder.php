<?php

namespace Database\Seeders;

use App\Models\Unidad;
use App\Models\Producto;
use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



use App\Models\User;



class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = Unidad::all();
        $categorias = Categoria::all();

        Producto::factory()->count(3)->make()->each(function ($producto) use ($unidades, $categorias) {
            $producto->unidad_id = $unidades->random()->id;
            $producto->categoria_id = $categorias->random()->id;
            $producto->save();
        });
    }
}
