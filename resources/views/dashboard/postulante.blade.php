{{-- CU2: Panel de Control (Dashboard Postulante) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mi Portal - Postulante</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if($postulante)
                <!-- Tarjeta de Perfil del Postulante -->
                <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                    <div class="relative z-10 flex justify-between items-center">
                        <div>
                            <h3 class="text-3xl font-extrabold mb-1">{{ $postulante->nombre_completo }}</h3>
                            <p class="text-blue-200 text-lg font-medium">
                                CI: {{ $postulante->ci }} | Estado: <span class="px-3 py-1 rounded-full text-sm font-bold bg-white" style="color: #0A3254;">{{ strtoupper(str_replace('_', ' ', $postulante->estado)) }}</span>
                            </p>
                        </div>
                        <img src="https://www.ficct.uagrm.edu.bo:3000/uploads/faculty/Escudo_FICCT.png" alt="Escudo" class="w-20 opacity-80 drop-shadow-md">
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
                </div>

                @if($postulante->estado === 'inscrito')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-yellow-800">⚠️ Pago Pendiente</h4>
                        <p class="text-yellow-700 mt-1">Debe realizar el pago de inscripción para continuar.</p>
                        <a href="{{ route('postulante.pago') }}" class="mt-3 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ir a Pagar</a>
                    </div>
                @endif

                @if($postulante->grupo)
                    <!-- Tarjeta de Grupo Asignado -->
                    <div class="bg-white shadow-md sm:rounded-xl p-6 mb-8 flex items-center justify-between" style="border-left: 6px solid #D52B1E;">
                        <div>
                            <h4 class="font-extrabold text-2xl mb-1" style="color: #0A3254;">Grupo Asignado: {{ $postulante->grupo->nombre }}</h4>
                            <p class="text-gray-600 font-medium text-lg">Aula Principal: <span class="font-bold text-gray-900">{{ $postulante->grupo->aula ?? 'Por definir' }}</span></p>
                        </div>
                        <div class="p-3 rounded-full" style="background-color: #fce8e8; color: #D52B1E;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    @if($grupoMaterias->count() > 0)
                        <div class="bg-white shadow-md sm:rounded-xl p-6 mb-8 border border-gray-100">
                            <h4 class="font-extrabold text-xl mb-6" style="color: #0A3254; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">Mis Materias y Exámenes</h4>
                            <div class="space-y-6">
                                @foreach($grupoMaterias as $materiaId => $gms)
                                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                        <div class="p-4" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                            <h5 class="font-black text-lg" style="color: #0A3254;">{{ $gms->first()->materia->nombre }}</h5>
                                        </div>
                                        @php $examenes = $gms->flatMap->examenes; @endphp
                                        @if($examenes->count() > 0)
                                            <div class="overflow-x-auto bg-white p-2">
                                                <table class="min-w-full text-sm text-left">
                                                    <thead class="text-xs uppercase text-white" style="background-color: #0A3254;">
                                                        <tr>
                                                            <th class="px-4 py-3 rounded-tl-lg font-bold">Tipo de Examen</th>
                                                            <th class="px-4 py-3 font-bold">Fecha y Hora</th>
                                                            <th class="px-4 py-3 font-bold">Lugar</th>
                                                            <th class="px-4 py-3 text-center rounded-tr-lg font-bold">Mi Nota</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($examenes as $examen)
                                                            @php $nota = $calificaciones->get($examen->id); @endphp
                                                            <tr class="bg-white border-b">
                                                                <td class="px-3 py-2 font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $examen->tipo) }}</td>
                                                                <td class="px-3 py-2">{{ $examen->fecha->format('d/m/Y') }} <span class="text-gray-500">({{ substr($examen->hora_inicio, 0, 5) }} - {{ substr($examen->hora_fin, 0, 5) }})</span></td>
                                                                <td class="px-3 py-2">{{ $examen->aula_examen ?? 'Aula virtual' }}</td>
                                                                <td class="px-3 py-2 text-center">
                                                                    @if($nota)
                                                                        <span class="font-bold {{ $nota->nota >= ($examen->puntaje_maximo * 0.51) ? 'text-green-600' : 'text-red-600' }}">
                                                                            {{ $nota->nota }} / {{ $examen->puntaje_maximo }}
                                                                        </span>
                                                                    @else
                                                                        <span class="text-gray-400 italic">Pendiente</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 mt-2 italic">Aún no hay exámenes programados para esta materia.</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                @if($postulante->asignacionCarrera)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h4 class="font-semibold text-green-800">🎉 Resultado Final</h4>
                        <p class="text-green-700">Carrera asignada: <strong>{{ $postulante->asignacionCarrera->carrera->nombre }}</strong></p>
                        <p class="text-green-700">Opción #{{ $postulante->asignacionCarrera->opcion_numero }}</p>
                        <p class="text-green-700">Promedio general: {{ $postulante->asignacionCarrera->nota_promedio_general }}</p>
                    </div>
                @endif
            @else
                <p class="text-gray-500">No se encontró su registro de postulante.</p>
            @endif
        </div>
    </div>
</x-app-layout>
