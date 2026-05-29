<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Grupo: {{ $grupo->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('grupos.update', $grupo) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="gestion_id" class="block text-sm font-medium text-gray-700">Gestión</label>
                        <select name="gestion_id" id="gestion_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->id }}" {{ $grupo->gestion_id == $gestion->id ? 'selected' : '' }}>
                                    {{ $gestion->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('gestion_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Grupo</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $grupo->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="capacidad_maxima" class="block text-sm font-medium text-gray-700">Capacidad Máxima</label>
                            <input type="number" name="capacidad_maxima" id="capacidad_maxima" value="{{ old('capacidad_maxima', $grupo->capacidad_maxima) }}" min="1" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('capacidad_maxima') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="aula" class="block text-sm font-medium text-gray-700">Aula (Opcional)</label>
                            <input type="text" name="aula" id="aula" value="{{ old('aula', $grupo->aula) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('aula') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('grupos.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
