<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
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
    public function show(int $code)
    {
        $product = Product::query()->find($code);
        if (!$product) {
            return response()->json(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *   tags={"Products"},
     *   path="/api/products/{code}",
     *   summary="Updates a product",
     *   description="Updates a single product based on a code",
     *    @OA\Parameter(
     *     name="code",
     *     description="product code",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="status", type="string",
     *       ),
     *       @OA\Property(
     *         property="url", type="string",
     *       ),
     *       @OA\Property(
     *         property="creator", type="string",
     *       ),
     *       @OA\Property(
     *         property="product_name", type="string",
     *       ),
     *       @OA\Property(
     *         property="quantity", type="string",
     *       ),
     *       @OA\Property(
     *         property="brands", type="string",
     *       ),
     *       @OA\Property(
     *         property="categories", type="string",
     *       ),
     *       @OA\Property(
     *         property="labels", type="string",
     *       ),
     *       @OA\Property(
     *         property="cities", type="string",
     *       ),
     *        @OA\Property(
     *         property="purchase_places", type="string",
     *       ),
     *       @OA\Property(
     *         property="stores", type="string",
     *       ),
     *       @OA\Property(
     *         property="ingredients_text", type="string",
     *       ),
     *       @OA\Property(
     *         property="traces", type="string",
     *       ),
     *       @OA\Property(
     *         property="serving_size", type="string",
     *       ),
     *       @OA\Property(
     *         property="serving_quantity", type="number",
     *       ),
     *       @OA\Property(
     *         property="nutriscore_score", type="number",
     *       ),
     *       @OA\Property(
     *         property="nutriscore_grade", type="string",
     *       ),
     *       @OA\Property(
     *         property="main_category", type="string",
     *       ),
     *       @OA\Property(
     *         property="image_url", type="string",
     *       ),
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   @OA\Response(
     *     response=404, 
     *     description="Not Found"
     *   ),
     *   @OA\Response(
     *     response=422, 
     *     description="Unprocessable Entity"
     *   )
     * )
     */
    public function update(UpdateProductRequest $request, $code)
    {
        $product = Product::query()->find($code);

        if (!$product) {
            return response()->json(['message' => 'product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->update($request->validated());

        return response()->json(['product' => $product], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *   tags={"Products"},
     *   path="/api/products/{code}",
     *   summary="Deletes a product",
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
