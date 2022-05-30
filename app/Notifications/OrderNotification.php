<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Support\Facades\Lang;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;
use App\Channels\VonageSmsChannel;


class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $mail;
    public $number;
    public $close_order;
    public $client_name;
    public $client_dni;
    public $reference_order;

    public function __construct($close_order, $client_name, $client_dni, $mail, $number, $reference_order)
    {
        $this->mail = $mail;
        $this->number = $number;
        $this->close_order = $close_order;
        $this->client_name = $client_name;
        $this->client_dni = $client_dni;
        $this->reference_order = $reference_order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WhatsAppChannel::class, VonageSmsChannel::class, 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                        ->greeting('Hola '. $this->client_name)
                        ->subject(Lang::get('Notificación de confirmación por el '. ($this->close_order ? 'cierre' : 'ingreso' ) .' de su orden #'.$this->reference_order))
                        ->line(Lang::get('Recibió este correo para confirmar que su orden #'.$this->reference_order.'. Ha sido '. ($this->close_order ? 'cerrada' : 'ingresada').' satisfactoriamnente.' ))
                        ->line(Lang::get('Le notificaremos cuando su orden tenga algun cambio.'))
                        ->salutation('Saludos.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toWhatsapp($notifiable)
    {
        $state =  $this->close_order ? 'cerrada' : 'ingresada';

        return (new WhatsAppMessage)
                ->content("Hola {$this->client_name}, Le comentamos que su orden *#{$this->reference_order}*. Ha sido {$state} satisfactoriamnente. Le notificaremos cuando su orden tenga algun cambio.")
                ->number($this->number);
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\VonageMessage
     */
    public function toVonageSms($notifiable)
    {
        $state =  $this->close_order ? 'cerrada' : 'ingresada';

        return (new WhatsAppMessage)
                    ->content("Hola {$this->client_name}, Le comentamos que su orden #{$this->reference_order}. Ha sido {$state} satisfactoriamnente.")
                    ->number($this->number);
    }
}
