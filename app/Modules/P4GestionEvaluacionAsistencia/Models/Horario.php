<?php

namespace App\Modules\P4GestionEvaluacionAsistencia\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin', 'aula'];

    public function grupoMaterias()
    {
        return $this->hasMany(GrupoMateria::class);
    }

    public function getDescripcionAttribute(): string
    {
        return ucfirst($this->dia) . " {$this->hora_inicio} - {$this->hora_fin}";
    }
}
