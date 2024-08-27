<?php

namespace App\Exports;

use App\Models\Checklist\CalidadView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ChecklistExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $checklist = CalidadView::filtros()->get();

        return view('excel.checklist', [
            'checklists' => $checklist
        ]);
    }
}
