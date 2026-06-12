<x-app-layout>
    <!-- Header Oculto para usar banner personalizado -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">Gestión de Exámenes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ search: '' }">
            
            <!-- Banner Institucional FICCT -->
            <div class="mb-8 relative overflow-hidden shadow-xl" style="background: linear-gradient(135deg, #0A3254 0%, #114c81 100%); border-radius: 1rem;">
                <div style="padding: 1.5rem 2rem; position: relative; z-index: 10; display: flex; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 1rem; color: white;">
                        <div style="display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem; background-color: rgba(255,255,255,0.1); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.2);">
                            <svg style="width: 2rem; height: 2rem; color: #bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; line-height: 1.2;">Panel de Exámenes</h2>
                            <p style="color: #dbeafe; font-size: 1rem; opacity: 0.9; margin: 0;">Gestione y evalúe los exámenes de todas las materias y grupos activos.</p>
                        </div>
                    </div>
                </div>
                <div style="position: absolute; top: 0; right: 0; width: 16rem; height: 16rem; background-color: white; opacity: 0.05; border-radius: 9999px; filter: blur(40px); transform: translate(33%, -25%);"></div>
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

            <!-- Controles Superiores -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                    <!-- Filtro por Gestión (Existente) -->
                    <form method="GET" class="flex items-center gap-3 w-full sm:w-auto">
                        <span class="text-sm font-bold text-gray-500 whitespace-nowrap">Filtrar Gestión:</span>
                        <select name="gestion_id" class="rounded-lg border-gray-300 shadow-sm text-sm font-semibold text-gray-700 bg-gray-50 focus:border-[#0A3254] focus:ring-[#0A3254] w-full sm:w-auto" onchange="this.form.submit()">
                            @foreach($gestiones as $g)
                                <option value="{{ $g->id }}" {{ $gestionId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                            @endforeach
                        </select>
                    </form>
                    
                    <!-- NUEVO: Barra de Búsqueda -->
                    <div class="relative w-full sm:w-72">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" x-model="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 shadow-sm focus:ring-[#0A3254] focus:border-[#0A3254]" placeholder="Buscar materia, grupo o tipo...">
                    </div>
                </div>

                <a href="{{ route('examenes.create') }}" class="font-bold px-5 py-2.5 rounded-lg text-white shadow-md transition-all flex items-center gap-2 w-full md:w-auto justify-center" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Programar Nuevo Examen
                </a>
            </div>

            @php
                // Nivel 1: Agrupar por Grupo
                $groupedByGrupo = $examenes->groupBy(function($item) {
                    return 'Grupo ' . $item->grupoMateria->grupo->nombre;
                });
            @endphp

            <!-- Lista de Grupos -->
            <div class="space-y-8">
                @forelse($groupedByGrupo as $groupName => $examenesDelGrupo)
                    @php
                        // Recolectar textos buscables del grupo
                        $searchableTextGroup = strtolower($groupName);
                        foreach($examenesDelGrupo as $ex) {
                            $searchableTextGroup .= ' ' . strtolower(str_replace('_',' ',$ex->tipo));
                            $searchableTextGroup .= ' ' . strtolower($ex->grupoMateria->materia->nombre);
                        }
                    @endphp
                    
                    <!-- Acordeón Principal: Grupo -->
                    <div class="bg-white shadow-md sm:rounded-xl border border-gray-200 overflow-hidden" 
                         x-data="{ textGroup: '{{ $searchableTextGroup }}', expandedGroup: true }"
                         x-show="search === '' || textGroup.includes(search.toLowerCase())">
                        
                        <!-- Cabecera del Grupo -->
                        <div @click="expandedGroup = !expandedGroup" class="bg-gray-100 border-b border-gray-200 px-6 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-200 transition-colors">
                            <h3 class="text-xl font-extrabold text-[#0A3254] flex items-center gap-3">
                                <span class="bg-blue-100 text-blue-800 p-2 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </span>
                                {{ $groupName }}
                            </h3>
                            <div class="flex items-center gap-4">
                                <span class="bg-white text-gray-700 py-1 px-3 rounded-full text-xs font-bold border border-gray-300 shadow-sm">
                                    {{ $examenesDelGrupo->count() }} exámenes en total
                                </span>
                                <svg class="w-6 h-6 text-gray-500 transition-transform duration-200" :class="expandedGroup ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Contenido del Grupo -->
                        <div x-show="expandedGroup" x-transition class="p-4 space-y-4 bg-gray-50">
                            
                            @php
                                // Nivel 2: Agrupar por Materia dentro del Grupo
                                $groupedByMateria = $examenesDelGrupo->groupBy(function($item) {
                                    return $item->grupoMateria->materia->nombre;
                                });
                            @endphp

                            @foreach($groupedByMateria as $materiaName => $examenesDeMateria)
                                @php
                                    $searchableTextMateria = strtolower($materiaName);
                                    foreach($examenesDeMateria as $ex) {
                                        $searchableTextMateria .= ' ' . strtolower(str_replace('_',' ',$ex->tipo));
                                    }
                                @endphp

                                <!-- Sub-Acordeón: Materia -->
                                <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden"
                                     x-data="{ textMateria: '{{ $searchableTextMateria }}', expandedMateria: true }"
                                     x-show="search === '' || textMateria.includes(search.toLowerCase()) || '{{ strtolower($groupName) }}'.includes(search.toLowerCase())">
                                    
                                    <!-- Cabecera de la Materia -->
                                    <div @click="expandedMateria = !expandedMateria" class="bg-white border-b border-gray-100 px-5 py-3 flex items-center justify-between cursor-pointer hover:bg-blue-50 transition-colors">
                                        <h4 class="text-md font-bold text-gray-800 flex items-center gap-2">
                                            📘 {{ $materiaName }}
                                        </h4>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                                {{ $examenesDeMateria->count() }} exámenes
                                            </span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="expandedMateria ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>

                                    <!-- Tabla de Exámenes de la Materia -->
                                    <div x-show="expandedMateria" x-transition class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-100">
                                            <thead>
                                                <tr style="background-color: #f8fafc;">
                                                    <th scope="col" class="px-5 py-2.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider w-1/4">Tipo de Examen</th>
                                                    <th scope="col" class="px-5 py-2.5 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Puntaje Máx</th>
                                                    <th scope="col" class="px-5 py-2.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
                                                    <th scope="col" class="px-5 py-2.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Estado</th>
                                                    <th scope="col" class="px-5 py-2.5 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-50">
                                                @foreach($examenesDeMateria as $ex)
                                                @php
                                                    $tipoDisplay = '';
                                                    if($ex->tipo === 'examen_1') $tipoDisplay = 'Primer Parcial';
                                                    elseif($ex->tipo === 'examen_2') $tipoDisplay = 'Segundo Parcial';
                                                    elseif($ex->tipo === 'examen_3') $tipoDisplay = 'Examen Final';
                                                    else $tipoDisplay = ucfirst(str_replace('_',' ',$ex->tipo));
                                                @endphp
                                                <tr class="hover:bg-blue-50 transition-colors duration-150"
                                                    x-data="{ tipo: '{{ strtolower($tipoDisplay) }}' }"
                                                    x-show="search === '' || textMateria.includes(search.toLowerCase()) || '{{ strtolower($groupName) }}'.includes(search.toLowerCase()) || tipo.includes(search.toLowerCase())">
                                                    <td class="px-5 py-3 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                                            {{ $tipoDisplay }}
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-3 whitespace-nowrap text-sm text-center">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                                            {{ $ex->puntaje_maximo }} pts
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-600 font-semibold">
                                                        {{ $ex->fecha->format('d/m/Y') }} 
                                                        <span class="text-gray-400 font-normal ml-1">{{ \Carbon\Carbon::parse($ex->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($ex->hora_fin)->format('H:i') }}</span>
                                                    </td>
                                                    <td class="px-5 py-3 whitespace-nowrap">
                                                        @if($ex->estado === 'finalizado')
                                                            <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                                Finalizado
                                                            </span>
                                                        @else
                                                            <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                                                {{ ucfirst($ex->estado) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                        <a href="{{ route('profesor.calificar', $ex) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-gray-300 rounded-md shadow-sm text-xs font-bold transition-colors hover:bg-gray-50" style="color: #0A3254;">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                            Calificar
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="bg-white shadow-md sm:rounded-xl overflow-hidden border border-gray-200 p-10 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg class="mb-3 opacity-50" style="width: 4rem; height: 4rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p class="text-base font-medium text-gray-500">No hay exámenes programados para esta gestión.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
