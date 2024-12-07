@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('My Cart') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if($cartItems->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400">
                    Your cart is empty!
                </div>
                @else
                <div id="cart-items-container" class="divide-y divide-gray-300 dark:divide-gray-700">
                    @foreach($cartItems as $item)
                    <div class="flex justify-between items-center py-4" data-id="{{ $item->id }}" id="cart-item-{{ $item->id }}">
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ $item->product->name }}</p>
                            <p class="text-sm text-red-700 dark:text-gray-400">Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center">
                            <button onclick="updateQuantity({{ $item->id }}, 'decrease')"
                                class="px-2 py-1 bg-red-600 text-white rounded-l hover:bg-red-700">-</button>
                            <span id="quantity-{{ $item->id }}"
                                class="px-4 py-1 bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                                {{ $item->quantity }}
                            </span>
                            <button onclick="updateQuantity({{ $item->id }}, 'increase')"
                                class="px-2 py-1 bg-red-600 text-white rounded-r hover:bg-red-700">+</button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <div class="flex justify-between mb-4">
                        <span class="text-3xl font-semibold">Total:</span>
                        <span id="cart-total" class="text-3xl font-bold text-red-600">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                    <a href="{{ route('checkout.show') }}"
                        class="w-full bg-red-700 text-white py-2 rounded text-center block hover:bg-red-800 transition">
                        Proceed to Checkout
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if (session('error'))
<div id="error-message" class="bg-red-500 text-white p-4 rounded-md mb-4 fixed top-4 left-1/2 transform -translate-x-1/2 z-50 shadow-lg">
    {{ session('error') }}
</div>
@endif

<script>
    function updateQuantity(id, action) {
        const quantityElement = document.getElementById(`quantity-${id}`);
        let currentQuantity = parseInt(quantityElement.textContent);
        let newQuantity;

        if (action === 'increase') {
            newQuantity = currentQuantity + 1;
        } else if (action === 'decrease' && currentQuantity > 1) {
            newQuantity = currentQuantity - 1;
        } else {
            return;
        }

        fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update quantity display
                    quantityElement.textContent = data.quantity;

                    // Format currency for total
                    const formattedTotal = 'Rp' + new Intl.NumberFormat('id-ID').format(data.total);

                    // Update total
                    const totalElement = document.getElementById('cart-total');
                    totalElement.textContent = formattedTotal;
                } else if (data.error) {
                    // Show error message
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update cart');
            });
    }
</script>
@endsection