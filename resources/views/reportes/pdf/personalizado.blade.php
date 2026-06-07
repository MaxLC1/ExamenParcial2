<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Personalizado</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #334155; margin: 0; padding: 0; }
        .header { width: 100%; border-bottom: 3px solid #D52B1E; padding-bottom: 15px; margin-bottom: 25px; }
        .header table { width: 100%; border: none; margin: 0; }
        .header td { border: none; padding: 0; }
        .logo-text { font-size: 24px; font-weight: 900; color: #0A3254; margin: 0; letter-spacing: 1px; }
        .report-title { font-size: 14px; color: #64748b; margin: 5px 0 0 0; text-transform: uppercase; font-weight: bold; }
        .meta-info { font-size: 11px; color: #94a3b8; text-align: right; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #0A3254; color: #ffffff; padding: 10px 6px; text-align: left; text-transform: uppercase; font-size: 9px; letter-spacing: 0.5px; border: 1px solid #082846; }
        .data-table td { padding: 8px 6px; border: 1px solid #e2e8f0; text-align: left; font-size: 10px; }
        .data-table tr:nth-child(even) { background-color: #f8fafc; }
        .font-bold { font-weight: bold; color: #0f172a; }
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; display: inline-block; text-align: center; }
        .badge-success { background-color: #dcfce3; color: #166534; border: 1px solid #bbf7d0; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .text-success { color: #16a34a; font-weight: bold; }
        .text-danger { color: #dc2626; font-weight: bold; }
        .footer { position: fixed; bottom: 0px; width: 100%; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 50%;">
                    <h1 class="logo-text">FICCT | UAGRM</h1>
                    <p class="report-title">Reporte Personalizado Multicriterio</p>
                </td>
                <td style="width: 50%;" class="meta-info">
                    <strong>Total Registros:</strong> {{ count($reporteData) }}<br>
                    <strong>Fecha de Generación:</strong> {{ date('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    @php
        $opcionesColumnas = [
            'ci' => 'CI',
            'nombre' => 'Nombre Completo',
            'telefono' => 'Teléfono',
            'email' => 'Correo',
            'nota' => 'Nota',
            'estado' => 'Estado',
            'carrera_asignada' => 'Carrera'
        ];
    @endphp

    <table class="data-table">
        <thead>
            <tr>
                @foreach($opcionesColumnas as $key => $label)
                    @if(in_array($key, $columnasSeleccionadas))
                        <th>{{ $label }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($reporteData as $row)
                <tr>
                    @foreach($opcionesColumnas as $key => $label)
                        @if(in_array($key, $columnasSeleccionadas))
                            <td>
                                @if($key === 'estado')
                                    <span class="badge {{ $row[$key] === 'Aprobado' ? 'badge-success' : 'badge-danger' }}">{{ $row[$key] }}</span>
                                @elseif($key === 'nota')
                                    <span class="{{ $row[$key] >= 60 ? 'text-success' : 'text-danger' }}">{{ $row[$key] }}</span>
                                @elseif($key === 'nombre')
                                    <span class="font-bold">{{ $row[$key] }}</span>
                                @else
                                    {{ $row[$key] }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columnasSeleccionadas) }}" style="text-align: center; padding: 20px; color: #64748b; font-style: italic;">
                        No se encontraron registros.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generado automáticamente por el Sistema Académico de la Facultad de Ingeniería en Ciencias de la Computación y Telecomunicaciones
    </div>
</body>
</html>
