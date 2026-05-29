<nav x-data="{ open: false }" class="shadow-md border-b" style="background-color: #0A3254; border-color: #051c2e;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center" style="gap: 12px;">
                        <img src="https://www.ficct.uagrm.edu.bo:3000/uploads/faculty/Escudo_FICCT.png" alt="Escudo FICCT" style="height: 40px; width: auto;">
                        <div class="flex items-center">
                            <span class="text-2xl font-black tracking-wide" style="color: white;">FICCT</span>
                            <span style="color: rgba(255,255,255,0.4); margin: 0 10px; font-size: 1.5rem; font-weight: 300;">|</span>
                            <span class="text-lg font-medium tracking-wide" style="color: #cbd5e1;">UAGRM</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(Auth::user()->isAdmin() || in_array(Auth::user()->role, ['autoridad', 'coordinador']))
                        <x-nav-link :href="route('gestiones.index')" :active="request()->routeIs('gestiones.*')">Gestiones</x-nav-link>
                        <x-nav-link :href="route('profesores.index')" :active="request()->routeIs('profesores.*')">Profesores</x-nav-link>
                        <x-nav-link :href="route('postulantes.index')" :active="request()->routeIs('postulantes.*')">Postulantes</x-nav-link>
                        {{-- OCULTOS PARA FASE 2
                        <x-nav-link :href="route('grupos.index')" :active="request()->routeIs('grupos.*')">Grupos</x-nav-link>
                        <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">Reportes</x-nav-link>
                        --}}
                    @endif

                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">Usuarios</x-nav-link>
                        {{-- OCULTO PARA FASE 2
                        <x-nav-link :href="route('examenes.index')" :active="request()->routeIs('examenes.*')">Exámenes</x-nav-link>
                        --}}
                        <x-nav-link :href="route('pagos.historial')" :active="request()->routeIs('pagos.*')">Pagos</x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'profesor')
                        {{-- OCULTO PARA FASE 2
                        <x-nav-link :href="route('profesor.asistencias.index')" :active="request()->routeIs('profesor.asistencias.*')">Mis Asistencias</x-nav-link>
                        --}}
                    @endif

                    @if(Auth::user()->isPostulante())
                        <x-nav-link :href="route('postulante.pago')" :active="request()->routeIs('postulante.pago')">Mi Pago</x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md focus:outline-none transition ease-in-out duration-150" style="background-color: #072440; color: white;">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition duration-150 ease-in-out" style="background-color: transparent; color: white;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='transparent'">
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->isAdmin() || in_array(Auth::user()->role, ['autoridad', 'coordinador']))
                <x-responsive-nav-link :href="route('gestiones.index')" :active="request()->routeIs('gestiones.*')">Gestiones</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profesores.index')" :active="request()->routeIs('profesores.*')">Profesores</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('postulantes.index')" :active="request()->routeIs('postulantes.*')">Postulantes</x-responsive-nav-link>
                {{-- OCULTOS PARA FASE 2
                <x-responsive-nav-link :href="route('grupos.index')" :active="request()->routeIs('grupos.*')">Grupos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">Reportes</x-responsive-nav-link>
                --}}
            @endif

            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">Usuarios</x-responsive-nav-link>
                {{-- OCULTO PARA FASE 2
                <x-responsive-nav-link :href="route('examenes.index')" :active="request()->routeIs('examenes.*')">Exámenes</x-responsive-nav-link>
                --}}
                <x-responsive-nav-link :href="route('pagos.historial')" :active="request()->routeIs('pagos.*')">Pagos</x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'profesor')
                {{-- OCULTO PARA FASE 2
                <x-responsive-nav-link :href="route('profesor.asistencias.index')" :active="request()->routeIs('profesor.asistencias.*')">Mis Asistencias</x-responsive-nav-link>
                --}}
            @endif

            @if(Auth::user()->isPostulante())
                <x-responsive-nav-link :href="route('postulante.pago')" :active="request()->routeIs('postulante.pago')">Mi Pago</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t" style="border-color: #072440;">
            <div class="px-4">
                <div class="font-bold text-base" style="color: white;">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm" style="color: #d1d5db;">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
