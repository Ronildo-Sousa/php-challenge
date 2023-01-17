<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

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
