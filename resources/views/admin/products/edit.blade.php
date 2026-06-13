@extends('layouts.app')

@section('content')

<h2 class="mb-4">✏️ Edit Product</h2>

<div class="card">
    <div class="card-body">
        <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (Rs.)</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                    @error('stock')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
             @if($product->image)
    @if(str_starts_with($product->image, 'images/'))
        <img src="{{ asset($product->image) }}" width="100" class="mb-2 rounded">
    @else
        <img src="{{ asset('storage/' . $product->image) }}" width="100" class="mb-2 rounded">
    @endif
@else
    <p class="text-muted">No image uploaded</p>
@endif
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image (optional)</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="/admin/products" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Update Product</button>
            </div>

        </form>
    </div>
</div>

@endsection