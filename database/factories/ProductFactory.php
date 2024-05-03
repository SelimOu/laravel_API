<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categorie;

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
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween($min = 10, $max = 100),
            'stock' => fake()->numberBetween($min = 1, $max = 10),
            'image' => fake()->randomelement(['images/cayeux-services-payants.jpg','images/elizeu-dias-RN6ts8IZ4_0-unsplash.jpg','images/istockphoto-489833698-612x612.jpg'])
        ];
    }
}
