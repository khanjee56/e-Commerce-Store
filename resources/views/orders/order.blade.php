@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <h2 class="mb-4">✅ Place Order</h2>

        <!-- Order Summary -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rs. {{ $item['price'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rs. {{ $item['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                            <td class="fw-bold text-success">Rs. {{ $grandTotal }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Your Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Confirm Order Button -->
        <form action="/orders/place" method="POST">
            @csrf
            <div class="d-flex justify-content-between">
                <a href="/cart" class="btn btn-outline-dark">← Back to Cart</a>
                <button type="submit" class="btn btn-dark btn-lg">
                    Confirm Order ✅
                </button>
            </div>
        </form>

    </div>
</div>

@endsection