<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Postulante - FICCT</title>
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
            border-top: 5px solid #D52B1E;
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
            background-color: #FEF3C7;
            border: 1.5px solid #F59E0B;
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
            color: #92400E;
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
            background-color: #D52B1E;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(213, 43, 30, 0.35);
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
        <img src="https://www.ficct.uagrm.edu.bo:3000/uploads/faculty/Escudo_FICCT.png" alt="Escudo FICCT">
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
            <h2>Registro de Postulante</h2>
            <p>{{ $gestionActual->nombre }} — Sistema de Admisión Preuniversitario</p>
        </div>

        <!-- Tarjeta del Formulario -->
        <div class="form-card">
            @if(session('error'))
                <div class="alert-error">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('postulante.registrar') }}">
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
                        <label>Apellido Paterno <span class="required">*</span></label>
                        <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" placeholder="Ingrese su apellido paterno" required>
                    </div>
                    <div class="field-group">
                        <label>Apellido Materno</label>
                        <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" placeholder="Ingrese su apellido materno">
                    </div>
                    <div class="field-group">
                        <label>Fecha de Nacimiento <span class="required">*</span></label>
                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                    </div>
                    <div class="field-group">
                        <label>Sexo <span class="required">*</span></label>
                        <select name="sexo" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 70012345">
                    </div>
                    <div class="field-group">
                        <label>Ciudad <span class="required">*</span></label>
                        <input type="text" name="ciudad" value="{{ old('ciudad') }}" placeholder="Ej: Santa Cruz" required>
                    </div>
                    <div class="field-group field-full">
                        <label>Colegio de Procedencia <span class="required">*</span></label>
                        <input type="text" name="colegio_procedencia" value="{{ old('colegio_procedencia') }}" placeholder="Nombre del colegio donde se graduó" required>
                    </div>
                    <div class="field-group field-full">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Dirección de domicilio actual">
                    </div>
                    <div class="field-full">
                        <div class="checkbox-group">
                            <input type="checkbox" name="titulo_bachiller" value="1" id="titulo_bachiller" required>
                            <span>Confirmo que poseo <strong>Título de Bachiller</strong> (Requisito Obligatorio)</span>
                        </div>
                    </div>
                </div>

                <!-- ═══ PREFERENCIA DE CARRERAS ═══ -->
                <div class="section-title section-spacing">
                    <span class="icon">🎓</span>
                    Preferencia de Carreras (ordene de 1ª a 3ª opción)
                </div>
                @foreach(['primera' => '1ª Opción', 'segunda' => '2ª Opción', 'tercera' => '3ª Opción'] as $key => $label)
                    <div class="field-group" style="margin-bottom: 14px;">
                        <label>{{ $label }} <span class="required">*</span></label>
                        <select name="{{ $key }}_opcion_carrera_id" required>
                            <option value="">Seleccione una carrera...</option>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}" {{ old($key.'_opcion_carrera_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                        @error($key.'_opcion_carrera_id') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                @endforeach

                <!-- ═══ CREDENCIALES DE ACCESO ═══ -->
                <div class="section-title section-spacing">
                    <span class="icon">🔐</span>
                    Credenciales de Acceso
                </div>
                <div class="fields-grid">
                    <div class="field-group field-full">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                        @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="field-group">
                        <label>Contraseña <span class="required">*</span></label>
                        <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="field-group">
                        <label>Confirmar Contraseña <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" placeholder="Repita su contraseña" required>
                    </div>
                </div>

                <!-- ═══ FOOTER ═══ -->
                <div class="form-footer">
                    <a href="{{ route('login') }}">← ¿Ya tiene cuenta? Iniciar sesión</a>
                    <button type="submit" class="btn-submit">Registrarme</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
