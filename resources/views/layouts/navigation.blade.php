<nav x-data="{ open: false }" class="bg-gray-900 border-b border-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="block h-9 w-auto" />                 
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-white hover:text-gray-200">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('sobre')" :active="request()->routeIs('sobre')" class="text-white hover:text-gray-200">
                        {{ __('Sobre') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contato')" :active="request()->routeIs('contato')" class="text-white hover:text-gray-200">
                        {{ __('Contato') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.servicos.index')" :active="request()->routeIs('admin.servicos.index')" class="text-white hover:text-gray-200">
                        {{ __('Serviços') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.pacotes.index')" :active="request()->routeIs('admin.pacotes.index')" class="text-white hover:text-gray-200">
                        {{ __('Planos') }}
                    </x-nav-link>
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.inventario.index')" :active="request()->routeIs('admin.inventario.index')" class="text-white hover:text-gray-200">
                                {{ __('Estoque') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-gray-200">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                             <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="text-white hover:text-gray-200">
                                {{ __('Usuários') }}
                            </x-nav-link>
                        @elseif (Auth::user()->role === 'user')
                            <x-nav-link :href="route('agendamento.index')" :active="request()->routeIs('agendamento.index')" class="text-white hover:text-gray-200">
                                {{ __('Meus Agendamentos') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="text-white hover:text-gray-200">
                            {{ __('Login') }}
                        </x-nav-link>
                        @if (Route::has('register'))
                            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-white hover:text-gray-200">
                                {{ __('Cadastrar') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            @if (Route::has('login'))
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-900 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-black hover:bg-gray-200">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @if (Route::has('login'))
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
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