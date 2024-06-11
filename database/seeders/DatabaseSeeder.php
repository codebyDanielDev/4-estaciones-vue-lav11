<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategoriasSeeder::class);
        $this->call(UnidadesSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(HistorialPreciosSeeder::class);
    }
}
