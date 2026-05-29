<?php

namespace App\Modules\P5PagosFacturacion\Services;

use App\Modules\P5PagosFacturacion\Contracts\WalletGatewayInterface;
use App\Modules\P5PagosFacturacion\Models\Pago;
use App\Modules\P2GestionProfesoresPostulantes\Models\Postulante;
use Illuminate\Support\Str;

class PagoService
{
    protected WalletGatewayInterface $gateway;

    public function __construct(WalletGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Procesar pago de inscripción con cartera digital.
     */
    public function procesarPago(Postulante $postulante, string $walletId, float $monto): array
    {
        // Verificar si ya tiene un pago completado
        $pagoExistente = Pago::where('postulante_id', $postulante->id)
            ->where('estado', 'completado')
            ->first();

        if ($pagoExistente) {
            return ['success' => false, 'message' => 'Ya se registró un pago para este postulante.'];
        }

        $referencia = 'FICCT-' . strtoupper(Str::random(10));

        // Crear registro de pago pendiente
        $pago = Pago::create([
            'postulante_id' => $postulante->id,
            'gestion_id' => $postulante->gestion_id,
            'monto' => $monto,
            'referencia_transaccion' => $referencia,
            'metodo_pago' => 'cartera_digital',
            'estado' => 'procesando',
            'wallet_id' => $walletId,
        ]);

        // === SIMULACIÓN DE VALIDACIÓN PAYPAL (PARA LA PRESENTACIÓN) ===
        // Si el correo es "error@paypal.com" simulamos que la cuenta no existe
        if ($walletId === 'error@paypal.com') {
            $pago->update(['estado' => 'fallido', 'metadata' => ['motivo' => 'Cuenta inexistente']]);
            return ['success' => false, 'message' => 'La cuenta de PayPal asociada a este correo no existe o está inactiva.'];
        }
        
        // Si el correo es "sinfondos@paypal.com" simulamos que no tiene saldo
        if ($walletId === 'sinfondos@paypal.com') {
            $pago->update(['estado' => 'fallido', 'metadata' => ['motivo' => 'Fondos insuficientes']]);
            return ['success' => false, 'message' => 'Transacción rechazada por PayPal: Fondos insuficientes en la cartera.'];
        }

        // Verificar saldo (Llamada original a la pasarela)
        $verificacion = $this->gateway->verificarSaldo($walletId, $monto);
        if (!$verificacion['success']) {
            $pago->update(['estado' => 'fallido']);
            return ['success' => false, 'message' => $verificacion['message'] ?? 'Saldo insuficiente.'];
        }

        // Procesar débito
        $resultado = $this->gateway->procesarDebito($walletId, $monto, $referencia);

        if ($resultado['success']) {
            $pago->update([
                'estado' => 'completado',
                'fecha_pago' => now(),
                'metadata' => $resultado,
            ]);

            $postulante->update(['estado' => 'pagado']);

            return [
                'success' => true,
                'message' => 'Pago procesado exitosamente.',
                'pago' => $pago->fresh(),
                'referencia' => $referencia,
            ];
        }

        $pago->update(['estado' => 'fallido', 'metadata' => $resultado]);
        return ['success' => false, 'message' => $resultado['message'] ?? 'Error al procesar el pago.'];
    }
}
