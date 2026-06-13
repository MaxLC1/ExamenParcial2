<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Programar Examen - {{ $grupoMateria->materia->nombre }} (Grupo {{ $grupoMateria->grupo->nombre }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('profesor.examenes.store', $grupoMateria) }}">
                    @csrf
                    
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border">
                        <p class="text-sm text-gray-600 mb-1"><strong>Materia:</strong> {{ $grupoMateria->materia->nombre }}</p>
                        <p class="text-sm text-gray-600 mb-1"><strong>{{ $grupoMateria->grupo->nombre }}</strong></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tipo de Examen</label>
                        <select name="tipo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="examen_1">Examen 1 (100 pts)</option>
                            <option value="examen_2">Examen 2 (100 pts)</option>
                            <option value="examen_3">Examen 3 (100 pts)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <input type="date" name="fecha" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hora Inicio</label>
                            <input type="time" name="hora_inicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hora Fin</label>
                            <input type="time" name="hora_fin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Aula del Examen</label>
                        <input type="text" name="aula_examen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ej: Aula Virtual / Lab 1">
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Programar Examen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
