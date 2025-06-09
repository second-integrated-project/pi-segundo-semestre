@extends('layouts.app')

@section('content')
    <div class="min-h-[55.55rem] bg-gray-900 flex items-center justify-center p-4 overflow-hidden">
        <div class="w-full max-w-md mx-3">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6 p-4 bg-gray-700 text-green-500 rounded text-sm"
                :status="session('status')" />

            <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
                </div>

                <div class="flex justify-center mb-6">
                    <h2 class="text-2xl font-bold text-white">{{ __('Reset Password') }}</h2>
                </div>

                <div class="mb-6 text-sm text-gray-400">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <x-input-label for="email" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Email')" />
                        <x-text-input id="email"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection