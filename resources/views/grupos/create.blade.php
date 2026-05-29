<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Grupo</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('grupos.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gestión</label>
                        <select name="gestion_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($gestiones as $g)<option value="{{ $g->id }}">{{ $g->nombre }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre del Grupo</label>
                        <input type="text" name="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="Ej: Grupo A">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Capacidad Máxima</label>
                        <input type="number" name="capacidad_maxima" value="65" min="1" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Aula</label>
                        <input type="text" name="aula" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ej: Aula 101">
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('grupos.index') }}" class="px-4 py-2 border border-gray-300 rounded-md">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
