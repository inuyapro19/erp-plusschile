<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SugerenciaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $trabajador_id;
    protected $areas_id;
    protected $area_operacional;
    protected $mensaje_descripcion;
    protected $mensaje_propuestas;
    protected $mensaje_de_mejoras;
    protected $tipo_reclamo;

    public function __construct(
         $trabajador_id,
         $areas_id,
         $area_operacional,
         $mensaje_descripcion,
         $mensaje_propuestas,
         $mensaje_de_mejoras,
         $tipo_reclamo
    )
    {
        $this->trabajador_id = $trabajador_id;
        $this->areas_id = $areas_id;
        $this->area_operacional = $area_operacional;
        $this->mensaje_descripcion = $mensaje_descripcion;
        $this->mensaje_propuestas = $mensaje_propuestas;
        $this->mensaje_de_mejoras = $mensaje_de_mejoras;
        $this->tipo_reclamo = $tipo_reclamo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
                'trabajador_id' => $this->trabajador_id,
                'areas_id' => $this->areas_id,
                'area_operaciona'=>$this->area_operacional,
                'mensaje_descripcion' => $this->mensaje_descripcion,
                'mensaje_propuestas' => $this->mensaje_propuestas,
                'mensaje_de_mejoras' => $this->mensaje_de_mejoras,
                'tipo_reclamo' => $this->tipo_reclamo
        ];

        return $this->view('email.sugerencia-mail',$data)
                    ->from('pedroaraya@fizz.cl','Nueva Sugerencia - '.$this->tipo_reclamo)
                    ->to('pedroaraya@fizz.cl')
                    ->subject('Solicitud de copia de contrato');

    }
}
