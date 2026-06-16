@extends('layouts.app')

@section('content')

<h2 class="mb-4">📊 Admin Dashboard</h2>

<div class="row justify-content-center g-10">
    <div class="col-md-2 mb-4">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h3>{{ $totalProducts }}</h3>
                <p class="mb-0">Total Products</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h3>{{ $totalOrders }}</h3>
                <p class="mb-0">Total Orders</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h3>{{ $totalCategories }}</h3>
                <p class="mb-0">Categories</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <h3>{{ $pendingOrders }}</h3>
                <p class="mb-0">Pending Orders</p>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card text-center bg-secondary text-white">
            <div class="card-body">
                <h3>{{ $totalusers }}</h3>
                <p class="mb-0">All Users</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <a href="/admin/products" class="btn btn-dark w-100 py-3">
            📦 Manage Products
        </a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="/admin/categories" class="btn btn-dark w-100 py-3">
            🏷️ Manage Categories
        </a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="/admin/orders" class="btn btn-dark w-100 py-3">
            📋 Manage Orders
        </a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="/admin/allusers" class="btn btn-dark w-100 py-3">
            📋 Manage Users
        </a>
    </div>
    <div class="row mt-3">
    <div class="col-md-4">
        <a href="/admin/face-setup" class="btn btn-dark w-100 py-3">
            📷 Setup Face Recognition
        </a>
    </div>
</div>
</div>

@endsection