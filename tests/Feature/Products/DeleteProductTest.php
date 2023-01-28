<?php

namespace Tests\Feature\Products;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_change_the_product_status_to_trash()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', [
            'product' => $product->code,
            'api_key' => $user->api_key
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('products', ['status' => ProductStatus::published->value]);
    }

    /** @test */
    public function an_invalid_product_code_should_return_a_not_found_error()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', [
            'product' => 0,
            'api_key' => $user->api_key
        ]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
