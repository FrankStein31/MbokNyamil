<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-8">
        @csrf

        <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">Login to Your Account</h2>

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border border-red-700 rounded-lg focus:ring-red-700 focus:border-red-700 py-3 px-4 text-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mb-6" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    class="block mt-1 w-full border border-red-700 rounded-lg shadow-sm focus:ring-maroon-600 focus:border-maroon-600 py-3 px-4 text-lg"
                    name="password"
                    required
                    autocomplete="current-password" />

                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 focus:outline-none">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A9.004 9.004 0 0112 19c-2.49 0-4.798-.964-6.516-2.683A9.004 9.004 0 013 12c0-2.49.964-4.798 2.683-6.516A9.004 9.004 0 0112 3c2.49 0 4.798.964 6.516 2.683A9.004 9.004 0 0121 12a9.004 9.004 0 01-.825 3.875M15 12h.01M9 12h.01M12 15h.01M12 9h.01" />
                    </svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.902A10.002 10.002 0 0112 5c5.523 0 10 4.477 10 10a10.002 10.002 0 01-3.902 8.02M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-maroon-600 shadow-sm focus:ring-maroon-600" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <!-- @if (Route::has('password.request'))
            <a class="text-sm text-maroon-600 hover:text-maroon-800 font-semibold" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif -->

            <x-primary-button class="bg-maroon-600 hover:bg-maroon-700 text-white font-bold py-2 px-4 rounded-lg">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-maroon-600 hover:text-maroon-800 font-semibold">
                    {{ __('Sign up here') }}
                </a>
            </p>
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