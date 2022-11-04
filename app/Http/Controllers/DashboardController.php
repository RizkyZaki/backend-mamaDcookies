<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $product = Product::count();
        $category = Category::count();
        return response()->json([
            'success' => true,
            'product' => $product,
            'category' => $category
        ], 200);
    }
}
