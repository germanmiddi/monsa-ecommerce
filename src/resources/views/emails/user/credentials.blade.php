<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de acceso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px 20px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .credentials-box {
            background-color: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .credential-item {
            margin: 10px 0;
            padding: 10px;
            background-color: white;
            border-radius: 4px;
            border: 1px solid #d1d5db;
        }
        .credential-label {
            font-weight: bold;
            color: #374151;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            color: #111827;
            margin-top: 5px;
            word-break: break-all;
        }
        .login-button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .login-button:hover {
            background-color: #4338ca;
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #92400e;
        }
        .security-tip {
            background-color: #ecfccb;
            border: 1px solid #65a30d;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #365314;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a {{ config('app.name') }}!</h1>
            <p>Tu cuenta ha sido creada exitosamente</p>
        </div>

        <div class="content">
            <p>Estimado/a <strong>{{ $user->name }}</strong>,</p>

            <p>Se ha creado una cuenta de acceso para ti en el sistema de administración de <strong>{{ config('app.name') }}</strong>.</p>

            <div class="credentials-box">
                <h3 style="margin-top: 0; color: #374151;">📋 Credenciales de Acceso</h3>

                <div class="credential-item">
                    <div class="credential-label">🌐 URL de Acceso</div>
                    <div class="credential-value">{{ $loginUrl }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">👤 Usuario (Email)</div>
                    <div class="credential-value">{{ $user->email }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">🔑 Contraseña</div>
                    <div class="credential-value">{{ $password }}</div>
                </div>

                <a href="{{ $loginUrl }}" class="login-button">
                    🚀 Acceder al Sistema
                </a>
            </div>

            {{-- <div class="warning">
                <strong>⚠️ Importante:</strong> Esta es una contraseña temporal. Por seguridad, te recomendamos cambiarla en tu primer acceso al sistema.
            </div> --}}

            <div class="security-tip">
                <strong>🔒 Consejos de Seguridad:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    {{-- <li>Cambia tu contraseña inmediatamente después del primer acceso</li> --}}
                    <li>Usa una contraseña segura con al menos 8 caracteres</li>
                    <li>No compartas estas credenciales con terceros</li>
                    <li>Cierra siempre tu sesión al terminar de usar el sistema</li>
                </ul>
            </div>

            <p>¡Esperamos que tengas una excelente experiencia usando nuestro sistema!</p>

            <p>Saludos cordiales,<br>
            <strong>El equipo de {{ config('app.name') }}</strong></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            <p>Este correo contiene información confidencial. Si no eres el destinatario, por favor elimínalo.</p>
        </div>
    </div>
</body>
</html>
