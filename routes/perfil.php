<?php

use App\Http\Controllers\ProfileController;

Route::get('/perfil/{rut}',[\App\Http\Controllers\PerfilController::class,'edit'])->name('perfil.edit');
Route::get('/getPerfil/{rut}',[\App\Http\Controllers\PerfilController::class,'getPerfilTrabajador'])->name('getperfil');
Route::post('/perfil/{rut}',[\App\Http\Controllers\PerfilController::class,'update'])->name('perfil.update');
Route::get('/getPerfilPrimerContacto',[\App\Http\Controllers\PerfilController::class,'getPerfilPrimerContacto']);
Route::get('/getPerfilSegundoContacto',[\App\Http\Controllers\PerfilController::class,'getPerfilSegundoContacto']);
Route::get('/getPerfilContrato',[\App\Http\Controllers\PerfilController::class,'getDatosContractuales']);

//Solicitudes de trabajador
Route::get('/solicitude-trabajador',[\App\Http\Controllers\SolicitudTrabajador::class,'index'])->name('solicitud.trabajador.index');
Route::get('/solicitude-trabajador/create',[\App\Http\Controllers\SolicitudTrabajador::class,'create'])->name('solicitud.trabajador.create');
Route::get('/solicitude-trabajador/{id}',[\App\Http\Controllers\SolicitudTrabajador::class,'edit'])->name('solicitud.trabajador.edit');
Route::post('/solicitude-trabajador-store',[\App\Http\Controllers\SolicitudTrabajador::class,'store'])->name('solicitud.trabajador.store');
Route::post('/solicitude-trabajador-respuestas/{id}',[\App\Http\Controllers\SolicitudTrabajador::class,'solicitud_respuestas'])->name('solicitud.trabajador.respuesta');
Route::get('/getMisSolicitudes',[\App\Http\Controllers\SolicitudTrabajador::class,'getMisSolicitudes']);
Route::get('/getRespuestas/{id}',[\App\Http\Controllers\SolicitudTrabajador::class,'getRespuestas']);
Route::post('/solicitude-admin-respuestas/{id}',[\App\Http\Controllers\SolicitudController::class,'solicitud_respuestas'])->name('solicitud.trabajador.respuesta');

Route::post('/profile/changepassword', [ProfileController::class, 'changePassword']);
