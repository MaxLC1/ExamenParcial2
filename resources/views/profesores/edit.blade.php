<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Profesor: {{ $profesor->nombre_completo }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('profesores.update', $profesor) }}">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $profesor->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido', $profesor->apellido) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título Profesional *</label>
                            <input type="text" name="titulo_profesional" value="{{ old('titulo_profesional', $profesor->titulo_profesional) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Especialidad</label>
                            <select name="especialidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccione una especialidad</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->nombre }}" {{ old('especialidad', $profesor->especialidad) == $materia->nombre ? 'selected' : '' }}>
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Requisitos de Contratación</label>
                        <div class="flex gap-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="maestria" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('maestria', $profesor->maestria) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Tiene Maestría</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="diplomado_educacion_superior" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('diplomado_educacion_superior', $profesor->diplomado_educacion_superior) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Diplomado en Edu. Superior</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $profesor->telefono) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="hidden" name="activo" value="0">
                            <input type="checkbox" name="activo" value="1" {{ $profesor->activo ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Activo</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('profesores.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
