@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📦 Manage Products</h2>
    <a href="/admin/products/create" class="btn btn-dark">+ Add New Product</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                    @if($product->image)
    @if(str_starts_with($product->image, 'images/'))
        <img src="{{ asset($product->image) }}" width="60" style="object-fit: cover; height: 60px;">
    @else
        <img src="{{ asset('storage/' . $product->image) }}" width="60" style="object-fit: cover; height: 60px;">
    @endif
@else
    <img src="https://via.placeholder.com/60" width="60">
@endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>Rs. {{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-warning">Edit</a>

                        <form action="/admin/products/{{ $product->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No products found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection