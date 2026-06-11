@extends('layouts.app')



@section('content')

    <!-- Hero Section -->
    <div class="p-5 mb-4 bg-dark text-white rounded-3 text-center">
        <h1>🛒 Welcome to MyStore</h1>
        <p class="lead">Find the best products at the best prices!</p>
    </div>

    <!-- Categories Filter -->
    <div class="mb-4">
        <a href="/" class="btn btn-dark me-2">All</a>
        @foreach($categories as $category)
            <a href="/?category={{ $category->id }}" class="btn btn-outline-dark me-2">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($product->image)
                       <img src="{{ asset($product->image) }}"
                             class="card-img-top"
                           style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/300x200"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;"
                             alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-muted">{{ $product->category->name }}</p>
                        <h5 class="text-success">Rs. {{ $product->price }}</h5>
                        <p class="text-muted small">Stock: {{ $product->stock }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="/products/{{ $product->id }}"
                           class="btn btn-dark w-100">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <h4>No products available yet!</h4>
            </div>
        @endforelse
    </div>

@endsection
