<?php

namespace Database\Seeders;

use App\Models\HistorialPrecio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorialPreciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HistorialPrecio::factory()->count(30)->create();
    }
}
