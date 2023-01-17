<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"Products"},
     *   path="/api/products",
     *   summary="Get a list of products",
     *   description="Returns a paginated list of all products",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function index()
    {
        $products = Product::query()
            ->paginate(6);

        return response()->json(['products' => $products], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *   tags={"Products"},
     *   path="/api/products/{code}",
     *   summary="Get product information",
     *   description="Returns details of a product based on a code",
     *   @OA\Parameter(
     *     name="code",
     *     description="product code",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   @OA\Response(
     *     response=404, 
     *     description="Not Found"
     *   )
     * )
     */
    public function show(Product $product)
    {
        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *   tags={"Products"},
     *   path="/api/products/{code}",
     *   summary="Delete a product",
     *   description="Marks a product as trash",
     *   @OA\Parameter(
     *     name="code",
     *     description="product code",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   @OA\Response(
     *     response=404, 
     *     description="Not Found"
     *   )
     * )
     */
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
