<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContratoVencimientoNotifications extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $contrato_vencimiento;

    public function __construct($contrato_vencimiento)
    {
        $this->contrato_vencimiento = $contrato_vencimiento;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
  /*  public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'mensaje'=>'Su contrato esta por vencer dentro de '.$this->contrato_vencimiento->dias_por_vencer.' días',
            'mensaje_admin'=>'EL Contrato de '.$this->contrato_vencimiento->nombres.' esta por vencer ('.$this->contrato_vencimiento->dias_por_vencer.'días)'
        ];
    }
}
