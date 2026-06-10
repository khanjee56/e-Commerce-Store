<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    public function register(){
        return view('auth.register');
    }
 public function registersave(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
    ]);

    return redirect('login')->with('success', 'Account created successfully!');
}
public function login(){
    return view('auth.login');
}
public function loginsave(REQUEST $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        return redirect('/')->with('success', 'Logged in successfully!');
    }

    return back()->with('error', 'Invalid email or password!');
}
public function logout(REQUEST $request){
    Auth::logout();
    return redirect('/login');
}
}

