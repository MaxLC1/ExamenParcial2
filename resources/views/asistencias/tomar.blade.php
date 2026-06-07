<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registro de Asistencia - FICCT</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tarjeta de Cabecera -->
            <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">{{ $grupoMateria->materia->nombre }}</h3>
                        <p class="text-blue-200 text-lg font-medium mb-4">
                            Grupo: <span class="font-bold text-white text-xl">{{ $grupoMateria->grupo->nombre }}</span>
                        </p>
                        
                        <!-- Filtro de Fecha integrado en el banner -->
                        <form method="GET" action="{{ route('profesor.asistencias.tomar', $grupoMateria) }}" class="flex flex-wrap items-center gap-3 p-3 rounded-xl shadow-sm" style="display: inline-flex; background-color: rgba(255, 255, 255, 0.1); border: 1px solid rgba(96, 165, 250, 0.3);">
                            <label class="text-sm font-bold text-blue-100 flex items-center gap-2">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Fecha de clase:
                            </label>
                            <input type="text" id="fecha-asistencia" name="fecha" value="{{ $fecha }}" class="rounded-lg border-none shadow-inner focus:ring-2 focus:ring-red-500 text-gray-900 font-bold px-4 py-2 w-32 cursor-pointer bg-white" required>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2 rounded-lg shadow-md transition-colors border border-red-500">
                                ↻ Cargar Lista
                            </button>
                        </form>
                    </div>
                    <div class="hidden sm:block">
                        <img src="{{ asset('img/escudo.png') }}" alt="Escudo" style="width: 96px;" class="opacity-80 drop-shadow-lg">
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <div class="bg-white shadow-md sm:rounded-xl mb-6 border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200" style="background-color: #f8fafc;">
                    <h4 class="font-extrabold text-lg flex items-center gap-2" style="color: #0A3254;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Nómina de Postulantes
                    </h4>
                </div>
                
                <form method="POST" action="{{ route('profesor.asistencias.guardar', $grupoMateria) }}">
                    @csrf
                    <input type="hidden" name="fecha" value="{{ $fecha }}">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr style="background-color: #0A3254;">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Cédula (CI)</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nombre Completo</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Estado de Asistencia</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($postulantes as $index => $postulante)
                                    @php
                                        $estadoActual = isset($asistenciasPrevias[$postulante->id]) ? $asistenciasPrevias[$postulante->id]->estado : 'presente';
                                    @endphp
                                    <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $postulante->ci }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">{{ $postulante->nombre_completo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center gap-6">
                                                <label class="flex items-center cursor-pointer p-2 rounded-lg hover:bg-green-50 transition-colors relative">
                                                    <input type="radio" name="asistencias[{{ $postulante->id }}]" value="presente" class="peer w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300" {{ $estadoActual === 'presente' ? 'checked' : '' }}>
                                                    <div class="absolute inset-0 rounded-lg peer-checked:bg-green-50 -z-10 transition-colors"></div>
                                                    <span class="ml-2 font-bold text-gray-600 peer-checked:text-green-700 transition-colors">Presente</span>
                                                </label>
                                                <label class="flex items-center cursor-pointer p-2 rounded-lg hover:bg-red-50 transition-colors relative">
                                                    <input type="radio" name="asistencias[{{ $postulante->id }}]" value="ausente" class="peer w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300" {{ $estadoActual === 'ausente' ? 'checked' : '' }}>
                                                    <div class="absolute inset-0 rounded-lg peer-checked:bg-red-50 -z-10 transition-colors"></div>
                                                    <span class="ml-2 font-bold text-gray-600 peer-checked:text-red-700 transition-colors">Ausente</span>
                                                </label>
                                                <label class="flex items-center cursor-pointer p-2 rounded-lg hover:bg-yellow-50 transition-colors relative">
                                                    <input type="radio" name="asistencias[{{ $postulante->id }}]" value="licencia" class="peer w-5 h-5 text-yellow-500 focus:ring-yellow-500 border-gray-300" {{ $estadoActual === 'licencia' ? 'checked' : '' }}>
                                                    <div class="absolute inset-0 rounded-lg peer-checked:bg-yellow-50 -z-10 transition-colors"></div>
                                                    <span class="ml-2 font-bold text-gray-600 peer-checked:text-yellow-700 transition-colors">Licencia</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <svg style="width: 60px; height: 60px; margin: 0 auto; color: #9ca3af;" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Sin postulantes</h3>
                                            <p class="mt-1 text-sm text-gray-500">No hay postulantes inscritos en este grupo todavía.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a href="{{ route('profesor.asistencias.index') }}" class="font-semibold transition-colors flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Volver a Mis Grupos
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 text-white font-bold rounded-lg shadow-lg hover:-translate-y-0.5 transition-all" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            💾 Guardar Asistencias
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Integración de Flatpickr para forzar formato de fecha DD/MM/YYYY -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#fecha-asistencia", {
                locale: "es",
                dateFormat: "Y-m-d", // Formato interno (para backend)
                altInput: true,
                altFormat: "d/m/Y",  // Formato visual (para el usuario)
                disableMobile: "true" // Fuerza a usar este calendario y no el nativo del celular
            });
        });
    </script>
</x-app-layout>
