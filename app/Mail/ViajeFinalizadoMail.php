<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ViajeFinalizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected  $viaje;

    public function __construct($viaje_finalizado)
    {
        $this->viaje  = $viaje_finalizado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.viaje-finalizados',['viajes'=>$this->viaje])
                        ->subject('Aviso de viajes finalizados')
                        ->from('contacto@plusschile.cl')
                        ->to('pedroaraya@fizz.cl');
    }
}
