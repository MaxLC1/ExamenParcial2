<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Reporte por Materia - {{ $gestion->nombre }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-2 mb-4">
                <a href="{{ route('reportes.por-materia', ['gestion_id' => $gestionId, 'formato' => 'pdf']) }}" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">📄 PDF</a>
                <a href="{{ route('reportes.por-materia', ['gestion_id' => $gestionId]) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">🌐 HTML</a>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Materia</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aprobados</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Reprobados</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">% Aprobación</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Promedio</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reporteData as $r)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $r['materia'] }}</td>
                                <td class="px-6 py-4 text-center">{{ $r['total'] }}</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">{{ $r['aprobados'] }}</td>
                                <td class="px-6 py-4 text-center text-red-600">{{ $r['reprobados'] }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 rounded text-sm {{ $r['porcentaje'] >= 50 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $r['porcentaje'] }}%</span>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $r['promedio'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('reportes.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">← Volver a reportes</a>
        </div>
    </div>
</x-app-layout>
