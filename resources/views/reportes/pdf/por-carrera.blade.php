<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Reporte por Carrera</title>
<style>body{font-family:Arial,sans-serif;font-size:12px;} h1{color:#4338ca;font-size:18px;} table{width:100%;border-collapse:collapse;margin-top:15px;} th,td{border:1px solid #ddd;padding:8px;text-align:center;} th{background:#f3f4f6;font-size:11px;text-transform:uppercase;} .header{text-align:center;margin-bottom:20px;}</style>
</head><body>
<div class="header">
    <h1>FICCT - Reporte Asignación a Carreras</h1>
    <p>{{ $gestion->nombre }} | Generado: {{ now()->format('d/m/Y H:i') }}</p>
</div>
<table>
    <thead><tr><th>Carrera</th><th>Código</th><th>Asignados</th></tr></thead>
    <tbody>
        @foreach($reporteData as $r)
        <tr>
            <td style="text-align:left;font-weight:bold;">{{ $r['carrera'] }}</td>
            <td>{{ $r['codigo'] }}</td>
            <td style="font-size:16px;font-weight:bold;color:#4338ca;">{{ $r['asignados'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body></html>
