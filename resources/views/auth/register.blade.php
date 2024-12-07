<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8">
        @csrf

        <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">Create Your Account</h2>

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border border-red-700 rounded-lg focus:ring-maroon-600 focus:border-maroon-600 py-3 px-4 text-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border border-red-700 rounded-lg focus:ring-maroon-600 focus:border-maroon-600 py-3 px-4 text-lg" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Phone Number -->
        <div class="mb-4">
            <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700 font-semibold" />
            <x-text-input id="phone" class="block mt-1 w-full border border-red-700 rounded-lg focus:ring-maroon-600 focus:border-maroon-600 py-3 px-4 text-lg" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border border-red-700 rounded-lg focus:ring-red-700 focus:border-red-700 py-3 px-4 text-lg" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border border-red-700 rounded-lg focus:ring-maroon-600 focus:border-maroon-600 py-3 px-4 text-lg" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-maroon-600 hover:text-maroon-800 font-semibold" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-maroon-600 hover:bg-maroon-700 text-white font-bold py-2 px-4 rounded-lg">
                {{ __('Register') }}
            </x-primary-button>
        </div>

    </form>

    <style>
        .text-maroon-600 {
            color: #b22222;
        }

        .bg-maroon-600 {
            background-color: #b22222;
        }

        .hover\:bg-maroon-700:hover {
            background-color: #9b1e1e;
        }
    </style>
</x-guest-layout>
