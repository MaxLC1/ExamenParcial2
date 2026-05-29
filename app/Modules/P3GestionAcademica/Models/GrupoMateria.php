<?php

namespace App\Modules\P3GestionAcademica\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMateria extends Model
{
    protected $table = 'grupo_materia';

    protected $fillable = [
        'grupo_id', 'materia_id', 'profesor_id', 'horario_id',
        'modalidad_clase', 'modalidad_examen',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function examenes()
    {
        return $this->hasMany(Examen::class);
    }
}
