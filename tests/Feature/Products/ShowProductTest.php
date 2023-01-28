<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    /** @test */
    public function it_shows_the_product_information_based_in_a_product_code()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->getJson(route('api.products.show', [
            'product' => $product->code,
            'api_key' => $user->api_key
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['product']);
    }

    /** @test */
    public function test_an_invalid_product_code_should_return_a_not_found_error()
    {
        $user = User::factory()->create();

        $response = $this->getJson(route('api.products.show', [
            'api_key' => $user->api_key,
            'product' => 0,
        ]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
