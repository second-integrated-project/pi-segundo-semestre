<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Amarillo Barber</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/css/navigation.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-900 text-white">
    <div id="aplicacao">
        <nav id="navbar" class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
            <div class="text-lg font-bold text-gray-800">
                <a href="{{ route('dashboard') }}">
                    <h1 id="logobar">Amarillo Barber</h1>
                </a>
            </div>
        
            <!-- Desktop Menu -->
            <ul class="hidden sm:flex gap-6 items-center text-sm font-medium text-gray-700">
                <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition {{ request()->routeIs('home') ? 'text-orange-500' : '' }}">Home</a></li>
                <li><a href="{{ route('sobre') }}" class="hover:text-orange-500 transition {{ request()->routeIs('sobre') ? 'text-orange-500' : '' }}">Sobre</a></li>
                <li><a href="{{ route('contato') }}" class="hover:text-orange-500 transition {{ request()->routeIs('contato') ? 'text-orange-500' : '' }}">Contato</a></li>
                <li><a href="{{ route('servicos') }}" class="hover:text-orange-500 transition {{ request()->routeIs('servicos') ? 'text-orange-500' : '' }}">Serviços</a></li>
        
                @guest
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}" class="hover:text-orange-500 transition">Entrar</a></li>
                    @endif
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="hover:text-orange-500 transition">Registrar</a></li>
                    @endif
                @else
                    <li><a href="{{ route('dashboard') }}" class="hover:text-orange-500 transition {{ request()->routeIs('dashboard') ? 'text-orange-500' : '' }}">Dashboard</a></li>
        
                    <li id="perfil" class="relative group">
                        <span class="cursor-pointer">{{ Auth::user()->name }} ▼</span>
                        <ul class="absolute hidden group-hover:block bg-white text-gray-800 rounded shadow-md mt-2 right-0 w-40">
                            <li><a class="block px-4 py-2 hover:bg-orange-100" href="{{ route('profile.edit') }}">Perfil</a></li>
                            <li>
                                <a class="block px-4 py-2 hover:bg-orange-100" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('formularioLogout').submit();">
                                    Sair
                                </a>
                                <form id="formularioLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        
            <!-- Mobile Hamburger -->
            <div class="sm:hidden">
                <button @click="open = !open" class="text-gray-700 focus:outline-none">
                    <!-- Ícone pode ser melhorado com Alpine.js -->
                    ☰
                </button>
            </div>
        </nav>
        
        <!-- Mobile Menu (Alpine.js necessário para funcionar corretamente) -->
        <div x-data="{ open: false }" :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden bg-white text-gray-800 px-6 py-4">
            <ul class="space-y-2 text-sm font-medium">
                <li><a href="{{ route('home') }}" class="block hover:text-orange-500">Home</a></li>
                <li><a href="{{ route('sobre') }}" class="block hover:text-orange-500">Sobre</a></li>
                <li><a href="{{ route('contato') }}" class="block hover:text-orange-500">Contato</a></li>
                <li><a href="{{ route('servicos') }}" class="block hover:text-orange-500">Serviços</a></li>
        
                @guest
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}" class="block hover:text-orange-500">Entrar</a></li>
                    @endif
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="block hover:text-orange-500">Registrar</a></li>
                    @endif
                @else
                    <li><a href="{{ route('dashboard') }}" class="block hover:text-orange-500">Dashboard</a></li>
                    @if(Auth::user()->role === 'admin')
                       <li><a href="{{ route('admin.inventario.index') }}" class="hover:text-orange-500 transition {{ request()->routeIs('admin.inventario.*') ? 'text-orange-500' : '' }}">Inventário</a></li>
                    @endif
                    <li><a href="{{ route('profile.edit') }}" class="block hover:text-orange-500">Perfil</a></li>
                    <li>
                        <a href="{{ route('logout') }}" class="block hover:text-orange-500"
                            onclick="event.preventDefault(); document.getElementById('mobileLogout').submit();">
                            Sair
                        </a>
                        <form id="mobileLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
        
        <main class="mt-6">
            @yield('content')
        </main>
    </div>
</body>

</html>