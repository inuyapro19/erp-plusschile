<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Ticket\BaseChechListController;
use App\Http\Controllers\Ticket\CategoriaController;
use App\Http\Controllers\Ticket\ChecklistCalidadController;
use App\Http\Controllers\Ticket\GraficosResumenCheckList;
use App\Http\Controllers\Ticket\ItemController;
use App\Http\Controllers\Ticket\ItemReportedController;
use App\Http\Controllers\Ticket\TicketController;
use App\Http\Controllers\Ticket\TipoController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;




    // Place all your routes here
    //dashboard
Route::get('/dashboard-calidad', [DashboardController::class, 'calidadDashboard'])
    ->name('dashboard.calidad')
    ->middleware([CheckPermission::class.':dashboard calidad']);

    Route::get('/checklist-calidad', [ChecklistCalidadController::class, 'index'])->name('calidad.index')
        ->middleware([CheckPermission::class.':Lista de Checklist']);

    Route::get('/getchecklistcalidad/{id?}',[ChecklistCalidadController::class, 'getChecklistCalidad']);

    Route::get('/checklist-calidad/nuevo', [ChecklistCalidadController::class, 'create'])->name('calidad.create')
        ->middleware([CheckPermission::class.':Agregar Checklist']);

    Route::get('/checklist-calidad/editar/{id?}', [ChecklistCalidadController::class, 'create'])
        ->name('calidad.edit')->middleware([CheckPermission::class.':Editar Checklist']);

    Route::get('/checklist-structure/{id}', [ChecklistCalidadController::class, 'getStructure']);

    Route::post('/checklist-calidad/{id?}', [ChecklistCalidadController::class, 'store']);
// Para el controlador BaseChechListController
    Route::get('/checklist/check-list-configuracion', [BaseChechListController::class, 'index'])
        ->name('checklist.index')
        ->middleware([CheckPermission::class.':Configuracion Checklist']);

// Para el controlador CategoriaController
    Route::get('/checklist/categoria', [CategoriaController::class, 'index']);
    Route::post('/checklist/categoria/{id?}', [CategoriaController::class, 'storeOrUpdate']);
    Route::delete('/checklist/categoria/{id}', [CategoriaController::class, 'destroy']);


//getChecklistCalidadById
    Route::get('/getCheckListCalidadId/{id}', [ChecklistCalidadController::class, 'getChecklistCalidadById']);
    //getChecklistCalidadByIdNegativeResponse
    Route::get('/getCheckListCalidadIdNegativeResponse/{id}', [ChecklistCalidadController::class, 'getChecklistCalidadByIdNegativeResponse']);

// Para el controlador ItemController
    Route::get('/checklist/item', [ItemController::class, 'index']);
    Route::post('/checklist/item/{id?}', [ItemController::class, 'storeOrUpdate']);
    Route::delete('/checklist/item/{id}', [ItemController::class, 'destroy']);

// Para el controlador TipoController
    Route::get('/checklist/tipo', [TipoController::class, 'index']);
    Route::post('/checklist/tipo/{id?}', [TipoController::class, 'storeOrUpdate']);
    Route::delete('/checklist/tipo/{id}', [TipoController::class, 'destroy']);

//ticket
    Route::get('/ticket', [TicketController::class, 'index'])->name('ticket.index')
        ->middleware([CheckPermission::class.':Lista de Ticket']);
    Route::get('/ticket-calidad', [TicketController::class, 'getTicket']);
    Route::post('/ticket-calidad/{id}', [TicketController::class, 'updateTicket']);

//import items from excel
    Route::post('/checklist/import-items', [ItemController::class, 'importItems']);

//trabajadoresByarea
    Route::get('/trabajadoresByArea/{checklistId?}', [ChecklistCalidadController::class, 'trabajadoresByArea']);
    //trabajadoresByAreaAll
    Route::get('/trabajadoresByAreaAll', [ChecklistCalidadController::class, 'trabajadoresByAreaAll']);
//validateChecklist
    Route::post('/validateChecklist/{id}', [ChecklistCalidadController::class, 'validarYFirmarChecklist']);

//getFirmantes
    Route::get('/getFirmantes/{id}', [ChecklistCalidadController::class, 'getFirmantes']);
//validateTicket
    Route::post('/validateTicket/{id}', [TicketController::class, 'validateTicket']);

//export ticket to excel
    Route::get('/export-ticket', [TicketController::class, 'exportTicket']);
    //exportr checklist to excel
    Route::get('/export-checklist', [ChecklistCalidadController::class, 'exportChecklist']);
//getTotalChecklistsByDay
    Route::get('/getTotalChecklistsByDay', [ChecklistCalidadController::class, 'getTotalChecklistsByDay']);
//getTicketStatus
    Route::get('/getTicketStatus', [TicketController::class, 'getTicketStatus']);
//chartByItemWith
    Route::get('/chartByItemWith', [GraficosResumenCheckList::class, 'chartByItemWith']);

//chartByAreaWith
   Route::get('/chartByAreaWith', [GraficosResumenCheckList::class, 'chartByAreaWith']);
//chartChecklistAndTicketsByDayCombined
    Route::get('/chartChecklistAndTicketsByDayCombined', [GraficosResumenCheckList::class, 'getChecklistsAndTicketsLast30Days']);

    Route::get('/item-reported', [ItemReportedController::class, 'index'])->name('item-reported.index');
    Route::get('/getAllItemReported', [ItemReportedController::class, 'getAllItemReported']);
//getUsersByAreas
    Route::post('/getUsersByAreas', [BaseChechListController::class, 'getUsersByAreas']);
//send mail
Route::get('/send-ticket-notification', [TicketController::class, 'sendTicketNotification'])->name('send.ticket.notification');
//firmaLogin
Route::post('/firmaLogin', [ChecklistCalidadController::class, 'firmaLogin']);
