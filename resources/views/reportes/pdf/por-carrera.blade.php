<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte por Carrera</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #334155; margin: 0; padding: 0; }
        .header { width: 100%; border-bottom: 3px solid #D52B1E; padding-bottom: 15px; margin-bottom: 25px; }
        .header table { width: 100%; border: none; margin: 0; }
        .header td { border: none; padding: 0; }
        .logo-text { font-size: 24px; font-weight: 900; color: #0A3254; margin: 0; letter-spacing: 1px; }
        .report-title { font-size: 14px; color: #64748b; margin: 5px 0 0 0; text-transform: uppercase; font-weight: bold; }
        .meta-info { font-size: 11px; color: #94a3b8; text-align: right; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #0A3254; color: #ffffff; padding: 12px 8px; text-align: center; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border: 1px solid #082846; }
        .data-table td { padding: 10px 8px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; }
        .data-table tr:nth-child(even) { background-color: #f8fafc; }
        .text-left { text-align: left !important; }
        .font-bold { font-weight: bold; color: #0f172a; }
        .text-highlight { color: #4338ca; font-size: 14px; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; background-color: #e2e8f0; color: #475569; display: inline-block; border: 1px solid #cbd5e1; }
        .footer { position: fixed; bottom: 0px; width: 100%; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 50%;">
                    <h1 class="logo-text">FICCT | UAGRM</h1>
                    <p class="report-title">Distribución de Alumnos por Carrera</p>
                </td>
                <td style="width: 50%;" class="meta-info">
                    <strong>Gestión Académica:</strong> {{ $gestion->nombre }}<br>
                    <strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-left">Programa Académico (Carrera)</th>
                <th>Código Institucional</th>
                <th>Alumnos Asignados</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporteData as $r)
            <tr>
                <td class="text-left font-bold">🎓 {{ $r['carrera'] }}</td>
                <td><span class="badge">{{ $r['codigo'] }}</span></td>
                <td class="text-highlight">{{ $r['asignados'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado automáticamente por el Sistema Académico de la Facultad de Ingeniería en Ciencias de la Computación y Telecomunicaciones
    </div>
</body>
</html>
