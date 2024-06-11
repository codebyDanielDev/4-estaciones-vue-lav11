<?php

namespace Database\Seeders;

use App\Models\Unidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = new Unidad();
        $unidades->nombre = 'cajas';
        $unidades->acronimo = 'CJ';
        $unidades->save();

        $unidades = new Unidad();
        $unidades->nombre = 'sacos';
        $unidades->acronimo = 'SC';
        $unidades->save();

        $unidades = new Unidad();
        $unidades->nombre = 'kilos';
        $unidades->acronimo = 'KG';
        $unidades->save();
    }
}
