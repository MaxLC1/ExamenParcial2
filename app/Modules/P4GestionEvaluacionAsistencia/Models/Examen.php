<?php

namespace App\Modules\P4GestionEvaluacionAsistencia\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\P3GestionAcademica\Models\GrupoMateria;

class Examen extends Model
{
    protected $table = 'examenes';

    protected $fillable = [
        'grupo_materia_id', 'tipo', 'puntaje_maximo',
        'fecha', 'hora_inicio', 'hora_fin', 'aula_examen', 'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function grupoMateria()
    {
        return $this->belongsTo(GrupoMateria::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    /**
     * Obtener el puntaje máximo según el tipo.
     */
    public static function puntajeMaximoPorTipo(string $tipo): int
    {
        return 100;
    }
}
