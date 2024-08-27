<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLiceciaMedica extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $trabajador;
    private $licencia;

    public function __construct($trabajador,$licencia)
    {
       $this->trabajador = $trabajador;
       $this->licencia = $licencia;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'rut'=>$this->trabajador->rut,
            'nombre_completo'=>$this->trabajador->primer_nombre.' '.$this->trabajador->primer_apellido.' '.$this->trabajador->segundo_apellido,
            'fecha_inicio'=>$this->licencia->fecha_inicio,
            'fecha_fin'=>$this->licencia->fecha_fin
        ];
        return $this->view('email.new_licencia_medica',$datos);
    }
}
