<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; font-size: 24px; }
        .card:hover { transform: translateY(-5px); transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        footer { background-color: #343a40; color: white; padding: 20px 0; margin-top: 50px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">🛒 MyStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    @auth
                        <li class="nav-item">
                          <a class="nav-link" href="/cart">
    <i class="fas fa-shopping-cart"></i> Cart
    @php
        $cartCount = count(session()->get('cart', []));
    @endphp
    @if($cartCount > 0)
        <span class="badge bg-danger rounded-pill">{{ $cartCount }}</span>
    @endif
</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/orders">My Orders</a>
                        </li>
                        @if(auth()->user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="/admin/dashboard">Admin Panel</a>
                            </li>
                        @endif
                        @auth
    <li class="nav-item">
        <a class="nav-link" href="/profile">
            👤 {{ auth()->user()->name }}
        </a>
    </li>
@endauth
                        <li class="nav-item">
                            <form action="{{ 'logout' }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn nav-link text-white">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ 'login' }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ 'register' }}">Register</a>
                        </li>
                        
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="text-center">
        <p>© 2026 MyStore. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>