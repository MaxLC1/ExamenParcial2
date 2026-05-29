<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Reporte por Profesor - {{ $gestion->nombre }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-2 mb-4">
                <a href="{{ route('reportes.por-profesor', ['gestion_id' => $gestionId, 'formato' => 'pdf']) }}" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">📄 PDF</a>
            </div>
            @if(!empty($reporteData) && $reporteData[0]['porcentaje'] > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <p class="text-yellow-800 font-semibold">🏆 Mayor índice de aprobados: {{ $reporteData[0]['profesor'] }} ({{ $reporteData[0]['porcentaje'] }}%)</p>
                </div>
            @endif
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profesor</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Grupos</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Alumnos</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aprobados</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">% Aprobación</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reporteData as $i => $r)
                            <tr class="{{ $i === 0 ? 'bg-yellow-50' : '' }}">
                                <td class="px-6 py-4 text-sm">{{ $i + 1 }} {{ $i === 0 ? '🏆' : '' }}</td>
                                <td class="px-6 py-4 font-medium">{{ $r['profesor'] }}</td>
                                <td class="px-6 py-4 text-center">{{ $r['grupos'] }}</td>
                                <td class="px-6 py-4 text-center">{{ $r['total_alumnos'] }}</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">{{ $r['aprobados'] }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 rounded text-sm {{ $r['porcentaje'] >= 50 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $r['porcentaje'] }}%</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('reportes.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">← Volver a reportes</a>
        </div>
    </div>
</x-app-layout>
