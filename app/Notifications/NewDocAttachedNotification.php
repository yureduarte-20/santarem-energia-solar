<?php

namespace App\Notifications;

use App\Models\PedidoDocumento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDocAttachedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private PedidoDocumento $pedidoDocumento
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
                    ->subject('Novo documento anexado')
                    ->line('Um novo documento foi adicionado a um projeto que você está acompanhando.')
                    ->action('Acessar', url()->route('pedido.edit', $this->pedidoDocumento->pedido_id))
                    ->salutation('Atenciosamente, '.env('APP_NAME').'.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
