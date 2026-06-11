<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <!-- Encabezado de la tarjeta -->
                <div class="bg-indigo-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">Editar Gestión</h2>
                    <p class="text-indigo-100 mt-1">Actualiza los datos y cupos para {{ $gestion->nombre }}</p>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('gestiones.update', $gestion) }}">
                        @csrf @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre de la Gestión</label>
                                <input type="text" name="nombre" value="{{ old('nombre', $gestion->nombre) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                                <select name="estado" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(['planificacion','inscripcion','en_curso','finalizada'] as $e)
                                        <option value="{{ $e }}" {{ $gestion->estado === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $gestion->fecha_inicio->format('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Fin</label>
                                <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $gestion->fecha_fin->format('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <hr class="border-gray-200 mb-8">
                        
                        <h3 class="font-bold text-xl text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Cupos por Carrera
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Informática</label>
                                <input type="number" name="cupo_informatica" value="{{ old('cupo_informatica', $gestion->cupo_informatica) }}" min="0" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Sistemas</label>
                                <input type="number" name="cupo_sistemas" value="{{ old('cupo_sistemas', $gestion->cupo_sistemas) }}" min="0" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Redes y Teleco.</label>
                                <input type="number" name="cupo_redes" value="{{ old('cupo_redes', $gestion->cupo_redes) }}" min="0" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Robótica</label>
                                <input type="number" name="cupo_robotica" value="{{ old('cupo_robotica', $gestion->cupo_robotica) }}" min="0" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('gestiones.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium shadow-md shadow-indigo-200 transition-colors">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
