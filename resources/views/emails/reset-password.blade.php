<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Sofía Floristería</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

                    <!-- Logo Header -->
                    <tr>
                        <td align="center" style="padding: 40px 20px; background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%);">
                            <img src="{{ asset('storage/flowers/logo.webp') }}" alt="Sofía Floristería" style="max-width: 150px; height: auto;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 40px 20px;">
                            <h1 style="margin: 0 0 20px; font-size: 24px; font-weight: bold; color: #1f2937;">
                                Restablecer Contraseña
                            </h1>
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6; color: #4b5563;">
                                Hola,
                            </p>
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6; color: #4b5563;">
                                Recibiste este correo porque solicitaste restablecer tu contraseña para tu cuenta en <strong>Sofía Floristería</strong>.
                            </p>
                            <p style="margin: 0 0 30px; font-size: 16px; line-height: 1.6; color: #4b5563;">
                                Haz clic en el botón de abajo para restablecer tu contraseña:
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <a href="{{ $url }}"
                                           style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); color: #ffffff; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.3);">
                                            Restablecer Contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 20px; font-size: 14px; line-height: 1.6; color: #6b7280;">
                                Este enlace expirará en <strong>{{ Config::get('auth.passwords.'.Config::get('auth.defaults.passwords').'.expire') }} minutos</strong>.
                            </p>

                            <p style="margin: 20px 0; font-size: 14px; line-height: 1.6; color: #6b7280;">
                                Si no solicitaste restablecer tu contraseña, puedes ignorar este correo de forma segura.
                            </p>
                        </td>
                    </tr>

                    <!-- Link alternativo -->
                    <tr>
                        <td style="padding: 0 40px 40px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 20px 0 10px; font-size: 12px; color: #9ca3af;">
                                Si tienes problemas haciendo clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu navegador:
                            </p>
                            <p style="margin: 0; font-size: 12px; word-break: break-all; color: #6b7280;">
                                <a href="{{ $url }}" style="color: #ec4899; text-decoration: underline;">{{ $url }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9fafb; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; font-size: 14px; color: #6b7280;">
                                © {{ date('Y') }} <strong style="color: #ec4899;">Sofía Floristería</strong>
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                Calle 16 # 2-48, Neiva - Huila
                            </p>
                            <p style="margin: 10px 0 0; font-size: 12px; color: #9ca3af;">
                                <a href="tel:+573177261647" style="color: #ec4899; text-decoration: none;">+57 317 726 1647</a> •
                                <a href="mailto:fraysury18@gmail.com" style="color: #ec4899; text-decoration: none;">fraysury18@gmail.com</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
