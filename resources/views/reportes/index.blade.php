<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Centro de Reportes Académicos - FICCT</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                        <div class="ml-3"><p class="text-sm font-medium text-green-800">{{ session('success') }}</p></div>
                    </div>
                </div>
            @endif

            <!-- Tarjeta de Cabecera -->
            <div class="shadow-lg sm:rounded-xl p-8 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                <div class="relative z-10" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="background-color: rgba(255, 255, 255, 0.1); border: 1px solid rgba(96, 165, 250, 0.3); padding: 1rem; border-radius: 1rem;">
                            <svg style="width: 36px; height: 36px; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-3xl font-extrabold mb-1">Módulo de Reportes</h3>
                            <p class="text-sm font-medium" style="color: #bfdbfe;">Análisis de rendimiento, estadísticas de docentes y distribución de carreras.</p>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <img src="{{ asset('img/escudo.png') }}" alt="Escudo" style="width: 96px;" class="opacity-80 drop-shadow-lg">
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            <!-- Botón hacia Reporte Personalizado -->
            <div class="mb-8 flex justify-end">
                <a href="{{ route('reportes.personalizado') }}" class="font-bold px-6 py-3 rounded-lg shadow-md transition-all flex items-center gap-2 text-white" style="background-color: #0A3254;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='#0A3254'">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Constructor de Reportes (Ad-Hoc)
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($gestiones as $g)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 flex flex-col">
                        <div class="p-5" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #0A3254;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="font-black text-xl" style="color: #0A3254;">{{ $g->nombre }}</h3>
                        </div>
                        
                        <div class="p-6 flex-1 flex flex-col gap-3">
                            <a href="{{ route('reportes.por-materia', ['gestion_id' => $g->id]) }}" class="group" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; background-color: #f0f9ff; color: #0369a1; text-decoration: none; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e0f2fe'" onmouseout="this.style.backgroundColor='#f0f9ff'">
                                <div style="padding: 0.5rem; background-color: white; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">📊</div>
                                <span>Reporte por Materia</span>
                                <svg style="width: 16px; height: 16px; margin-left: auto; transition: transform 0.2s;" class="transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            
                            <a href="{{ route('reportes.por-profesor', ['gestion_id' => $g->id]) }}" class="group" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; background-color: #fef2f2; color: #b91c1c; text-decoration: none; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='#fef2f2'">
                                <div style="padding: 0.5rem; background-color: white; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">👨‍🏫</div>
                                <span>Reporte por Profesor</span>
                                <svg style="width: 16px; height: 16px; margin-left: auto; transition: transform 0.2s;" class="transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            
                            <a href="{{ route('reportes.por-carrera', ['gestion_id' => $g->id]) }}" class="group" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 0.5rem; background-color: #f0fdf4; color: #15803d; text-decoration: none; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#dcfce3'" onmouseout="this.style.backgroundColor='#f0fdf4'">
                                <div style="padding: 0.5rem; background-color: white; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">🎓</div>
                                <span>Reporte por Carrera</span>
                                <svg style="width: 16px; height: 16px; margin-left: auto; transition: transform 0.2s;" class="transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                        
                        @if(Auth::user()->isAdmin())
                            <div class="p-6 pt-0 mt-auto">
                                <form method="POST" action="{{ route('reportes.asignar-carreras') }}">
                                    @csrf 
                                    <input type="hidden" name="gestion_id" value="{{ $g->id }}">
                                    <button type="submit" class="w-full text-white font-bold px-4 py-3 rounded-lg shadow-md transition-all flex justify-center items-center gap-2" style="background-color: #0A3254; cursor: pointer; border: none;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='#0A3254'" onclick="return confirm('¿Está seguro de ejecutar el algoritmo de asignación de carreras para esta gestión?')">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        Ejecutar Asignación de Carreras
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white shadow-sm rounded-xl p-12 text-center border border-gray-200">
                        <svg style="width: 64px; height: 64px; margin: 0 auto; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="mt-4 text-lg font-bold text-gray-900">No hay gestiones disponibles</h3>
                        <p class="mt-2 text-gray-500">Cree una gestión académica para poder generar sus reportes.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
