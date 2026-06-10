<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->category, function($query) use ($request) {
            return $query->where('category_id', $request->category);
        })->get();

        return view('home', compact('products', 'categories'));
    }
}