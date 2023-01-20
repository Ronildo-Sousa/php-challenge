<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->paginate(6);

        return response()->json(['products' => $products], Response::HTTP_OK);
    }

    public function show(int $code)
    {
        $product = Product::query()->find($code);
        if (!$product) {
            return response()->json(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, $code)
    {
        $product = Product::query()->find($code);

        if (!$product) {
            return response()->json(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->update($request->validated());

        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    public function destroy(int $code)
    {
        $product = Product::query()->find($code);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->status = ProductStatus::trash->value;
        $product->save();

        return response()->json(['message' => 'product marks as trash'], Response::HTTP_OK);
    }
}
