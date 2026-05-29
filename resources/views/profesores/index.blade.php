{{-- CU4: Gestionar Profesores (Vista Principal) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profesores</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold mb-1">Directorio de Profesores</h3>
                    <p class="text-blue-200 text-sm font-medium">Gestión del plantel docente autorizado</p>
                </div>
                <div class="relative z-10">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('profesores.create') }}" class="text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-lg transition" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">+ Nuevo Profesor</a>
                    @endif
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl transform translate-x-1/3 -translate-y-1/4"></div>
            </div>
            @if(session('success'))<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>@endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead style="background-color: #0A3254; color: white;">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">CI</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Especialidad</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Estado</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($profesores as $profesor)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $profesor->ci }}</td>
                                <td class="px-6 py-4 font-medium">{{ $profesor->nombre_completo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $profesor->user->email }}</td>
                                <td class="px-6 py-4 text-sm">{{ $profesor->especialidad ?? '-' }}</td>
                                <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full {{ $profesor->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $profesor->activo ? 'Activo' : 'Inactivo' }}</span></td>
                                @if(Auth::user()->isAdmin())
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('profesores.edit', $profesor) }}" class="hover:underline mr-2" style="color: #0A3254;">Editar</a>
                                        <form action="{{ route('profesores.destroy', $profesor) }}" method="POST" class="inline">@csrf @method('DELETE')
                                            <button type="submit" class="hover:underline" style="color: #D52B1E;" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay profesores registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $profesores->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
