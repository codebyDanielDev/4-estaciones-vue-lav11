<?php

namespace Database\Factories;
use App\Models\Unidad;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidad>
 */
class UnidadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Unidad::class;

     public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->words(3, true),
            'acronimo' => strtoupper($this->faker->unique()->lexify('???')),
        ];
    }
}
