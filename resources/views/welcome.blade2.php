<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <header class="fixed top-0 left-0 w-full z-50 bg-red-500 dark:bg-red-500 shadow-md">
            <div class="container mx-auto flex justify-between items-center py-4 px-6">
                <a href="{{ url('/') }}" class="font-bold text-xl rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">{{ config('app.name') }}</a>
                <nav class="flex justify-between items-center space-x-4">
                    <div class="flex items-center space-x-4">
                        <ul class="flex space-x-4">
                            <li><a href="{{ url('/') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Home</a></li>
                            <li><a href="{{ route('about') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">About</a></li>
                            <li><a href="" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Products</a></li>
                            <li><a href="" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Contact</a></li>
                        </ul>
                        @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                        </a>
                        @endif
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <div class="relative min-h-screen flex flex-col items-center justify-center pt-24 selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="mt-6">
                    <!-- Banner Carousel -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($banners as $banner)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->name }}" class="w-full h-auto object-cover">
                            </div>
                            @endforeach
                        </div>
                        <!-- Navigasi -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- Pagination di dalam swiper-container -->
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="container mx-auto py-8">
                        <h1 class="text-2xl font-bold mb-6 text-center">Daftar Produk</h1>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($products as $product)
                            <div class="border rounded-lg shadow-md overflow-hidden">
                                <div class="flex justify-center">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-contain">
                                </div>
                                <div class="p-4">
                                    <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                                    <p class="text-sm text-gray-500">Kategori: {{ $product->category->name }}</p>
                                    <p class="text-lg font-bold text-red-500">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </main>
            </div>
        </div>
        <footer class="py-16 text-center text-sm text-black dark:text-white/70">
            {{ config('app.name') }} v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.swiper-container', {
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                slidesPerView: 1, // Menampilkan satu banner per layar
                spaceBetween: 30, // Jarak antar-slide
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });
    </script>
    <style>
        .swiper-container {
            position: relative;
            margin-top: 100px;
            width: 100%;
        }

        .swiper-pagination {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
</body>

</html>