<?php

namespace App\Modules\P5PagosFacturacion\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'postulante_id', 'gestion_id', 'monto', 'referencia_transaccion',
        'metodo_pago', 'estado', 'wallet_id', 'metadata', 'fecha_pago',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'metadata' => 'array',
            'fecha_pago' => 'datetime',
        ];
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }
}
