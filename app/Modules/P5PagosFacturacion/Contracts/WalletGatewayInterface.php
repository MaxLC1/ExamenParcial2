<?php

namespace App\Modules\P5PagosFacturacion\Contracts;

interface WalletGatewayInterface
{
    /**
     * Verificar si una cartera digital tiene saldo suficiente.
     */
    public function verificarSaldo(string $walletId, float $monto): array;

    /**
     * Procesar un débito de la cartera digital.
     */
    public function procesarDebito(string $walletId, float $monto, string $referencia): array;

    /**
     * Consultar estado de una transacción.
     */
    public function consultarTransaccion(string $referencia): array;
}
