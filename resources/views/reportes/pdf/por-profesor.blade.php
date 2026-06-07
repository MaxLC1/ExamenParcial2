<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte por Profesor</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #334155; margin: 0; padding: 0; }
        .header { width: 100%; border-bottom: 3px solid #D52B1E; padding-bottom: 15px; margin-bottom: 20px; }
        .header table { width: 100%; border: none; margin: 0; }
        .header td { border: none; padding: 0; }
        .logo-text { font-size: 24px; font-weight: 900; color: #0A3254; margin: 0; letter-spacing: 1px; }
        .report-title { font-size: 14px; color: #64748b; margin: 5px 0 0 0; text-transform: uppercase; font-weight: bold; }
        .meta-info { font-size: 11px; color: #94a3b8; text-align: right; }
        .highlight-box { background-color: #fef9c3; border: 1px solid #fef08a; padding: 12px; border-radius: 6px; margin-bottom: 20px; color: #854d0e; font-size: 13px; text-align: center; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .data-table th { background-color: #0A3254; color: #ffffff; padding: 12px 8px; text-align: center; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border: 1px solid #082846; }
        .data-table td { padding: 10px 8px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; }
        .data-table tr:nth-child(even) { background-color: #f8fafc; }
        .text-left { text-align: left !important; }
        .font-bold { font-weight: bold; color: #0f172a; }
        .winner-row { background-color: #fef9c3 !important; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; display: inline-block; }
        .badge-success { background-color: #dcfce3; color: #166534; border: 1px solid #bbf7d0; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .text-success { color: #16a34a; font-weight: bold; }
        .footer { position: fixed; bottom: 0px; width: 100%; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 50%;">
                    <h1 class="logo-text">FICCT | UAGRM</h1>
                    <p class="report-title">Estadísticas de Aprobación por Profesor</p>
                </td>
                <td style="width: 50%;" class="meta-info">
                    <strong>Gestión Académica:</strong> {{ $gestion->nombre }}<br>
                    <strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    @if(!empty($reporteData) && $reporteData[0]['porcentaje'] > 0)
    <div class="highlight-box">
        <strong>🏆 Mayor Índice de Aprobados:</strong> {{ $reporteData[0]['profesor'] }} ({{ $reporteData[0]['porcentaje'] }}%)
    </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>Ranking</th>
                <th class="text-left">Profesor</th>
                <th>Grupos</th>
                <th>Total Alumnos</th>
                <th>Aprobados</th>
                <th>% Aprobación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporteData as $i => $r)
            <tr class="{{ $i === 0 ? 'winner-row' : '' }}">
                <td class="font-bold">{{ $i + 1 }} {{ $i === 0 ? '🏆' : '' }}</td>
                <td class="text-left font-bold">{{ $r['profesor'] }}</td>
                <td>{{ $r['grupos'] }}</td>
                <td>{{ $r['total_alumnos'] }}</td>
                <td class="text-success">{{ $r['aprobados'] }}</td>
                <td>
                    <span class="badge {{ $r['porcentaje'] >= 60 ? 'badge-success' : 'badge-danger' }}">{{ $r['porcentaje'] }}%</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado automáticamente por el Sistema Académico de la Facultad de Ingeniería en Ciencias de la Computación y Telecomunicaciones
    </div>
</body>
</html>
