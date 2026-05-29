<?php

namespace App\Gateways;

use App\Modules\P5PagosFacturacion\Contracts\WalletGatewayInterface;
use Illuminate\Support\Str;

/**
 * Simulación de pasarela de pago de cartera digital.
 * Reproduce el flujo real para desarrollo y pruebas.
 */
class FakeWalletGateway implements WalletGatewayInterface
{
    public function verificarSaldo(string $walletId, float $monto): array
    {
        // Simular wallets con saldo
        // Cualquier wallet_id que empiece con "VALID" tiene saldo
        if (str_starts_with(strtoupper($walletId), 'VALID') || strlen($walletId) >= 8) {
            return [
                'success' => true,
                'saldo_disponible' => 1000.00,
                'suficiente' => true,
                'wallet_id' => $walletId,
            ];
        }

        return [
            'success' => false,
            'message' => 'Cartera digital no encontrada o saldo insuficiente.',
            'wallet_id' => $walletId,
        ];
    }

    public function procesarDebito(string $walletId, float $monto, string $referencia): array
    {
        $verificacion = $this->verificarSaldo($walletId, $monto);

        if (!$verificacion['success']) {
            return [
                'success' => false,
                'message' => 'No se pudo procesar el débito: saldo insuficiente.',
                'referencia' => $referencia,
            ];
        }

        return [
            'success' => true,
            'message' => 'Débito procesado exitosamente.',
            'referencia' => $referencia,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
            'monto_debitado' => $monto,
            'fecha' => now()->toIso8601String(),
        ];
    }

    public function consultarTransaccion(string $referencia): array
    {
        return [
            'success' => true,
            'referencia' => $referencia,
            'estado' => 'completado',
            'fecha' => now()->toIso8601String(),
        ];
    }
}
