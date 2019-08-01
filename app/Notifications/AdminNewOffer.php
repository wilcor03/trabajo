<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\User;

class AdminNewOffer extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        return (new MailMessage()) 
                    ->greeting('Hola Admin!')                  
                    ->subject('Nueva oferta - [ Empleo - ConTabilizalo ]')
                    ->line('Nueva oferta: '.$this->offer->vacancyName)
                    ->line('Empresa: '.$this->offer->user->employerProfile->socialReason)
                    ->line('Descripción: '.$this->offer->description);
    }

    /*public function toSlack($notifiable)
    { dd($this);
        return (new SlackMessage)
                    ->content('One of your invoices has been paid!');
    }*/


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
}
