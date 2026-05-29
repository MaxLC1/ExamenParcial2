<?php

namespace App\Modules\P3GestionAcademica\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nombre', 'codigo', 'descripcion'];

    public function grupoMaterias()
    {
        return $this->hasMany(GrupoMateria::class);
    }
}
