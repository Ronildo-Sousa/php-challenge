<?php

namespace Tests\Feature\Products;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_show_a_list_of_products()
    {
        $this->artisan('db:seed');
        $user = User::factory()->create();

        $response = $this->getJson(route('api.products.index', [
            'api_key' => $user->api_key
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['products']);

        $this->assertNotEmpty($response->collect()->get('products')["per_page"]);
    }

    /** @test  */
    public function it_gets_per_page_parm_from_url()
    {
        $this->artisan('db:seed');
        $user = User::factory()->create();

        $response = $this->getJson(route('api.products.index', [
            'api_key' => $user->api_key,
            'per-page' => 2
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['products']);

        $this->assertEquals(
            2,
            $response->collect()->get('products')["per_page"]
        );
    }
}
