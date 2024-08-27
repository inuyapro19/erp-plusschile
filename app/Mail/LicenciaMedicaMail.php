<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LicenciaMedicaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $rut;
    protected $nombre;


    public function __construct($rut,$nombres)
    {
        $this->rut=$rut;
        $this->nombre=$nombres;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=[

            'rut'=>$this->rut,
            'nombre'=>$this->nombre,

        ];
        return $this->view('mail.licencia_medica',$data);
    }
}
