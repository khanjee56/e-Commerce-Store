<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCategories = Category::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalusers  = User::count();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalCategories', 'pendingOrders','totalusers'));
    }
   public function logout(){
    Auth::logout();
    return redirect('/login');
   }
    // Show All Products
    public function products()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Show Add Product Form
    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Save New Product
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'category_id' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return redirect('/admin/products')->with('success', 'Product added successfully!');
    }

    // Show Edit Product Form
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update Product
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'category_id' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $product->image;

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }

    // Delete Product
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product deleted successfully!');
    }
    // Show All Categories
public function categories()
{
    $categories = Category::withCount('products')->latest()->get();
    return view('admin.categories.index', compact('categories'));
}

// Show Add Category Form
public function createCategory()
{
    return view('admin.categories.create');
}

// Save New Category
public function storeCategory(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories|max:255',
    ]);

    Category::create(['name' => $request->name]);

    return redirect('/admin/categories')->with('success', 'Category added successfully!');
}

// Show Edit Category Form
public function editCategory($id)
{
    $category = Category::findOrFail($id);
    return view('admin.categories.edit', compact('category'));
}

// Update Category
public function updateCategory(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'name' => 'required|max:255|unique:categories,name,' . $id,
    ]);

    $category->update(['name' => $request->name]);

    return redirect('/admin/categories')->with('success', 'Category updated successfully!');
}

// Delete Category
public function destroyCategory($id)
{
    $category = Category::findOrFail($id);
    $category->delete();
    return redirect('/admin/categories')->with('success', 'Category deleted successfully!');
}
// Show All Orders
public function orders()
{
    $orders = Order::with('user', 'orderItems.product')->latest()->get();
    return view('admin.orders.index', compact('orders'));
}

// Update Order Status
public function updateOrderStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $request->validate([
        'status' => 'required|in:pending,delivered,cancelled',
    ]);

    $order->update(['status' => $request->status]);

    return redirect('/admin/orders')->with('success', 'Order status updated successfully!');
}

public function show(){
    $users = User::all();
   
  
    return view('admin.user.index', compact('users'));
}
public function delete($id){
     $user = User::findorFail($id);
     $user->delete();
     return redirect('/admin/allusers')->with('sucess','user deleted sucessfully');
}
}