<?php

namespace App\Modules\P5PagosFacturacion\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use App\Modules\P5PagosFacturacion\Models\Pago;
use App\Modules\P5PagosFacturacion\Services\PagoService;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function formulario(Request $request)
    {
        $postulante = $request->user()->postulante;

        if (!$postulante || !in_array($postulante->estado, ['inscrito', 'pagado', 'en_curso', 'aprobado', 'reprobado', 'asignado', 'rechazado'])) {
            return redirect()->route('dashboard')->with('error', 'No puede realizar ni ver el pago en este estado.');
        }

        $pagoCompletado = Pago::where('postulante_id', $postulante->id)->where('estado', 'completado')->first();

        return view('postulante.pago', compact('postulante', 'pagoCompletado'));
    }

    public function procesar(Request $request)
    {
        $validated = $request->validate([
            'wallet_id' => 'required|email|max:100',
        ]);

        $postulante = $request->user()->postulante;
        if (!$postulante) {
            return back()->with('error', 'No se encontró su registro de postulante.');
        }

        $pagoService = app(PagoService::class);
        $resultado = $pagoService->procesarPago($postulante, $validated['wallet_id'], 250.00);

        if ($resultado['success']) {
            return redirect()->route('postulante.pago')->with('success', $resultado['message']);
        }

        return back()->with('error', $resultado['message']);
    }

    public function historial(Request $request)
    {
        $pagos = Pago::with(['postulante', 'gestion'])->orderByDesc('created_at')->paginate(20);
        return view('pagos.historial', compact('pagos'));
    }

    public function destroy(Pago $pago)
    {
        // Revertir el estado del postulante si se elimina su pago
        if ($pago->postulante && $pago->postulante->estado === 'pagado') {
            $pago->postulante->update(['estado' => 'inscrito']);
        }
        
        $pago->delete();
        return redirect()->route('pagos.historial')->with('success', 'Pago eliminado correctamente. El postulante volvió a estado pendiente de pago.');
    }
}
