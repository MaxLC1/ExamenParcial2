<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Calificar Examen: {{ ucfirst(str_replace('_',' ',$examen->tipo)) }} - {{ $examen->grupoMateria->materia->nombre }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-4">
                <p><strong>Materia:</strong> {{ $examen->grupoMateria->materia->nombre }}</p>
                <p><strong>Grupo:</strong> {{ $examen->grupoMateria->grupo->nombre }}</p>
                <p><strong>Tipo:</strong> {{ ucfirst(str_replace('_',' ',$examen->tipo)) }} | <strong>Puntaje máximo:</strong> {{ $examen->puntaje_maximo }} pts</p>
                <p><strong>Fecha:</strong> {{ $examen->fecha->format('d/m/Y') }}</p>
            </div>
            <form method="POST" action="{{ route('profesor.guardar-calificaciones', $examen) }}">
                @csrf
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nota (0-{{ $examen->puntaje_maximo }})</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($postulantes as $p)
                                <tr>
                                    <td class="px-6 py-3 text-sm">{{ $p->ci }}</td>
                                    <td class="px-6 py-3 font-medium">{{ $p->nombre_completo }}</td>
                                    <td class="px-6 py-3 text-center">
                                        <input type="number" name="notas[{{ $p->id }}]"
                                            value="{{ $calificaciones[$p->id]->nota ?? '' }}"
                                            min="0" max="{{ $examen->puntaje_maximo }}" step="0.01"
                                            class="w-24 rounded-md border-gray-300 shadow-sm text-center focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center mt-4">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('examenes.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1">
                            <span>←</span> Volver atrás
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1">
                            <span>←</span> Volver atrás
                        </a>
                    @endif
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Guardar Calificaciones</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
