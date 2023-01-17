<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
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
    public function definition()
    {
        return [
            'code' => fake()->numerify("#####"),
            'status' => [
                ProductStatus::draft->value,
                ProductStatus::published->value,
                ProductStatus::trash->value,
            ][rand(0, 2)],
            'imported_t' => now(),
            'url' => fake()->url(),
            'creator' => fake()->name(),
            'created_t' => fake()->numberBetween(),
            'last_modified_t' => fake()->numberBetween(),
            'product_name' => fake()->name(),
            'quantity' => (string)fake()->numberBetween(),
            'brands' => fake()->name(),
            'categories' => fake()->name(),
            'labels' => fake()->sentence(3),
            'cities' => fake()->city(),
            'purchase_places' => fake()->city(),
            'stores' => fake()->name(),
            'ingredients_text' => fake()->sentence(),
            'traces' => fake()->sentence(3),
            'serving_size' => fake()->sentence(3),
            'serving_quantity' => fake()->numerify(),
            'nutriscore_score' => fake()->numerify(),
            'nutriscore_grade' => fake()->word(),
            'main_category' => fake()->name(),
            'image_url' => fake()->url(),
        ];
    }
}
