<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('America/Guayaquil');
        
        VerifyEmail::$toMailCallback = function($notifiable, $verificationUrl){
            return (new MailMessage)
            ->greeting('Hola '. $notifiable->name)
            ->subject(Lang::get('Confirme su dirección de correo electrónico'))
            ->line(Lang::get('Haga clic en el botón de abajo para verificar su dirección de correo electrónico.'))
            ->action(Lang::get('Confirme su dirección de correo electrónico'), $verificationUrl)
            ->line(Lang::get('Si no creó una cuenta, no es necesario realizar ninguna otra acción.'))
            ->salutation('Saludos.');  
        };

        VerifyEmail::$createUrlCallback = function($notifiable){
            return URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 30)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        };
    }
}
