<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Carga Masiva de Postulantes</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-gray-600">Sube un archivo Excel (.xlsx) o CSV con los datos de los postulantes. El archivo debe contener los siguientes encabezados (en la primera fila):</p>
                <ul class="list-disc pl-5 mb-6 text-sm text-gray-500">
                    <li>ci</li>
                    <li>nombre</li>
                    <li>apellido_paterno</li>
                    <li>apellido_materno (opcional)</li>
                    <li>email</li>
                    <li>fecha_nacimiento (DD-MM-YYYY o DD/MM/YYYY)</li>
                    <li>sexo (Masculino/Femenino)</li>
                    <li>telefono (opcional)</li>
                    <li>direccion (opcional)</li>
                    <li>colegio_procedencia</li>
                    <li>ciudad</li>
                    <li>opcion_1 (Código o nombre exacto de la carrera)</li>
                    <li>opcion_2 (Código o nombre exacto de la carrera)</li>
                    <li>opcion_3 (Código o nombre exacto de la carrera)</li>
                </ul>

                <form method="POST" action="{{ route('postulantes.procesar-importacion') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Archivo Excel/CSV</label>
                        <input type="file" name="archivo_excel" accept=".xlsx, .xls, .csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:text-white hover:file:bg-[#072440]" style="--tw-file-bg: #0A3254;" onchange="this.style.setProperty('--tw-file-bg', '#0A3254');" required>
                        <style>
                            input[type=file]::file-selector-button { background-color: #0A3254; color: white; cursor: pointer; transition: background-color 0.2s; }
                            input[type=file]::file-selector-button:hover { background-color: #072440; }
                        </style>
                        @error('archivo_excel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('postulantes.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white rounded-md font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Subir e Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
