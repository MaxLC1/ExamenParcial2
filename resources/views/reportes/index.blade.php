<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($gestiones as $g)
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-4">{{ $g->nombre }}</h3>
                    <div class="space-y-2">
                        <a href="{{ route('reportes.por-materia', ['gestion_id' => $g->id]) }}" class="block text-indigo-600 hover:underline">📊 Reporte por Materia</a>
                        <a href="{{ route('reportes.por-profesor', ['gestion_id' => $g->id]) }}" class="block text-blue-600 hover:underline">👨‍🏫 Reporte por Profesor</a>
                        <a href="{{ route('reportes.por-carrera', ['gestion_id' => $g->id]) }}" class="block text-green-600 hover:underline">🎓 Reporte por Carrera</a>
                        @if(Auth::user()->isAdmin())
                            <form method="POST" action="{{ route('reportes.asignar-carreras') }}" class="mt-4">
                                @csrf <input type="hidden" name="gestion_id" value="{{ $g->id }}">
                                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-sm" onclick="return confirm('¿Ejecutar asignación de carreras?')">🚀 Asignar Carreras</button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
