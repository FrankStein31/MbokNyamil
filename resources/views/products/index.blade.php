@extends('layouts.welcome')

@section('title', 'Our Products')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text 
                       bg-gradient-to-r from-red-500 to-orange-600 mb-4">
                Jelajahi Produk Kami
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berbagai produk berkualitas dengan harga terbaik. 
                Setiap produk dipilih dengan teliti untuk memberikan pengalaman terbaik.
            </p>
        </div>

        {{-- Notification System --}}
        @if (session('success'))
        <div id="success-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 
                                        bg-gradient-to-r from-green-400 to-green-600 
                                        text-white px-6 py-4 rounded-xl shadow-2xl 
                                        animate-bounce">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if (session('error'))
        <div id="error-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 
                                      bg-gradient-to-r from-red-400 to-red-600 
                                      text-white px-6 py-4 rounded-xl shadow-2xl 
                                      animate-shake">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        {{-- Search and Filter Section --}}
        <div class="mb-12">
            <form method="GET" action="{{ route('products.index') }}" class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <div class="relative flex-grow">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari produk..."
                            value="{{ request('search') }}"
                            class="w-full px-5 py-3 rounded-full border-2 border-gray-300 
                                   focus:border-red-500 focus:ring-2 focus:ring-red-200 
                                   transition duration-300 ease-in-out"
                        >
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 
                                    w-6 h-6 text-gray-400" fill="none" stroke="currentColor" 
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <div class="relative flex-grow">
                        <select name="category" onchange="this.form.submit()" 
                                class="w-full px-5 py-3 rounded-full border-2 border-gray-300 
                                       focus:border-red-500 focus:ring-2 focus:ring-red-200 
                                       transition duration-300 ease-in-out appearance-none">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 
                                    w-6 h-6 text-gray-400 pointer-events-none" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($products as $product)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden 
                        transform transition duration-300 hover:scale-105 
                        hover:shadow-2xl group">
                <div class="relative p-6 bg-gray-100">
                    <img 
                        src="{{ asset('storage/' . $product->image) }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-56 object-contain rounded-xl 
                               transition duration-300 group-hover:scale-110"
                    >
                    <div class="absolute top-4 right-4 bg-red-500 text-white 
                                px-3 py-1 rounded-full text-xs">
                        {{ $product->category->name }}
                    </div>
                </div>

                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2 truncate">
                        {{ $product->name }}
                    </h2>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold text-red-600">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-500 bg-gray-200 px-2 py-1 rounded-full">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>

                    @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-orange-500 
                                                     text-white px-6 py-3 rounded-full 
                                                     font-semibold shadow-lg hover:shadow-2xl 
                                                     hover:from-red-600 hover:to-orange-600 
                                                     transition duration-300 ease-in-out 
                                                     transform hover:-translate-y-1 
                                                     flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 4.293a1 1 0 00-.207.707V19a1 1 0 001 1h16a1 1 0 001-1v-1a1 1 0 00-.207-.707L17 13M7 13V9a4 4 0 014-4h4a4 4 0 014 4v4"></path>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    @else
                    <button onclick="alert('Anda harus login untuk menambahkan produk ke keranjang!')" 
                            class="w-full bg-gray-300 text-gray-700 px-6 py-3 rounded-full 
                                   hover:bg-gray-400 transition duration-300">
                        Tambah ke Keranjang
                    </button>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <img src="/api/placeholder/400/300" alt="No Products" class="mx-auto mb-6">
                <p class="text-2xl text-gray-500">Tidak ada produk yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        const removeMessage = (message) => {
            if (message) {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-20px)';
                    setTimeout(() => message.remove(), 500);
                }, 2000);
            }
        };

        removeMessage(successMessage);
        removeMessage(errorMessage);
    });
</script>
@endsection