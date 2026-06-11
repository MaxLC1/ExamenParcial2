<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calificación de Exámenes - FICCT</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                        <div class="ml-3"><p class="text-sm font-medium text-green-800">{{ session('success') }}</p></div>
                    </div>
                </div>
            @endif

            <!-- Tarjeta de Cabecera (Información del Examen) -->
            <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">{{ ucfirst(str_replace('_',' ',$examen->tipo)) }}</h3>
                        <p class="text-blue-200 text-lg font-medium">
                            {{ $examen->grupoMateria->materia->nombre }} | Grupo: <span class="font-bold text-white">{{ $examen->grupoMateria->grupo->nombre }}</span>
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <div class="flex items-center gap-2 px-4 py-1.5 rounded-full border border-blue-400 border-opacity-30 shadow-sm" style="background-color: rgba(255, 255, 255, 0.1);">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-semibold text-blue-100">Fecha: {{ $examen->fecha->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-1.5 rounded-full border border-red-400 border-opacity-30 shadow-sm" style="background-color: rgba(213, 43, 30, 0.2);">
                                <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                <span class="text-sm font-semibold text-red-100">Puntaje Máximo: {{ $examen->puntaje_maximo }} pts</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <img src="{{ asset('img/escudo.png') }}" alt="Escudo" class="w-24 opacity-80 drop-shadow-lg">
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <form method="POST" action="{{ route('profesor.guardar-calificaciones', $examen) }}">
                @csrf
                <div class="bg-white shadow-md sm:rounded-xl mb-6 border border-gray-100 overflow-hidden" x-data="{ search: '' }">
                    <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4" style="background-color: #f8fafc;">
                        <h4 class="font-extrabold text-lg flex items-center gap-2" style="color: #0A3254;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Lista de Postulantes
                        </h4>
                        <div class="relative w-full sm:w-72">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg>
                            </div>
                            <input type="text" x-model="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white shadow-sm focus:ring-[#0A3254] focus:border-[#0A3254]" placeholder="Buscar por CI o Nombre...">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr style="background-color: #0A3254;">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Cédula (CI)</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nombre Completo</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Nota Alcanzada</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($postulantes as $index => $p)
                                    <tr class="hover:bg-blue-50 transition-colors {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}"
                                        x-show="search === '' || '{{ strtolower($p->ci) }}'.includes(search.toLowerCase()) || '{{ strtolower($p->nombre_completo) }}'.includes(search.toLowerCase())">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p->ci }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">{{ $p->nombre_completo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="number" name="notas[{{ $p->id }}]"
                                                value="{{ $calificaciones[$p->id]->nota ?? '' }}"
                                                min="0" max="{{ $examen->puntaje_maximo }}" step="0.01"
                                                class="w-28 rounded-lg border-gray-300 shadow-sm text-center font-bold text-lg focus:border-red-500 focus:ring-red-500" required>
                                            <span class="text-xs text-gray-500 block mt-1">/ {{ $examen->puntaje_maximo }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('examenes.index') }}" class="font-semibold transition-colors flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100" style="color: #0A3254;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Volver al Listado
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="font-semibold transition-colors flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100" style="color: #0A3254;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Volver al Dashboard
                        </a>
                    @endif
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 text-white font-bold rounded-lg shadow-lg hover:-translate-y-0.5 transition-all" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                        💾 Guardar Calificaciones
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
