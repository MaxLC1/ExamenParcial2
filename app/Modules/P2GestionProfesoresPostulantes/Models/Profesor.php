<?php

namespace App\Modules\P2GestionProfesoresPostulantes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\P1GestionUsuarioSeguridad\Models\User;
use App\Modules\P3GestionAcademica\Models\GrupoMateria;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $fillable = [
        'user_id', 'ci', 'nombre', 'apellido', 'especialidad',
        'titulo_profesional', 'maestria', 'diplomado_educacion_superior',
        'telefono', 'activo'
    ];

    protected function casts(): array
    {
        return [
            'maestria' => 'boolean',
            'diplomado_educacion_superior' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupoMaterias()
    {
        return $this->hasMany(GrupoMateria::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Cantidad de grupos asignados actualmente.
     */
    public function cantidadGrupos(): int
    {
        return $this->grupoMaterias()->distinct('grupo_id')->count('grupo_id');
    }
}
