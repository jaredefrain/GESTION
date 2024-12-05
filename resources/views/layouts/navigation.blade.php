<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.create')" :active="request()->routeIs('admin.create')">
                            {{ __('Crear Entrenador/Arbitro') }}
                        </x-nav-link>
                        <x-nav-link :href="route('teams.index')" :active="request()->routeIs('teams.index')">
                            {{ __('Gestionar Equipos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.player.details.index', Auth::user())" :active="request()->routeIs('admin.player.details.index')">
                            {{ __('Detalles jugadores') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.tournaments.index')" :active="request()->routeIs('admin.tournaments.index')">
                            {{ __('Gestionar Torneos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.games.index')" :active="request()->routeIs('admin.games.index')">
                            {{ __('Planificar Partidos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('stadiums.index')" :active="request()->routeIs('stadiums.index')">
                            {{ __('Gestionar Estadios') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.sponsors.index')" :active="request()->routeIs('admin.sponsors.index')">
                            {{ __('Gestionar Patrocinadores') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.finances.index')" :active="request()->routeIs('admin.finances.index')">
                            {{ __('Gestionar Finanzas') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'referee')
                        <x-nav-link :href="route('referee.dashboard')" :active="request()->routeIs('referee.dashboard')">
                            {{ __('Dashboard Árbitro') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'player')
                        <x-nav-link :href="route('player.dashboard')" :active="request()->routeIs('player.dashboard')">
                            {{ __('Dashboard Jugador') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'coach')
                        <x-nav-link :href="route('coach.dashboard')" :active="request()->routeIs('coach.dashboard')">
                            {{ __('Dashboard Entrenador') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.create')" :active="request()->routeIs('admin.create')">
                    {{ __('Crear Entrenador/Arbitro') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('teams.index')" :active="request()->routeIs('teams.index')">
                    {{ __('Gestionar Equipos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.player.details.index', Auth::user())" :active="request()->routeIs('admin.player.details.index')">
                    {{ __('Detalles jugadores') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tournaments.index')" :active="request()->routeIs('admin.tournaments.index')">
                    {{ __('Gestionar Torneos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.games.index')" :active="request()->routeIs('admin.games.index')">
                    {{ __('Planificar Partidos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('stadiums.index')" :active="request()->routeIs('stadiums.index')">
                    {{ __('Gestionar Estadios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sponsors.index')" :active="request()->routeIs('admin.sponsors.index')">
                    {{ __('Gestionar Patrocinadores') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.finances.index')" :active="request()->routeIs('admin.finances.index')">
                    {{ __('Gestionar Finanzas') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'referee')
                <x-responsive-nav-link :href="route('referee.dashboard')" :active="request()->routeIs('referee.dashboard')">
                    {{ __('Dashboard Árbitro') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'player')
                <x-responsive-nav-link :href="route('player.dashboard')" :active="request()->routeIs('player.dashboard')">
                    {{ __('Dashboard Jugador') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'coach')
                <x-responsive-nav-link :href="route('coach.dashboard')" :active="request()->routeIs('coach.dashboard')">
                    {{ __('Dashboard Entrenador') }}
                </x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
    </div>
</nav>