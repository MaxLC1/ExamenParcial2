<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis Grupos (Registro de Asistencia)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($gruposMateria->isEmpty())
                        <p class="text-gray-500 text-center py-4">No tienes grupos asignados actualmente.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($gruposMateria as $gm)
                                <div class="border rounded-lg p-5 hover:shadow-md transition-shadow bg-gray-50">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">{{ $gm->materia->nombre }}</h3>
                                            <p class="text-sm text-gray-600">Grupo: {{ $gm->grupo->nombre }}</p>
                                        </div>
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-medium">
                                            {{ ucfirst($gm->modalidad_clase) }}
                                        </span>
                                    </div>
                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('profesor.asistencias.tomar', $gm) }}" class="flex-1 bg-indigo-600 text-white text-center py-2 rounded-md hover:bg-indigo-700 transition">
                                            📝 Registrar Asistencia
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
