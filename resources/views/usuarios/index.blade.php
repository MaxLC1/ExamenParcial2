{{-- CU13: Gestionar Usuarios y Roles (Vista Principal) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Usuarios y Roles</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold mb-1">Usuarios y Accesos</h3>
                    <p class="text-blue-200 text-sm font-medium">Control de roles y permisos del sistema</p>
                </div>
                <div class="relative z-10">
                    <a href="{{ route('usuarios.importar') }}" class="text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-lg transition bg-blue-800 hover:bg-blue-900 border border-blue-700">Importar Usuarios en Lotes</a>
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <!-- Filtros de Búsqueda -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Buscar (Nombre o Email)</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm" placeholder="Buscar...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Filtrar por Rol</label>
                        <select name="role" class="mt-1 rounded-md border-gray-300 shadow-sm text-sm">
                            <option value="">Todos</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="profesor" {{ request('role') == 'profesor' ? 'selected' : '' }}>Profesor (Docente)</option>
                            <option value="postulante" {{ request('role') == 'postulante' ? 'selected' : '' }}>Postulante</option>
                            <option value="autoridad" {{ request('role') == 'autoridad' ? 'selected' : '' }}>Autoridad</option>
                            <option value="coordinador" {{ request('role') == 'coordinador' ? 'selected' : '' }}>Coordinador</option>
                            <option value="otros" {{ request('role') == 'otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="text-white px-4 py-2 rounded-md text-sm font-bold shadow transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Filtrar</button>
                        @if(request()->has('search') || request()->has('role'))
                            <a href="{{ route('usuarios.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium ml-2 hover:underline">Limpiar Filtros</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background-color: #0A3254; color: white;">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Rol Actual</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Cambiar Rol</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($usuarios as $usuario)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $usuario->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usuario->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($usuario->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($usuario->id !== Auth::id())
                                                <form action="{{ route('usuarios.update-role', $usuario) }}" method="POST" class="flex gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                        <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="profesor" {{ $usuario->role == 'profesor' ? 'selected' : '' }}>Profesor (Docente)</option>
                                                        <option value="postulante" {{ $usuario->role == 'postulante' ? 'selected' : '' }}>Postulante</option>
                                                        <option value="autoridad" {{ $usuario->role == 'autoridad' ? 'selected' : '' }}>Autoridad</option>
                                                        <option value="coordinador" {{ $usuario->role == 'coordinador' ? 'selected' : '' }}>Coordinador</option>
                                                        <option value="otros" {{ $usuario->role == 'otros' ? 'selected' : '' }}>Otros</option>
                                                    </select>
                                                    <button type="submit" class="text-white px-3 py-1 rounded font-bold shadow transition text-xs" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">Guardar</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 italic">No puedes cambiar tu propio rol</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
