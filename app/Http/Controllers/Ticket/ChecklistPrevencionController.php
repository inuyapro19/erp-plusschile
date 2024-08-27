<?php

namespace App\Http\Controllers\Ticket;

use App\Exports\ChecklistExport;
use App\Http\Controllers\Controller;
use App\Jobs\UpdateOrCreateChecklistResponse;
use App\Mail\ChecklistTicketMail;
use App\Mail\ChecklistTicketPrevencionMail;
use App\Models\Buses;
use App\Models\Checklist\CalidadView;
use App\Models\Checklist\CheckList;
use App\Models\Checklist\Item;
use App\Models\Checklist\CheckListTypes;
use App\Models\Checklist\PrevencionView;
use App\Models\Checklist\RevisionBus;
use App\Models\Checklist\Ticket;
use App\Models\User;
use App\Traits\GeneratesFoliosTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChecklistPrevencionController extends Controller
{
    use GeneratesFoliosTrait;

    //use HandlesImages;

    public function index()
    {
        return view('checklist.prevencion.index');
    }

    public function create($id = null)
    {
        $checklist = CheckList::where('id', $id)->first();
        $data = ['id' => $id];

        if ($checklist) {
            $data['id_bus'] = $checklist->bus_id;
        }

        return view('checklist.prevencion.create', $data);
    }

    public function getChecklistPrevencion($id = null)
    {
        try {

            if ($id) {
                $checklistCalidad = PrevencionView::where('CHECKLIST_ID', $id)
                    ->first();
                return response($checklistCalidad, 200);
            } else {
                $option = \request('option');
                if ($option == 'all') {
                    $checklistCalidad = PrevencionView::orderBy('CHECKLIST_ID', 'desc')
                        ->get();
                } else {
                    //paginacion de 10
                    $checklistCalidad = PrevencionView::orderBy('CHECKLIST_ID', 'desc')
                        ->filtros()
                        ->dateBetween()
                        ->paginate(20);
                }
                return response($checklistCalidad, 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }

    }

    public function getStructure($id)
    {
        try {
            $checklist_id = \request()->get('checklist_id');
            $query = CheckListTypes::where('category_id', $id)
                ->orderBy('order_type', 'asc');

            if ($checklist_id) {
                $query->with([
                    'items' => function ($query) {
                        $query->whereNull('parent_id');
                    },
                    'items.field',
                    'items.responses' => function ($query) use ($checklist_id) {
                        $query->where('checklist_id', $checklist_id);
                    },
                    'items.children',
                    'items.children.field'
                ]);
            } else {
                $query->with([
                    'items' => function ($query) {
                        $query->whereNull('parent_id')
                            ->where('is_active', 'si');
                    },
                    'items.field',
                    'items.children',
                    'items.children.field'
                ]);
            }

            $category = $query->get();

            if ($category->isEmpty()) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }

            return response()->json($category);
        } catch (\Exception $e) {
            // Manejo de la excepción
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }


    public function store(Request $request, $id = 0)
    {
        try {
            // Validaciones
            $request->validate([
                'category_id' => 'required|integer',
                'bus_id' => 'required|integer',
               // 'kilometraje' => 'required|integer',
                'fecha' => 'required|date',
                'observaciones' => 'sometimes|string',
                'respuestas' => 'required',
            ]);

            $userId = auth()->id();

            if ($id != 0) {
                $checklist = CheckList::findOrFail($id);
            } else {
                $folio = $this->createUniqueFolio($request->category_id, CheckList::class);
                $checklist = new CheckList();
                $checklist->fill($request->only(['category_id', 'bus_id','fecha']));
                $checklist->destino_id = 13;
                $checklist->tipo_servicio = 'SERVICIO EN LINEA';
                $checklist->folio = $folio;
                $checklist->user_id = $userId;
            }



            $checklist->observaciones = $request->observaciones;
            $checklist->save();

            //revision bus
            /*$revisionBus = new RevisionBus();
            $revisionBus->bus_id = $request->bus_id;
            $revisionBus->kilometraje = $request->kilometraje;
            $revisionBus->fecha_revision = $request->fecha;
            $revisionBus->checklist_id = $checklist->id;
            $revisionBus->save();*/

         $revisonBus =   DB::table('revisiones_buses')->insert([
                'bus_id' => $request->bus_id,
                'kilometraje' => $request->kilometraje,
                'fecha_revision' => $request->fecha,
                'checklist_id' => $checklist->id
            ]);

            // Verificar si hay usuarios firmantes
            if ($request->has('users')) {
                $users = json_decode($request->users);
                $cantidad_areas = $request->cantidad_areas;
                DB::transaction(function () use ($users, $checklist) {
                    foreach ($users as $user) {
                        DB::table('checklist_users_signed')->insert([
                            'checklist_id' => $checklist->id,
                            'user_id' => $user->id,
                            'success' => 1,
                            'observacion' => $user->observaciones ?? null, // Assuming observaciones might be optional
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }


                });
                $cantidad_users = count($users);
                if ($cantidad_users == $cantidad_areas) {
                    $checklist->signed_status = 'Firmado';
                    $checklist->save();
                }
            }

            $respuestas = $request->input('respuestas');
            $noConformidades = 0;
            $ticketsByUser = [];
            $hayRechazados = false;
            $hayAprobadosConObservaciones = false;

            foreach ($respuestas as $key => $respuesta) {
                $data = [
                    'checklist_id' => $checklist->id,
                    'item_id' => $respuesta['id'],
                    'respuesta' => $respuesta['respuesta'] ?? null,
                    'observaciones' => $respuesta['observaciones'] ?? null,
                    'respuesta_add' => $respuesta['respuesta_add'] ?? null,
                    'valor' => $respuesta['valor'] ?? null,
                ];

                if ($request->hasFile("respuestas.$key.images")) {
                    $file = $request->file("respuestas.$key.images");
                    $rutaArchivo = $file->store('checklist/calidad', 'public');
                    $data['images'] = $rutaArchivo;
                }

                UpdateOrCreateChecklistResponse::dispatch($data);


                if (($respuesta['respuesta'] == 'NO' || $respuesta['valor'] == 'NO') && $id == 0) {
                    $noConformidades += 1;


                    $item = Item::find($respuesta['id']);
                    $itemName = $item ? $item->name : 'Unknown Item';

                    Log::info($item->responsables);

                    $assigned_to = null;
                    if ($item->responsables->isNotEmpty()) {
                        $assigned_to = $item->responsables->first()->id;
                    }

                    $critical = $item->critical ?? null; // Asegúrate de que el modelo Item tenga el campo 'critical'

                    if ($critical == 'refused') {
                        $hayRechazados = true;
                    } elseif ($critical == 'approved with observation') {
                        $hayAprobadosConObservaciones = true;
                    }

                    //crea un log de ticket creados
                    Log::channel('checklist')->info('Ticket creado', [
                        'checklist_id' => $checklist->id,
                        'item_id' => $respuesta['id'],
                        'item_name' => $itemName,
                        'user_id' => $userId,
                        'response' => $respuesta['respuesta'],
                        'priority' => $this->determinarPrioridad($item),
                        'assigned_to' => $assigned_to,
                    ]);

                    $ticket = Ticket::create([
                        'checklist_id' => $checklist->id,
                        'nro_ticket' => $this->createUniqueNroTicket(2, Ticket::class),
                        'reported_by' => $userId,
                        'title' => $itemName,
                        'description' => $respuesta['observaciones'] . (isset($respuesta['respuesta_add']) ? '<br/>Detalles: ' . $respuesta['respuesta_add'] : ''),
                        'priority' => $item->prioridad,
                        'assigned_to' => $assigned_to,
                        'item_id' => $respuesta['id'],
                        'category' => 2
                    ]);

                    //ticket histories
                    DB::table('ticket_histories')->insert([
                        'ticket_id' => $ticket->id,
                        'action_by' => $userId,
                        'action' => 'creacion de ticket',
                        'description' => json_encode($ticket),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Agrupar los tickets por el usuario asignado
                    $assignedTo = $ticket->assigned_to;
                    if (!array_key_exists($assignedTo, $ticketsByUser)) {
                        $ticketsByUser[$assignedTo] = [];
                    }
                    $ticketsByUser[$assignedTo][] = $ticket;


                }
            }

            /*if ($id == 0) {
                $buses = Buses::where('id', $checklist->bus_id)->first();
                // Enviar correo a cada usuario con los tickets asignados
                foreach ($ticketsByUser as $userId => $tickets) {
                    $user = User::find($userId);
                    //busca al bus de la checklist

                    if ($user) {
                        Mail::to($user->email)->send(new ChecklistTicketPrevencionMail($tickets, $user->name, $user->apellidos, $buses, $checklist->folio));
                    }
                }
            }*/
            if ($id == 0) {
                $buses = Buses::where('id', $checklist->bus_id)->first();

                // Mapeo de área_id a correos electrónicos
                $areaCorreoMap = [
                    //3  => 'notificaciones-calidad@plusschile.cl',
                    8  => 'notificaciones-informatica@plusschile.cl',
                    9  => 'notificaciones-mantencion@plusschile.cl',
                    12 => 'notificaciones-operaciones@plusschile.cl',
                    28 => 'notificaciones-prevencion@plusschile.cl',
                    10 => 'notificaciones-monitoreo@plusschile.cl'
                ];

                // Inicializar un arreglo para agrupar los tickets por área
                $ticketsPorArea = [];

                // Agrupar los tickets por área
                foreach ($ticketsByUser as $userId => $tickets) {
                    foreach ($tickets as $ticket) {
                        // Obtener el area_id del item asociado al ticket
                        $checklistItem = Item::find($ticket->item_id);
                        $areaId = $checklistItem->area_id;

                        // Agrupar tickets por área
                        if (!isset($ticketsPorArea[$areaId])) {
                            $ticketsPorArea[$areaId] = [];
                        }
                        $ticketsPorArea[$areaId][] = $ticket;
                    }
                }

                // Enviar un correo por área con todos los tickets correspondientes
                foreach ($ticketsPorArea as $areaId => $tickets) {
                    // Determinar el correo del área responsable basándose en el area_id
                    $areaResponsableCorreo = $areaCorreoMap[$areaId] ?? null;

                    if ($areaResponsableCorreo && !empty($tickets)) {
                        // Enviar el correo al área responsable con todos los tickets de esa área
                        Mail::to($areaResponsableCorreo)->send(new ChecklistTicketPrevencionMail($tickets, 'Nombre del Área', 'Apellidos del Área', $buses, $checklist->folio));
                    }
                }
            }

            if ($hayRechazados) {
                $checklist->status = 'rechazado';
            } elseif ($hayAprobadosConObservaciones) {
                $checklist->status = 'aprobado con observaciones';
            } else {
                $checklist->status = 'aprobado';
            }

            $checklist->save();

            return response()->json(['message' => 'Checklist guardado correctamente', 'checklist' => $checklist], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    private function determinarPrioridad($item)
    {
        //'approved', 'approved with observation', 'refused'
        if ($item->critical === 'approved with observation') {
            return 'baja';
        } else {
            return 'alta';
        }
    }


    public function getChecklistPrevencionById($id)
    {
        try {
            $checklistCalidad = CheckList::with(['items.responses' => function ($query) use ($id) {
                $query->where('checklist_id', $id)->get();
            },'items.type','items.area'])
                ->where('id', $id)
                ->first();
            return response($checklistCalidad, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }

    }

    public function validarYFirmarChecklist(Request $request, $id)
    {
        $userId = $request->input('trabajador_id');
        $password = $request->input('password');
        $isAgreeSigned = $request->input('isAgreeSigned') == '1';

        try {
            $user = User::with('trabajador.contrato')->find($userId);

            if (!$user) {
                return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
            }

            if (!$user->trabajador || !$user->trabajador->contrato) {
                return response()->json(['mensaje' => 'Información de trabajador o contrato no disponible'], 404);
            }

            $areaId = $user->trabajador->contrato->area_id;

            // Obtener los IDs de los checklist items asociados a la área del usuario
            $checklistItemIds = Item::where('area_id', $areaId)->pluck('id');

            // Verificar si hay tickets abiertos para los checklist items de la área del usuario
            $ticketsAbiertos = Ticket::whereIn('item_id', $checklistItemIds)
                //->where('status', 'Abierto')
                ->count();

            if ($ticketsAbiertos == 0) {
                return response()->json(['mensaje' => 'Este área no tiene tickets abiertos y no puede firmar el checklist'], 403);
            }

            if ($isAgreeSigned) {
                // Verificar si la contraseña es correcta solo si el usuario acepta firmar
                if (!Hash::check($password, $user->password)) {
                    return response()->json(['mensaje' => 'Contraseña incorrecta'], 403);
                }

                // Verificar si el usuario tiene el permiso para firmar el checklist
                if (!$user->can('Firmar Checklist Prevencion')) {
                    return response()->json(['mensaje' => 'No autorizado para firmar el checklist'], 403);
                }

                // Insertar o actualizar el registro en checklist_users_signed
                DB::table('checklist_users_signed')->updateOrInsert(
                    ['checklist_id' => $id, 'user_id' => $userId],
                    [
                        'success' => 1, // Ya verificamos que está de acuerdo en firmar
                        'observacion' => $request->input('observacion') ?? '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Actualizar el estado del checklist a "firmado"
                DB::table('checklists')
                    ->where('id', $id)
                    ->update(['signed_status' => 'Firmado']);

                return response()->json(['mensaje' => 'Checklist firmado exitosamente'], 200);
            }

            // Si el usuario no está de acuerdo en firmar, aún registramos el intento
            DB::table('checklist_users_signed')->insert([
                'checklist_id' => $id,
                'user_id' => $userId,
                'success' => 0,
                'observacion' => $request->input('observacion') ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['mensaje' => 'Acción realizada correctamente, pero sin firma'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

   /* public function trabajadoresByArea($checklistId)
    {
        // Asumiendo que $checklistId es el ID del checklist del cual quieres encontrar los trabajadores relacionados
        // Primero, encuentra los items del checklist y sus áreas correspondientes
        // $itemIds = ChecklistItem::where('checklist_id', $checklistId)->pluck('id');

        // Encuentra los tickets asociados a esos items del checklist
        $areas = Ticket::Where('checklist_id', $checklistId)
            ->with('checklistItem.area') // Asegúrate de que esta relación exista en tu modelo Ticket
            ->get()
            ->pluck('checklistItem.area')
            ->unique('id'); // Evitar áreas duplicadas

        // Extraer los IDs de las áreas
        $areaIds = $areas->pluck('id');

        // Filtrar los trabajadores que pertenecen a esas áreas
        // Asegúrate de que esta relación (trabajador -> contrato -> área) exista en tus modelos
        $trabajadores = User::whereHas('trabajador.contrato', function ($query) use ($areaIds) {
            $query->whereIn('area_id', $areaIds);
        })
            ->get();

        return response()->json($trabajadores);
    }*/
    public function trabajadoresByArea(Request $request, $checklistId)
    {
        // Asumiendo que $checklistId es el ID del checklist del cual quieres encontrar los trabajadores relacionados
        // Primero, encuentra los items del checklist y sus áreas correspondientes
        // $itemIds = ChecklistItem::where('checklist_id', $checklistId)->pluck('id');

        // Obtener el área_id de la cadena de consulta si está presente
        $areaId = $request->query('area_id');

        // Encuentra los tickets asociados a esos items del checklist
        $query = Ticket::Where('checklist_id', $checklistId)
            ->with('checklistItem.area'); // Asegúrate de que esta relación exista en tu modelo Ticket

        // Aplica filtro por área si se proporciona el área_id en la cadena de consulta
        if ($areaId) {
            $query->whereHas('checklistItem.area', function ($query) use ($areaId) {
                $query->where('id', $areaId);
            });
        }

        $tickets = $query->get();

        // Extraer los IDs de las áreas
        $areaIds = $tickets->pluck('checklistItem.area.id')->unique();

        // Filtrar los trabajadores que pertenecen a esas áreas
        // Asegúrate de que esta relación (trabajador -> contrato -> área) exista en tus modelos
        $trabajadores = User::whereHas('trabajador.contrato', function ($query) use ($areaIds) {
            $query->whereIn('area_id', $areaIds);
        })
            ->get();

        return response()->json($trabajadores);
    }
    //usuarios que firmaron el checklist
    public function getFirmantes($id)
    {
        /*$firmantes = DB::table('checklist_users_signed')
            ->join('users', 'checklist_users_signed.user_id', '=', 'users.id')
            ->where('checklist_id', $id)
            //select generale un alias para cada columna
            ->select(
                'users.name as nombre',
                'users.apellidos as apellidos',
                'users.email as email',
                'checklist_users_signed.success as firmado',
                'checklist_users_signed.observacion as observacion',
                'checklist_users_signed.created_at as fecha')
           //limite de 3
            ->limit(3)
            ->get();*/
        $firmantes = DB::table('checklist_users_signed')
            ->join('users', 'checklist_users_signed.user_id', '=', 'users.id')
            ->join('trabajadores', 'users.id', '=', 'trabajadores.user_id')
            ->join('contrato', 'trabajadores.id', '=', 'contrato.trabajador_id')
            ->join('areas', 'contrato.area_id', '=', 'areas.id')
            ->where('checklist_users_signed.checklist_id', $id)
            ->select(
                'users.name as nombre',
                'users.apellidos as apellidos',
                'users.email as email',
                'checklist_users_signed.success as firmado',
                'checklist_users_signed.observacion as observacion',
                'checklist_users_signed.created_at as fecha',
                // Select additional fields from trabajadores, contratos, and areas

                'areas.descripcion_area as area_name'
            )
            ->limit(3)
            ->get();


        return response()->json($firmantes);
    }

    //exportar checklist
    public function exportChecklist()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new ChecklistExport(), 'ticket.xlsx');
    }

    //graficos

    public function getTotalChecklistsByDay()
    {
        $results = Checklist::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('QUARTER(created_at) as quarter'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('year', 'quarter')
            ->orderBy('year', 'ASC')
            ->orderBy('quarter', 'ASC')
            ->get();


        return $results;
    }

    public function getBusRevisionData($busId)
    {
        try {
            // Attempt to retrieve the bus revision data
            $results = RevisionBus::where('bus_id', $busId)
                ->orderBy('id', 'desc')
                ->first();

            // If no results were found, throw an exception
            if (!$results) {
                throw new \Exception('No bus revision data found for the provided bus ID');
            }

            // If results were found, return them as a JSON response
            return response()->json($results);
        } catch (\Exception $e) {
            // If an exception was thrown, return an error message as a JSON response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
