<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Reporte Personalizado</h2>
    </x-slot>

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
                            <svg style="width: 2rem; height: 2rem; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Constructor de Reportes Ad-Hoc</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Diseña reportes personalizados seleccionando los filtros y columnas exactas que necesitas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg sm:rounded-2xl border-t-4 mb-8" style="border-color: #0A3254;">
                <form method="POST" action="{{ route('reportes.personalizado') }}" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-8">
                        <!-- Filtros -->
                        <div class="md:col-span-5 bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h4 class="font-extrabold text-gray-800 border-b-2 border-gray-300 pb-3 mb-5 flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-800 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                                Filtros de Búsqueda
                            </h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Gestión Académica</label>
                                    <select name="gestion_id" onchange="this.form.submit()" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-white font-medium text-gray-800">
                                        @foreach($gestiones as $g)
                                            <option value="{{ $g->id }}" {{ $gestionId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Filtrar por Materia</label>
                                    <select name="materia_id" onchange="this.form.submit()" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-white font-medium text-gray-800">
                                        <option value="">-- Todas las Materias --</option>
                                        @foreach($materias as $m)
                                            <option value="{{ $m->id }}" {{ $filtroMateria == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Filtrar por Estado</label>
                                    <select name="estado" onchange="this.form.submit()" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-white font-medium text-gray-800">
                                        <option value="todos" {{ $filtroEstado == 'todos' ? 'selected' : '' }}>-- Todos --</option>
                                        <option value="aprobado" {{ $filtroEstado == 'aprobado' ? 'selected' : '' }}>Aprobados</option>
                                        <option value="reprobado" {{ $filtroEstado == 'reprobado' ? 'selected' : '' }}>Reprobados</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Columnas -->
                        <div class="md:col-span-7 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                            <h4 class="font-extrabold text-gray-800 border-b-2 border-gray-300 pb-3 mb-5 flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-800 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                                Datos a Visualizar (Columnas)
                            </h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @php
                                    $opcionesColumnas = [
                                        'ci' => 'Carnet de Identidad',
                                        'nombre' => 'Nombre Completo',
                                        'telefono' => 'Teléfono',
                                        'email' => 'Correo Electrónico',
                                        'nota' => 'Nota (Promedio)',
                                        'estado' => 'Estado (Aprobado/Reprobado)',
                                        'carrera_asignada' => 'Carrera Asignada'
                                    ];
                                @endphp
                                
                                @foreach($opcionesColumnas as $key => $label)
                                    <label class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-blue-50 cursor-pointer transition-colors {{ in_array($key, $columnasSeleccionadas) ? 'bg-blue-50 border-blue-300' : '' }}">
                                        <input type="checkbox" name="columnas[]" value="{{ $key }}" class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                            {{ in_array($key, $columnasSeleccionadas) ? 'checked' : '' }}>
                                        <span class="ml-3 font-medium text-gray-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col-reverse sm:flex-row justify-center sm:justify-end gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" class="font-bold px-8 py-3 rounded-lg text-white shadow-md transition-all text-center flex items-center justify-center gap-2" style="background-color: #0A3254;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='#0A3254'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Generar en Pantalla
                        </button>
                        
                        <button type="submit" name="formato" value="pdf" class="font-bold px-8 py-3 rounded-lg text-white shadow-md transition-all text-center flex items-center justify-center gap-2" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Descargar en PDF
                        </button>
                    </div>
                </form>
            </div>
            
            @if($mostrarTabla && request()->get('formato') !== 'pdf')
                <div id="resultados-tabla" class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-200 mt-8">
                    <div class="px-8 py-5" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <h3 class="font-extrabold text-xl text-gray-800 flex items-center gap-2">
                            <span class="text-2xl">📋</span>
                            Resultados del Reporte 
                            <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full ml-2">{{ count($reporteData) }} registros</span>
                        </h3>
                    </div>
                    
                    @if(count($reporteData) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr style="background-color: #f1f5f9;">
                                        @foreach($opcionesColumnas as $key => $label)
                                            @if(in_array($key, $columnasSeleccionadas))
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold text-gray-600 uppercase tracking-wider">{{ $label }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($reporteData as $row)
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                            @foreach($opcionesColumnas as $key => $label)
                                                @if(in_array($key, $columnasSeleccionadas))
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                        @if($key === 'estado')
                                                            @if($row[$key] === 'Aprobado')
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">Aprobado</span>
                                                            @else
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">Reprobado</span>
                                                            @endif
                                                        @elseif($key === 'nota')
                                                            <span class="font-bold text-lg {{ $row[$key] >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $row[$key] }}</span>
                                                        @elseif($key === 'nombre')
                                                            <span class="font-bold">{{ $row[$key] }}</span>
                                                        @elseif($key === 'carrera_asignada')
                                                            @if($row[$key])
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">{{ $row[$key] }}</span>
                                                            @else
                                                                <span class="text-gray-400 italic">Sin Asignar</span>
                                                            @endif
                                                        @else
                                                            {{ $row[$key] }}
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Sin Resultados</h3>
                            <p class="text-gray-500">No se encontraron postulantes que coincidan con los filtros seleccionados.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if($mostrarTabla && request()->get('formato') !== 'pdf')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const tabla = document.getElementById('resultados-tabla');
                if (tabla) {
                    tabla.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 300); // Pequeño retraso para asegurar que la vista cargó
        });
    </script>
    @endif
</x-app-layout>
