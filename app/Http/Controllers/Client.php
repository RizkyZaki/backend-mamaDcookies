<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class Client extends Controller
{
    function allProduct()
    {
        $product = Product::with('category')->get();
        return response()->json([
            'product' => $product
        ], 200);
    }

    function allCategory()
    {
        $category = Category::all();
        return response()->json([
            'category' => $category
        ], 200);
    }

    function recentProduct()
    {
        $product = Product::latest()->take(5)->with("category")->get();
        return response()->json([
            'product' => $product
        ], 200);
    }
    function searchProduct($keyword)
    {
        $result = Product::where('nama_product', 'LIKE', '%' . $keyword . '%')->with("category")->get();
        if (count($result)) {
            return response()->json($result);
        } else {
            return response()->json(['result' => 'Product Not Found'], 422);
        }
    }

    function CategoryProduct($id)
    {
        $category = Category::find($id);
        return response()->json([
            'product' => $category->product,
            'category' => $category->nama_category
        ]);
    }

    function detailShow($id)
    {
        $product = Product::with('category')->find($id);
        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }
}
