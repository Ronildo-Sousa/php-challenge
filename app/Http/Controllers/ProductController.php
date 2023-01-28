<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\ListProductsRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(ListProductsRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        $productsPerPage = $requestData['per-page'] ?? 6;

        $products = Product::query()
            ->paginate($productsPerPage);

        return response()->json(['products' => $products], Response::HTTP_OK);
    }

    public function show(int $code): JsonResponse
    {
        $product = Product::query()->find($code);
        if (!$product) {
            return response()->json(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, $code): JsonResponse
    {
        $product = Product::query()->find($code);

        if (!$product) {
            return response()->json(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->update($request->validated());

        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    public function destroy(int $code): JsonResponse
    {
        $product = Product::query()->find($code);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->update(['status' => ProductStatus::trash->value]);

        return response()->json(['message' => 'product marks as trash'], Response::HTTP_OK);
    }
}
