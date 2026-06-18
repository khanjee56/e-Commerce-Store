<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
   public function index(Request $request)
{
    $categories = Category::all();

    $products = Product::with('category')
        ->when($request->category, function($query) use ($request) {
            return $query->where('category_id', $request->category);
        })
        ->when($request->search, function($query) use ($request) {
            return $query->where('name', 'LIKE', '%' . $request->search . '%');
        })
        ->get();

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
// Show Face Login Page
public function faceLogin()
{
    return view('auth.face-login');
}

// Verify Face Login
public function faceLoginVerify(Request $request)
{
    // Get all admin users who have face data
    $admins = \App\Models\User::where('role', 'admin')
                              ->whereNotNull('face_descriptor')
                              ->get();

    if($admins->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No admin face data found!'
        ]);
    }

    // Get incoming face descriptor
    $incomingDescriptor = $request->face_descriptor;

    foreach($admins as $admin) {
        // Get saved face descriptor
        $savedDescriptor = json_decode($admin->face_descriptor, true);

        // Calculate distance between two faces
        $distance = $this->euclideanDistance($incomingDescriptor, $savedDescriptor);

        // If distance is less than 0.6 → faces match!
        if($distance < 0.6) {
            // Log the admin in
            Auth::login($admin);

            return response()->json([
                'success' => true,
                'message' => 'Face matched! Logging in...'
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Face not recognized!'
    ]);
}

// Calculate distance between two face descriptors
// Calculate distance between two face descriptors
private function euclideanDistance($descriptor1, $descriptor2)
{
    $sum = 0;
    for($i = 0; $i < count($descriptor1); $i++) {
        $sum += pow($descriptor1[$i] - $descriptor2[$i], 2);
    }
    return sqrt($sum);
}
// Show Profile Page
public function profile()
{
    return view('profile');
}

// Update Profile
public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
    ]);

    return redirect('/profile')->with('success', 'Profile updated successfully!');
}

// Update Password
public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password'         => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    // Check if current password is correct
    if(!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Current password is incorrect!');
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect('/profile')->with('success', 'Password updated successfully!');
}
}

