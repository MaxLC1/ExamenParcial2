<?php

namespace App\Modules\P3GestionAcademica\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'gestiones';

    protected $fillable = [
        'nombre', 'fecha_inicio', 'fecha_fin', 'estado',
        'cupo_informatica', 'cupo_sistemas', 'cupo_redes', 'cupo_robotica',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }

    public function postulantes()
    {
        return $this->hasMany(Postulante::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionCarrera::class);
    }
}
