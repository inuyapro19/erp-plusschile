<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LicenciaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $codigo_trabajador;
    protected $rut;
    protected $nombre;
    protected $dias_por_vencer;

    public function __construct($codigo_trabajador,$rut,$nombres,$dias_por_vencer)
    {
        $this->codigo_trabajador=$codigo_trabajador;
        $this->rut=$rut;
        $this->nombre=$nombres;
        $this->dias_por_vencer=$dias_por_vencer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=[
            'codigo_trabajador'=>$this->codigo_trabajador,
            'rut'=>$this->rut,
            'nombre'=>$this->nombre,
            'dias_por_vencer'=>$this->dias_por_vencer,
        ];
        return $this->view('email.licencia-vencimiento',$data);
    }
}
