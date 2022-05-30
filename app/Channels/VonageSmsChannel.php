<?php

namespace App\Channels;
 
use Illuminate\Notifications\Notification;

class VonageSmsChannel
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
        $message = $notification->toVonageSms($notifiable);
 
        // Send notification to the $notifiable instance...
        $basic  = new \Vonage\Client\Credentials\Basic(config('services.vonage.key'), config('services.vonage.secret'));
        $client = new \Vonage\Client($basic);

        // $message->number;
        return $client->sms()->send(
            new \Vonage\SMS\Message\SMS(config('services.vonage.sms_from'), "BRAND_NAME", $message->content)
        );
    }
}