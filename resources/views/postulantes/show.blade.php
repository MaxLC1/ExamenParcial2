<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle Postulante: {{ $postulante->nombre_completo }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="text-sm text-gray-500">CI:</span> <span class="font-semibold">{{ $postulante->ci }}</span></div>
                    <div><span class="text-sm text-gray-500">Estado:</span> <span class="font-semibold capitalize">{{ str_replace('_',' ',$postulante->estado) }}</span></div>
                    <div><span class="text-sm text-gray-500">Gestión:</span> {{ $postulante->gestion->nombre ?? '-' }}</div>
                    <div><span class="text-sm text-gray-500"></span> <strong>{{ $postulante->grupo->nombre ?? 'Sin asignar' }}</strong></div>
                    <div><span class="text-sm text-gray-500">Teléfono:</span> {{ $postulante->telefono ?? '-' }}</div>
                    <div><span class="text-sm text-gray-500">Nacimiento:</span> {{ $postulante->fecha_nacimiento->format('d/m/Y') }}</div>
                </div>
            </div>
            @if($resumenNotas->isNotEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4">Calificaciones</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Materia</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Parcial 1 (30)</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Parcial 2 (30)</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Final (40)</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resumenNotas as $nota)
                                <tr>
                                    <td class="px-4 py-2 font-medium">{{ $nota['materia'] }}</td>
                                    <td class="px-4 py-2 text-center">{{ $nota['parcial_1'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center">{{ $nota['parcial_2'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center">{{ $nota['final'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center font-bold">{{ $nota['total'] }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $nota['aprobado'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $nota['aprobado'] ? 'Aprobado' : 'Reprobado' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <a href="{{ route('postulantes.index') }}" class="text-indigo-600 hover:underline">← Volver a la lista</a>
        </div>
    </div>
</x-app-layout>
