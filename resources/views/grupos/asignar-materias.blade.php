<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Asignar Materias - {{ $grupo->nombre }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
            @if($asignaciones->isNotEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="font-semibold mb-3">Asignaciones Actuales</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"><tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Materia</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Profesor</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Horario</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Modalidad</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr></thead>
                        <tbody>
                            @foreach($asignaciones as $a)
                            <tr>
                                <td class="px-4 py-2">{{ $a->materia->nombre }}</td>
                                <td class="px-4 py-2">{{ $a->profesor->nombre_completo }}</td>
                                <td class="px-4 py-2">{{ $a->horario?->descripcion ?? '-' }}</td>
                                <td class="px-4 py-2 capitalize">{{ $a->modalidad_clase }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('grupos.eliminar-asignacion', [$grupo->id, $a->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar asignación?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-3">Nueva Asignación</h3>
                <form method="POST" action="{{ route('grupos.guardar-asignacion', $grupo) }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Materia</label>
                            <select name="materia_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach($materias as $m)<option value="{{ $m->id }}">{{ $m->nombre }}</option>@endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Profesor</label>
                            <select name="profesor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach($profesores as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre_completo }} {{ $p->especialidad ? '('.$p->especialidad.')' : '' }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">El sistema validará que la especialidad coincida.</p>
                        </div>
                        <div class="col-span-2">
                            <h4 class="font-medium text-sm text-gray-700 mb-2">Programación Semanal</h4>
                            <div class="space-y-2">
                                @foreach($horariosAgrupados as $dia => $horariosDelDia)
                                    <div class="flex items-center gap-4 bg-gray-50 p-3 rounded border">
                                        <div class="w-32">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="dias[{{ $dia }}][activo]" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="ml-2 capitalize font-medium text-sm">{{ $dia }}</span>
                                            </label>
                                        </div>
                                        <div class="flex-1">
                                            <select name="dias[{{ $dia }}][horario_id]" class="block w-full rounded-md border-gray-300 shadow-sm text-sm py-1.5">
                                                @foreach($horariosDelDia as $h)
                                                    <option value="{{ $h->id }}">{{ substr($h->hora_inicio, 0, 5) }} - {{ substr($h->hora_fin, 0, 5) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex-1">
                                            <select name="dias[{{ $dia }}][modalidad]" class="block w-full rounded-md border-gray-300 shadow-sm text-sm py-1.5">
                                                <option value="presencial">Presencial</option>
                                                <option value="virtual">Virtual</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Asignar</button>
                </form>
            </div>
            <a href="{{ route('grupos.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">← Volver a grupos</a>
        </div>
    </div>
</x-app-layout>
