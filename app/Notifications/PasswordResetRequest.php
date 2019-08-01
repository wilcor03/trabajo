<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class PasswordResetRequest extends Notification implements ShouldQueue
{
    use Queueable;
    protected $token;
    protected $name;
    /**
    * Create a new notification instance.
    *
    * @return void
    */
    public function __construct($token, $name)
    {
        $this->token    = $token;
        $this->name     = $name; 
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
        //$url = url('/api/password/find/'.$this->token);
        $url = url('/app/auth/reset-password/'.$this->token);
        //dd($url);
        return (new MailMessage)
            ->greeting('Hola! '.strtoupper($this->name))
            ->subject('Cambio de Contraseña [Empleo - ConTabilizalo]')
            ->line('Usted esta recibiendo este mensaje por que recibimos una solicitud para cambiar la contraseña de su cuenta.')
            ->action('Cambiar contraseña', url($url))
            ->line('Si usted no solicito el cambio de su contraseña, omita este correo por favor!.');
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
}