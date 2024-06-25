<?php

namespace Database\Seeders;

use App\Models\HProduct;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtén todos los ids de los productos disponibles
        $productoIds = Producto::pluck('id')->toArray();

        // Obtén 5 ids únicos aleatorios
        $uniqueIds = array_rand(array_flip($productoIds), 2);

        // Crea registros en la tabla hproducts con los ids seleccionados
        foreach ($uniqueIds as $productoId) {
            HProduct::create([
                'producto_id' => $productoId,
            ]);
        }
    }
}
