<?php

/*Obtener datos para usarlos en vue js*/

use App\Http\Controllers\DestinatarioController;

Route::get('/regiones',[\App\Http\Controllers\RegionController::class,'getRegiones']);
Route::get('/comunas/{id?}',[\App\Http\Controllers\ComunaController::class,'getComunas']);
Route::get('/bancos',[\App\Http\Controllers\BancoController::class,'getBancos']);
Route::get('/empleador',[\App\Http\Controllers\EmpleadorController::class,'getEmpleador']);
Route::get('/ubicaciones',[\App\Http\Controllers\UbicacionController::class,'getUbicacion']);
Route::get('/areas',[\App\Http\Controllers\AreasController::class,'getAreas']);
Route::get('/cargos/{id?}',[\App\Http\Controllers\CargoController::class,'getCargos']);
Route::get('/prevision',[\App\Http\Controllers\PrevisionController::class,'getPrevicion']);
Route::get('/prevision_inp',[\App\Http\Controllers\PrevisionInpController::class,'getPrevicioninp']);
Route::get('/salud',[\App\Http\Controllers\SaludController::class,'getSalud']);
Route::get('/nacionalidades',[\App\Http\Controllers\NacionalidadController::class,'getNacionalidad']);
Route::get('/pueblos_originarios',[\App\Http\Controllers\PuebloOriginarioController::class,'getPuebloOriginarios']);
Route::get('/codigo_parentesco',[\App\Http\Controllers\CargaFamiliarController::class,'getCadigoParentesco']);
Route::get('/tipo_licencia',[\App\Http\Controllers\LicenciaController::class,'getTipoLicencia']);
Route::get('/ahorro-voluntario',[\App\Http\Controllers\AhorroVoluntarioController::class,'getAhorroVoluntario']);
Route::get('/motivos',[\App\Http\Controllers\MotivoController::class,'getMotivo']);
Route::get('/tipo-licencia-medicas',[\App\Http\Controllers\TramiteLicenciaMedicaController::class,'getTipoLicenciaMedicas']);
Route::get('/destinos',[\App\Http\Controllers\DestinoController::class,'getDestinos']);
Route::get('/clientes',[\App\Http\Controllers\ClienteController::class,'getCliente']);

//destinatarios
Route::get('/destinatarios',[DestinatarioController::class,'index'])->name('destinatarios.index');
Route::get('/getDestinarios',[DestinatarioController::class,'getDestinatarios']);
Route::post('/destinatarios/{id?}',[DestinatarioController::class,'store']);

Route::delete('/destinatarios/{id}',[DestinatarioController::class,'destroy']);

