<?php

namespace Database\Factories;

use App\Models\HistorialPrecio;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorialPrecio>
 */
class HistorialPrecioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = HistorialPrecio::class;

    public function definition(): array
    {
        $producto = Producto::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'producto_id' => $producto->id,
            'user_id' => $user->id,
            'precio_compra_total' => $this->faker->randomFloat(2, 1, 100),
            'cantidad' => $this->faker->randomFloat(2, 1, 100),
            'precio_compra_producto' => $this->faker->randomFloat(2, 1, 100),
            'dividendo' => $this->faker->randomFloat(2, 1, 100),
            'porcentaje_min' => $this->faker->randomFloat(2, 0, 20),
            'porcentaje_max' => $this->faker->randomFloat(2, 20, 50),
            'precio_venta' => $this->faker->randomFloat(2, 1, 200),
            'created_at' => Carbon::now()->subDays(rand(1, 30)),
            'updated_at' => Carbon::now()->subDays(rand(1, 30))
        ];
    }
}
