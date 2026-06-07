{{-- CU5: Gestionar Postulantes (Vista Principal) --}}
<x-app-layout>
    <!-- Header Oculto para usar banner personalizado -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Postulantes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Banner Institucional FICCT -->
            <div class="mb-8 relative overflow-hidden shadow-xl" style="background: linear-gradient(135deg, #0A3254 0%, #114c81 100%); border-radius: 1rem;">
                <div style="padding: 1.5rem 2rem; position: relative; z-index: 10; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: white;">
                        <div style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem; background-color: rgba(255,255,255,0.1); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                            <svg style="width: 2rem; height: 2rem; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Registro de Postulantes</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Visualización y control de todos los estudiantes preuniversitarios</p>
                        </div>
                    </div>
                    
                    @if(Auth::user()->isAdmin())
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="{{ route('postulantes.importar') }}" class="font-bold px-5 py-2 rounded-lg text-white shadow-lg transition-all flex items-center gap-2 border border-white/20" style="background-color: rgba(255,255,255,0.15);" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.25)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.15)'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Importar CSV/Excel
                        </a>
                    </div>
                    @endif
                </div>
                <div style="position: absolute; top: 0; right: 0; width: 16rem; height: 16rem; background-color: white; opacity: 0.05; border-radius: 9999px; filter: blur(40px); transform: translate(33%, -25%);"></div>
            </div>

            <!-- Controles Superiores: Filtros y Acciones -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <form method="GET" class="flex flex-wrap items-end gap-3 w-full">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Gestión</label>
                        <select name="gestion_id" class="rounded-lg border-gray-300 shadow-sm text-sm font-semibold text-gray-700 bg-gray-50 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todas</option>
                            @foreach($gestiones as $g)
                                <option value="{{ $g->id }}" {{ request('gestion_id') == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Buscar (CI o Nombre)</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="rounded-lg border-gray-300 shadow-sm text-sm font-semibold text-gray-700 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400" placeholder="Buscar...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Estado</label>
                        <select name="estado" class="rounded-lg border-gray-300 shadow-sm text-sm font-semibold text-gray-700 bg-gray-50 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos</option>
                            @foreach(['inscrito','pagado','en_curso','aprobado','reprobado','asignado'] as $e)
                                <option value="{{ $e }}" {{ request('estado') === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="font-bold px-5 py-2.5 rounded-lg text-white shadow-md transition-all h-[42px]" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- Tabla Principal -->
            <div class="bg-white shadow-md sm:rounded-xl overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr style="background-color: #f8fafc;">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">CI</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Gestión</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Grupo</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($postulantes as $p)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">{{ $p->ci }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $p->nombre_completo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $p->gestion->nombre ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ $p->grupo->nombre ?? 'Sin grupo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClass = match($p->estado) {
                                                'aprobado', 'asignado' => 'bg-green-100 text-green-800 border-green-200',
                                                'reprobado' => 'bg-red-100 text-red-800 border-red-200',
                                                'pagado' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                default => 'bg-blue-100 text-blue-800 border-blue-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_',' ',$p->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">
                                        <a href="{{ route('postulantes.show', $p) }}" class="text-gray-600 hover:text-blue-900 font-bold flex items-center gap-1" title="Ver">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('postulantes.edit', $p) }}" class="text-blue-600 hover:text-blue-900 font-bold flex items-center gap-1" title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('postulantes.destroy', $p) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar este postulante?');" class="inline m-0 p-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold flex items-center gap-1" title="Eliminar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="mb-3 opacity-50" style="width: 4rem; height: 4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <p class="text-base font-medium text-gray-500">No hay postulantes registrados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($postulantes->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $postulantes->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
