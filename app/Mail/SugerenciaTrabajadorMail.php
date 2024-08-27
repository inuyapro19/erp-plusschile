<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SugerenciaTrabajadorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $areas_id;
    protected $area_operacional;
    protected $mensaje_descripcion;
    protected $mensaje_propuestas;
    protected $mensaje_de_mejoras;
    protected $tipo_reclamo;
    protected $respuesta;

    public function __construct(
        $areas_id
    )
    {

        $this->areas_id = $areas_id;
        $this->area_operacional = $area_operacional;
        $this->mensaje_descripcion = $mensaje_descripcion;
        $this->mensaje_propuestas = $mensaje_propuestas;
        $this->mensaje_de_mejoras = $mensaje_de_mejoras;
        $this->tipo_reclamo = $tipo_reclamo;
        $this->respuesta = $respuesta;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'areas_id' => $this->areas_id,
            'area_operaciona'=>$this->area_operacional,
            'mensaje_descripcion' => $this->mensaje_descripcion,
            'mensaje_propuestas' => $this->mensaje_propuestas,
            'mensaje_de_mejoras' => $this->mensaje_de_mejoras,
            'tipo_reclamo' => $this->tipo_reclamo,
            'respuesta'=>$this->respuesta
        ];

        return $this->view('email.sugerencia-trabajador-mail',$data)
            ->from('pedroaraya@fizz.cl','Respuesta Sugerencia - '.$this->tipo_reclamo)
            ->to('pedroaraya@fizz.cl')
            ->subject('Respuesta de Sugerencia');

    }
}
