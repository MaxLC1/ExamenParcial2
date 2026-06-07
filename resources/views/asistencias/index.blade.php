<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Control de Asistencia - FICCT</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Cabecera -->
            <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-1">Módulo de Asistencias</h3>
                        <p class="text-blue-200 text-lg font-medium">
                            Profesor: {{ Auth::user()->name }}
                        </p>
                    </div>
                    <img src="{{ asset('img/escudo.png') }}" alt="Escudo" class="w-20 opacity-80 drop-shadow-md">
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <!-- Contenedor de Grupos -->
            <div class="bg-white shadow-md sm:rounded-xl p-6 mb-8 border border-gray-100">
                <h4 class="font-extrabold text-xl mb-6 flex items-center gap-2" style="color: #0A3254; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mis Grupos Asignados
                </h4>
                
                @if($gruposMateria->isEmpty())
                    <p class="text-gray-500 text-center py-8 font-medium">No tienes grupos asignados actualmente para tomar asistencia.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($gruposMateria as $gm)
                            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 bg-white">
                                <div class="p-4 flex justify-between items-center" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <h5 class="font-black text-lg" style="color: #0A3254;">{{ $gm->materia->nombre }}</h5>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full border" style="background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd;">
                                        {{ ucfirst($gm->modalidad_clase) }}
                                    </span>
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="p-2 rounded-lg bg-gray-100 text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <p class="text-gray-600 font-medium">Grupo: <span class="font-bold text-gray-900 text-lg">{{ $gm->grupo->nombre }}</span></p>
                                    </div>
                                    <a href="{{ route('profesor.asistencias.tomar', $gm) }}" class="block w-full py-2.5 text-white font-bold rounded-lg text-center transition-colors shadow-md" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                                        📝 Tomar Asistencia
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
