<?php

namespace App\Exports;

use App\Models\Checklist\TicketView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TicketExport implements FromView
{
    public function view(): View
    {
        $tickets = TicketView::filtros()->get();

        return view('excel.ticket', [
            'tickets' => $tickets
        ]);
    }
}
