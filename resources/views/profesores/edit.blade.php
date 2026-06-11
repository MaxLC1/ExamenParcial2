<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profesores</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tarjeta de Título (Two-Box Layout) -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0 w-full">
                    <h3 class="text-2xl font-extrabold mb-1">Editar Profesor</h3>
                    <p class="text-blue-200 text-sm font-medium">Actualiza los datos y requisitos de {{ $profesor->nombre_completo }}</p>
                </div>
                <!-- Círculo decorativo de fondo -->
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <!-- Tarjeta del Formulario -->
            <div class="bg-white shadow-xl border border-gray-100 sm:rounded-xl p-8">
                <form method="POST" action="{{ route('profesores.update', $profesor) }}">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $profesor->nombre) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido', $profesor->apellido) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Título Profesional <span class="text-red-500">*</span></label>
                            <input type="text" name="titulo_profesional" value="{{ old('titulo_profesional', $profesor->titulo_profesional) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Especialidad</label>
                            <select name="especialidad" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]">
                                <option value="">Seleccione una especialidad</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->nombre }}" {{ old('especialidad', $profesor->especialidad) == $materia->nombre ? 'selected' : '' }}>
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-gray-800 mb-4">Requisitos de Contratación</h3>
                    
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-8">
                        <div class="flex flex-col sm:flex-row gap-8">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="maestria" value="1" class="w-5 h-5 rounded border-gray-300 shadow-sm focus:ring-[#0A3254]" style="color: #0A3254;" {{ old('maestria', $profesor->maestria) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">Tiene Maestría</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="diplomado_educacion_superior" value="1" class="w-5 h-5 rounded border-gray-300 shadow-sm focus:ring-[#0A3254]" style="color: #0A3254;" {{ old('diplomado_educacion_superior', $profesor->diplomado_educacion_superior) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">Diplomado en Edu. Superior</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $profesor->telefono) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0A3254] focus:ring-[#0A3254]">
                        </div>
                        <div class="flex items-end pb-2">
                            <label class="flex items-center cursor-pointer bg-white p-2 rounded border border-gray-200 shadow-sm">
                                <input type="hidden" name="activo" value="0">
                                <input type="checkbox" name="activo" value="1" {{ $profesor->activo ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 shadow-sm focus:ring-[#0A3254]" style="color: #0A3254;">
                                <span class="ml-3 text-sm font-bold text-gray-800">Estado Activo</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('profesores.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-white rounded-md font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            Actualizar Profesor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
