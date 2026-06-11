@extends('layouts.app')

@section('content')

<h2 class="mb-4">📦 My Orders</h2>

@if(count($orders) > 0)
    @foreach($orders as $order)
        <div class="card mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <span>Order #{{ $order->id }}</span>
                <span>{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rs. {{ $item->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <span>
                        Status:
                        @if($order->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">Delivered</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </span>
                    <strong>Total: Rs. {{ $order->total_price }}</strong>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center mt-5">
        <h4>You have no orders yet! 😢</h4>
        <a href="/" class="btn btn-dark mt-3">Start Shopping</a>
    </div>
@endif

@endsection