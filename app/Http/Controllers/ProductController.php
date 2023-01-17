<?php

namespace App\Http\Controllers;

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

    public function destroy($id)
    {
        //
    }
}
