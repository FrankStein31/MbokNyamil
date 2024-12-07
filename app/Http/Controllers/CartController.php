<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        return response()->json($cartItems);
    }

    public function showCart()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('cart', compact('cartItems', 'total'));
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($request->id);

        // Pastikan user hanya bisa mengupdate cart miliknya
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Periksa stok produk
        $product = $cartItem->product; // Asumsi ada relasi 'product' di model Cart
        if ($request->quantity > $product->stock) {
            return response()->json([
                'error' => 'Quantity exceeds available stock!',
                'available_stock' => $product->stock,
            ], 400);
        }

        // Update quantity jika stok mencukupi
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Hitung total baru
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'status' => 'success',
            'quantity' => $cartItem->quantity,
            'total' => $total
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id'
        ]);

        $cartItem = Cart::findOrFail($request->id);

        if ($cartItem->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to add to cart.'], 403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Dapatkan informasi produk
        $product = \App\Models\Product::findOrFail($validated['product_id']);

        // Dapatkan item cart pengguna (jika ada)
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        // Hitung total quantity setelah penambahan
        $newQuantity = ($cartItem ? $cartItem->quantity : 0) + $validated['quantity'];

        // Cek apakah stok mencukupi
        if ($newQuantity > $product->stock) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock!');
        }

        // Tambahkan atau perbarui cart item
        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
            ],
            [
                'quantity' => $newQuantity,
            ]
        );

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('checkout', compact('cartItems', 'total'));
    }
}
