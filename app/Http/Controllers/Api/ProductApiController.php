<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    // GET /api/products - Get all products
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'success' => true,
            'data'    => $products
        ]);
    }

    // GET /api/products/{id} - Get single product
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if(!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $product
        ]);
    }

    // GET /api/categories - Get all categories
    public function categories()
    {
        $categories = Category::withCount('products')->get();

        return response()->json([
            'success' => true,
            'data'    => $categories
        ]);
    }
}