<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Reporte por Materia</title>
<style>body{font-family:Arial,sans-serif;font-size:12px;} h1{color:#4338ca;font-size:18px;} table{width:100%;border-collapse:collapse;margin-top:15px;} th,td{border:1px solid #ddd;padding:8px;text-align:center;} th{background:#f3f4f6;font-size:11px;text-transform:uppercase;} .header{text-align:center;margin-bottom:20px;} .aprobado{color:#16a34a;font-weight:bold;} .reprobado{color:#dc2626;}</style>
</head><body>
<div class="header">
    <h1>FICCT - Reporte por Materia</h1>
    <p>{{ $gestion->nombre }} | Generado: {{ now()->format('d/m/Y H:i') }}</p>
</div>
<table>
    <thead><tr><th>Materia</th><th>Total</th><th>Aprobados</th><th>Reprobados</th><th>% Aprobación</th><th>Promedio</th></tr></thead>
    <tbody>
        @foreach($reporteData as $r)
        <tr>
            <td style="text-align:left;font-weight:bold;">{{ $r['materia'] }}</td>
            <td>{{ $r['total'] }}</td>
            <td class="aprobado">{{ $r['aprobados'] }}</td>
            <td class="reprobado">{{ $r['reprobados'] }}</td>
            <td>{{ $r['porcentaje'] }}%</td>
            <td>{{ $r['promedio'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body></html>
