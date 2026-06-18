@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <h2 class="mb-4">👤 My Profile</h2>

        <!-- Update Profile Info -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <form action="/profile" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ auth()->user()->name }}"
                               required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ auth()->user()->email }}"
                               required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text"
                               class="form-control"
                               value="{{ auth()->user()->role }}"
                               disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Member Since</label>
                        <input type="text"
                               class="form-control"
                               value="{{ auth()->user()->created_at->format('d M Y') }}"
                               disabled>
                    </div>

                    <button type="submit" class="btn btn-dark">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form action="/profile/password" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password"
                               name="current_password"
                               class="form-control"
                               required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit" class="btn btn-dark">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">My Orders Summary</h5>
            </div>
            <div class="card-body">
                @php
                    $orders = auth()->user()->orders;
                @endphp
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3>{{ $orders->count() }}</h3>
                        <p class="text-muted">Total Orders</p>
                    </div>
                    <div class="col-md-4">
                        <h3>{{ $orders->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted">Pending</p>
                    </div>
                    <div class="col-md-4">
                        <h3>{{ $orders->where('status', 'delivered')->count() }}</h3>
                        <p class="text-muted">Delivered</p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="/orders" class="btn btn-dark">View All Orders</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection