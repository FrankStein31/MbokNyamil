<?php

namespace App\Http\Controllers;

use App\Mail\OrderUpdateStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Notifications\OrderStatusUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $payments = Payment::where('is_active', 1)->get();

        return view('checkout', compact('cartItems', 'total', 'payments'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'payment_id' => 'required|exists:payments,id',
        ]);

        DB::beginTransaction();

        try {
            $total = $this->calculateTotal();

            $order = Order::create([
                'user_id' => auth()->id(),
                'payment_id' => $request->payment_id,
                'total_amount' => $total,
                'shipping_address' => $request->address,
                'shipping_phone' => $request->phone,
                'status' => 'pending',
            ]);

            // Buat item pesanan dan kurangi stok produk
            $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
            foreach ($cartItems as $item) {
                // Pastikan stok mencukupi
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stock for product {$item->product->name} is insufficient.");
                }

                // Buat item pesanan
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan keranjang
            Cart::where('user_id', auth()->id())->delete();

            $order->user->notify(new OrderStatusUpdate($request->status, $order->id));

            DB::commit();

            // Redirect ke halaman pembayaran
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order has been placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());

            return back()->with('error', $e->getMessage());
        }
    }

    private function calculateTotal()
    {
        return Cart::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
    }
    public function updateStatus(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        // Kirim notifikasi ke user
        $order->user->notify(new OrderStatusUpdate($request->status, $order->id));

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }
}
