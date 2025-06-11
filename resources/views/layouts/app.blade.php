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

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/imask"></script>
</head>

<body class="font-sans antialiased  flex flex-col bg-gray-900">
    <div class="flex-grow">
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

    <!-- Rodapé -->
    <footer class="bottom-0 border-t border-gray-700 bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between gap-8">

                <!-- Sobre o Projeto -->
                <div class="md:w-1/3">
                    <h3 class="text-white text-lg font-semibold mb-2">Projeto Integrativo (PI) - 2º Semestre</h3>
                    <p class="text-sm leading-relaxed">
                        API construída com <strong>Laravel + Breeze</strong> e <strong>SQLite</strong> como banco de
                        dados.<br>
                        Projeto do 2º semestre do curso, desenvolvido durante o 1º semestre do ano de 2025 para o PIC -
                        FATEC Indaiatuba.
                    </p>
                </div>

                <!-- Time de Desenvolvedores -->
                <div class="md:w-1/3">
                    <h3 class="text-white text-lg font-semibold mb-4">Equipe de Desenvolvimento</h3>
                    <ul class="space-y-3">
                        @php
                            $devs = [
                                ['name' => 'Luis Bernardo Pessanha Batista', 'url' => 'https://github.com/lbpb293'],
                                ['name' => 'Luiz Gustavo Trindade Neves', 'url' => 'https://github.com/luizinbrzado'],
                                ['name' => 'Murilo Poltronieri', 'url' => 'https://github.com/murilopbc'],
                                [
                                    'name' => 'Pedro Henrique Tamotsu Tozaki',
                                    'url' => 'https://github.com/tamotsutozaki',
                                ],
                                ['name' => 'Rafael Tadeu Praça', 'url' => 'https://github.com/RafaTPz'],
                                ['name' => 'Weslley de Andrade Rosário', 'url' => 'https://github.com/w-rosario'],
                            ];
                        @endphp

                        @foreach ($devs as $dev)
                            <li>
                                <a href="{{ $dev['url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center text-sm text-gray-300 hover:text-orange-400 transition-colors">
                                    <svg class="w-5 h-5 mr-2 fill-current" viewBox="0 0 24 24" aria-hidden="true"
                                        focusable="false" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303
          3.438 9.8 8.205 11.385.6.113.82-.258.82-.577
          0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61
          -.546-1.387-1.333-1.757-1.333-1.757-1.09-.744.084-.729.084-.729
          1.205.084 1.84 1.236 1.84 1.236 1.07 1.835 2.807 1.305 3.492.997
          .108-.776.418-1.305.76-1.605-2.665-.3-5.466-1.335-5.466-5.93
          0-1.31.468-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322
          3.3 1.23a11.5 11.5 0 013.003-.403c1.02.005 2.045.138 3.003.403
          2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176
          .765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92
          .435.375.81 1.102.81 2.222 0 1.606-.015 2.896-.015 3.286 0
          .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
                                    </svg>
                                    {{ $dev['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Informações & Contato -->
                <div class="md:w-1/3">
                    <h3 class="text-white text-lg font-semibold mb-2">Informações</h3>
                    <ul class="text-sm space-y-1">
                        <li><strong>Banco de Dados:</strong> SQLite</li>
                        <li><strong>Autenticação:</strong> Laravel Breeze com papéis USER e ADMIN</li>
                        <li><strong>Uso recomendado:</strong> Composer, PHP, Node.js e npm instalados</li>
                        <li>
                            <a href="https://github.com/second-integrated-project/pi-segundo-semestre" target="_blank"
                                class="text-orange-400 hover:underline">Repositório no GitHub</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-700 pt-4 text-center text-xs text-gray-500 select-none">
                &copy; {{ date('Y') }} {{ config('app.name', 'Barbearia') }}. Código aberto para fins acadêmicos e
                colaboração - PIC FATEC.
            </div>
        </div>
    </footer>
</body>

</html>
