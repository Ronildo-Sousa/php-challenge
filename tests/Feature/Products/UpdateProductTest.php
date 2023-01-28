<?php

namespace Tests\Feature\Products;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_edit_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->putJson(route('api.products.update', [
            'product' => $product->code,
            'status' => ProductStatus::draft->value,
            'url' => 'http://some-value.com',
            'creator' => 'updated-value',
            'product_name' => 'updated-value',
            'quantity' => 'updated-value',
            'brands' => 'updated-value',
            'categories' => 'updated-value',
            'labels' => 'updated-value',
            'cities' => 'updated-value',
            'purchase_places' => 'updated-value',
            'stores' => 'updated-value',
            'ingredients_text' => 'updated-value',
            'traces' => 'updated-value',
            'serving_size' => 'updated-value',
            'serving_quantity' => 0.5,
            'nutriscore_score' => 0.0,
            'nutriscore_grade' => 'updated-value',
            'main_category' => 'updated-value',
            'image_url' => 'http://some-value.com',
            'api_key' => $user->api_key
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['product']);

        $this->assertDatabaseHas('products', [
            'code' => $product->code,
            'status' => ProductStatus::draft->value,
            'url' => 'http://some-value.com',
            'creator' => 'updated-value',
            'product_name' => 'updated-value',
            'quantity' => 'updated-value',
            'brands' => 'updated-value',
            'categories' => 'updated-value',
            'labels' => 'updated-value',
            'cities' => 'updated-value',
            'purchase_places' => 'updated-value',
            'stores' => 'updated-value',
            'ingredients_text' => 'updated-value',
            'traces' => 'updated-value',
            'serving_size' => 'updated-value',
            'serving_quantity' => 0.5,
            'nutriscore_score' => 0.0,
            'nutriscore_grade' => 'updated-value',
            'main_category' => 'updated-value',
            'image_url' => 'http://some-value.com',
        ]);
    }
}
