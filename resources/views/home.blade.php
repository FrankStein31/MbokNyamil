@extends('layouts.welcome')

@section('title', 'Home')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <main>
            {{-- Banner Section with Enhanced Styling --}}
            <section class="mb-12 rounded-2xl overflow-hidden shadow-lg relative">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($banners as $banner)
                        <div class="swiper-slide transition-transform duration-300 hover:scale-105">
                            <img 
                                src="{{ asset('storage/' . $banner->image) }}" 
                                alt="{{ $banner->name }}" 
                                class="w-full h-[300px] lg:h-[400px] object-cover"
                            >
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Custom Navigation Styling --}}
                    <div class="swiper-button-prev !w-10 !h-10 !left-2 bg-white/50 hover:bg-white/70 rounded-full !after:text-lg"></div>
                    <div class="swiper-button-next !w-10 !h-10 !right-2 bg-white/50 hover:bg-white/70 rounded-full !after:text-lg"></div>
                    
                    {{-- Pagination --}}
                    <div class="swiper-pagination"></div>
                </div>
            </section>

            {{-- Products Section with Grid Layout --}}
            <section>
                <div class="text-center mb-10">
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-800 
                               bg-gradient-to-r from-red-500 to-pink-600 
                               bg-clip-text text-transparent">
                        Produk Kami
                    </h1>
                    <p class="text-gray-500 mt-2">Temukan produk berkualitas dengan harga terbaik</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden 
                                transition-all duration-300 hover:shadow-xl 
                                hover:-translate-y-2 group">
                        <div class="relative">
                            <img 
                                src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-48 object-contain p-4 
                                       group-hover:scale-105 transition-transform"
                            >
                            <div class="absolute top-4 right-4 
                                        bg-red-500 text-white px-2 py-1 
                                        rounded-full text-xs">
                                {{ $product->category->name }}
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">
                                {{ $product->name }}
                            </h2>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-red-600">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </main>
    </div>
</div>

{{-- Swiper JS dan Konfigurasi --}}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
        });
    });
</script>
@endsection