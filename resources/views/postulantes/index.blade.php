{{-- CU5: Gestionar Postulantes (Vista Principal) --}}
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Postulantes</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10 mb-4 md:mb-0">
                    <h3 class="text-2xl font-extrabold mb-1">Registro de Postulantes</h3>
                    <p class="text-blue-200 text-sm font-medium">Visualización y control de todos los estudiantes preuniversitarios</p>
                </div>
                <div class="relative z-10 flex gap-3">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('postulantes.importar') }}" class="text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-lg transition bg-blue-800 hover:bg-blue-900 border border-blue-700">⬇️ Importar CSV/Excel</a>
                    @endif
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" class="flex gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gestión</label>
                        <select name="gestion_id" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                            <option value="">Todas</option>
                            @foreach($gestiones as $g)
                                <option value="{{ $g->id }}" {{ request('gestion_id') == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Buscar (CI o Nombre)</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm" placeholder="Buscar...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                            <option value="">Todos</option>
                            @foreach(['inscrito','pagado','en_curso','aprobado','reprobado','asignado'] as $e)
                                <option value="{{ $e }}" {{ request('estado') === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="text-white px-4 py-2 rounded-md text-sm font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Filtrar</button>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead style="background-color: #0A3254; color: white;">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">CI</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Gestión</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Grupo</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($postulantes as $p)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $p->ci }}</td>
                                <td class="px-6 py-4 font-medium">{{ $p->nombre_completo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $p->gestion->nombre ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ $p->grupo->nombre ?? 'Sin grupo' }}</td>
                                <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_',' ',$p->estado)) }}</span></td>
                                <td class="px-6 py-4 text-sm font-medium flex gap-3">
                                    <a href="{{ route('postulantes.show', $p) }}" class="hover:underline" style="color: #0A3254;">Ver</a>
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('postulantes.edit', $p) }}" class="hover:underline" style="color: #0A3254;">Editar</a>
                                        <form action="{{ route('postulantes.destroy', $p) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar este postulante?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="hover:underline" style="color: #D52B1E;">Eliminar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay postulantes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $postulantes->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
