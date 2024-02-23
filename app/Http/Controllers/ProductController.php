<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $user_id = $request->user()->id;
        $products = Product::where('user_id',$user_id)->get();
        return response($products,201);
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'price' => 'required',
        ]);

        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response(['message' => 'Product Created Successfully!'],201);
    }

    public function show($id){
        $product = Product::finddOrFail($id);

        return response($product,201);
    }

    public function update(Request $request , $id){
        $product = Product::finddOrFail($id);

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response(['message' => 'Product Updated Successfully!'],201);
    }

    public function destroy($id){
        $product = Product::finddOrFail($id);
        $product->delete();
        return response(['message' => 'Product Deleted Successfully'],201);
    }
}
