<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckPermission;
use App\Models\TrabajadorBono;


Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
    ->name('dashboard.administrador')
    ->middleware([CheckPermission::class.':dashboard admin']);
;
Route::get('/dashboard/rrhh', [DashboardController::class, 'rrhhDashboard'])
    ->name('dashboard.rrhh')
    ->middleware([CheckPermission::class.':dashboard rrhh']);
//dashboard.trabajador
Route::get('/dashboard/trabajador', [DashboardController::class, 'trabajadorDashboard'])
    ->name('dashboard.trabajador')
    ->middleware([CheckPermission::class.':dashboard trabajador']);

Route::resource('/trabajadores',\App\Http\Controllers\TrabajadorController::class);
Route::get('/lista-trabajadores',[\App\Http\Controllers\TrabajadorController::class,'getTrabajadores']);
Route::get('/lista-tripulacion',[\App\Http\Controllers\TripulacionController::class,'getListaTripulaciones']);

Route::get('/trabajadores/{id}/edita_admin',[\App\Http\Controllers\TrabajadorController::class,'editAdmin'])->name('trabajadores.edit.admin');
Route::post('/trabajador-filtro',[\App\Http\Controllers\TrabajadorController::class,'getFiltro'])->name('trabajadores.filtrar');
Route::get('/trabajadores/reset/{rut}',[\App\Http\Controllers\TrabajadorController::class,'reset'])->name('trabajadores.reset');
Route::post('/trabajadores/update_admin/{id}',[\App\Http\Controllers\TrabajadorController::class,'update_admin'])->name('trabajadores.admin.update');

Route::get('/generar-certificado-antiguidad/{id}',[\App\Http\Controllers\PdfController::class,'generarDocumentoPdf']);

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/show', [ProfileController::class, 'show']);

Route::get('/editar_contrasena',[\App\Http\Controllers\PerfilController::class,'editar_contrasena'])->name('user.cambio_contrasena');
Route::post('/cambiar_contrasena',[\App\Http\Controllers\PerfilController::class,'cambio_contrasena']);
//TRABAJADORES Desviculados
Route::POST('/trabajadores-desvinculador/{id}',[\App\Http\Controllers\TrabajadorDesvinculadosController::class,'destroy']);
Route::get('/desvinculados',[\App\Http\Controllers\TrabajadorDesvinculadosController::class,'index'])->name('desvinculador.index');
Route::get('/lista-trabajadores-desvinculados',[\App\Http\Controllers\TrabajadorDesvinculadosController::class,'getDesvinculados']);
Route::get('/formulario-reincorpocacion/{id}',[\App\Http\Controllers\TrabajadorDesvinculadosController::class,'reincorporar_trabajador'])->name('formulario-reincorporacion');
Route::post('/reincorporar/{id}',[\App\Http\Controllers\TrabajadorDesvinculadosController::class,'reincorporar'])->name('trabajadores.reincorporar');

Route::get('/configuracion',[\App\Http\Controllers\ConfiguracionController::class,'index'])->name('configuracion.index');
Route::post('/nacionalidades',[\App\Http\Controllers\NacionalidadController::class,'store'])->name('nacionalidades.index');
Route::put('/nacionalidades/{id}',[\App\Http\Controllers\NacionalidadController::class,'update'])->name('nacionalidades.upated');
Route::delete('/nacionalidades/{id}',[\App\Http\Controllers\NacionalidadController::class,'destroy'])->name('nacionalidades.destroy');

Route::post('/areas',[\App\Http\Controllers\AreasController::class,'store'])->name('area.store');
Route::put('/areas/{id}',[\App\Http\Controllers\AreasController::class,'update'])->name('area.update');
Route::delete('/areas/{id}',[\App\Http\Controllers\AreasController::class,'destroy'])->name('area.destroy');

Route::get('/getOficinas',[\App\Http\Controllers\OficinaController::class,'getOficinas']);
Route::post('/oficinas',[\App\Http\Controllers\OficinaController::class,'store'])->name('oficina.store');
Route::put('/oficinas/{id}',[\App\Http\Controllers\OficinaController::class,'update'])->name('oficina.update');
Route::delete('/oficinas/{id}',[\App\Http\Controllers\OficinaController::class,'destroy'])->name('oficina.destroy');

Route::post('/cargos',[\App\Http\Controllers\CargoController::class,'store'])->name('cargo.store');
Route::put('/cargos/{id}',[\App\Http\Controllers\CargoController::class,'update'])->name('cargo.update');
Route::delete('/cargos/{id}',[\App\Http\Controllers\CargoController::class,'destroy'])->name('cargo.destroy');

Route::post('/previsiones',[\App\Http\Controllers\PrevisionController::class,'store'])->name('prevision.store');
Route::put('/previsiones/{id}',[\App\Http\Controllers\PrevisionController::class,'update'])->name('prevision.update');
Route::delete('/previsiones/{id}',[\App\Http\Controllers\PrevisionController::class,'destroy'])->name('prevision.destroy');

Route::post('/previsiones_inp',[\App\Http\Controllers\PrevisionInpController::class,'store'])->name('previsioninp.store');
Route::put('/previsiones_inp/{id}',[\App\Http\Controllers\PrevisionInpController::class,'update'])->name('previsioninp.update');
Route::delete('/previsiones_inp/{id}',[\App\Http\Controllers\PrevisionInpController::class,'destroy'])->name('previsioninp.destroy');

Route::post('/salud',[\App\Http\Controllers\SaludController::class,'store'])->name('salud.store');
Route::put('/salud/{id}',[\App\Http\Controllers\SaludController::class,'update'])->name('salud.update');
Route::delete('/salud/{id}',[\App\Http\Controllers\SaludController::class,'destroy'])->name('salud.destroy');

Route::post('/bancos',[\App\Http\Controllers\BancoController::class,'store'])->name('bancos.store');
Route::put('/bancos/{id}',[\App\Http\Controllers\BancoController::class,'update'])->name('bancos.update');
Route::delete('/bancos/{id}',[\App\Http\Controllers\BancoController::class,'destroy'])->name('bancos.destroy');

Route::post('/ubicaciones',[\App\Http\Controllers\UbicacionController::class,'store'])->name('ubicaciones.store');
Route::put('/ubicaciones/{id}',[\App\Http\Controllers\UbicacionController::class,'update'])->name('ubicaciones.update');
Route::delete('/ubicaciones/{id}',[\App\Http\Controllers\UbicacionController::class,'destroy'])->name('ubicaciones.destroy');

Route::post('/empleadores/{id?}',[\App\Http\Controllers\EmpleadorController::class,'store'])->name('empleadores.store');
//Route::put('/empleadores/{id}',[\App\Http\Controllers\EmpleadorController::class,'update'])->name('empleadores.update');
Route::delete('/empleadores/{id}',[\App\Http\Controllers\EmpleadorController::class,'destroy'])->name('empleadores.destroy');

Route::post('/motivos',[\App\Http\Controllers\MotivoController::class,'store'])->name('motivo.store');
Route::put('/motivos/{id}',[\App\Http\Controllers\MotivoController::class,'update'])->name('motivo.update');
Route::delete('/motivos/{id}',[\App\Http\Controllers\MotivoController::class,'destroy'])->name('motivo.destroy');

//editar
Route::get('/cargaContrato/{id}',[\App\Http\Controllers\ContratoController::class,'getContrato']);
Route::get('/cargaContacto/{id}',[\App\Http\Controllers\ContactoController::class,'getContacto']);
Route::get('/cargaFamiliar/{id}',[\App\Http\Controllers\CargaFamiliarController::class,'getCargaFamiliar']);
Route::get('/cargaBancos/{id}',[\App\Http\Controllers\OtrosController::class,'getBancos']);

Route::get('/cargaPrevisiones/{id}',[\App\Http\Controllers\PrevisionController::class,'getCargarPrevisiones']);
Route::get('/cargaSalud/{id}',[\App\Http\Controllers\SaludController::class,'getCargarSalud']);
Route::get('/cargaAhorros/{id}',[\App\Http\Controllers\AhorroVoluntarioController::class,'getCargaAhorros']);
Route::get('/CargarLicencias/{id}',[\App\Http\Controllers\LicenciaController::class,'getCargaLicencias']);


//nuevo roles
Route::get('/roles-usuarios',[\App\Http\Controllers\RoleController::class,'index'])->name('role.index');
Route::get('/roles-usuarios/create',[\App\Http\Controllers\RoleController::class,'create'])->name('role.create');
Route::get('/getRoles',[\App\Http\Controllers\RoleController::class,'getRoles']);
Route::get('/getPermisos',[\App\Http\Controllers\RoleController::class,'getPermission']);
Route::post('/role/{id?}',[\App\Http\Controllers\RoleController::class,'store'])->name('role.store');
Route::get('/role/{id}',[\App\Http\Controllers\RoleController::class,'getRolebyId']);
//Route::put('/role/{id}',[\App\Http\Controllers\RoleController::class,'update'])->name('roles.update');
Route::delete('/role/{id}',[\App\Http\Controllers\RoleController::class,'destroy'])->name('roles.destroy');
Route::get('/asignar-roles',[\App\Http\Controllers\RoleController::class,'asignar_roles'])->name('roles.asignar');
Route::post('/asignar-roles-create',[\App\Http\Controllers\RoleController::class,'asignar_roles_create'])->name('roles.asignar.create');

//tramite licencias medicas
Route::get('/licencias-medicas',[\App\Http\Controllers\TramiteLicenciaMedicaController::class,'index'])->name('tramite.index');
Route::get('/getLicencias',[\App\Http\Controllers\TramiteLicenciaMedicaController::class,'getLicenciaMedicas']);
Route::get('/licencias-medicas/create',[\App\Http\Controllers\TramiteLicenciaMedicaController::class,'create'])->name('tramite.create');
Route::post('/licencias-medicas/{id?}',[\App\Http\Controllers\TramiteLicenciaMedicaController::class,'store'])->name('tramite.store');
Route::delete('/licencias-medicas/{id}',[\App\Http\Controllers\TramiteLicenciaMedicaController::class,'destroy']);

//validaciones de campos
Route::post('/licencia_store',[\App\Http\Controllers\LicenciaController::class,'store']);

//EXPORT
Route::get('/export-trabajadores',[\App\Http\Controllers\OtrosController::class,'export_trabajadores'])->name('export.trabajadores');
///trabajadores/descargar
//Route::get('/trabajadores/descargar',[\App\Http\Controllers\TrabajadorController::class,'descargar']);
//Solicitudes
Route::resource('/solicitudes',\App\Http\Controllers\SolicitudController::class);
Route::get('/solicitud-finalizadas',[\App\Http\Controllers\SolicitudController::class,'finalizadas'])->name('solicitud.finalizada');
Route::get('/getSolicitudes',[\App\Http\Controllers\SolicitudController::class,'getSolicitudes'])->name('solicitud.lista');
Route::get('/solicitude-responder/{id}',[\App\Http\Controllers\SolicitudController::class,'verRespuestas'])->name('solicitud.ver.respuestas');
Route::get('/getSolicitudesRespuestas/{id}',[\App\Http\Controllers\SolicitudController::class,'getRespuestas']);

//Sugerencias
Route::resource('/sugerencia',\App\Http\Controllers\SugerenciaController::class);
Route::get('/sugerencias-tipo-sugerencia',[\App\Http\Controllers\SugerenciaController::class,'sugerencia'])->name('sugerencia.todas.sugerencias');
Route::get('/sugerencias-tipo-felicitaciones',[\App\Http\Controllers\SugerenciaController::class,'felicitaciones'])->name('sugerencia.felicitaciones');
Route::get('/mis-sugerencias',[\App\Http\Controllers\SugerenciaController::class,'mis_sugerencias'])->name('sugerencia.mis_sugerencias');
Route::post('/sugerencia-respuestas',[\App\Http\Controllers\SugerenciaController::class,'sugerencia_respuesta'])->name('sugerencia.respuesta');

//importar datos del trabajador por tabla
Route::get('/trabajador-import', [App\Http\Controllers\TrabajadorImport::class, 'user_import'])->name('trabajador.import');
Route::post('/ficha-import-create', [App\Http\Controllers\TrabajadorImport::class, 'ficha_import_create'])->name('trabajador.ficha.create');
Route::post('/ficha-import-update', [App\Http\Controllers\TrabajadorImport::class, 'ficha_import_update'])->name('trabajador.ficha.update');

//Documentos de trabajo
Route::get('/documentos',[\App\Http\Controllers\DocumentosController::class,'index'])->name('documento.index');
Route::get('/getdocumentos',[\App\Http\Controllers\DocumentosController::class,'getDocumentos']);
Route::get('/documento/create',[\App\Http\Controllers\DocumentosController::class,'create'])->name('documento.create');
Route::post('/documentos',[\App\Http\Controllers\DocumentosController::class,'store']);
Route::get('/documentos/{id}',[\App\Http\Controllers\DocumentosController::class,'edit']);
Route::post('/documentos/{id}',[\App\Http\Controllers\DocumentosController::class,'update']);
Route::delete('/documentos/{id}',[\App\Http\Controllers\DocumentosController::class,'destroy']);


//vacaciones

Route::get('/getVacaciones/{id?}',[\App\Http\Controllers\TrabajadorVacacionController::class,'getTrabajadoresVacaciones']);
Route::get('/vacaiones-trabajador',[\App\Http\Controllers\TrabajadorVacacionController::class,'index'])->name('vacaciones.index');
Route::get('/vaciones-trabajador/create',[\App\Http\Controllers\TrabajadorVacacionController::class,'create'])->name('vacaciones.create');
Route::post('/vaciones-trabajador/{id?}',[\App\Http\Controllers\TrabajadorVacacionController::class,'store'])->name('vacaciones.store');
Route::get('/vaciones-trabajador/{id}/edit',[\App\Http\Controllers\TrabajadorVacacionController::class,'edit'])->name('vacaciones.edit');
Route::put('/vaciones-trabajador/{id}',[\App\Http\Controllers\TrabajadorVacacionController::class,'update'])->name('vacaciones.update');
Route::delete('/vaciones-trabajador/{id}',[\App\Http\Controllers\TrabajadorVacacionController::class,'destroy'])->name('vacaciones.destroy');

//clientes

Route::get('/cliente-index',[\App\Http\Controllers\ClienteController::class,'index'])->name('cliente.index');
Route::post('/clientes/{id?}',[\App\Http\Controllers\ClienteController::class,'store'])->name('cliente.create');
Route::delete('/clientes/{id}',[\App\Http\Controllers\ClienteController::class,'destroy'])->name('cliente.delete');

//destinos
Route::get('/destino-index',[\App\Http\Controllers\DestinoController::class,'index'])->name('destinos.index');
Route::post('/destinos/{id?}',[\App\Http\Controllers\DestinoController::class,'store'])->name('destinos.create');
Route::delete('/destinos/{id}',[\App\Http\Controllers\DestinoController::class,'destroy'])->name('destinos.delete');

//calendario
Route::get('/getCalendario',[\App\Http\Controllers\CalendarioConfiguracionController::class,'getCalendario']);
Route::get('/calendario-index',[\App\Http\Controllers\CalendarioConfiguracionController::class,'index'])->name('calendario.index');
Route::post('/calendarios-configuracion/{id?}',[\App\Http\Controllers\CalendarioConfiguracionController::class,'store']);
Route::delete('',[\App\Http\Controllers\CalendarioConfiguracionController::class,'destroy']);
//pdf
Route::get('/vista-previa-documento',[\App\Http\Controllers\DocumentosController::class,'vista_previsa']);
//Route::get('/descarga-documento',[\App\Http\Controllers\PdfController::class,'getDocumento']);

//certificado_vacaciones
Route::get('comprobante-vacaciones-preview',[\App\Http\Controllers\DocumentosController::class,'certificado_vacaciones']);

//RENUMERACIONES
Route::get('/remuneraciones',[\App\Http\Controllers\RemuneracionesController::class,'index'])->name('remuneraciones.index');
//Haberes y descuetos
Route::get('/haberes-y-descuentos',[\App\Http\Controllers\HaberesController::class,'index'])->name('haberes.index');

//bonos haberes
Route::get('/bonos-disponibles',[\App\Http\Controllers\HaberesController::class,'getBonos']);
Route::get('/bonos-disponibles-all',[\App\Http\Controllers\BonoHaberController::class,'getBonos']);
Route::post('/agregar-bonos/{id?}',[\App\Http\Controllers\BonoHaberController::class,'store']);
Route::delete('/eliminar-bonos/{id}',[\App\Http\Controllers\BonoHaberController::class,'destroy']);

//ANTICIPOS HABERES
Route::get('/anticipo-disponibles',[\App\Http\Controllers\HaberesController::class,'getAnticipos']);

//ANTICIPOS HABERES
Route::get('/horas-extras-disponibles',[\App\Http\Controllers\HaberesController::class,'getHorasExtras']);
//ANTICIPOS HABERES
Route::get('/haberes-no-imponibles-disponibles',[\App\Http\Controllers\HaberesController::class,'getHaberesNoImponibles']);
//PRESTAMOS Y CUOTAS
Route::get('/prestamos-inicio',[\App\Http\Controllers\PrestamoController::class,'index'])->name('prestamos.index');
Route::get('/prestamos-disponibles',[\App\Http\Controllers\PrestamoController::class,'getPrestamos']);
Route::post('/agregar-prestamos/{id?}',[\App\Http\Controllers\PrestamoController::class,'store']);
Route::delete('/eliminar-prestamos/{id}',[\App\Http\Controllers\PrestamoController::class,'destroy']);

//asignaciones de bonos

Route::get('/asignacion-bono-trabajador',[\App\Http\Controllers\TrabajadorBonoController::class,'index'])->name('trabajador.bono.index');
Route::get('/bonos-trabajador-disponibles',[\App\Http\Controllers\TrabajadorBonoController::class,'getBonoTrabajador']);
Route::post('/bonos-trabajador-agregar/{id?}',[\App\Http\Controllers\TrabajadorBonoController::class,'store']);
Route::delete('/bonos-trabajador-delete/{id}',[\App\Http\Controllers\TrabajadorBonoController::class,'destroy']);

Route::post('/cambio-estado-bono-asignados',[\App\Http\Controllers\TrabajadorBonoController::class,'cambiosEstado']);
Route::post('/eliminar-masiva-bono-asignados',[\App\Http\Controllers\TrabajadorBonoController::class,'eliminacionMasiva']);
Route::post('/cambio-monto-bono-asignado/{id}',[\App\Http\Controllers\TrabajadorBonoController::class,'cambioMonto']);

Route::get('/liquidacion-mensual',[\App\Http\Controllers\LiquidacionSueldoController::class,'index'])->name('liquidacion.index');
Route::get('/getLiquidacion-mensual/{mes}',[\App\Http\Controllers\LiquidacionSueldoController::class,'getLiquidacionesMensual']);

Route::get('/liquidacion-sueldo-calculo/{mes}/{year}',[\App\Http\Controllers\LiquidacionSueldoController::class,'calculo_remuneraciones']);

Route::post('/eliminar-masiva-liquidacion',[\App\Http\Controllers\LiquidacionSueldoController::class,'eliminacionMasiva']);

Route::get('/mi-liquidacion-mensual/{id}',[\App\Http\Controllers\LiquidacionSueldoController::class,'liquidacion_mensual_all']);

Route::get('/parametros-remuneracion',[\App\Http\Controllers\ParamentroLiquidacion::class,'index'])->name('parametros.liquidacion.index');
Route::get('/getParamentrosRenumeracion',[\App\Http\Controllers\ParamentroLiquidacion::class,'getParamentros']);
Route::post('/paramentros-remuneraciones/{id?}',[\App\Http\Controllers\ParamentroLiquidacion::class,'store']);

Route::get('/rellena-afp',function (){
    $trabajadores = \App\Models\Trabajador::all();
    foreach ($trabajadores as $trabajadore){
        \App\Models\PrevisionTrabajador::create([
            'tipo'=>'afp',
            'prevision_id'=>rand(1,7),
            'trabajador_id'=>$trabajadore->id
        ]);
    }
    return 'success';
});

Route::get('rellena-salud',function (){
    $trabajadores = \App\Models\Trabajador::all();

    foreach ($trabajadores as $trabajadore){

        \App\Models\SaludTrabajador::create([
            'salud_id'=>7,
            'cotiza_siete_porciento'=>'SI',
            'tipo_plan'=>'UF',
            'monto_peso'=>0,
            'monto_uf'=>0,
            'trabajador_id'=>$trabajadore->id
        ]);
    }

    return 'success';

});

Route::get('/rellena-bonos',function (){
    $trabajadores = \App\Models\Trabajador::all();
    foreach ($trabajadores as $trabajadore){

        $trabajador_bono = new TrabajadorBono();

        $trabajador_bono->trabajador_id = $trabajadore->id;
        $trabajador_bono->bonos_id =1;
        $trabajador_bono->mes = 1;
        $trabajador_bono->anyo = 2022;
        $trabajador_bono->monto = 0;
        $trabajador_bono->estado = 'activo';
        $trabajador_bono->save();

    }
    return 'success';
});

Route::post('liquidacion-mensual-pdf',[\App\Http\Controllers\PdfController::class,'liquidacion_mensual_single']);
Route::get('getliquidacion-mensual-pdf-all',[\App\Http\Controllers\PdfController::class,'getLiquidacionesAll']);
Route::post('liquidacion-mensual-pdf-all',[\App\Http\Controllers\PdfController::class,'liquidacion_mensual_all']);

Route::get('/control-meses-renumerable',[\App\Http\Controllers\MesesController::class,'index'])->name('meses.index');
Route::get('/get-control-meses-renumerable',[\App\Http\Controllers\MesesController::class,'getMeses']);
Route::post('/control-meses-renumerable/{id?}',[\App\Http\Controllers\MesesController::class,'store']);

//solo prueba de familiar
Route::get('/carga-familiares-calculo',[\App\Http\Controllers\LiquidacionSueldoController::class,'calcular_carga_familiar']);

//rutas y tramos
Route::get('/rutas',[\App\Http\Controllers\RutaController::class,'index'])->name('ruta.index');
Route::get('/getRutas',[\App\Http\Controllers\RutaController::class,'getTramos']);
Route::post('/rutas/{id?}',[\App\Http\Controllers\RutaController::class,'store']);
Route::delete('/rutas/{id}',[\App\Http\Controllers\RutaController::class,'destroy']);

Route::get('/getGastoTipo',[\App\Http\Controllers\OtrosController::class,'getGastoTipo']);
