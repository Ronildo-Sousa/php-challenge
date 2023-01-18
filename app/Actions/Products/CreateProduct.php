<?php

namespace App\Actions\Products;

use App\Enums\ProductStatus;
use App\Models\Product;

class CreateProduct
{
    public static function run(array $productData): ?Product
    {
        if (empty($productData)) {
            return null;
        }

        return Product::query()
            ->create([
                'code' => $productData['code'],
                'status' => $productData['status'] ?? ProductStatus::published->value,
                'imported_t' => now(),
                'url' => $productData['url'],
                'creator' => $productData['creator'],
                'created_t' => $productData['created_t'],
                'last_modified_t' => $productData['last_modified_t'],
                'product_name' => $productData['product_name'],
                'quantity' => $productData['quantity'],
                'brands' => $productData['brands'],
                'categories' => $productData['categories'],
                'labels' => $productData['labels'],
                'cities' => $productData['cities'],
                'purchase_places' => $productData['purchase_places'],
                'stores' => $productData['stores'],
                'ingredients_text' => $productData['ingredients_text'],
                'traces' => $productData['traces'],
                'serving_size' => $productData['serving_size'],
                'serving_quantity' => (float)$productData['serving_quantity'],
                'nutriscore_score' => (float)$productData['nutriscore_score'],
                'nutriscore_grade' => $productData['nutriscore_grade'],
                'main_category' => $productData['main_category'],
                'image_url' => $productData['image_url'],
            ]);
    }
}
