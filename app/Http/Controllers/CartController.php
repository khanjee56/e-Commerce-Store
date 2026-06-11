<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show Cart Page
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add to Cart
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        // If product already in cart — increase quantity
        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
            $cart[$request->product_id]['total'] = 
                $cart[$request->product_id]['quantity'] * $product->price;
        } else {
            // Add new product to cart
            $cart[$request->product_id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $request->quantity,
                'total'    => $product->price * $request->quantity,
                'image'    => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect('/')->with('success', 'Product added to cart successfully!');
    }

    // Remove from Cart
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect('/cart')->with('success', 'Product removed from cart!');
    }

    // Clear Cart
    public function clear()
    {
        session()->forget('cart');
        return redirect('/cart')->with('success', 'Cart cleared!');
    }
}