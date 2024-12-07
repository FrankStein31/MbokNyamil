@extends('layouts.welcome')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
            {{-- Header Section --}}
            <div class="bg-gradient-to-r from-red-500 to-orange-600 text-white py-12 px-6 md:px-12 text-center">
                <h1 class="text-4xl font-extrabold mb-4">
                    Tentang <span class="text-white">{{ $profile->name }}</span>
                </h1>
                <p class="text-xl opacity-80">
                    Perjalanan kami dalam memberikan pelayanan terbaik
                </p>
            </div>

            {{-- Profile Details --}}
            <div class="grid md:grid-cols-2 gap-8 p-8 md:p-12">
                {{-- Left Column - Profile Info --}}
                <div>
                    <div class="space-y-6">
                        <div class="bg-gray-100 p-6 rounded-xl shadow-md">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Pribadi
                            </h2>
                            <div class="space-y-2">
                                <p class="flex items-center">
                                    <span class="font-semibold mr-2 text-gray-600 w-20">Nama</span>
                                    <span class="text-gray-800">{{ $profile->name }}</span>
                                </p>
                                <p class="flex items-center">
                                    <span class="font-semibold mr-2 text-gray-600 w-20">Email</span>
                                    <span class="text-gray-800">{{ $profile->email }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-xl shadow-md">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat
                            </h2>
                            <p class="text-gray-800">
                                {{ $profile->address }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Right Column - Komitmen --}}
                <div class="flex items-center justify-center">
                    <div class="bg-white p-8 rounded-xl shadow-md text-center">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Komitmen Kami
                        </h2>
                        <p class="text-gray-600 max-w-md mx-auto leading-relaxed">
                            Kami berkomitmen untuk memberikan pelayanan terbaik, 
                            kualitas produk unggul, dan kepuasan pelanggan sebagai 
                            prioritas utama dalam setiap interaksi dan transaksi.
                        </p>
                        <div class="mt-6 space-y-4">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-700">Kualitas Terjamin</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-700">Pelayanan Profesional</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M13 8a3 3 0 00-3 3v1h6v-1a3 3 0 00-3-3z"></path>
                                </svg>
                                <span class="text-gray-700">Harga Kompetitif</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection