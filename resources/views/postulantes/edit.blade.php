<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Postulante: {{ $postulante->nombre_completo }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('postulantes.update', $postulante) }}">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CI (Solo lectura)</label>
                            <input type="text" value="{{ $postulante->ci }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $postulante->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido Paterno *</label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $postulante->apellido_paterno) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $postulante->apellido_materno) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $postulante->fecha_nacimiento ? $postulante->fecha_nacimiento->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sexo *</label>
                            <select name="sexo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="Masculino" {{ old('sexo', $postulante->sexo) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('sexo', $postulante->sexo) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $postulante->telefono) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ciudad *</label>
                            <input type="text" name="ciudad" value="{{ old('ciudad', $postulante->ciudad) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Colegio de Procedencia *</label>
                        <input type="text" name="colegio_procedencia" value="{{ old('colegio_procedencia', $postulante->colegio_procedencia) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion', $postulante->direccion) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="hidden" name="titulo_bachiller" value="0">
                            <input type="checkbox" name="titulo_bachiller" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('titulo_bachiller', $postulante->titulo_bachiller) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Posee Título de Bachiller</span>
                        </label>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Opciones de Carrera</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Primera Opción *</label>
                            <select name="primera_opcion_carrera_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccione...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ old('primera_opcion_carrera_id', $postulante->primera_opcion_carrera_id) == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Segunda Opción *</label>
                            <select name="segunda_opcion_carrera_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccione...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ old('segunda_opcion_carrera_id', $postulante->segunda_opcion_carrera_id) == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tercera Opción *</label>
                            <select name="tercera_opcion_carrera_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccione...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ old('tercera_opcion_carrera_id', $postulante->tercera_opcion_carrera_id) == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('postulantes.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
