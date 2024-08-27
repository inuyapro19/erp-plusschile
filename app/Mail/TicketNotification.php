<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $tickets;
    public $departamento;

    public function __construct($tickets, $departamento)
    {
        $this->tickets = $tickets;
        $this->departamento = $departamento;
    }


    public function build()
    {
        // Generar PDF al vuelo en orientación horizontal
        /*$pdf = PDF::loadView('pdf.ticket_report', ['tickets' => $this->tickets])
            ->setPaper('a4', 'landscape');*/ // Establece el papel a A4 en orientación horizontal

        // La vista 'pdf.checklist' contiene el diseño de tu PDF.
        // Debes crear esta vista y asegurarte de que recibe los datos (`$tickets`) correctamente.

        return $this->view('emails.ticket.notification', [
            'tickets' => $this->tickets,
            'departamento' => $this->departamento,
        ])
            ->subject('Reporte de tickets de calidad')
            ->from('contacto@plusschile.cl', 'Plus Chile')
            ->to('pedroaraya@fizz.cl');

    }
}
