{{-- CU3: Gestionar Gestiones Académicas (Formulario de Creación) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Gestión Académica</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0">
                    <h3 class="text-2xl font-extrabold mb-1">Crear Nueva Gestión</h3>
                    <p class="text-blue-200 text-sm font-medium">Configuración de un nuevo periodo académico</p>
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>
            <div class="bg-white shadow-xl border border-gray-100 sm:rounded-xl p-8">
                <form method="POST" action="{{ route('gestiones.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Gestión I-2026">
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-3 mt-6">Cupos por Carrera</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Informática</label>
                            <input type="number" name="cupo_informatica" value="{{ old('cupo_informatica', 200) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Sistemas</label>
                            <input type="number" name="cupo_sistemas" value="{{ old('cupo_sistemas', 150) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Redes y Teleco.</label>
                            <input type="number" name="cupo_redes" value="{{ old('cupo_redes', 100) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ing. Robótica</label>
                            <input type="number" name="cupo_robotica" value="{{ old('cupo_robotica', 50) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('gestiones.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white rounded-md font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
