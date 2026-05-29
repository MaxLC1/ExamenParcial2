<?php

namespace App\Modules\P2GestionProfesoresPostulantes\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $fillable = [
        'user_id', 'gestion_id', 'ci', 'nombre', 'apellido_paterno', 'apellido_materno',
        'fecha_nacimiento', 'sexo', 'telefono', 'direccion', 'colegio_procedencia', 'ciudad', 'titulo_bachiller', 'estado', 'grupo_id',
        'primera_opcion_carrera_id', 'segunda_opcion_carrera_id',
        'tercera_opcion_carrera_id', 'cuarta_opcion_carrera_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'titulo_bachiller' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function asignacionCarrera()
    {
        return $this->hasOne(AsignacionCarrera::class);
    }

    public function primeraOpcion()
    {
        return $this->belongsTo(Carrera::class, 'primera_opcion_carrera_id');
    }

    public function segundaOpcion()
    {
        return $this->belongsTo(Carrera::class, 'segunda_opcion_carrera_id');
    }

    public function terceraOpcion()
    {
        return $this->belongsTo(Carrera::class, 'tercera_opcion_carrera_id');
    }

    public function cuartaOpcion()
    {
        return $this->belongsTo(Carrera::class, 'cuarta_opcion_carrera_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        $nombre = "{$this->nombre} {$this->apellido_paterno}";
        if ($this->apellido_materno) {
            $nombre .= " {$this->apellido_materno}";
        }
        return $nombre;
    }
}
