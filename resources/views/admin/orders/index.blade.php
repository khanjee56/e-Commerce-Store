@extends('layouts.app')

@section('content')

<h2 class="mb-4">📋 Manage Orders</h2>

@forelse($orders as $order)
    <div class="card mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <span>Order #{{ $order->id }} — {{ $order->user->name }}</span>
            <span>{{ $order->created_at->format('d M Y') }}</span>
        </div>
        <div class="card-body">

            <!-- Order Items -->
            <table class="table table-sm">
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

            <!-- Order Status + Total -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <strong>Total: Rs. {{ $order->total_price }}</strong>

                <!-- Update Status Form -->
                <form action="/admin/orders/{{ $order->id }}" method="POST" class="d-flex gap-2">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-select form-select-sm">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                            Delivered
                        </option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-dark">Update</button>
                </form>
            </div>

            <!-- Status Badge -->
            <div class="mt-2">
                Status:
                @if($order->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($order->status == 'delivered')
                    <span class="badge bg-success">Delivered</span>
                @else
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </div>

        </div>
    </div>
@empty
    <div class="text-center mt-5">
        <h4>No orders yet!</h4>
    </div>
@endforelse

@endsection