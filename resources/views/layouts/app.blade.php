<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Barbearia') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/imask"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @if (session('success') || session('error') || session('info'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                    class="fixed bottom-5 right-5 z-50 max-w-xs w-full shadow-lg rounded-lg overflow-hidden">
                    <div
                        class="
            px-4 py-3 
            {{ session('success') ? 'bg-green-600' : (session('error') ? 'bg-red-600' : 'bg-blue-600') }} 
            text-white flex items-start space-x-2
        ">
                        <div class="flex-1">
                            <p class="text-sm font-medium">
                                {{ session('success') ?? (session('error') ?? session('info')) }}
                            </p>
                        </div>
                        <button @click="show = false"
                            class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>
