<?php

namespace App\Http\Controllers\Ticket;

use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use App\Mail\TicketNotification;
use App\Models\Checklist\CheckList;
use App\Models\Checklist\Ticket;
use App\Models\Checklist\TicketView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
    public function index()
    {
        return view('checklist.ticket.index');
    }

    public function getTicket()
    {
        try {
            $option = request('option');

            $user = Auth::user();
            $trabajador = $user->trabajador()->with('contrato')->first();
            $area_id = $trabajador->contrato->area_id ?? null;

            $query = TicketView::orderBy('TICKET_ID', 'desc');


            // Aplicar filtros de fecha si se proporcionan


            // Verifica si el usuario tiene un rol de calidad
            if (!$user->hasRole(['Jefe Control Calidad', 'Asistente Control de Calidad', 'admin'])) {
                // Si no es usuario de calidad, se filtra por su área
                if ($area_id) {
                    $query->where('AREA_ID', $area_id);
                } else {
                    // Manejar el caso en que no hay un área asociada con el usuario
                    // Podrías lanzar una excepción o manejarlo de alguna otra manera
                }
            }

            $query->dateBetween();
            $query->filtros();

            if ($option == 'all') {
                $ticket = $query->get();
            } else {
                $ticket = $query->paginate(20);
            }


            return response()->json($ticket, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }


    //cambio de estado
    public function updateTicket(Request $request, $id)
    {
        try {
            $ticket = Ticket::find($id);
            $ticket->status = $request->estado;
            $ticket->resolution_summary = $request->resolution_summary;

            $ticket->save();

            DB::table('ticket_histories')->insert([
                'ticket_id' => $ticket->id, // Assuming this is correct
                'action_by' => Auth::user()->id,
                'action' => 'cambio de estado', // Replace with actual action
                'description' => json_encode($ticket), // Replace with actual description
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json($ticket, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    //un usuario valida que el ticket este realmente resuelto estoy cambia el estado del checklist a aprovado si todos los ticket con el checklist_id estan cerrados e validados como estados
    public function validateTicket(Request $request, $id)
    {
        DB::beginTransaction(); // Iniciar una transacción

        try {
            $ticket = Ticket::find($id);
            if (!$ticket) {
                return response()->json(['mensaje' => 'Ticket no encontrado'], 404);
            }

            if ($request->action == 'reject') {
                // Marcar el ticket como "Abierto" y registrar la razón del rechazo
                $ticket->status = 'Abierto';
                $ticket->observacion_validate = $request->reason;
            } else {

                $ticket->status_validate = 'validado';
            }
            // $ticket->save();
            //  $ticket->status_validate = 'validado';
            $ticket->save();

            // Verifica si todos los tickets del checklist están validados
            $totalTickets = Ticket::where('checklist_id', $ticket->checklist_id)->count();
            $validados = Ticket::where('checklist_id', $ticket->checklist_id)->where('status_validate', 'validado')->count();

            DB::table('checklist_responses')
                ->where('item_id', $ticket->item_id)
                ->update(['respuesta' => 'SI']);

            if ($validados == $totalTickets) {

                // Actualiza el estado del checklist a "aprobado"
                $checklist = $ticket->checklist;
                $checklist->status = 'aprobado';
                $checklist->save();
            }


            // Registrar la historia del ticket
            DB::table('ticket_histories')->insert([
                'ticket_id' => $ticket->id,
                'action_by' => Auth::user()->id,
                'action' => $request->action == 'reject' ? 'Rechazo de ticket' : 'Validacion de ticket',
                'description' => json_encode($ticket->toArray()),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit(); // Confirmar la transacción

            return response()->json($ticket, 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción si hay un error
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function exportTicket()
    {
        return Excel::download(new TicketExport, 'ticket.xlsx');
    }

    public function getTicketStatus()
    {
        $ticketsAbiertosPorArea = Ticket::query()
            ->select('areas.descripcion_area as area_name', DB::raw('count(*) as total'))
            ->join('checklist_items', 'ticket.item_id', '=', 'checklist_items.id')
            ->join('areas', 'checklist_items.area_id', '=', 'areas.id')
            ->where('ticket.status', '=', 'Abierto')
            ->groupBy('areas.descripcion_area')
            ->get();

        $ticketsCerradosPorArea = Ticket::query()
            ->select('areas.descripcion_area as area_name', DB::raw('count(*) as total'))
            ->join('checklist_items', 'ticket.item_id', '=', 'checklist_items.id')
            ->join('areas', 'checklist_items.area_id', '=', 'areas.id')
            ->where('ticket.status', '=', 'Cerrado')
            ->groupBy('areas.descripcion_area')
            ->get();

        return response()->json([
            'ticketsAbiertosPorArea' => $ticketsAbiertosPorArea,
            'ticketsCerradosPorArea' => $ticketsCerradosPorArea,
        ]);
    }


    public function sendTicketNotification()
    {

        // Obtenemos la fecha actual
        $today = Carbon::today();

        // Consultamos los checklists del día actual
        $checklists = Checklist::with([
            'tickets' => function ($query) use ($today) {
                $query->where('status', 'Abierto');
            },
            'bus',
            'tickets.checklistItem',
            'tickets.checklistItem.type',
            'tickets.reportedBy',
            'tickets.checklistItem.responses' => function ($query) use ($today) {
                $query->where('checklist_id', function($subQuery) use ($today) {
                    $subQuery->select('id')
                        ->from('checklists')
                        ->whereDate('fecha', $today)
                        ->limit(1);
                });
            }
        ])
            ->whereDate('fecha', $today)
            ->where('category_id',1)
            ->get();
        return response()->json($checklists, 200);
        // Formateamos los datos para la salida
        $checklistData = $checklists->map(function ($checklist) {
            return [
                'folio' => $checklist->folio,
                'bus_id' => $checklist->bus->id,
                'nro_bus' => $checklist->bus->numero_bus,
                'patente' => $checklist->bus->patente,
                'fecha' => $checklist->fecha,
                'items' => $checklist->tickets->map(function ($ticket) {
                    return [
                        'nro_ticket' => $ticket->nro_ticket,
                        'item' => $ticket->checklistItem->name,
                        'categoria' => $ticket->checklistItem->type->name,
                        'reportado_por' => $ticket->reportedBy->name.' '.$ticket->reportedBy->apellidos, // Asumiendo que hay un método en el modelo Ticket que obtiene el usuario que reportó
                        'respuesta' => $ticket->checklistItem->responses[0]->respuesta, // Debes ajustar esto según la lógica de tu aplicación y la estructura de tus tablas
                        'valor' => $ticket->checklistItem->responses[0]->valor,
                        'observaciones' => $ticket->checklistItem->responses[0]->observaciones,
                        'respuesta_adicional' => $ticket->checklistItem->responses[0]->respuesta_add,
                        'critical' => $ticket->checklistItem->critical // Ajusta la lógica según tus necesidades
                    ];
                })->toArray()
            ];
        });

       // return response()->json($checklistData);

        // Envía la notificación por correo electrónico
       Mail::to(['dusan@plusschile.cl','sig@plusschile.cl'])
            ->send(new TicketNotification($checklistData,'Control de Calidad'));


        return response()->json(['status' => 'Notificación de ticket enviada con éxito.'], 200);
    }


}
