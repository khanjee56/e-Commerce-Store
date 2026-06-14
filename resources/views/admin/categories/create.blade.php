@extends('layouts.app')

@section('content')

<h2 class="mb-4">➕ Add New Category</h2>

<div class="card">
    <div class="card-body">
        <form action="/admin/categories" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="e.g. Electronics"
                       required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="/admin/categories" class="btn btn-outline-dark">← Back</a>
                <button type="submit" class="btn btn-dark">Add Category</button>
            </div>

        </form>
    </div>
</div>

@endsection