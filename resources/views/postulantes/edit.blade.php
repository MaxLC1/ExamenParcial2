<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Postulantes</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tarjeta de Título (Two-Box Layout) -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0 w-full">
                    <h3 class="text-2xl font-extrabold mb-1">Editar Postulante</h3>
                    <p class="text-blue-200 text-sm font-medium">Actualizando información de {{ $postulante->nombre_completo }}</p>
                </div>
                <!-- Círculo decorativo de fondo -->
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <!-- Tarjeta del Formulario -->
            <div class="bg-white shadow-xl border border-gray-100 sm:rounded-xl p-8">
                <form method="POST" action="{{ route('postulantes.update', $postulante) }}">
                    @csrf @method('PUT')
                    
                    <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Datos Personales</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">CI (Solo lectura)</label>
                            <input type="text" value="{{ $postulante->ci }}" class="block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm cursor-not-allowed text-gray-500" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre', $postulante->nombre) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Apellido Paterno <span class="text-red-500">*</span></label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $postulante->apellido_paterno) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $postulante->apellido_materno) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Nacimiento <span class="text-red-500">*</span></label>
                            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $postulante->fecha_nacimiento ? $postulante->fecha_nacimiento->format('Y-m-d') : '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Sexo <span class="text-red-500">*</span></label>
                            <select name="sexo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                                <option value="Masculino" {{ old('sexo', $postulante->sexo) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('sexo', $postulante->sexo) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $postulante->telefono) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ciudad <span class="text-red-500">*</span></label>
                            <input type="text" name="ciudad" value="{{ old('ciudad', $postulante->ciudad) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-gray-800 mb-4 mt-8 border-b pb-2">Información Académica</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Colegio de Procedencia <span class="text-red-500">*</span></label>
                            <input type="text" name="colegio_procedencia" value="{{ old('colegio_procedencia', $postulante->colegio_procedencia) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion', $postulante->direccion) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="flex items-center cursor-pointer bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm w-max">
                            <input type="hidden" name="titulo_bachiller" value="0">
                            <input type="checkbox" name="titulo_bachiller" value="1" class="w-5 h-5 rounded border-gray-300 shadow-sm focus:ring-[#0A3254]" style="color: #0A3254;" {{ old('titulo_bachiller', $postulante->titulo_bachiller) ? 'checked' : '' }}>
                            <span class="ml-3 text-sm font-bold text-gray-800">Posee Título de Bachiller</span>
                        </label>
                    </div>

                    <h3 class="font-bold text-lg text-gray-800 mb-4 mt-8 border-b pb-2">Opciones de Carrera</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Primera Opción <span class="text-red-500">*</span></label>
                            <select name="primera_opcion_carrera_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                                <option value="">Seleccione...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ old('primera_opcion_carrera_id', $postulante->primera_opcion_carrera_id) == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Segunda Opción <span class="text-red-500">*</span></label>
                            <select name="segunda_opcion_carrera_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                                <option value="">Seleccione...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ old('segunda_opcion_carrera_id', $postulante->segunda_opcion_carrera_id) == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tercera Opción <span class="text-red-500">*</span></label>
                            <select name="tercera_opcion_carrera_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                                <option value="">Seleccione...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ old('tercera_opcion_carrera_id', $postulante->tercera_opcion_carrera_id) == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('postulantes.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">
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
