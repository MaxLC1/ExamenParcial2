<?php

namespace App\Modules\P3GestionAcademica\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['gestion_id', 'nombre', 'capacidad_maxima', 'aula'];

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function postulantes()
    {
        return $this->hasMany(Postulante::class);
    }

    public function grupoMaterias()
    {
        return $this->hasMany(GrupoMateria::class);
    }

    public function getCuposDisponiblesAttribute(): int
    {
        return $this->capacidad_maxima - $this->postulantes()->count();
    }
}
