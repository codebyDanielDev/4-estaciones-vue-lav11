<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;



use App\Models\Producto;
use App\Models\Unidad;
use App\Models\Categoria;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->words(3, true),
            'unidad_id' => Unidad::factory(),
            'categoria_id' => Categoria::factory(),
            'dividendo' => $this->faker->randomFloat(2, 1, 100),
            'porcentaje_min' => $this->faker->randomFloat(2, 0, 100),
            'porcentaje_max' => $this->faker->optional()->randomFloat(2, 0, 100),
            //'user_id' => User::factory(),
        ];
    }
}
