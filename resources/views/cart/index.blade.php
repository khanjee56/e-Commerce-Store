@extends('layouts.app')

@section('content')

<h2 class="mb-4">🛒 My Cart</h2>

@if(count($cart) > 0)

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp

                @foreach($cart as $id => $item)
                    @php $grandTotal += $item['total']; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rs. {{ $item['price'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rs. {{ $item['total'] }}</td>
                        <td>
                            <form action="/cart/remove" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                    <td colspan="2" class="fw-bold text-success">Rs. {{ $grandTotal }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between">
        <a href="/cart/clear" class="btn btn-outline-danger">🗑️ Clear Cart</a>
        <a href="/orders/place" class="btn btn-dark btn-lg">Place Order ✅</a>
    </div>

@else
    <div class="text-center mt-5">
        <h4>Your cart is empty! 😢</h4>
        <a href="/" class="btn btn-dark mt-3">Continue Shopping</a>
    </div>
@endif 
@endsection