<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Programar Examen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Encabezado del Formulario -->
            <div class="mb-6 relative overflow-hidden shadow-md" style="background: linear-gradient(135deg, #0A3254 0%, #114c81 100%); border-radius: 1rem;">
                <div style="padding: 1.5rem 2rem; position: relative; z-index: 10; display: flex; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: white;">
                        <a href="{{ route('examenes.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg bg-white/10 hover:bg-white/20 transition border border-white/20" title="Volver atrás">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Programar Examen</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Configure la fecha, hora y lugar de la evaluación académica.</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-lg sm:rounded-2xl overflow-hidden border-t-4" style="border-color: #D52B1E;">
                <form method="POST" action="{{ route('examenes.store') }}" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="col-span-1 md:col-span-2">
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Información del Curso
                            </h3>
                            
                            <label class="block text-sm font-bold text-gray-700 mb-2">Grupo y Materia <span class="text-red-500">*</span></label>
                            <select name="grupo_materia_id" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                                <option value="">-- Seleccione una materia asignada --</option>
                                @foreach($grupoMaterias as $gm)
                                    <option value="{{ $gm->id }}">Grupo {{ $gm->grupo->nombre }} - {{ $gm->materia->nombre }} (Gestión {{ $gm->grupo->gestion->nombre }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tipo de Evaluación <span class="text-red-500">*</span></label>
                            <select name="tipo" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                                <option value="examen_1">Primer Examen Parcial (100 pts)</option>
                                <option value="examen_2">Segundo Examen Parcial (100 pts)</option>
                                <option value="examen_3">Examen Final (100 pts)</option>
                            </select>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Programación
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Fecha <span class="text-red-500">*</span></label>
                            <input type="date" name="fecha" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Hora de Inicio <span class="text-red-500">*</span></label>
                            <input type="time" name="hora_inicio" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Hora de Finalización <span class="text-red-500">*</span></label>
                            <input type="time" name="hora_fin" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Logística
                        </h3>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Aula Asignada</label>
                        <input type="text" name="aula_examen" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" placeholder="Ej: Aula Magna 2, Módulo 236">
                        <p class="text-xs text-gray-500 mt-2">Puede dejarlo en blanco si se definirá posteriormente.</p>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('examenes.index') }}" class="font-bold px-6 py-3 rounded-lg text-gray-700 bg-white border-2 border-gray-200 hover:bg-gray-50 transition-all text-center">
                            Cancelar
                        </a>
                        <button type="submit" class="font-bold px-8 py-3 rounded-lg text-white shadow-md transition-all text-center" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            Guardar Programación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
