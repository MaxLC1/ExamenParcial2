<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Exámenes</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
            <div class="flex justify-between mb-4">
                <form method="GET" class="flex gap-2">
                    <select name="gestion_id" class="rounded-md border-gray-300 shadow-sm text-sm" onchange="this.form.submit()">
                        @foreach($gestiones as $g)<option value="{{ $g->id }}" {{ $gestionId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>@endforeach
                    </select>
                </form>
                <a href="{{ route('examenes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Programar Examen</a>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grupo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Materia</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pts Máx</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($examenes as $ex)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $ex->grupoMateria->grupo->nombre }}</td>
                            <td class="px-4 py-3 text-sm font-medium">{{ $ex->grupoMateria->materia->nombre }}</td>
                            <td class="px-4 py-3 text-sm">{{ ucfirst(str_replace('_',' ',$ex->tipo)) }}</td>
                            <td class="px-4 py-3 text-sm text-center">{{ $ex->puntaje_maximo }}</td>
                            <td class="px-4 py-3 text-sm">{{ $ex->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $ex->estado === 'finalizado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($ex->estado) }}</span></td>
                            <td class="px-4 py-3 text-sm"><a href="{{ route('profesor.calificar', $ex) }}" class="text-indigo-600 hover:underline">Calificar</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-4 text-center text-gray-500">No hay exámenes programados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $examenes->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
