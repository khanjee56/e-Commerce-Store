@extends('layouts.app')



@section('content')

    <!-- Hero Section -->
    <div class="p-5 mb-4 bg-dark text-white rounded-3 text-center">
        <h1>🛒 Welcome to MyStore</h1>
        <p class="lead">Find the best products at the best prices!</p>
    </div>
    <!-- Search Bar -->
<div class="mb-4">
    <form action="/" method="GET">
        <div class="input-group">
            <input type="text"
                   name="search"
                   class="form-control form-control-lg"
                   placeholder="🔍 Search products..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-dark">Search</button>
            @if(request('search'))
                <a href="/" class="btn btn-outline-dark">Clear</a>
            @endif
        </div>
    </form>
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
    @if(str_starts_with($product->image, 'images/'))
        <img src="{{ asset($product->image) }}" width="200" style="object-fit: cover; height: 200px;">
    @else
        <img src="{{ asset('storage/' . $product->image) }}" width="200" style="object-fit: cover; height: 200px;">
    @endif
@else
    <img src="https://via.placeholder.com/60" width="60">
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
