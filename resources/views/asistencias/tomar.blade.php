<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tomar Asistencia: {{ $grupoMateria->materia->nombre }} (Grupo {{ $grupoMateria->grupo->nombre }})</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                <form method="GET" action="{{ route('profesor.asistencias.tomar', $grupoMateria) }}" class="mb-6 flex gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de la clase</label>
                        <input type="date" name="fecha" value="{{ $fecha }}" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Cargar Lista</button>
                </form>

                <hr class="mb-6">

                <form method="POST" action="{{ route('profesor.asistencias.guardar', $grupoMateria) }}">
                    @csrf
                    <input type="hidden" name="fecha" value="{{ $fecha }}">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Postulante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado de Asistencia</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($postulantes as $postulante)
                                    @php
                                        $estadoActual = isset($asistenciasPrevias[$postulante->id]) ? $asistenciasPrevias[$postulante->id]->estado : 'presente';
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $postulante->ci }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $postulante->nombre_completo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex gap-4">
                                                <label class="flex items-center text-green-700 cursor-pointer">
                                                    <input type="radio" name="asistencias[{{ $postulante->id }}]" value="presente" class="mr-2" {{ $estadoActual === 'presente' ? 'checked' : '' }}>
                                                    Presente
                                                </label>
                                                <label class="flex items-center text-red-700 cursor-pointer">
                                                    <input type="radio" name="asistencias[{{ $postulante->id }}]" value="ausente" class="mr-2" {{ $estadoActual === 'ausente' ? 'checked' : '' }}>
                                                    Ausente
                                                </label>
                                                <label class="flex items-center text-yellow-700 cursor-pointer">
                                                    <input type="radio" name="asistencias[{{ $postulante->id }}]" value="licencia" class="mr-2" {{ $estadoActual === 'licencia' ? 'checked' : '' }}>
                                                    Licencia
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay postulantes inscritos en este grupo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('profesor.asistencias.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Guardar Asistencias</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
