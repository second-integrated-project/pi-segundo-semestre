<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @stack('styles')
    @vite(['resources/css/componentes/nav.css', 'resources/js/app.js'])
</head>

<!-- as partes comentadas é por que eu estava fazendo o projeto com o auth ui do laravel, porem faremos nosso próprio auth -->

<body>
    <div id="aplicacao">
        <nav id="navbar">
            <ul>
                @guest
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}">Entrar</a></li>
                    @endif
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}">Registrar</a></li>
                    @endif
                @else
                    <li><a href="{{ route('home') }}" class="link">Home</a></li>
                    <li><a href="{{ route('home') }}" class="link">Teste</a></li>

                    <li id="perfil" class="dropdown">
                        <span class="link">{{ Auth::user()->name }} ▼</span>
                        <ul class="submenu">
                            <li>
                                <a class="link" href="{{ route('profile.edit') }}">Perfil</a>
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

        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>