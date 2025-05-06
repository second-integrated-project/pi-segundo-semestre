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
    @vite(['resources/css/app.css', 'resources/css/componentes/nav.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-900 text-white">
    <div id="aplicacao">
        <nav id="navbar" class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
            <div class="text-lg font-bold text-gray-800">
                <h1 id="logobar">Amarillo Barber</h1>
            </div>
            <ul class="flex gap-6 items-center text-sm font-medium text-gray-700">
                @guest
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}" class="hover:text-orange-500 transition">Entrar</a></li>
                    @endif
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="hover:text-orange-500 transition">Registrar</a></li>
                    @endif
                @else
                    <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition">Home</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition">Teste</a></li>

                    <li id="perfil" class="dropdown">
                        <span class="link">{{ Auth::user()->name }} ▼</span>
                        <ul class="submenu">
                            <li>
                                <a class="link" href="{{ route('profile.edit') }}">
                                    Perfil
                                </a>
                            </li>
                            <li>
                                <a class="link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('formularioLogout').submit();">
                                    Sair
                                </a>
                                <form id="formularioLogout" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </nav>

        <main class="mt-6">
            @yield('content')
        </main>
    </div>
</body>

</html>