<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Gestión: {{ $gestion->nombre }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('gestiones.update', $gestion) }}">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $gestion->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(['planificacion','inscripcion','en_curso','finalizada'] as $e)
                                <option value="{{ $e }}" {{ $gestion->estado === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $gestion->fecha_inicio->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $gestion->fecha_fin->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-3 mt-6">Cupos por Carrera</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Informática</label>
                            <input type="number" name="cupo_informatica" value="{{ old('cupo_informatica', $gestion->cupo_informatica) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Sistemas</label>
                            <input type="number" name="cupo_sistemas" value="{{ old('cupo_sistemas', $gestion->cupo_sistemas) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Redes y Teleco.</label>
                            <input type="number" name="cupo_redes" value="{{ old('cupo_redes', $gestion->cupo_redes) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Robótica</label>
                            <input type="number" name="cupo_robotica" value="{{ old('cupo_robotica', $gestion->cupo_robotica) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('gestiones.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
