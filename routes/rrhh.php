<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\rrhh\TrabajadorController;


//create
Route::get('/trabajador-nuevo/{id?}', [TrabajadorController::class, 'create'])->name('trabajador.nuevo');
Route::get('/trabajador-editar/{id?}', [TrabajadorController::class, 'create'])->name('trabajador.editar');
//getTrabajador
Route::get('/getTrabajador/{id}', [TrabajadorController::class, 'getTrabajador']);

Route::post('/addTrabajador', [TrabajadorController::class, 'store']);
Route::post('/editTrabajador/{id?}', [TrabajadorController::class, 'store']);
Route::post('/unlinkTrabajador/{id?}', [TrabajadorController::class, 'destroy']);

Route::get('/getTrabajadoresDevinculados', [TrabajadorController::class, 'unlinkTrabajador']);


