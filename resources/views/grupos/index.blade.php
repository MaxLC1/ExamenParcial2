<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Grupos Académicos - FICCT</h2>
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
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                        <div class="ml-3"><p class="text-sm font-medium text-red-800">{{ session('error') }}</p></div>
                    </div>
                </div>
            @endif

            <!-- Tarjeta de Cabecera (Panel de Control de Grupos) -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-8 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-bottom: 5px solid #D52B1E;">
                <div class="relative z-10" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="background-color: rgba(255, 255, 255, 0.1); border: 1px solid rgba(96, 165, 250, 0.3); padding: 0.75rem; border-radius: 0.75rem;">
                            <svg style="width: 32px; height: 32px; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold mb-1">Administración de Grupos</h3>
                            <p class="text-sm font-medium" style="color: #bfdbfe;">Gestiona aulas, distribuye postulantes y asigna materias.</p>
                        </div>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 1rem;">
                        <!-- Filtro de Gestión -->
                        <form method="GET" style="margin: 0;">
                            <select name="gestion_id" class="rounded-lg shadow-inner font-bold" style="padding: 0.5rem 1rem; border: none; color: #111827; cursor: pointer;" onchange="this.form.submit()">
                                @foreach($gestiones as $g)<option value="{{ $g->id }}" {{ $gestionId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>@endforeach
                            </select>
                        </form>

                        @if(Auth::user()->isAdmin())
                            <!-- Botón Crear Grupo -->
                            <a href="{{ route('grupos.create') }}" class="font-bold transition-all shadow-md" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.25rem; border-radius: 0.5rem; background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; text-decoration: none;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.1)'">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Nuevo Grupo
                            </a>
                        @endif
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>

            @if(Auth::user()->isAdmin())
                <!-- Panel de Asignación Masiva -->
                <div class="bg-white shadow-md sm:rounded-xl mb-8 border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200" style="background-color: #f8fafc; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                        <h4 class="font-extrabold text-lg" style="color: #0A3254; display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Distribución Masiva de Postulantes
                        </h4>
                        <form method="POST" action="{{ route('grupos.asignar-postulantes') }}" style="display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; margin: 0;">
                            @csrf
                            <input type="hidden" name="gestion_id" value="{{ $gestionId }}">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <label class="text-sm font-bold text-gray-700">Capacidad por Aula:</label>
                                <input type="number" name="capacidad" value="70" min="30" max="100" class="rounded-lg border-gray-300 shadow-sm text-center font-bold" style="width: 5rem; padding: 0.5rem;">
                            </div>
                            <button type="submit" class="text-white font-bold shadow-md transition-colors" style="background-color: #D52B1E; padding: 0.5rem 1.25rem; border-radius: 0.5rem; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                                Ejecutar Distribución
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($grupos as $grupo)
                    @php
                        $porcentaje = min(100, ($grupo->postulantes->count() / $grupo->capacidad_maxima) * 100);
                        $colorBarra = $porcentaje >= 100 ? '#D52B1E' : ($porcentaje > 75 ? '#eab308' : '#0A3254');
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1">
                        <div class="p-4 flex justify-between items-center" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <h3 class="font-black text-xl" style="color: #0A3254;">{{ $grupo->nombre }}</h3>
                            @if(Auth::user()->isAdmin())
                                <div class="flex gap-2">
                                    <a href="{{ route('grupos.edit', $grupo) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-1.5 rounded-md transition-colors" title="Editar Grupo">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este grupo?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-1.5 rounded-md transition-colors" title="Eliminar Grupo">
                                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-2 rounded-lg bg-gray-100 text-gray-500">
                                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <p class="text-gray-600 font-medium">Aula: <span class="font-bold text-gray-900">{{ $grupo->aula ?? 'Sin asignar' }}</span></p>
                            </div>
                            
                            <div class="mb-1 flex justify-between items-center text-sm">
                                <span class="font-bold text-gray-700">Ocupación</span>
                                <span class="font-bold {{ $porcentaje >= 100 ? 'text-red-600' : 'text-blue-800' }}">{{ $grupo->postulantes->count() }} / {{ $grupo->capacidad_maxima }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-5 shadow-inner">
                                <div class="h-2.5 rounded-full transition-all duration-500" style="width: {{ $porcentaje }}%; background-color: {{ $colorBarra }};"></div>
                            </div>
                            
                            <div class="flex justify-between items-center gap-2 pt-2 border-t border-gray-100">
                                <a href="{{ route('postulantes.index', ['grupo_id' => $grupo->id]) }}" class="flex-1 text-center text-sm font-bold bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                    👥 Ver Lista
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('grupos.asignar-materias', $grupo) }}" class="flex-1 text-center text-sm font-bold text-white px-3 py-2 rounded-lg shadow-sm transition-colors" style="background-color: #0A3254;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='#0A3254'">
                                        📚 Materias →
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white shadow-sm rounded-xl p-12 text-center border border-gray-200">
                        <svg style="width: 64px; height: 64px; margin: 0 auto; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h3 class="mt-4 text-lg font-bold text-gray-900">No hay grupos registrados</h3>
                        <p class="mt-2 text-gray-500">Comienza creando un grupo manualmente o usando la distribución masiva.</p>
                        @if(Auth::user()->isAdmin())
                            <div class="mt-6">
                                <a href="{{ route('grupos.create') }}" class="inline-flex items-center gap-2 px-6 py-3 font-bold text-white rounded-lg shadow-md transition-all hover:-translate-y-0.5" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Crear mi primer grupo
                                </a>
                            </div>
                        @endif
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">{{ $grupos->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
