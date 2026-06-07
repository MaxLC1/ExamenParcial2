<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Reporte por Materia</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Banner Institucional FICCT -->
            <div class="mb-6 relative overflow-hidden shadow-xl" style="background: linear-gradient(135deg, #0A3254 0%, #114c81 100%); border-radius: 1rem;">
                <div style="padding: 1.5rem 2rem; position: relative; z-index: 10; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: white;">
                        <a href="{{ route('reportes.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg bg-white/10 hover:bg-white/20 transition border border-white/20" title="Volver atrás">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem; background-color: rgba(255,255,255,0.1); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                            <svg style="width: 2rem; height: 2rem; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Reporte de Rendimiento por Materia</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Gestión: {{ $gestion->nombre }}</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('reportes.por-materia', ['gestion_id' => $gestionId, 'formato' => 'pdf']) }}" class="inline-flex items-center gap-2 font-bold px-5 py-2.5 rounded-lg shadow-md transition-all text-white" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Exportar PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabla de Datos -->
            <div class="bg-white shadow-md sm:rounded-xl overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr style="background-color: #f8fafc;">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Materia</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-extrabold text-green-600 uppercase tracking-wider">Aprobados</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-extrabold text-red-600 uppercase tracking-wider">Reprobados</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">% Aprobación</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Promedio General</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($reporteData as $r)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $r['materia'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-gray-700">
                                    {{ $r['total'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-green-600">
                                    {{ $r['aprobados'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-red-600">
                                    {{ $r['reprobados'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $r['porcentaje'] >= 60 ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200' }}">
                                        {{ $r['porcentaje'] }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-bold bg-blue-50 text-blue-800 border border-blue-100">
                                        {{ $r['promedio'] }} / 100
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <p class="text-gray-500 font-medium">No hay datos disponibles para generar el reporte.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
