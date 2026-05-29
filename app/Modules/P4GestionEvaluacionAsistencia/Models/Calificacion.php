<?php

namespace App\Modules\P4GestionEvaluacionAsistencia\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = ['examen_id', 'postulante_id', 'nota', 'observacion'];

    protected function casts(): array
    {
        return [
            'nota' => 'decimal:2',
        ];
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
