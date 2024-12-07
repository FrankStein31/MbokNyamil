<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan dengan status selain 'finished' untuk pengguna yang sedang login
        $orders = Order::where('user_id', auth()->id())
            ->where('status', '!=', 'finished') // Status selain 'finished'
            ->get();

        // Tampilkan pesanan di view 'orders.index'
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Ambil pesanan berdasarkan ID
        $order = Order::with('items.product', 'payment')->where('user_id', auth()->id())->findOrFail($id);

        // Tampilkan detail pesanan
        return view('orders.detail', compact('order'));
    }
    public function history()
    {
        $finishedOrders = Order::where('user_id', auth()->id())
            ->where('status', 'finished')
            ->get();

        return view('orders.history', compact('finishedOrders'));
    }
}
