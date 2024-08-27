<?php


Route::get('/ingreso-gastos-recaudacion-viaje',[\App\Http\Controllers\RecaudacionGastosController::class,'index'])->name('gastos.index');
Route::post('/ingreso-gastos-viaje',[\App\Http\Controllers\RecaudacionGastosController::class,'store']);
Route::get('/getGastos',[\App\Http\Controllers\RecaudacionGastosController::class,'getGastos']);
Route::get('/getMontoViaje',[\App\Http\Controllers\RecaudacionGastosController::class,'getMontoViaje']);
Route::delete('/ingreso-gastos-viaje/{id}',[\App\Http\Controllers\RecaudacionGastosController::class,'destroy']);


Route::get('/pasajes-en-camino',[\App\Http\Controllers\PasajeController::class,'index'])->name('pasajes.index');
Route::get('/getPasajes',[\App\Http\Controllers\PasajeController::class,'getPasaje']);
Route::post('/pasajes-en-camino/{id?}',[\App\Http\Controllers\PasajeController::class,'store']);

Route::get('/documentos-viaje',[\App\Http\Controllers\DocumentoViajesController::class,'index'])->name('documentoviajes.index');
Route::get('/getDocumentoViaje',[\App\Http\Controllers\DocumentoViajesController::class,'getDocumentoViaje']);
Route::post('/documentos-viaje/{id?}',[\App\Http\Controllers\DocumentoViajesController::class,'store']);
Route::delete('/documentos-viaje/{id}',[\App\Http\Controllers\DocumentoViajesController::class,'destroy']);

//egresos cajas
Route::get('/egresos-caja',[\App\Http\Controllers\GastoEgresoCajaController::class,'index'])->name('gastoEgresoCajas.index');
Route::get('/getEgresoCajas',[\App\Http\Controllers\GastoEgresoCajaController::class,'getGastoCaja']);
Route::post('/save-egreso-caja/{id?}',[\App\Http\Controllers\GastoEgresoCajaController::class,'store']);
Route::delete('/egresos-caja/{id}',[\App\Http\Controllers\GastoEgresoCajaController::class,'destroy']);

//reporte cierre caja
Route::get('/reporte-cierre-caja',[\App\Http\Controllers\GastoEgresoCajaController::class,'cierreCaja']);


//autorizados trabajadores
Route::get('/trabajadores-autorizados',[\App\Http\Controllers\TrabajadoresAutorizadosController::class,'getTrabajadoresAutorizados']);
