<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Crear Grupo</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Encabezado del Formulario -->
            <div class="mb-6 relative overflow-hidden shadow-md" style="background: linear-gradient(135deg, #0A3254 0%, #114c81 100%); border-radius: 1rem;">
                <div style="padding: 1.5rem 2rem; position: relative; z-index: 10; display: flex; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: white;">
                        <a href="{{ route('grupos.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg bg-white/10 hover:bg-white/20 transition border border-white/20" title="Volver atrás">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem; background-color: rgba(255,255,255,0.1); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                            <svg style="width: 2rem; height: 2rem; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Apertura de Grupo Académico</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Defina los detalles del nuevo grupo para el periodo académico vigente.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg sm:rounded-2xl overflow-hidden border-t-4" style="border-color: #D52B1E;">
                <form method="POST" action="{{ route('grupos.store') }}" class="p-8">
                    @csrf
                    
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Información General
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Gestión Académica <span class="text-red-500">*</span></label>
                            <select name="gestion_id" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                                @foreach($gestiones as $g)
                                    <option value="{{ $g->id }}">{{ $g->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del Grupo <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required placeholder="Ej: Grupo SA, Grupo SC">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Capacidad Máxima <span class="text-red-500">*</span></label>
                            <input type="number" name="capacidad_maxima" value="70" min="1" max="100" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" required>
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Aula Asignada</label>
                            <input type="text" name="aula" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50" placeholder="Ej: Módulo 236 - Aula 10">
                            <p class="text-xs text-gray-500 mt-2">Puede dejarlo en blanco si el aula se definirá posteriormente.</p>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('grupos.index') }}" class="font-bold px-6 py-3 rounded-lg text-gray-700 bg-white border-2 border-gray-200 hover:bg-gray-50 transition-all text-center">
                            Cancelar
                        </a>
                        <button type="submit" class="font-bold px-8 py-3 rounded-lg text-white shadow-md transition-all text-center flex items-center justify-center gap-2" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Registrar Grupo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
