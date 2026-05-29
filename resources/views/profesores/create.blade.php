{{-- CU4: Gestionar Profesores (Formulario de Registro) --}}
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Profesor</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0">
                    <h3 class="text-2xl font-extrabold mb-1">Registrar Nuevo Profesor</h3>
                    <p class="text-blue-200 text-sm font-medium">Añadir un docente al directorio institucional</p>
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>
            <div class="bg-white shadow-xl border border-gray-100 sm:rounded-xl p-8">
                <form method="POST" action="{{ route('profesores.store') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CI</label>
                            <input type="text" name="ci" value="{{ old('ci') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('ci') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título Profesional *</label>
                            <input type="text" name="titulo_profesional" value="{{ old('titulo_profesional') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Especialidad</label>
                            <select name="especialidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccione una especialidad</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->nombre }}" {{ old('especialidad') == $materia->nombre ? 'selected' : '' }}>
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
                                <input type="checkbox" name="maestria" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('maestria') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Tiene Maestría</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="diplomado_educacion_superior" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('diplomado_educacion_superior') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Diplomado en Edu. Superior</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <p class="text-sm text-gray-500 mb-4">La contraseña inicial será el CI del profesor.</p>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('profesores.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white rounded-md font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
