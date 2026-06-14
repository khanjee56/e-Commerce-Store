@extends('layouts.app')

@section('content')

<h2 class="mb-4">✏️ Edit Category</h2>

<div class="card">
    <div class="card-body">
        <form action="/admin/categories/{{ $category->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $category->name }}"
                       required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="/admin/categories" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Update Category</button>
            </div>

        </form>
    </div>
</div>

@endsection