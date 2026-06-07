<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Postulación de Docentes - FICCT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #F3F4F6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #111827;
        }

        /* Cabecera institucional */
        .header-bar {
            width: 100%;
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            background-color: #0A3254;
        }
        .header-bar img { width: 75px; height: auto; object-fit: contain; }
        .header-bar .brand { display: flex; align-items: center; gap: 12px; }
        .header-bar .brand-name { font-size: 36px; font-weight: 900; color: #ffffff; letter-spacing: 1px; }
        .header-bar .brand-sep { color: #6b7280; font-size: 28px; font-weight: 300; }
        .header-bar .brand-sub { font-size: 28px; font-weight: 600; letter-spacing: 2px; color: #9ca3af; }

        /* Contenedor principal */
        .main-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
        }

        /* Título */
        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .page-title h2 {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
        }
        .page-title p {
            margin-top: 8px;
            font-size: 18px;
            font-weight: 500;
            color: #4B5563;
        }

        /* Tarjeta del formulario */
        .form-card {
            width: 100%;
            max-width: 720px;
            padding: 40px 44px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-top: 5px solid #0A3254; /* Color cambiado para diferenciarlo de postulante */
        }

        /* Secciones del formulario */
        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #0A3254;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background-color: #0A3254;
            color: #ffffff;
            font-size: 14px;
        }

        .section-spacing { margin-top: 32px; }

        /* Grid para campos */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 20px;
        }
        .field-full { grid-column: 1 / -1; }

        /* Campos del formulario */
        .field-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }
        .field-group label .required { color: #D52B1E; margin-left: 2px; }

        .field-group input[type="text"],
        .field-group input[type="email"],
        .field-group input[type="date"],
        .field-group input[type="password"],
        .field-group select {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1.5px solid #D1D5DB;
            border-radius: 8px;
            background-color: #F9FAFB;
            color: #111827;
            transition: all 0.2s ease;
            outline: none;
            font-family: 'Figtree', sans-serif;
        }
        .field-group input:focus,
        .field-group select:focus {
            border-color: #0A3254;
            box-shadow: 0 0 0 3px rgba(10, 50, 84, 0.12);
            background-color: #ffffff;
        }
        .field-group .error-msg {
            font-size: 12px;
            color: #DC2626;
            margin-top: 4px;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            background-color: #E0F2FE;
            border: 1.5px solid #0284C7;
            border-radius: 8px;
            margin-top: 4px;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #0A3254;
            cursor: pointer;
            flex-shrink: 0;
        }
        .checkbox-group span {
            font-size: 13px;
            font-weight: 500;
            color: #075985;
        }

        /* Alerta de error */
        .alert-error {
            padding: 12px 16px;
            background-color: #FEE2E2;
            border: 1.5px solid #FCA5A5;
            border-radius: 8px;
            color: #991B1B;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Footer del formulario */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
        }
        .form-footer a {
            font-size: 14px;
            color: #0A3254;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .form-footer a:hover {
            color: #D52B1E;
            text-decoration: underline;
        }

        /* Botón principal */
        .btn-submit {
            padding: 12px 32px;
            background-color: #0A3254;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s ease;
            letter-spacing: 0.5px;
            font-family: 'Figtree', sans-serif;
        }
        .btn-submit:hover {
            background-color: #072440;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(10, 50, 84, 0.35);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .fields-grid { grid-template-columns: 1fr; }
            .form-card { padding: 28px 20px; }
            .header-bar .brand-name { font-size: 28px; }
            .header-bar .brand-sub { font-size: 22px; }
            .form-footer { flex-direction: column; gap: 16px; }
        }
    </style>
</head>
<body>
    <!-- Cabecera Institucional -->
    <div class="header-bar">
        <img src="{{ asset('img/escudo.png') }}" alt="Escudo FICCT CUP" style="height: 60px; width: auto;">
        <div class="brand">
            <span class="brand-name">FICCT</span>
            <span class="brand-sep">|</span>
            <span class="brand-sub">UAGRM</span>
        </div>
    </div>

    <!-- Contenedor Principal -->
    <div class="main-container">
        <!-- Título -->
        <div class="page-title">
            <h2>Postulación de Docentes</h2>
            <p>Sistema Académico de Cursos Preuniversitarios</p>
        </div>

        <!-- Tarjeta del Formulario -->
        <div class="form-card">
            @if(session('error'))
                <div class="alert-error">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('profesor.registrar') }}">
                @csrf

                <!-- ═══ DATOS PERSONALES ═══ -->
                <div class="section-title">
                    <span class="icon">👤</span>
                    Datos Personales
                </div>
                <div class="fields-grid">
                    <div class="field-group">
                        <label>CI <span class="required">*</span></label>
                        <input type="text" name="ci" value="{{ old('ci') }}" placeholder="Ej: 12345678" required>
                        @error('ci') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="field-group">
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="field-group">
                        <label>Apellidos <span class="required">*</span></label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Ingrese sus apellidos" required>
                    </div>
                    <div class="field-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 70012345">
                    </div>
                </div>

                <!-- ═══ PERFIL PROFESIONAL ═══ -->
                <div class="section-title section-spacing">
                    <span class="icon">💼</span>
                    Perfil Profesional
                </div>
                <div class="fields-grid">
                    <div class="field-group field-full">
                        <label>Título Universitario <span class="required">*</span></label>
                        <input type="text" name="titulo_profesional" value="{{ old('titulo_profesional') }}" placeholder="Ej: Lic. en Ingeniería Informática" required>
                        @error('titulo_profesional') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="field-group field-full">
                        <label>Especialidad <span class="required">*</span></label>
                        <select name="especialidad" required>
                            <option value="">Seleccione su especialidad...</option>
                            <option value="Inglés" {{ old('especialidad') == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                            <option value="Matemáticas" {{ old('especialidad') == 'Matemáticas' ? 'selected' : '' }}>Matemáticas</option>
                            <option value="Física" {{ old('especialidad') == 'Física' ? 'selected' : '' }}>Física</option>
                            <option value="Computación" {{ old('especialidad') == 'Computación' ? 'selected' : '' }}>Computación</option>
                        </select>
                        @error('especialidad') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="field-full">
                        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                            <label class="inline-flex items-center" style="cursor: pointer; background-color: #f8fafc; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <input type="checkbox" name="maestria" value="1" {{ old('maestria') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Posee Grado de Maestría</span>
                            </label>
                            
                            <label class="inline-flex items-center" style="cursor: pointer; background-color: #f8fafc; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <input type="checkbox" name="diplomado_educacion_superior" value="1" {{ old('diplomado_educacion_superior') ? 'checked' : '' }} required class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Posee Título de Educación (Diplomado en Educación Superior) <span class="required" style="color: #D52B1E;">*</span></span>
                            </label>
                        </div>
                        @error('diplomado_educacion_superior') <p class="error-msg" style="margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- ═══ CREDENCIALES DE ACCESO ═══ -->
                <div class="section-title section-spacing">
                    <span class="icon">🔐</span>
                    Credenciales de Acceso
                </div>
                <div class="fields-grid">
                    <div class="field-group field-full">
                        <label>Email Institucional o Personal <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                        @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="field-group">
                        <label>Contraseña <span class="required">*</span></label>
                        <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
                        @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="field-group">
                        <label>Confirmar Contraseña <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" placeholder="Repita su contraseña" required>
                    </div>
                </div>

                <!-- ═══ FOOTER ═══ -->
                <div class="form-footer">
                    <a href="{{ route('login') }}">← ¿Ya tiene cuenta? Iniciar sesión</a>
                    <button type="submit" class="btn-submit">Enviar Postulación</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
