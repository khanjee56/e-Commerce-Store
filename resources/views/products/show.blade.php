@extends('layouts.app')

@section('content')

<div class="row">
    <!-- Product Image -->
    <div class="col-md-5">
                         @if($product->image)
    @if(str_starts_with($product->image, 'images/'))
        <img src="{{ asset($product->image) }}" width="360" style="object-fit: cover; height: 360px;">
    @else
        <img src="{{ asset('storage/' . $product->image) }}" width="360" style="object-fit: cover; height: 360px;">
    @endif
@else
    <img src="https://via.placeholder.com/60" width="60">
@endif
    </div>

    <!-- Product Info -->
    <div class="col-md-7">
        <h2>{{ $product->name }}</h2>
        <span class="badge bg-dark">{{ $product->category->name }}</span>
        <hr>
        <h3 class="text-success">Rs. {{ $product->price }}</h3>
        <p>{{ $product->description }}</p>
        <p class="text-muted">Stock Available: {{ $product->stock }}</p>

        @auth
            @if($product->stock > 0)
                <form action="/cart/add" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" name="quantity"
                               class="form-control w-25"
                               value="1" min="1"
                               max="{{ $product->stock }}">
                    </div>
                    <button type="submit" class="btn btn-dark btn-lg">
                        🛒 Add to Cart
                    </button>
                </form>
            @else
                <button class="btn btn-secondary btn-lg" disabled>
                    Out of Stock
                </button>
            @endif
        @else
            <a href="/login" class="btn btn-dark btn-lg">
                Login to Add to Cart
            </a>
        @endauth

        <a href="/" class="btn btn-outline-dark mt-2">← Back to Home</a>
    </div>
</div>

@endsection