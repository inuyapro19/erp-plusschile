<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficosResumenCheckList extends Controller
{

    public function chartByItemWith()
    {
        $itemsWithMostNoResponses = DB::table('checklist_responses as cr')
            ->join('checklist_items as ci', 'cr.item_id', '=', 'ci.id')
            ->join('checklists as c', 'cr.checklist_id', '=', 'c.id')
            ->select('ci.name as Labels', DB::raw('COUNT(*) as no_count'))
            ->where('cr.respuesta', 'NO')
            ->where('c.fecha', '>=', now()->subDays(30))
            ->groupBy('ci.name')
            ->orderByDesc('no_count')
            ->limit(10)
            ->get();
        return response($itemsWithMostNoResponses);
    }

    //ahora en vez de item respuesta , ahora los mismo pero por areas en los tickets
    public function chartByAreaWith()
    {
        $areasWithMostNoResponses = DB::table('checklist_responses as cr')
            ->join('checklist_items as ci', 'cr.item_id', '=', 'ci.id')
            ->join('checklists as c', 'cr.checklist_id', '=', 'c.id')
            ->join('areas as a', 'ci.area_id', '=', 'a.id')
            ->select('a.descripcion_area as Labels', DB::raw('COUNT(*) as no_count'))
            ->where('cr.respuesta', 'NO')
            ->where('c.fecha', '>=', now()->subDays(30))
            ->groupBy('a.descripcion_area')
            ->orderByDesc('no_count')
            ->limit(10)
            ->get();
        return response($areasWithMostNoResponses);
    }

    /*
     * Grafico de los ultimos 30 dias en el cual muestre cantidad de checklist por dia y tickets generados por dia.
     * */

    public function getChecklistsAndTicketsLast30Days()
{
    $date30DaysAgo = now()->subDays(30);

    $dateRange = DB::table(DB::raw("(
        SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
        FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) as a
        CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) as b
        CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) as c
    ) as DateRange"));

    $checklists = DB::table('checklists')
        ->select(DB::raw('DATE(created_at) as Fecha'), DB::raw('COUNT(*) as TotalChecklists'))
        ->where('created_at', '>=', $date30DaysAgo)
        ->groupBy(DB::raw('DATE(created_at)'));

    $tickets = DB::table('ticket')
        ->select(DB::raw('DATE(created_at) as Fecha'), DB::raw('COUNT(*) as TotalTickets'))
        ->where('created_at', '>=', $date30DaysAgo)
        ->groupBy(DB::raw('DATE(created_at)'));

    $result = $dateRange
        ->leftJoinSub($checklists, 'C', function ($join) {
            $join->on('DateRange.Date', '=', 'C.Fecha');
        })
        ->leftJoinSub($tickets, 'T', function ($join) {
            $join->on('DateRange.Date', '=', 'T.Fecha');
        })
        ->select('DateRange.Date as Fecha', DB::raw('COALESCE(C.TotalChecklists, 0) as TotalChecklists'), DB::raw('COALESCE(T.TotalTickets, 0) as TotalTickets'))
        ->whereBetween('DateRange.Date', [$date30DaysAgo, now()])
        ->orderBy('DateRange.Date')
        ->get();

    return $result;
}

}
