<!DOCTYPE html>
<html lang="es" class="overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FICCT - UAGRM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-ficct-gray { background-color: #E2E6E9; } /* Color de fondo similar a la imagen */
    </style>
</head>
<body class="bg-ficct-gray text-gray-800 antialiased min-h-screen flex flex-col relative overflow-x-hidden w-full">

    <!-- Decoración de fondo (Círculo difuminado como en la imagen) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-0 right-0 w-1/2 h-[800px] bg-white opacity-40 rounded-l-full blur-3xl transform translate-x-1/3 -translate-y-20"></div>
    </div>

    <!-- NAVBAR -->
    <nav class="w-full px-4 lg:px-8 py-4 lg:py-5 flex items-center justify-between border-b border-gray-300 border-opacity-50">
        <!-- Logo -->
        <div class="flex items-center gap-1 sm:gap-2">
            <span class="text-xl sm:text-2xl font-black" style="color: #0A3254;">FICCT</span>
            <span class="text-gray-400">|</span>
            <span class="text-xs sm:text-sm font-semibold text-gray-500 tracking-wider">UAGRM</span>
        </div>

        <!-- Espacio central vacío para mantener la estructura de flex-between -->
        <div class="hidden lg:flex flex-1"></div>

        <!-- Right Side -->
        <div class="flex items-center gap-4">
            <button onclick="document.getElementById('modal-acceso').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-white font-semibold shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg border border-transparent" style="background-color: #D52B1E; border-color: #b82519;">
                Ingresar al Sistema
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </button>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <main class="flex-grow px-5 md:px-8 lg:px-20 pt-8 md:pt-12 pb-8 md:pb-12 w-full max-w-7xl mx-auto flex flex-col justify-center">
        <div class="flex items-center gap-3 mb-3 md:mb-4">
            <div class="w-6 md:w-8 h-[1px]" style="background-color: #0A3254;"></div>
            <span class="text-xs md:text-sm font-bold tracking-widest uppercase" style="color: #0A3254;">UAGRM — SANTA CRUZ</span>
        </div>

        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4 md:mb-6 max-w-4xl break-words" style="color: #1a2238;">
            Facultad de Ingeniería en<br>Ciencias de la Computación<br class="hidden md:block"> y Telecomunicaciones
        </h1>

        <p class="text-base sm:text-lg text-gray-600 max-w-2xl mb-6 md:mb-8 leading-relaxed">
            Formando profesionales altamente capacitados en computación, sistemas, redes y robótica desde 1987 en la Universidad Autónoma Gabriel René Moreno.
        </p>

        <div class="flex flex-col sm:flex-row flex-wrap gap-4 mb-8 md:mb-12">
            <a href="#" class="w-full sm:w-auto px-6 md:px-8 py-3 text-white font-semibold rounded shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5 flex justify-center items-center gap-2" style="background-color: #0A3254;">
                Conoce Nuestras Carreras
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="#" class="w-full sm:w-auto px-6 md:px-8 py-3 text-center text-gray-700 font-semibold rounded border border-gray-400 hover:bg-gray-200 transition-all">
                Conócenos
            </a>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 border-t border-gray-300 border-opacity-60 pt-10">
            <div>
                <div class="flex items-center gap-2 text-gray-500 font-semibold mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    CARRERAS
                </div>
                <div class="text-5xl font-bold" style="color: #0A3254;">4</div>
                <div class="text-sm text-gray-500 mt-1">Programas de pregrado</div>
            </div>
            <div>
                <div class="flex items-center gap-2 text-gray-500 font-semibold mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    ESTUDIANTES
                </div>
                <div class="text-5xl font-bold" style="color: #0A3254;">+5,000</div>
                <div class="text-sm text-gray-500 mt-1">Matrícula activa</div>
            </div>
            <div>
                <div class="flex items-center gap-2 text-gray-500 font-semibold mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    MAESTRÍAS
                </div>
                <div class="text-5xl font-bold" style="color: #0A3254;">3</div>
                <div class="text-sm text-gray-500 mt-1">Programas de posgrado</div>
            </div>
            <div>
                <div class="flex items-center gap-2 text-gray-500 font-semibold mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    FUNDACIÓN
                </div>
                <div class="text-5xl font-bold" style="color: #0A3254;">2012</div>
                <div class="text-sm text-gray-500 mt-1">Primera de su tipo en Bolivia</div>
            </div>
        </div>
    </main>

    <!-- MODAL CAMPUS VIRTUAL -->
    <div id="modal-acceso" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm" onclick="document.getElementById('modal-acceso').classList.add('hidden')"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-8 py-6 flex justify-between items-center" style="background-color: #0A3254;">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Acceso al Campus Virtual
                </h3>
                <button onclick="document.getElementById('modal-acceso').classList.add('hidden')" class="text-gray-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50">
                <!-- Opción Postulante -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4 text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Soy Nuevo Postulante</h4>
                    <p class="text-sm text-gray-500 mb-6">Regístrate para iniciar tu proceso de admisión a la FICCT.</p>
                    <a href="{{ route('postulante.registro') }}" class="block w-full py-2.5 text-white font-bold rounded-lg transition-colors" style="background-color: #D52B1E;" onmouseover="this.style.backgroundColor='#b82519'" onmouseout="this.style.backgroundColor='#D52B1E'">
                        Comenzar Registro
                    </a>
                </div>

                <!-- Opción Usuario -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl text-center hover:shadow-lg transition-all">
                    <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4 text-blue-800">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Ya tengo cuenta</h4>
                    <p class="text-sm text-gray-500 mb-6">Ingresa si eres administrativo, docente o postulante registrado.</p>
                    <a href="{{ route('login') }}" class="block w-full py-2.5 text-white font-bold rounded-lg transition-colors" style="background-color: #0A3254;" onmouseover="this.style.backgroundColor='#072440'" onmouseout="this.style.backgroundColor='#0A3254'">
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
