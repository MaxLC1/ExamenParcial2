<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestiones</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tarjeta de Título (Two-Box Layout) -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0 w-full">
                    <h3 class="text-2xl font-extrabold mb-1">Editar Gestión</h3>
                    <p class="text-blue-200 text-sm font-medium">Actualiza los datos y cupos para {{ $gestion->nombre }}</p>
                </div>
                <!-- Círculo decorativo de fondo -->
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <!-- Tarjeta del Formulario -->
            <div class="bg-white shadow-xl border border-gray-100 sm:rounded-xl p-8">
                <form method="POST" action="{{ route('gestiones.update', $gestion) }}">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre de la Gestión</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $gestion->nombre) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                            <select name="estado" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach(['planificacion','inscripcion','en_curso','finalizada'] as $e)
                                    <option value="{{ $e }}" {{ $gestion->estado === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $gestion->fecha_inicio->format('Y-m-d')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $gestion->fecha_fin->format('Y-m-d')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <h3 class="font-bold text-xl text-gray-800 mb-4 flex items-center gap-2">
                        Cupos por Carrera
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Informática</label>
                            <input type="number" name="cupo_informatica" value="{{ old('cupo_informatica', $gestion->cupo_informatica) }}" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Sistemas</label>
                            <input type="number" name="cupo_sistemas" value="{{ old('cupo_sistemas', $gestion->cupo_sistemas) }}" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Redes y Teleco.</label>
                            <input type="number" name="cupo_redes" value="{{ old('cupo_redes', $gestion->cupo_redes) }}" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ing. Robótica</label>
                            <input type="number" name="cupo_robotica" value="{{ old('cupo_robotica', $gestion->cupo_robotica) }}" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('gestiones.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-white rounded-md font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
