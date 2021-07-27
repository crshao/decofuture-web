<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return Product::find($product->id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'color' => 'required',
            'stock' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails())
        {
            return $validator->errors();
        }

        Product::create([
            'seller_id' => $request['seller_id'],
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'color' => $request['color'],
            'stock' => $request['stock'],
            'image' => $request['image']
        ]);

        return new JsonResponse([
            'result' => true,
            'type' => 'success',
            'http_code' => 200,
            'info' => 'create product success!',
        ], 200);
    }
}
