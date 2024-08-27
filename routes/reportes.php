<?php
use App\Http\Controllers\reportes\operaciones\ReportesTripulacionController;

Route::get('/getHistorialTripulacion', [ReportesTripulacionController::class, 'getHistorialTripilacion']);
Route::get('/getHistorialBuses', [ReportesTripulacionController::class, 'getHistorialBusesViajes']);
Route::get('/getHistorialPorConceptos', [ReportesTripulacionController::class, 'getHistorialPorConceptos']);
Route::get('/getBusesPeridos', [ReportesTripulacionController::class, 'getBusesPeridos']);
Route::get('/getViajesMineria', [ReportesTripulacionController::class, 'getViajesMineria']);
//getViajesFolio
Route::get('/getViajesFolio', [ReportesTripulacionController::class, 'getViajesFolio']);
//Imprimir
Route::get('imprimirHistorialBuses', [ReportesTripulacionController::class, 'imprimirHistorialBuses']);
Route::get('/imprimirHistorialTripulacion', [ReportesTripulacionController::class, 'imprimirHistorialTripulacion']);

//comprobante de salida
Route::get('/getComprobanteSalida/{id}', [\App\Http\Controllers\ViajeController::class, 'comprobanteSalida']);
Route::get('/getCertificadoSanitizacion/{id?}', [\App\Http\Controllers\ViajeController::class, 'getCertificadoSanitizacion']);
