@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('My Orders') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if($orders->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400">
                    You don't have any orders yet.
                </div>
                @else
                <div class="divide-y divide-gray-300 dark:divide-gray-700">
                    @foreach ($orders as $order)
                    <div class="py-4">
                        <p><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p><strong>Total Amount:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                        <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                        <a href="{{ route('orders.show', $order->id) }}"
                            class="text-blue-500 hover:underline mt-2 inline-block">
                            View Order Details
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
