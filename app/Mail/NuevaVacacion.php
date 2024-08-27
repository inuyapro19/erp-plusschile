<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaVacacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $trabajador;
    private $vacaciones;

    public function __construct($trabajador,$vacaciones)
    {
        $this->trabajador = $trabajador;
        $this->vacaciones = $vacaciones;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.nueva_vacacion',[
            'rut'=>$this->trabajador->rut,
            'nombre_completo'=>$this->trabajador->primer_nombre.' '.$this->trabajador->primer_apellido.' '.$this->trabajador->segundo_apellido,
            'vacaciones'=>$this->vacaciones
        ]);
    }
}
