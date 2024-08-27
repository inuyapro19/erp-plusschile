<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Ticket\ChecklistPrevencionController;
use App\Http\Controllers\Ticket\ItemReportedController;
use App\Http\Controllers\Ticket\TicketPrevencionController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;


// Place all your routes here
//dashboard
Route::get('/dashboard-prevencion', [DashboardController::class, 'prevencionDashboard'])
    ->name('dashboard.prevencion')
    ->middleware([CheckPermission::class.':dashboard Prevencion']);

Route::get('/checklist-prevencion', [ChecklistPrevencionController ::class, 'index'])->name('prevencion.index')
    ->middleware([CheckPermission::class . ':Lista de Checklist Prevencion']);

Route::get('/getchecklistPrevencion/{id?}', [ChecklistPrevencionController ::class, 'getChecklistPrevencion']);
Route::get('/checklist-prevencion/nuevo', [ChecklistPrevencionController ::class, 'create'])->name('prevencion.create')
    ->middleware([CheckPermission::class . ':Agregar Checklist Prevencion']);
Route::get('/checklist-prevencion/editar/{id?}', [ChecklistPrevencionController ::class, 'create'])
    ->name('prevencion.edit')->middleware([CheckPermission::class . ':Editar Checklist Prevencion']);

Route::get('/checklist-structure-prevencion/{id}', [ChecklistPrevencionController ::class, 'getStructure']);

Route::post('/checklist-prevencion/{id?}', [ChecklistPrevencionController ::class, 'store']);
//getChecklistPrevencionById
Route::get('/getChecklistPrevencionById/{id}', [ChecklistPrevencionController ::class, 'getChecklistPrevencionById']);
//getBusRevisionData
Route::get('/getBusRevisionData/{id}', [ChecklistPrevencionController ::class, 'getBusRevisionData']);
//trabajadoresByArea
Route::get('/trabajadoresByAreaPrevencion/{id}', [ChecklistPrevencionController ::class, 'trabajadoresByArea']);

//getFirmantes
Route::get('/getFirmantesPrevencion/{id}', [ChecklistPrevencionController ::class, 'getFirmantes']);
//validarYFirmarChecklist
Route::post('/validarYFirmarChecklistPrevencion/{id}', [ChecklistPrevencionController ::class, 'validarYFirmarChecklist']);


Route::get('/ticket-prevencion', [TicketPrevencionController::class,'index'])->name('ticket.prevencion.index');
Route::get('/ticket-prevencion/get', [TicketPrevencionController::class,'getTicket']);
Route::post('/ticket-prevencion/update/{id}', [TicketPrevencionController::class,'updateTicket']);
Route::post('/ticket-prevencion/validate/{id}', [TicketPrevencionController::class,'validateTicket']);
Route::get('/ticket-prevencion/export', [TicketPrevencionController::class,'exportTicket']);
Route::get('/ticket-prevencion/status', [TicketPrevencionController::class,'getTicketStatus']);


Route::get('/item-reported-prevencion', [ItemReportedController::class, 'getAllItemReportedPrevencion']);
Route::get('/send-ticket-prevencion-notification', [TicketPrevencionController::class, 'sendTicketNotification']);

