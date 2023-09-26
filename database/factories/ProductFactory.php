<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama'  => $this->faker->name(),
            'harga'  => 20000,
            'stok'  => 100,
            'status'  => 1,
            'id_kategori'  => $this->faker->randomElement([1, 9])
        ];
    }
}
