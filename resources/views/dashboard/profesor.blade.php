{{-- CU2: Panel de Control (Dashboard Profesor) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel del Profesor</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($profesor)
                <!-- Tarjeta de Bienvenida -->
                <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-extrabold mb-1">Bienvenido, {{ $profesor->nombre_completo }}</h3>
                        <p class="text-blue-200 text-lg font-medium">Especialidad: {{ $profesor->especialidad ?? 'No especificada' }}</p>
                    </div>
                    <!-- Decoración de fondo -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
                </div>
                <h3 class="text-lg font-semibold mb-4">Mis Grupos Asignados</h3>
                @if($gruposAgrupados->isEmpty())
                    <p class="text-gray-500">No tiene grupos asignados actualmente.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($gruposAgrupados as $key => $gms)
                            @php 
                                $firstGm = $gms->first(); 
                                $examenesUnicos = $gms->flatMap->examenes->unique('id');
                            @endphp
                            <!-- Tarjeta de Grupo -->
                            <div class="bg-white shadow-md sm:rounded-xl p-6 transition transform hover:-translate-y-1 hover:shadow-xl" style="border-top: 4px solid #0A3254;">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="font-extrabold text-xl" style="color: #0A3254;">{{ $firstGm->materia->nombre }}</h4>
                                        <span class="inline-block mt-1 px-3 py-1 text-sm font-bold text-white rounded-full" style="background-color: #D52B1E;">
                                            Grupo {{ $firstGm->grupo->nombre }}
                                        </span>
                                    </div>
                                    <a href="{{ route('profesor.examenes.create', $firstGm) }}" class="text-xs text-white px-3 py-2 rounded-md font-bold shadow hover:opacity-90 transition" style="background-color: #0A3254;">+ Examen</a>
                                </div>
                                <div class="mb-4">
                                    <h5 class="text-xs uppercase font-bold text-gray-500 mb-1">Horarios Programados</h5>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        @foreach($gms as $gm)
                                            <li class="flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $gm->modalidad_clase === 'virtual' ? 'bg-blue-500' : 'bg-green-500' }}"></span>
                                                {{ $gm->horario?->descripcion ?? 'Sin horario' }} 
                                                <span class="text-xs text-gray-400">({{ ucfirst($gm->modalidad_clase) }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                @if($examenesUnicos->isNotEmpty())
                                    <div>
                                        <h5 class="text-xs uppercase font-extrabold mb-2 border-t pt-4" style="color: #D52B1E;">Exámenes Programados</h5>
                                        @foreach($examenesUnicos as $examen)
                                            <div class="mt-2 flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                <div class="text-sm">
                                                    <span class="font-bold" style="color: #0A3254;">{{ ucfirst(str_replace('_', ' ', $examen->tipo)) }}</span><br>
                                                    <span class="text-xs font-medium text-gray-500">{{ $examen->fecha->format('d/m/Y') }}</span>
                                                </div>
                                                <a href="{{ route('profesor.calificar', $examen) }}" class="text-sm px-4 py-1.5 rounded font-bold transition border" style="color: #D52B1E; border-color: #D52B1E; hover:bg-red-50;">Calificar</a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <p class="text-gray-500">No se encontró su perfil de profesor.</p>
            @endif
        </div>
    </div>
</x-app-layout>
