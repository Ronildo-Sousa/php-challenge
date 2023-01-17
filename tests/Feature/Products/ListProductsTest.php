<?php

namespace Tests\Feature\Products;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    /** @test */
    public function it_should_show_a_list_of_products()
    {
        $this->artisan('db:seed');
        $response = $this->getJson(route('api.products.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['products']);

        $this->assertNotEmpty($response->collect()->get('products')["per_page"]);
    }
}
