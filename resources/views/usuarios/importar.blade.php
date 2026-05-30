{{-- CU13: Gestionar Usuarios y Roles (Importación Masiva) --}}
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Importar Usuarios</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0">
                    <h3 class="text-2xl font-extrabold mb-1">Carga Masiva de Usuarios</h3>
                    <p class="text-blue-200 text-sm font-medium">Creación de cuentas para Autoridades, Coordinadores, etc.</p>
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
            
            <div class="bg-white shadow-xl border border-gray-100 sm:rounded-xl p-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                    <p class="text-blue-800 font-medium">Sube un archivo Excel (.xlsx) o CSV con las cuentas a generar. Encabezados requeridos:</p>
                </div>
                <ul class="list-disc pl-5 mb-6 text-sm text-gray-500">
                    <li>nombre</li>
                    <li>email</li>
                    <li>rol (admin, profesor, docente, autoridad, coordinador, otros)</li>
                    <li>ci (Opcional en general, pero Requerido si el rol es profesor)</li>
                    <li>password (opcional, si se omite será 'Password123')</li>
                </ul>

                <form method="POST" action="{{ route('usuarios.procesar-importacion') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Archivo Excel/CSV</label>
                        <input type="file" name="archivo_excel" accept=".xlsx, .xls, .csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition" required>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-8">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-bold transition">Volver al Inicio</a>
                        <button type="submit" class="px-5 py-2.5 text-white rounded-md font-bold shadow-lg transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Subir y Generar Cuentas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
