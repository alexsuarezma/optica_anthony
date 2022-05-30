<?php

namespace App\Channels;
 
use Illuminate\Notifications\Notification;
use UltraMsg\WhatsAppApi;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsapp($notifiable);
 
        // Send notification to the $notifiable instance...
        $ultramsg_token=config('services.whatsapp.whatsapp_token'); // Ultramsg.com token
        $instance_id=config('services.whatsapp.whatsapp_instance_id'); // Ultramsg.com instance id
        $client = new WhatsAppApi($ultramsg_token,$instance_id);

        // $basic  = new \Vonage\Client\Credentials\Basic("cda35cc9", "nz89DE4NX6eRT46o");
        // $client = new \Vonage\Client($basic);
       
        // $response = $client->sms()->send(
        //     new \Vonage\SMS\Message\SMS("593962599426", BRAND_NAME, 'A text message sent using the Nexmo SMS API')
        // );
        
        // $message = $response->current();

        return $client->sendChatMessage($message->number,$message->content);
    }
}