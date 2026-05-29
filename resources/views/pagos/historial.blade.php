{{-- CU12: Control Historial de Pagos --}}
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Historial de Pagos</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjeta de Título -->
            <div class="shadow-lg sm:rounded-xl p-6 mb-6 text-white relative overflow-hidden flex items-center justify-between" style="background: linear-gradient(135deg, #0A3254 0%, #072440 100%); border-left: 6px solid #D52B1E;">
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold mb-1">Registro Central de Pagos</h3>
                    <p class="text-blue-200 text-sm font-medium">Historial completo de transacciones de postulantes</p>
                </div>
                <div class="relative z-10 p-3 rounded-full bg-white bg-opacity-10">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white shadow-xl sm:rounded-xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead style="background-color: #0A3254;">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Referencia</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Postulante</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Monto</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Wallet ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($pagos as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm font-mono">{{ $p->referencia_transaccion }}</td>
                            <td class="px-4 py-3 text-sm">{{ $p->postulante->nombre_completo }}</td>
                            <td class="px-4 py-3 text-center font-semibold">Bs. {{ number_format($p->monto, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $p->wallet_id }}</td>
                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $p->estado === 'completado' ? 'bg-green-100 text-green-800' : ($p->estado === 'fallido' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">{{ ucfirst($p->estado) }}</span></td>
                            <td class="px-4 py-3 text-sm">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('pagos.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Está seguro de eliminar este pago? El postulante volverá a estado pendiente de pago.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-4 text-center text-gray-500">No hay pagos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $pagos->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
