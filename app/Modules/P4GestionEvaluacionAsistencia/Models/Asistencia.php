<?php

namespace App\Modules\P4GestionEvaluacionAsistencia\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'grupo_materia_id',
        'postulante_id',
        'fecha',
        'estado',
        'observacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function grupoMateria()
    {
        return $this->belongsTo(GrupoMateria::class);
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
