<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Show Place Order Page
    public function placeOrderPage()
    {
        $cart = session()->get('cart', []);

        if(count($cart) == 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        $grandTotal = 0;
        foreach($cart as $item) {
            $grandTotal += $item['total'];
        }

        return view('orders.order', compact('cart', 'grandTotal'));
    }

    // Place Order
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if(count($cart) == 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        // Calculate grand total
        $grandTotal = 0;
        foreach($cart as $item) {
            $grandTotal += $item['total'];
        }

        // Create Order
        $order = Order::create([
            'user_id'     => auth()->user()->id,
            'total_price' => $grandTotal,
            'status'      => 'pending',
        ]);

        // Create Order Items
        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // Reduce stock
            $product = Product::findOrFail($id);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        // Clear Cart
        session()->forget('cart');

        return redirect('/orders')->with('success', 'Order placed successfully!');
    }

    // My Orders Page
    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->user()->id)
                        ->latest()
                        ->get();

        return view('orders.myorder', compact('orders'));
    }
}