@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('Checkout') }}
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
                    <h3 class="text-2xl font-bold mb-4">Cart Items</h3>
                    @foreach($cartItems as $item)
                    <div class="flex justify-between items-center py-4">
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-white">{{ $item->product->name }}</p>
                            <p class="text-sm text-red-700 dark:text-gray-400">
                                Rp{{ number_format($item->product->price, 0, ',', '.') }} x {{ $item->quantity }}
                            </p>
                        </div>
                        <div class="font-semibold text-gray-800 dark:text-white">
                            Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-3xl font-semibold">Total:</span>
                        <span id="cart-total" class="text-3xl font-bold text-red-600">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-2xl font-bold mb-4">Shipping Information</h3>
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="address" class="block font-medium text-gray-700 dark:text-gray-300">
                                    Address
                                </label>
                                <input type="text" name="address" id="address" class="w-full mt-1 p-2 border rounded bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200" required>
                            </div>
                            <div>
                                <label for="phone" class="block font-medium text-gray-700 dark:text-gray-300">
                                    Phone Number
                                </label>
                                <input type="text" name="phone" id="phone" class="w-full mt-1 p-2 border rounded bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200" required>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-4">Payment Method</h3>
                            <div class="space-y-4">
                                <label for="payment_id" class="block font-medium text-gray-700 dark:text-gray-300">
                                    Select Payment Method
                                </label>
                                <select name="payment_id" id="payment_id" class="w-full mt-1 p-2 border rounded bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200" required>
                                    <option value="" disabled selected>Select a payment method</option>
                                    @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}" data-description="{{ $payment->description }}">
                                        {{ $payment->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <p id="payment-description" class="mt-2 text-gray-500 dark:text-gray-400"></p>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full mt-4 bg-red-700 text-white py-3 rounded text-center block hover:bg-red-800 transition">
                            Complete Purchase
                        </button>
                    </form>
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
    document.addEventListener('DOMContentLoaded', function () {
        const paymentSelect = document.getElementById('payment_id');
        const paymentDescription = document.getElementById('payment-description');

        paymentSelect.addEventListener('change', function () {
            // Ambil deskripsi dari atribut data-description di <option>
            const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
            const description = selectedOption.getAttribute('data-description');

            // Tampilkan deskripsi di elemen paragraf
            paymentDescription.textContent = description ? description : '';
        });
    });
</script>
@endsection