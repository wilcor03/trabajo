<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class PasswordResetSuccess extends Notification implements ShouldQueue
{
    use Queueable;
    
    /**
    * Create a new notification instance.
    *
    * @return void
    */
    protected $user;

    public function __construct($user)
    {
      $this->user = $user;
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
      $url = '/app/auth/login';
      return (new MailMessage)
          ->greeting('Hola! '.strtoupper($this->user->name))
          ->line('Ha cambiado su contraseña con exito!.')
          ->line('Ya puede ingresar con su nueva contraseña.')
          ->action('Ingresar', url($url));
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