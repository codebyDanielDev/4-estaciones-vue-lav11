<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear categorías
        $frutas = new Categoria();
        $frutas->nombre = 'Frutas';
        $frutas->save();

        $verduras = new Categoria();
        $verduras->nombre = 'Verduras';
        $verduras->save();
    }
}
