<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje de Contacto - SandyDecor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #e91e63;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            color: #e91e63;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
        }
        .content {
            margin-bottom: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #e91e63;
            border-radius: 4px;
        }
        .field-label {
            font-weight: bold;
            color: #e91e63;
            margin-bottom: 5px;
            display: block;
        }
        .field-value {
            color: #333;
            word-wrap: break-word;
        }
        .message-content {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .timestamp {
            color: #999;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">🎁 SandyDecor</div>
            <div class="subtitle">Nuevo mensaje de contacto recibido</div>
        </div>

        <div class="content">
            <div class="field">
                <span class="field-label">Nombre completo:</span>
                <span class="field-value">{{ $contactData['nombre'] }}</span>
            </div>

            <div class="field">
                <span class="field-label">Correo electrónico:</span>
                <span class="field-value">{{ $contactData['email'] }}</span>
            </div>

            @if(!empty($contactData['telefono']))
            <div class="field">
                <span class="field-label">Teléfono:</span>
                <span class="field-value">{{ $contactData['telefono'] }}</span>
            </div>
            @endif

            <div class="field">
                <span class="field-label">Asunto:</span>
                <span class="field-value">
                    @switch($contactData['asunto'])
                        @case('consulta')
                            Consulta de producto
                            @break
                        @case('pedido')
                            Estado de mi pedido
                            @break
                        @case('soporte')
                            Soporte y ayuda
                            @break
                        @case('otro')
                            Otro
                            @break
                        @default
                            {{ $contactData['asunto'] }}
                    @endswitch
                </span>
            </div>

            <div class="field">
                <span class="field-label">Mensaje:</span>
                <div class="message-content">{{ $contactData['mensaje'] }}</div>
            </div>
        </div>

        <div class="footer">
            <p><strong>SandyDecor</strong> - Regalos que enamoran</p>
            <p>📧 soporte@sandydecor.com | 📞 098-123-4567</p>
            <p>🏠 Loja, Ecuador</p>
            <div class="timestamp">
                Mensaje recibido el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}
            </div>
        </div>
    </div>
</body>
</html>
