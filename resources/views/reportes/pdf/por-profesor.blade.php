<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Reporte por Profesor</title>
<style>body{font-family:Arial,sans-serif;font-size:12px;} h1{color:#4338ca;font-size:18px;} table{width:100%;border-collapse:collapse;margin-top:15px;} th,td{border:1px solid #ddd;padding:8px;text-align:center;} th{background:#f3f4f6;font-size:11px;text-transform:uppercase;} .header{text-align:center;margin-bottom:20px;} .winner{background:#fef9c3;}</style>
</head><body>
<div class="header">
    <h1>FICCT - Reporte por Profesor</h1>
    <p>{{ $gestion->nombre }} | Generado: {{ now()->format('d/m/Y H:i') }}</p>
</div>
@if(!empty($reporteData))
<p style="background:#fef9c3;padding:8px;border-radius:4px;">🏆 Mayor índice: <strong>{{ $reporteData[0]['profesor'] }}</strong> ({{ $reporteData[0]['porcentaje'] }}%)</p>
@endif
<table>
    <thead><tr><th>#</th><th>Profesor</th><th>Grupos</th><th>Total Alumnos</th><th>Aprobados</th><th>% Aprobación</th></tr></thead>
    <tbody>
        @foreach($reporteData as $i => $r)
        <tr class="{{ $i === 0 ? 'winner' : '' }}">
            <td>{{ $i + 1 }}</td>
            <td style="text-align:left;">{{ $r['profesor'] }}</td>
            <td>{{ $r['grupos'] }}</td>
            <td>{{ $r['total_alumnos'] }}</td>
            <td>{{ $r['aprobados'] }}</td>
            <td>{{ $r['porcentaje'] }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body></html>
