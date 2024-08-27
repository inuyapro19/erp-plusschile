<?php

namespace App\Mail;

use App\Models\Checklist\CheckList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChecklistTicketPrevencionMail extends Mailable
{
    use Queueable, SerializesModels;


    public $tickets;
    public $userName;
    public $userApellidos;

    public $buses;

    public $folio;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct($tickets, $userName, $userApellidos,$buses,$folio)
    {
        $this->tickets = $tickets;
        $this->userName = $userName;
        $this->userApellidos = $userApellidos;
        $this->buses = $buses;
        $this->folio = $folio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.checklist_ticket_prevencion')
            ->from('info@plusschile.cl', 'Intranet PlussChile')
            ->subject('Notificación Intranet')
            ->with([
                'tickets' => $this->tickets,
                'userName' => $this->userName,
                'userApellidos' => $this->userApellidos,
                'buses' => $this->buses,
                'folio' => $this->folio,
            ]);
    }
}
