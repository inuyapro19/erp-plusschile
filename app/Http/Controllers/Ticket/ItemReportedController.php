<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Checklist\ItemReported;
use App\Models\Checklist\ItemReportedPrevencion;
use Illuminate\Http\Request;

class ItemReportedController extends Controller
{
    public function index()
    {
        return view('checklist.item_reported.index');
    }

    //get all item reported
    public function getAllItemReported()
    {
        $itemReported = ItemReported::filtros()->get();
        return response()->json($itemReported);
    }

    public function getAllItemReportedPrevencion()
    {
        $itemReported = ItemReportedPrevencion::filtros()->get();
        return response()->json($itemReported);
    }
}
