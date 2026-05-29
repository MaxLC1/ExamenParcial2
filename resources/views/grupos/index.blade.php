<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Grupos</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
            <div class="flex justify-between items-end mb-4">
                <form method="GET" class="flex gap-2">
                    <select name="gestion_id" class="rounded-md border-gray-300 shadow-sm text-sm" onchange="this.form.submit()">
                        @foreach($gestiones as $g)<option value="{{ $g->id }}" {{ $gestionId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>@endforeach
                    </select>
                </form>
                @if(Auth::user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('grupos.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Crear Grupo</a>
                        <form method="POST" action="{{ route('grupos.asignar-postulantes') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="gestion_id" value="{{ $gestionId }}">
                            <input type="number" name="capacidad" value="65" min="30" max="100" class="w-20 rounded-md border-gray-300 text-sm">
                            <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-md hover:bg-green-700 text-sm">Asignar Postulantes</button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($grupos as $grupo)
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg text-indigo-600">{{ $grupo->nombre }}</h3>
                                <p class="text-sm text-gray-500">Aula: {{ $grupo->aula ?? 'Sin asignar' }}</p>
                                <p class="text-sm text-gray-500">Postulantes: {{ $grupo->postulantes->count() }} / {{ $grupo->capacidad_maxima }}</p>
                            </div>
                            @if(Auth::user()->isAdmin())
                                <div class="flex gap-2">
                                    <a href="{{ route('grupos.edit', $grupo) }}" class="text-gray-400 hover:text-indigo-600">✏️</a>
                                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este grupo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600">🗑️</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ min(100, ($grupo->postulantes->count() / $grupo->capacidad_maxima) * 100) }}%"></div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('postulantes.index', ['grupo_id' => $grupo->id]) }}" class="text-sm bg-gray-100 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-200 transition font-medium">👥 Ver Postulantes</a>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('grupos.asignar-materias', $grupo) }}" class="text-sm text-indigo-600 hover:underline">Asignar Materias →</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3">No hay grupos creados.</p>
                @endforelse
            </div>
            <div class="mt-4">{{ $grupos->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
