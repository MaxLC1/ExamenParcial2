<?php

namespace App\Services;

use App\Modules\P3GestionAcademica\Models\GrupoMateria;
use App\Modules\P2GestionProfesoresPostulantes\Models\Profesor;
use App\Modules\P4GestionEvaluacionAsistencia\Models\Horario;

class HorarioService
{
    public function tieneConflictoProfesor(int $profesorId, int $horarioId, ?int $excluirId = null): bool
    {
        $q = GrupoMateria::where('profesor_id', $profesorId)->where('horario_id', $horarioId);
        if ($excluirId) $q->where('id', '!=', $excluirId);
        return $q->exists();
    }

    public function excedeGruposProfesor(int $profesorId, int $max = 5): bool
    {
        return GrupoMateria::where('profesor_id', $profesorId)->distinct('grupo_id')->count('grupo_id') >= $max;
    }
}
