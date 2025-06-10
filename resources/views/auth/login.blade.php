@extends('layouts.app')

@section('content')
    <div class="min-h-[55.55rem] bg-gray-900 flex items-center justify-center p-4 overflow-hidden">
        <div class="w-full max-w-md mx-3">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6 p-4 bg-gray-800 text-green-500 rounded shadow" :status="session('status')" />

            <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto">
                </div>

                <div class="flex justify-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Acesse sua conta</h2>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <x-input-label for="email" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Email')" />
                        <x-text-input id="email"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <x-input-label for="password" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Password')" />

                        <x-text-input id="password"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="password" name="password" required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center mb-6">
                        <input id="remember_me" type="checkbox"
                            class="rounded bg-gray-700 border-gray-600 text-orange-500 focus:ring-orange-500"
                            name="remember">
                        <label for="remember_me" class="ms-2 text-sm text-gray-300">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-orange-500 hover:text-orange-400 focus:outline-none"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit"
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
