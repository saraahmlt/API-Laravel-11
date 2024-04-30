<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'name' => $this->faker->name(),
                'description' => $this->faker->sentence(),
                'stock' => $this->faker->numberBetween(0, 100),
                'price' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
