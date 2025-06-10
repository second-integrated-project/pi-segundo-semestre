@extends('layouts.app')

@section('content')
    <div class="min-h-[55.55rem] bg-gray-900 flex items-center justify-center p-4 overflow-hidden">
        <div class="w-full max-w-md mx-3">
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto">
                </div>

                <div class="flex justify-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Criar nova conta</h2>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-6">
                        <x-input-label for="name" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Name')" />
                        <x-text-input id="name"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-6">
                        <x-input-label for="email" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Email')" />
                        <x-text-input id="email"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <x-input-label for="password" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Password')" />
                        <x-text-input id="password"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <x-input-label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2"
                            :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation"
                            class="block w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-md text-white focus:ring-orange-500 focus:border-orange-500"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')"
                            class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a class="text-sm text-orange-500 hover:text-orange-400 focus:outline-none"
                            href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button type="submit"
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection