<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Asignar Materias</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Banner Institucional FICCT -->
            <div class="mb-6 relative overflow-hidden shadow-md" style="background: linear-gradient(135deg, #0A3254 0%, #114c81 100%); border-radius: 1rem;">
                <div style="padding: 1.5rem 2rem; position: relative; z-index: 10; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: white;">
                        <a href="{{ route('grupos.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg bg-white/10 hover:bg-white/20 transition border border-white/20" title="Volver a grupos">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem; background-color: rgba(255,255,255,0.1); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                            <svg style="width: 2rem; height: 2rem; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Asignación de Materias</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Configure las materias y profesores para el grupo <strong>{{ $grupo->nombre }}</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($asignaciones->isNotEmpty())
                <div class="bg-white shadow-md sm:rounded-xl overflow-hidden border border-gray-200 mb-8">
                    <div class="p-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#0A3254]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Materias Programadas
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Materia</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Profesor</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Horarios Asignados</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @php
                                    $groupedAsignaciones = $asignaciones->groupBy(function($a) {
                                        return $a->materia_id . '-' . $a->profesor_id;
                                    });
                                @endphp
                                @foreach($groupedAsignaciones as $group)
                                    @php $first = $group->first(); @endphp
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="px-6 py-4 align-top whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                {{ $first->materia->nombre }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 align-top font-bold text-gray-900 whitespace-nowrap">
                                            {{ $first->profesor->nombre_completo }}
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($group as $a)
                                                    <div class="inline-flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 shadow-sm">
                                                        <div class="flex items-center gap-1.5 text-xs text-gray-700 font-medium whitespace-nowrap">
                                                            <svg class="w-3.5 h-3.5 text-[#0A3254]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <span>{{ str_replace(':00 -', ' -', str_replace(':00 ', ' ', $a->horario?->descripcion ?? '-')) }}</span>
                                                            <span class="text-gray-400 font-normal italic ml-1">({{ ucfirst(substr($a->modalidad_clase, 0, 4)) }}.)</span>
                                                        </div>
                                                        <form action="{{ route('grupos.eliminar-asignacion', [$grupo->id, $a->id]) }}" method="POST" onsubmit="return confirm('¿Seguro que desea retirar este horario?');" class="inline-flex ml-2 border-l border-gray-200 pl-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold p-0.5 rounded transition-colors" title="Eliminar Horario">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-lg sm:rounded-2xl overflow-hidden border-t-4" style="border-color: #D52B1E;">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#D52B1E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Nueva Asignación
                    </h3>
                </div>
                <form method="POST" action="{{ route('grupos.guardar-asignacion', $grupo) }}" class="p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Materia a Impartir <span class="text-red-500">*</span></label>
                            <select name="materia_id" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50 font-semibold text-gray-800" required>
                                <option value="" disabled selected>Seleccione una materia...</option>
                                @foreach($materias as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Profesor Encargado <span class="text-red-500">*</span></label>
                            <select name="profesor_id" class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors bg-gray-50 font-semibold text-gray-800" required>
                                <option value="" disabled selected>Seleccione un profesor...</option>
                                @foreach($profesores as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre_completo }} {{ $p->especialidad ? '('.$p->especialidad.')' : '' }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2 italic">* El sistema validará automáticamente que la especialidad coincida.</p>
                        </div>
                    </div>

                    <div class="mt-4 mb-8">
                        <h4 class="font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Programación Semanal de Clases
                        </h4>
                        <div class="space-y-3 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            @foreach($horariosAgrupados as $dia => $horariosDelDia)
                                <div class="flex flex-col sm:flex-row sm:items-center gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:border-blue-200 transition-colors" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
                                    <div style="flex: 0 0 120px; display: flex; align-items: center;">
                                        <label class="inline-flex items-center cursor-pointer group">
                                            <input type="checkbox" name="dias[{{ $dia }}][activo]" value="1" class="w-5 h-5 rounded border-gray-300 text-[#0A3254] focus:ring-[#0A3254] transition-all">
                                            <span class="ml-3 capitalize font-bold text-gray-700 group-hover:text-[#0A3254] transition-colors">{{ $dia }}</span>
                                        </label>
                                    </div>
                                    <div style="flex: 1; min-width: 200px;">
                                        <select name="dias[{{ $dia }}][horario_id]" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors text-sm font-semibold text-gray-700" style="width: 100%; min-width: 200px;">
                                            @foreach($horariosDelDia as $h)
                                                <option value="{{ $h->id }}">{{ substr($h->hora_inicio, 0, 5) }} - {{ substr($h->hora_fin, 0, 5) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="flex: 1; min-width: 150px;">
                                        <select name="dias[{{ $dia }}][modalidad]" class="w-full p-2.5 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-colors text-sm font-semibold text-gray-700" style="width: 100%; min-width: 150px;">
                                            <option value="presencial">Presencial</option>
                                            <option value="virtual">Virtual</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100 mt-6">
                        <button type="submit" class="font-bold px-8 py-3 rounded-lg text-white shadow-md transition-all text-center flex items-center justify-center gap-2" style="background-color: #0A3254;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='#0A3254'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Registrar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
