<?php

namespace App\Modules\P3GestionAcademica\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = ['nombre', 'codigo', 'descripcion'];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionCarrera::class);
    }
}
