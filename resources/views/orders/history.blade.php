@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{ __('Order History') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if($finishedOrders->isEmpty())
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        You have no finished orders.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($finishedOrders as $order)
                        <div class="border-b border-gray-300 dark:border-gray-700 py-4">
                            <p><strong>Order ID:</strong> {{ $order->id }}</p>
                            <p><strong>Total Amount:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Payment Method:</strong> {{ $order->payment->name }}</p>
                            <p><strong>Status:</strong> <span class="text-green-500">{{ $order->status }}</span></p>
                            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                            <a href="{{ route('orders.show', $order->id) }}" class="text-red-600 hover:underline">
                                View Details
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
