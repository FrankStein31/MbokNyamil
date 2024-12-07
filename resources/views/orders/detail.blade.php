@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('Order Details') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h3>

                <div class="space-y-4">
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Total Amount:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>

                    <h4 class="text-xl font-semibold mt-6">Ordered Products:</h4>
                    <div class="divide-y divide-gray-300 dark:divide-gray-700">
                        @foreach($order->items as $item)
                        <div class="py-4 flex justify-between">
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

                    <h4 class="text-xl font-semibold mt-6">Payment Method:</h4>
                    <p>{{ $order->payment->name }}: {{ $order->payment->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
