<nav x-data="{ open: false }" class="bg-gray-900 border-b border-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center min-w-0 flex-1">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="block h-8 w-auto sm:h-9" />
                </div>

                <!-- links das paginas -->
                <div class="hidden lg:flex lg:space-x-4 xl:space-x-8 lg:ml-6 xl:ml-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                        class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('sobre')" :active="request()->routeIs('sobre')"
                        class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                        {{ __('Sobre') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contato')" :active="request()->routeIs('contato')"
                        class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                        {{ __('Contato') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.servicos.index')" :active="request()->routeIs('admin.servicos.index')"
                        class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                        {{ __('Serviços') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.pacotes.index')" :active="request()->routeIs('admin.pacotes.index')"
                        class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                        {{ __('Planos') }}
                    </x-nav-link>
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.inventario.index')" :active="request()->routeIs('admin.inventario.index')"
                                class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                                {{ __('Estoque') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                                class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')"
                                class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                                {{ __('Usuários') }}
                            </x-nav-link>
                        @elseif (Auth::user()->role === 'user')
                            <x-nav-link :href="route('agendamento.index')" :active="request()->routeIs('agendamento.index')"
                                class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                                {{ __('Meus Agendamentos') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')"
                            class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                            {{ __('Login') }}
                        </x-nav-link>
                        @if (Route::has('register'))
                            <x-nav-link :href="route('register')" :active="request()->routeIs('register')"
                                class="text-white hover:text-gray-200 text-sm xl:text-base whitespace-nowrap">
                                {{ __('Cadastrar') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- dropdown -->
            @if (Route::has('login'))
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-900 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')" class="text-black hover:bg-gray-200">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- deslogar -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" class="text-black hover:bg-gray-200"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                @endauth
            @endif

            <!-- Hamburger Menu -->
            <div class="flex items-center lg:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- menu da versão mobile -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden bg-gray-900 border-t border-gray-600">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <!-- links básicos visíveis -->
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" :class="request()->routeIs('home')
                ? 'bg-white text-gray-700 hover:bg-gray-200'
                : 'text-white hover:bg-gray-700'"
                class="block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sobre')" :active="request()->routeIs('sobre')" :class="request()->routeIs('sobre')
                ? 'bg-white text-gray-700 hover:bg-gray-200'
                : 'text-white hover:bg-gray-700'"
                class="block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Sobre') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contato')" :active="request()->routeIs('contato')" :class="request()->routeIs('contato')
                ? 'bg-white text-gray-700 hover:bg-gray-200'
                : 'text-white hover:bg-gray-700'"
                class="block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Contato') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.servicos.index')" :active="request()->routeIs('admin.servicos.index')" :class="request()->routeIs('admin.servicos.index')
                ? 'bg-white text-gray-700 hover:bg-gray-200'
                : 'text-white hover:bg-gray-700'"
                class="block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Serviços') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pacotes.index')" :active="request()->routeIs('admin.pacotes.index')" :class="request()->routeIs('admin.pacotes.index')
                ? 'bg-white text-gray-700 hover:bg-gray-200'
                : 'text-white hover:bg-gray-700'"
                class="block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Planos') }}
            </x-responsive-nav-link>

            <!-- links específicos por tipo de usuário -->
            @auth
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.inventario.index')" :active="request()->routeIs('admin.inventario.index')" :class="request()->routeIs('admin.inventario')
                        ? 'bg-white text-gray-700 hover:bg-gray-200'
                        : 'text-white hover:bg-gray-700'"
                        class="block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Estoque') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" :class="request()->routeIs('admin.dashboard')
                        ? 'bg-white text-gray-700 hover:bg-gray-200'
                        : 'text-white hover:bg-gray-700'"
                        class="block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" :class="request()->routeIs('admin.users.index')
                        ? 'bg-white text-gray-700 hover:bg-gray-200'
                        : 'text-white hover:bg-gray-700'"
                        class="block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Usuários') }}
                    </x-responsive-nav-link>
                @elseif (Auth::user()->role === 'user')
                    <x-responsive-nav-link :href="route('agendamento.index')" :active="request()->routeIs('agendamento.index')" :class="request()->routeIs('agendamento.index')
                        ? 'bg-white text-gray-700 hover:bg-gray-200'
                        : 'text-white hover:bg-gray-700'"
                        class="block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Meus Agendamentos') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" :class="request()->routeIs('login')
                    ? 'bg-white text-gray-700 hover:bg-gray-200'
                    : 'text-white hover:bg-gray-700'"
                    class="block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" :class="request()->routeIs('register')
                        ? 'bg-white text-gray-700 hover:bg-gray-200'
                        : 'text-white hover:bg-gray-700'"
                        class="block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Cadastrar') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- perfil responsivo -->
        @if (Route::has('login'))
            @auth
                <div class="pt-4 pb-1 border-t border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-400 break-all">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1 px-2">
                        <x-responsive-nav-link :href="route('profile.edit')" :class="request()->routeIs('profile.edit')
                            ? 'bg-white text-gray-700 hover:bg-gray-200'
                            : 'text-white hover:bg-gray-700'"
                            class="block px-3 py-2 rounded-md text-base font-medium">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <!-- autenticação -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')" :class="request()->routeIs('logout')
                                ? 'bg-white text-gray-700 hover:bg-gray-200'
                                : 'text-white hover:bg-gray-700'"
                                class="block px-3 py-2 rounded-md text-base font-medium"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @else
            @endauth
        @endif
    </div>
</nav>
