<?php

namespace App\Modules\P3GestionAcademica\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionCarrera extends Model
{
    protected $table = 'asignaciones_carrera';

    protected $fillable = [
        'postulante_id', 'carrera_id', 'gestion_id',
        'opcion_numero', 'nota_promedio_general', 'estado',
    ];

    protected function casts(): array
    {
        return [
            'nota_promedio_general' => 'decimal:2',
        ];
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }
}
