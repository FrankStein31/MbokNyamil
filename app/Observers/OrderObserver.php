<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\OrderStatusUpdate;

class OrderObserver
{
    public function updated(Order $order)
    {
        // Cek apakah status berubah
        if ($order->wasChanged('status')) {
            // Kirim notifikasi ke user
            $order->user->notify(new OrderStatusUpdate($order->status, $order->id));
        }
    }
}