{{-- CU2: Panel de Control (Dashboard Administrador) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Administración - FICCT
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Alertas --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif
            {{-- Tarjeta de Bienvenida --}}
            <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-1">Bienvenido, Administrador</h3>
                        <p class="text-blue-200 text-lg font-medium">Panel de Control Central de Admisiones FICCT</p>
                    </div>
                    <svg class="w-16 h-16 opacity-80 drop-shadow-md text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white shadow-lg hover:shadow-xl sm:rounded-lg p-6 border-l-4 transform hover:-translate-y-1 transition-all duration-300" style="border-left-color: #0A3254;">
                    <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Total Inscritos</div>
                    <div class="text-4xl font-black" style="color: #0A3254;">{{ $total_inscritos }}</div>
                </div>
                <div class="bg-white shadow-lg hover:shadow-xl sm:rounded-lg p-6 border-l-4 border-green-500 transform hover:-translate-y-1 transition-all duration-300">
                    <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Total Aprobados</div>
                    <div class="text-4xl font-black text-green-600">{{ $total_aprobados }}</div>
                </div>
                <div class="bg-white shadow-lg hover:shadow-xl sm:rounded-lg p-6 border-l-4 transform hover:-translate-y-1 transition-all duration-300" style="border-left-color: #D52B1E;">
                    <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Total Reprobados</div>
                    <div class="text-4xl font-black" style="color: #D52B1E;">{{ $total_reprobados }}</div>
                </div>
                <div class="bg-white shadow-lg hover:shadow-xl sm:rounded-lg p-6 border-l-4 transform hover:-translate-y-1 transition-all duration-300" style="border-left-color: #9333EA;">
                    <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Grupos Habilitados</div>
                    <div class="text-4xl font-black" style="color: #9333EA;">{{ $total_grupos }}</div>
                </div>
            </div>

            {{-- Gestión Actual --}}
            @if($gestion_actual)
                <div class="shadow-md sm:rounded-xl p-6 mb-8 flex justify-between items-center text-white" style="background-color: #0A3254; border-left: 6px solid #D52B1E;">
                    <div>
                        <h3 class="text-xl font-bold mb-1">Gestión Activa: {{ $gestion_actual->nombre }}</h3>
                        <p class="text-blue-200 text-sm font-medium">Estado: <span class="uppercase font-bold text-white bg-blue-900 px-2 py-1 rounded ml-1">{{ str_replace('_', ' ', $gestion_actual->estado) }}</span></p>
                        <p class="text-blue-200 text-sm mt-1">Periodo: {{ $gestion_actual->fecha_inicio->format('d/m/Y') }} - {{ $gestion_actual->fecha_fin->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex gap-4">
                        @if($gestion_anterior)
                            <a href="{{ route('dashboard', ['gestion_id' => $gestion_anterior->id]) }}" class="px-4 py-2 bg-white text-gray-800 font-bold rounded shadow hover:bg-gray-100 flex items-center gap-2 transition">
                                <span>← Anterior</span>
                            </a>
                        @else
                            <button disabled class="px-4 py-2 bg-blue-900 text-blue-300 font-bold rounded cursor-not-allowed flex items-center gap-2">
                                <span>← Anterior</span>
                            </button>
                        @endif

                        @if($gestion_siguiente)
                            <a href="{{ route('dashboard', ['gestion_id' => $gestion_siguiente->id]) }}" class="px-4 py-2 bg-white text-gray-800 font-bold rounded shadow hover:bg-gray-100 flex items-center gap-2 transition">
                                <span>Siguiente →</span>
                            </a>
                        @else
                            <button disabled class="px-4 py-2 bg-blue-900 text-blue-300 font-bold rounded cursor-not-allowed flex items-center gap-2">
                                <span>Siguiente →</span>
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ================================================================= --}}
            {{-- BOTONES DE ACCESO DIRECTO (Navegación principal del sistema)  --}}
            {{-- ================================================================= --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Botón para ir a crear y administrar los periodos académicos (Ej. Gestión I-2026) --}}
                <a href="{{ route('gestiones.index') }}" class="bg-white shadow sm:rounded-lg p-6 border-t-4 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center text-center" style="border-top-color: #0A3254;">
                    <svg class="w-8 h-8 mb-3" style="color: #0A3254;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <h3 class="font-bold text-lg" style="color: #0A3254;">Gestiones</h3>
                    <p class="text-gray-500 text-sm mt-1">Administrar gestiones académicas</p>
                </a>

                {{-- Botón para registrar o ver la lista de profesores de la facultad --}}
                <a href="{{ route('profesores.index') }}" class="bg-white shadow sm:rounded-lg p-6 border-t-4 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center text-center" style="border-top-color: #0A3254;">
                    <svg class="w-8 h-8 mb-3" style="color: #0A3254;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <h3 class="font-bold text-lg" style="color: #0A3254;">Profesores</h3>
                    <p class="text-gray-500 text-sm mt-1">Gestionar profesores docentes</p>
                </a>

                {{-- Botón para ver la lista de postulantes inscritos y asignarles grupos --}}
                <a href="{{ route('postulantes.index') }}" class="bg-white shadow sm:rounded-lg p-6 border-t-4 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center text-center" style="border-top-color: #0A3254;">
                    <svg class="w-8 h-8 mb-3" style="color: #0A3254;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    <h3 class="font-bold text-lg" style="color: #0A3254;">Postulantes</h3>
                    <p class="text-gray-500 text-sm mt-1">Ver postulantes inscritos</p>
                </a>

                @if(Auth::user()->isAdmin())
                    {{-- Botón exclusivo para que el administrador verifique qué postulantes ya pagaron su matrícula --}}
                    <a href="{{ route('pagos.historial') }}" class="bg-white shadow sm:rounded-lg p-6 border-t-4 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center text-center" style="border-top-color: #D52B1E;">
                        <svg class="w-8 h-8 mb-3" style="color: #D52B1E;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="font-bold text-lg" style="color: #D52B1E;">Pagos</h3>
                        <p class="text-gray-500 text-sm mt-1">Ver historial y control de pagos</p>
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="bg-white shadow sm:rounded-lg p-6 border-t-4 border-gray-800 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center text-center">
                        <svg class="w-8 h-8 mb-3 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h3 class="font-bold text-lg text-gray-800">Usuarios y Accesos</h3>
                        <p class="text-gray-500 text-sm mt-1">Gestión de roles y accesos al sistema</p>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
