<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background-color: #F3F4F6; min-height: 100vh; display: flex; flex-direction: column; margin: 0;">
        <!-- Cabecera Institucional Superior -->
        <div style="width: 100%; padding: 20px 0; display: flex; align-items: center; justify-content: center; gap: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); background-color: #0A3254;">
            <img src="{{ asset('img/escudo.png') }}" alt="Escudo FICCT CUP" style="width: auto; height: 60px; object-fit: contain;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 36px; font-weight: 900; color: #ffffff; letter-spacing: 1px;">FICCT</span>
                <span style="color: #6b7280; font-size: 28px; font-weight: 300;">|</span>
                <span style="font-size: 28px; font-weight: 600; letter-spacing: 2px; color: #9ca3af;">UAGRM</span>
            </div>
        </div>

        <!-- Contenedor Principal (Fondo claro) -->
        <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-size: 32px; font-weight: 800; color: #111827; margin: 0;">Iniciar Sesión</h2>
                <p style="margin-top: 8px; font-size: 18px; font-weight: 500; color: #4B5563;">Sistema de Admisión Preuniversitario</p>
            </div>

            <!-- CUADRO BLANCO (Tarjeta de Login) -->
            <div style="width: 100%; max-width: 500px; padding: 40px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border-top: 5px solid #D52B1E;">
                <div style="font-size: 16px;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
