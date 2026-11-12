<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestablecerContrasena extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $token,
        public readonly string $tipoCuenta
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $broker = $this->tipoCuenta === 'empresa' ? 'empresas' : 'users';
        $nombre = $this->tipoCuenta === 'empresa'
            ? ($notifiable->nombreEmpresa ?? 'equipo')
            : trim(($notifiable->nombres ?? '') . ' ' . ($notifiable->apellidos ?? ''));

        return (new MailMessage)
            ->subject('Restablece tu contraseña | Málaga Emplea')
            ->greeting('Hola' . ($nombre ? ', ' . $nombre : '') . '.')
            ->line('Recibimos una solicitud para crear una nueva contraseña para tu cuenta de Málaga Emplea.')
            ->action('Crear nueva contraseña', route('password.reset', [
                'tipo' => $this->tipoCuenta,
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]))
            ->line('Este enlace vence en ' . config("auth.passwords.$broker.expire") . ' minutos y solo puede usarse una vez.')
            ->line('Si no solicitaste este cambio, puedes ignorar este mensaje. Tu contraseña actual seguirá funcionando.');
    }
}
