<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Home</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen font-sans antialiased dark:bg-black dark:text-white/50">
    
    <header class="fixed top-0 left-0 w-full z-50 bg-gradient-to-r bg-red-700 dark:bg-red-7000 shadow-2xl">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <!-- Logo on the left -->
                <a href="{{ url('/') }}" class="text-2xl font-light tracking-wider text-white hover:text-gray-300 transition-colors duration-300 ease-in-out">
                    {{ config('app.name') }}
                </a>

                <!-- Centered Navigation -->
                <div class="flex-1 flex justify-center">
                    <nav class="flex items-center">
                        <ul class="flex space-x-6">
                            <li>
                                <a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors duration-200 font-medium tracking-wide">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white transition-colors duration-200 font-medium tracking-wide">
                                    Products
                                </a>
                            </li>
                            <li class="relative" id="cart-dropdown-container">
                                <div class="relative">
                                    <button id="cart-toggle-btn" class="text-gray-300 hover:text-white transition-colors duration-200 font-medium tracking-wide flex items-center">
                                        Cart
                                        <span id="cart-count" class="bg-white text-gray-900 rounded-full px-2 py-1 text-xs ml-2">0</span>
                                    </button>
                                    <!-- Cart dropdown remains the same -->
                                    <div id="cart-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                        <!-- Cart content remains the same -->
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors duration-200 font-medium tracking-wide">
                                    About
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors duration-200 font-medium tracking-wide">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Auth links on the right -->
                <div class="pl-4 border-l border-gray-700">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-white hover:text-gray-300 transition-colors duration-200 font-medium tracking-wide">
                        Dashboard
                    </a>
                    @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:text-gray-300 transition-colors duration-200 font-medium tracking-wide">
                            Log in
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded-md transition-colors duration-200">
                            Register
                        </a>
                        @endif
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center pt-24">
        @yield('content')
    </div>
    <!-- Footer -->
    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
        @ {{ config('app.name') }}
    </footer>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cart Management
        class CartManager {
            constructor() {
                this.cart = [];
                this.cartToggleBtn = document.getElementById('cart-toggle-btn');
                this.cartDropdown = document.getElementById('cart-dropdown');
                this.cartItemsContainer = document.getElementById('cart-items-container');
                this.cartEmptyMessage = document.getElementById('cart-empty-message');
                this.cartCountElement = document.getElementById('cart-count');
                this.cartTotalSection = document.getElementById('cart-total-section');
                this.cartTotalPriceElement = document.getElementById('cart-total-price');

                this.initEventListeners();
                this.fetchCart();
            }

            initEventListeners() {
                // Toggle cart dropdown
                this.cartToggleBtn.addEventListener('click', () => this.toggleCart());

                // Close cart when clicking outside, but not on cart-related elements
                document.addEventListener('click', (event) => {
                    const isClickInsideCart = this.cartDropdown.contains(event.target) || 
                                                this.cartToggleBtn.contains(event.target);
                    if (!isClickInsideCart) {
                        this.closeCart();
                    }
                });

                // Prevent dropdown from closing when interacting with cart items
                this.cartDropdown.addEventListener('click', (event) => {
                    event.stopPropagation();
                });
            }

            toggleCart() {
                this.cartDropdown.classList.toggle('hidden');
                this.fetchCart();
            }

            closeCart() {
                this.cartDropdown.classList.add('hidden');
            }

            fetchCart() {
                fetch('{{ route('cart.index') }}')
                    .then(response => response.json())
                    .then(data => {
                        this.cart = data;
                        this.renderCart();
                    })
                    .catch(error => {
                        console.error('Error fetching cart data:', error);
                    });
            }

            renderCart() {
                // Clear previous items
                this.cartItemsContainer.innerHTML = '';

                // Update cart count
                this.cartCountElement.textContent = this.cart.length;

                // Toggle empty message and total section
                if (this.cart.length === 0) {
                    this.cartEmptyMessage.classList.remove('hidden');
                    this.cartTotalSection.classList.add('hidden');
                } else {
                    this.cartEmptyMessage.classList.add('hidden');
                    this.cartTotalSection.classList.remove('hidden');
                }

                // Render cart items
                this.cart.forEach((item, index) => {
                    const cartItemElement = document.createElement('div');
                    cartItemElement.classList.add('flex', 'justify-between', 'items-center', 'border-b', 'py-3', 'dark:border-gray-700');
                    cartItemElement.innerHTML = `
                        <div class="flex items-center">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white">${item.product.name}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Rp${item.product.price}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button data-index="${index}" class="decrease-qty px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded-l">-</button>
                            <span class="px-4 py-1 bg-gray-100 dark:bg-gray-600">${item.quantity}</span>
                            <button data-index="${index}" class="increase-qty px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded-r">+</button>
                            <button data-index="${index}" class="remove-item ml-2 text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    this.cartItemsContainer.appendChild(cartItemElement);
                });

                // Update total price
                this.cartTotalPriceElement.textContent = this.calculateTotalPrice();

                // Add event listeners for dynamically created buttons
                this.addCartItemEventListeners();
            }

            addCartItemEventListeners() {
                // Prevent dropdown from closing on cart item interactions
                this.cartItemsContainer.querySelectorAll('button').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                    });
                });

                // Increase Quantity
                document.querySelectorAll('.increase-qty').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const index = e.currentTarget.dataset.index;
                        const cartItem = this.cart[index];
                        
                        fetch('{{ route('cart.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                id: cartItem.id,
                                quantity: cartItem.quantity + 1
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                cartItem.quantity++;
                                this.renderCart();
                            }
                        });
                    });
                });

                // Decrease Quantity
                document.querySelectorAll('.decrease-qty').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const index = e.currentTarget.dataset.index;
                        if (this.cart[index].quantity > 1) {
                            this.cart[index].quantity--;
                            this.updateCartOnServer(this.cart[index]);
                            this.renderCart();
                        }
                    });
                });

                // Remove Item
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const index = e.currentTarget.dataset.index;
                        const removedItem = this.cart[index];
                        this.cart.splice(index, 1);
                        this.removeItemFromServer(removedItem);
                        this.renderCart();
                    });
                });
            }

            updateCartOnServer(item) {
                fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(item)
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                });
            }

            removeItemFromServer(item) {
                fetch('{{ route('cart.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(item)
                })
                .catch(error => {
                    console.error('Error removing item from cart:', error);
                });
            }

            calculateTotalPrice() {
                return this.cart.reduce((total, item) => {
                    return total + (item.product.price * item.quantity);
                }, 0).toFixed(2);
            }
        }

        // Initialize cart manager
        new CartManager();
    });
</script>

</html>