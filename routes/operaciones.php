<?php

use App\Http\Controllers\BusesController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckPermission;
use App\Models\BusCertificado;

Route::get('/home-operaciones',[DashboardController::class,'operacionesDashboard'])
    ->name('home.operaciones')
    ->middleware([CheckPermission::class.':dashboard operaciones']);

Route::get('/buses',[BusesController::class,'index'])->name('buses.index');
Route::get('/buses/create/{id?}',[BusesController::class,'create'])->name('buses.create');
Route::post('/buses/{id?}',[BusesController::class,'store']);

Route::post('/cambiar_estado-buses/{id}',[\App\Http\Controllers\BusesController::class,'cambio_estado']);

Route::get('/getBuses/{id?}',[\App\Http\Controllers\BusesController::class,'getBuses']);
Route::get('/getBusesLista',[\App\Http\Controllers\BusesController::class,'getBusesLista']);

Route::get('/certificado-buses',[\App\Http\Controllers\BusCertificadoController::class,'index'])->name('bus-certificado.index');
Route::get('/certificado-buses-create',[\App\Http\Controllers\BusCertificadoController::class,'create'])->name('bus-certificado.create');
Route::get('/getCertificadosBuses',[\App\Http\Controllers\BusCertificadoController::class,'getCertificadosBuses']);
Route::post('/certificado-buses-add',[\App\Http\Controllers\BusCertificadoController::class,'store'])->name('bus-certificado.store');

Route::get('/getbuses-choferes',[\App\Http\Controllers\BusesController::class,'getBuses_tripulacion']);

Route::resource('/tripulacion',\App\Http\Controllers\TripulacionController::class);
Route::get('/getTripulacion/{id?}',[\App\Http\Controllers\TripulacionController::class,'getListaTripulaciones']);

Route::get('/viajes',[\App\Http\Controllers\ViajeController::class,'index'])->name('viajes.index');
Route::get('/viajes/create',[\App\Http\Controllers\ViajeController::class,'create'])->name('viajes.create');
Route::post('/viajes',[\App\Http\Controllers\ViajeController::class,'store'])->name('viajes.store');
Route::get('/getViajes',[\App\Http\Controllers\ViajeController::class,'getViajes']); //solo en curso y finalizados
Route::get('/getViajesFinalizados',[\App\Http\Controllers\ViajeController::class,'getViajesFinalizados']); //get finalizados
Route::post('reemplazar-tripulante/{id}',[\App\Http\Controllers\ViajeController::class,'reemplazar_tripulacion']);
Route::get('/ultimoViaje',[\App\Http\Controllers\ViajeController::class,'ultimo_viaje']);
Route::get('/getTramos',[\App\Http\Controllers\OtrosController::class,'getTramos']);
Route::post('/actualizar-viaje/{id}',[\App\Http\Controllers\ViajeController::class,'update']);
//agregar un nuevo tripulante
Route::post('/agregar-tripulante/{id}',[\App\Http\Controllers\ViajeController::class,'agregar_tripulante']);
//eliminar viaje
Route::delete('/eliminar-viaje/{id}',[\App\Http\Controllers\ViajeController::class,'destroy']);

Route::post('/tramos',[\App\Http\Controllers\TramoController::class,'store']);

Route::post('/cambio-estado-viaje/{id}',[\App\Http\Controllers\ViajeController::class,'cambio_estado_viaje']);

Route::get('/gestion',[\App\Http\Controllers\GestionTripulacionController::class,'index'])->name('gestion.index');
Route::post('/gestion',[\App\Http\Controllers\GestionTripulacionController::class,'store'])->name('gestion.store');
Route::get('/getGestionTripulacion',[\App\Http\Controllers\GestionTripulacionController::class,'getGestionTripulacion']);

Route::get('/obtener-ultimo-folio',[\App\Http\Controllers\MontoAsignadoController::class,'obtener_ultimo_folio']);
Route::post('/agregar-folio/{id?}',[\App\Http\Controllers\MontoAsignadoController::class,'agregar_folio']);

Route::post('/agregar-jefe-maquina',[\App\Http\Controllers\TripulacionController::class,'store']);
Route::post('/agregar-gestion',[\App\Http\Controllers\GestionTripulacionController::class,'add_gestion']);

Route::get('/buses-tripulacion-jefe-maquina',[\App\Http\Controllers\TripulacionController::class,'get_buses_conductor']);

Route::get('/certicado-recorrido-pdf/{id}',[\App\Http\Controllers\PdfController::class,'certificado_recorrido']);
Route::get('/generar-folio/{folio}',[\App\Http\Controllers\PdfController::class,'generar_folio']);

Route::post('/actualiza-ubicacion-trabajador/{id}',[\App\Http\Controllers\TripulacionController::class,'actualizacion_ubicacion']);

Route::get('/buses-export',[\App\Http\Controllers\BusesController::class,'export']);

Route::get('/consulta-certificado-por-vencer',function (){
   return   $certificadoBus = \Illuminate\Support\Facades\DB::select(' select `fecha_emision`,fecha_vencimiento ,`tipo_certificado`, `bus_id`, DATEDIFF(fecha_vencimiento, now()) as `dias_por_vencer`
 from `bus_certificados` where `fecha_vencimiento` > now()');
});

Route::get('/dias-libres-pdf/{id}',[\App\Http\Controllers\PdfController::class,'dias_libres']);

Route::get('/montos-entregados',[\App\Http\Controllers\MontoEntregadoController::class,'index'])->name('monto.entregados.index');
Route::get('/getMontoEntregado',[\App\Http\Controllers\MontoEntregadoController::class,'getMontoEntregado']);
Route::post('/montos-entregados',[\App\Http\Controllers\MontoEntregadoController::class,'store']);
Route::post('/cambiar-estado-aprobado-rechazado/{id}',[\App\Http\Controllers\MontoEntregadoController::class,'cambioEstado']);
//Route::post('/montos-entregados',[\App\Http\Controllers\MontoEntregadoController::class,'store']);

//cambio estado tripulante
Route::post('/update-cambio-estado-tripulacion/{id}',[\App\Http\Controllers\TripulacionController::class,'cambio_estado']);

//reporte de tripulacion
Route::get('/reporte-tripulacion',[\App\Http\Controllers\reportes\operaciones\ReportesTripulacionController::class,'index'])->name('reporte.tripulacion.index');
Route::get('/reporte-buses-viajes',[\App\Http\Controllers\reportes\operaciones\ReportesTripulacionController::class,'busesViaje'])->name('reporte.buses.index');

//proximo viaje
Route::get('/proximo-viaje',[\App\Http\Controllers\ViajeController::class,'ProximosViajesview']);

//monto destino
Route::get('/monto-destinos',[\App\Http\Controllers\MontoDestinoController::class,'index'])->name('monto.destino.index');
Route::get('/monto-destino/{id}',[\App\Http\Controllers\MontoDestinoController::class,'getMontoDestinosBydestinoID']);
Route::get('/getMontoDestino',[\App\Http\Controllers\MontoDestinoController::class,'getMontoDestinos']);
Route::post('/monto-destino-store/{id?}',[\App\Http\Controllers\MontoDestinoController::class,'store']);
Route::delete('/monto-destino-delete/{id}',[\App\Http\Controllers\MontoDestinoController::class,'destroy']);

// GET FOLIOS
Route::get('/getFolios',[\App\Http\Controllers\MontoAsignadoController::class,'obtenerFolios']);

//update all viajes status
Route::get('/comprobar-estados-viajes',[\App\Http\Controllers\ViajeController::class,'updateViajesFinalizar']);

