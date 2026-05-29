<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Reporte por Carrera - {{ $gestion->nombre }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-2 mb-4">
                <form action="{{ route('reportes.asignar-carreras') }}" method="POST">
                    @csrf
                    <input type="hidden" name="gestion_id" value="{{ $gestionId }}">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700" onclick="return confirm('¿Está seguro de ejecutar la asignación de carreras? Esto distribuirá a los postulantes aprobados en las carreras según sus notas y cupos disponibles.')">
                        Ejecutar Asignación de Carreras
                    </button>
                </form>
                <a href="{{ route('reportes.por-carrera', ['gestion_id' => $gestionId, 'formato' => 'pdf']) }}" class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700 flex items-center">📄 Exportar PDF</a>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Carrera</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Asignados</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reporteData as $r)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $r['carrera'] }}</td>
                                <td class="px-6 py-4 text-center">{{ $r['codigo'] }}</td>
                                <td class="px-6 py-4 text-center text-lg font-bold text-indigo-600">{{ $r['asignados'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('reportes.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">← Volver a reportes</a>
        </div>
    </div>
</x-app-layout>
