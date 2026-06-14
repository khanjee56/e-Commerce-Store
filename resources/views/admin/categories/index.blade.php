@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🏷️ Manage Categories</h2>
    <a href="/admin/categories/create" class="btn btn-dark">+ Add New Category</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Total Products</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <a href="/admin/categories/{{ $category->id }}/edit"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="/admin/categories/{{ $category->id }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure? All products in this category will be affected!')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No categories found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection