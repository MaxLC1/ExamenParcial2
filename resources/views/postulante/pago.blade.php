<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Pago de Inscripción</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif
            @if($pagoCompletado)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="font-semibold text-green-800 text-lg">✅ Pago Completado</h3>
                    <p class="text-green-700 mt-2">Referencia: {{ $pagoCompletado->referencia_transaccion }}</p>
                    <p class="text-green-700">Monto: Bs. {{ number_format($pagoCompletado->monto, 2) }}</p>
                    <p class="text-green-700">Fecha: {{ $pagoCompletado->fecha_pago->format('d/m/Y H:i') }}</p>
                </div>
            @else
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-blue-800 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zM8.216 2.667l-2.483 15.65h3.04l.955-6.059c.082-.519.526-.901 1.05-.901h1.583c3.087 0 5.568-1.077 6.273-4.693.364-1.874.153-3.08-1.054-3.95-1.126-1.066-2.92-1.39-5.321-1.39H8.216z"/></svg>
                            Pago seguro con PayPal
                        </h3>
                        <p class="text-3xl font-bold text-gray-800 mt-2">Bs. 250.00</p>
                        <p class="text-sm text-gray-500 mt-1">Inscripción al curso preparatorio FICCT</p>
                    </div>
                    <form id="pago-form" method="POST" action="{{ route('postulante.pago.procesar') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Correo asociado a PayPal</label>
                            <input type="email" id="paypal-email" name="wallet_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="ejemplo@correo.com" required minlength="8" oninvalid="this.setCustomValidity('Por favor, ingresa un correo válido que incluya un @')" oninput="this.setCustomValidity('')">
                            @error('wallet_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <p class="text-xs text-gray-400 mb-4 text-center">Solo se aceptan pagos mediante pasarela internacional PayPal. (No QR, No Efectivo).</p>
                        <button type="button" onclick="abrirPasarela()" class="w-full bg-[#0070ba] text-white py-3 rounded-md hover:bg-[#003087] font-semibold transition">Pagar con PayPal</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Simulado de PayPal -->
    <div id="paypal-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm overflow-hidden animate-pulse-once">
            <div class="bg-gray-100 p-4 border-b text-center">
                <svg class="w-8 h-8 text-[#0070ba] mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zM8.216 2.667l-2.483 15.65h3.04l.955-6.059c.082-.519.526-.901 1.05-.901h1.583c3.087 0 5.568-1.077 6.273-4.693.364-1.874.153-3.08-1.054-3.95-1.126-1.066-2.92-1.39-5.321-1.39H8.216z"/></svg>
                <h3 class="font-bold text-gray-800 mt-2">Pagar con PayPal</h3>
            </div>
            <div id="paypal-content" class="p-6">
                <p class="text-sm text-gray-600 mb-4 text-center">Inicia sesión en tu cuenta para completar el pago de <strong>Bs. 250.00</strong> a la Universidad.</p>
                <input type="password" placeholder="Contraseña de PayPal" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 mb-4" required oninvalid="this.setCustomValidity('Por favor, ingresa tu contraseña de PayPal.')" oninput="this.setCustomValidity('')">
                <button type="button" onclick="procesarPago()" class="w-full bg-[#0070ba] text-white py-2 rounded-md hover:bg-[#003087] font-semibold transition">Iniciar Sesión y Pagar</button>
                <button type="button" onclick="cerrarPasarela()" class="w-full text-center text-sm text-gray-500 mt-3 hover:underline">Cancelar y volver</button>
            </div>
            <div id="paypal-loading" class="p-6 hidden text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#0070ba] mb-4"></div>
                <p class="text-gray-600">Procesando transacción segura...</p>
            </div>
            
            <div id="paypal-success" class="p-6 hidden text-center">
                <svg class="w-16 h-16 text-green-500 mx-auto mb-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-green-600 font-bold text-lg">¡Pago Realizado Exitosamente!</p>
                <p class="text-gray-500 text-sm mt-1">Redirigiendo...</p>
            </div>
        </div>
    </div>

    <script>
        function abrirPasarela() {
            const email = document.getElementById('paypal-email').value;
            if(!email || !email.includes('@')) {
                alert('Por favor ingrese un correo válido de PayPal antes de continuar.');
                return;
            }
            document.getElementById('paypal-modal').classList.remove('hidden');
            document.getElementById('paypal-modal').classList.add('flex');
        }
        function cerrarPasarela() {
            document.getElementById('paypal-modal').classList.add('hidden');
            document.getElementById('paypal-modal').classList.remove('flex');
        }
        function procesarPago() {
            document.getElementById('paypal-content').classList.add('hidden');
            document.getElementById('paypal-loading').classList.remove('hidden');
            
            // Simular el tiempo de conexión a la API de PayPal
            setTimeout(() => {
                document.getElementById('paypal-loading').classList.add('hidden');
                document.getElementById('paypal-success').classList.remove('hidden');
                
                // Dar tiempo para que el usuario vea la animación de éxito
                setTimeout(() => {
                    document.getElementById('pago-form').submit();
                }, 1500);
            }, 2000);
        }
    </script>
</x-app-layout>
