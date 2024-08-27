<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudContratoMail extends Mailable
{
    use Queueable, SerializesModels;

    private  $filname;
    private  $nombre;
    private  $apellidos;
    private  $correo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filname)
    {
        $this->filame = $filname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->view('email.solicitud_contrato')
            ->from('pedroaraya@fizz.cl','solicitud de copia contratro')
            //->to('contacto@ihabita.cl')
            ->to('pedroaraya@fizz.cl')
            ->subject('Solicitud de copia de contrato')
            ->attach('upload/solicitudes/contratos/'. $this->filame);
    }
}
