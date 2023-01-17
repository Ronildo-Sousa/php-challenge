<?php

namespace Tests\Feature\Actions\Products;

use App\Actions\Products\CreateProduct;
use App\Models\Product;
use Tests\TestCase;

class CreateProductActionTest extends TestCase
{
    /** @test */
    public function it_should_create_a_product_in_database()
    {
        $product = CreateProduct::run(Product::factory()->make()->toArray());
        $this->assertDatabaseHas('products', ['code' => $product->code]);
    }

    /** @test */
    public function it_shold_not_be_able_to_create_a_product_with_empty_data()
    {
        CreateProduct::run([]);
        $this->assertDatabaseEmpty('products');
    }
}
