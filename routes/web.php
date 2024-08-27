<?php

use App\Models\Reportes\ReportePeajesRazonSocial;
use App\Models\TrabajadorViaje;
use App\Models\User;
use App\Models\Viaje;
use App\Notifications\ViajeFinalizadoNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ViajeFinalizadoMail;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\Auth\LoginController::class,'showLoginForm']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//import
Route::get('/categorias-votacion',[App\Http\Controllers\VotacionController::class,'categoria_votacion'])->name('votacion.categorias');

//votaciones
//Route::get('votacion/{clave?}',[App\Http\Controllers\VotacionController::class,'lista_votacion'])->name('votacion.lista');
//Route::post('/busqueda/{clave}',[App\Http\Controllers\VotacionController::class,'busqueda'])->name('votacion.busqueda');

//Route::post('enviar_votacion/{clave}',[App\Http\Controllers\VotacionController::class,'enviar_voto'])->name('enviar_voto');
//Route::get('/resultado-votacion/{clase}',[App\Http\Controllers\VotacionController::class,'resultados'])->name('resultado_votacion');

/*  RUTAS DE ADMINISTRADOR  */
require __DIR__.'/admin.php';

/*  RUTAS DE ULTILIDADES PARA API  */
require __DIR__.'/ultiliadades.php';

/*  RUTAS DE PERFIL  */
require __DIR__.'/perfil.php';

/* RUTAS DE RRHH */
require __DIR__.'/rrhh.php';

/*  RUTAS DE tripulaciones  */
require __DIR__.'/operaciones.php';

/*  RUTAS DE secretaria */
require __DIR__.'/secretaria.php';

/*  RUTAS DE REPORTES */
require __DIR__.'/reportes.php';

/*  RUTAS DE CALIDAD */
require __DIR__.'/calidad.php';

/*  RUTAS DE PREVENCION */
require __DIR__.'/prevencion.php';

/*  RUTAS DE SISTEMA */
require __DIR__.'/Configuracion.php';

Route::get('/calendario-remuneracion',[\App\Http\Controllers\CalendarioController::class,'index']);

Route::get('/ver-dpf-vacaciones',function (){
    return view('pdf.certificado_vacaciones');
});

Route::get('/ver-dpf-antiguidad',function (){
    return view('pdf.certificado_antiguidad');
});

Route::get('/404',function (){
    return view('errors.404');
})->name('errors.404');

Route::get('/viaje-finalizado',function (){
        //consulta por la fecha y hora de llegada del viaje
        $viaje_finalizado = DB::select("SELECT ID, NRO_VIAJE, BUSES_ID, ORIGEN_ID, DESTINO_ID, VIAJE_ESPECIAL, DESTINO_ESPECIAL, ORIGEN_ESPECIAL, FECHA_VIAJE, HORA_SALIDA, HORA_LLEGADA, FECHA_LLEGADA, NOTA_VIAJE, NOTIFICACION,CLIENTE_ID, EMPLEADOR_ID, TIPO_VIAJE, ESTADO
                                              FROM viajes
                                              WHERE (hora_llegada >= TIME(CURRENT_DATE()) AND fecha_llegada <= CURDATE())
                                              AND (estado = 'EN ORIGEN' OR estado ='EN RUTA')
                                              AND (notificacion = 'N');");
    //return response($viaje_finalizado,200);
        //si devuelve registros cambiar estado a traves del foreach
    $viajes_contar = count($viaje_finalizado);
    if($viajes_contar>0){
        foreach ($viaje_finalizado as $viajes)
        {
            $viaje =  Viaje::find($viajes->ID);
            $viaje->notificacion = 'Y';
            $viaje->estado = 'FINALIZADO';
            $viaje->save();

            $bus = \App\Models\Buses::find($viajes->BUSES_ID);
            $bus->estado = 'Bus operativo';
            $bus->save();

            $trabajador_id = TrabajadorViaje::where('viaje_id','=',$viajes->ID)->get();

            foreach ($trabajador_id as $trabajadores){
                $trabajador = Trabajador::find($trabajadores->trabajador_id);
                $trabajador->condicion = 'Disponible';
                $trabajador->save();
            }

        }
        //dispara correo recordatorio al encargado
        Mail::send(new ViajeFinalizadoMail($viaje_finalizado));
        $user = User::with(['role'=>function($q){
            $q->where('name','=','operaciopnes');
        }])->get();
    }

    //notificacion al adminsitrador de operaciones
       return response($viaje_finalizado,200);
});

Route::get('/dias-libre-documento',function (){

    return view('pdf.dias');

});

Route::get('/user-operaciones',function (){
    /*$user = User::with(['roles'=>function($q){
        $q->where('name','=','operaciones')->get();
    }])
        ->whereHas('roles')
        ->get();*/
    $roles =   \Spatie\Permission\Models\Role::with('users')
        ->where('name','=','operaciones')
        ->first();
   foreach ($roles->users as $user){
        $user_notificacion = User::find($user->id);
        $user_notificacion->notify(new ViajeFinalizadoNotifications());
    }
    return response($roles,200);
});

Route::get('/tripulaciones-vistas',function (){
   $tripulacion =   \App\Models\Tripulacion::estados()->get();
   return response($tripulacion,200);
});

Route::get('/vacaciones-vistas',function (){

    $tripulacion_vacaciones = \App\Models\Vistas\Vacaciones::get();

    return response($tripulacion_vacaciones,200);
});

Route::get('/calcular-remuneraciones',function (){
   $remunereaciones = DB::select('CALL CALCULAR_REMUNERACION_MENSUAL(12,227)');
   return response($remunereaciones,200);
});

Route::get('/datos-previred',function (){
    $previScraper = new Gfarias\PreviScraper\PreviScraper();
    $previred = $previScraper->previred();
    return (json_encode($previred->all()));
});

//listado de trabajadores por cargo para asignacion de bonos y descuentos mensuales
Route::get('/export-lista-asignacion-bonos',[\App\Http\Controllers\ExportController::class,'export_trabajadores_bonos']);
Route::post('/carga-archivos-asignaciones',[\App\Http\Controllers\ImportController::class,'asignaciones_mensuales_carga']);
Route::post('/carga-archivos-licencias',[\App\Http\Controllers\ImportController::class,'licencias_medicas_carga']);


Route::get('/export-tripulacion-retorno',function (){


    $fecha_inicio = \request('fecha_inicio') ?? '';
    $fecha_fin = \request('fecha_fin') ?? '';

    $tripulacion = \App\Models\Vistas\TripulacionRetornoFechas::filtros();

    if ($fecha_inicio != '' && $fecha_fin != ''){
        $tripulacion = $tripulacion->whereBetween('FECHA_TERMINO',[$fecha_inicio,$fecha_fin]);
    }

   $tripulacion = $tripulacion->orderBy('NOMBRE_CARGO','DESC')
                    ->get();

    return $tripulacion;
});

Route::get('/export-tripulacion-retorno-print',function (){


    $fecha_inicio = \request('fecha_inicio') ?? '';
    $fecha_fin = \request('fecha_fin') ?? '';

    $tripulacion_auxiliar = \App\Models\Vistas\TripulacionRetornoFechas::filtros()->where('NOMBRE_CARGO','=','Auxiliar de Buses');
    $tripulacion_conductores = \App\Models\Vistas\TripulacionRetornoFechas::filtros()->where('NOMBRE_CARGO','=','Conductor de Buses');

    if ($fecha_inicio != '' && $fecha_fin != ''){
        $tripulacion_auxiliar = $tripulacion_auxiliar->whereBetween('FECHA_TERMINO',[$fecha_inicio,$fecha_fin]);
        $tripulacion_conductores = $tripulacion_conductores->whereBetween('FECHA_TERMINO',[$fecha_inicio,$fecha_fin]);
    }

    $tripulacion_auxiliar = $tripulacion_auxiliar->orderBy('NOMBRE_CARGO','ASC')
                    ->orderBy('FECHA_TERMINO','ASC')
                        ->get();
    $tripulacion_conductores = $tripulacion_conductores->orderBy('NOMBRE_CARGO','ASC')
                    ->orderBy('FECHA_TERMINO','ASC')
                        ->get();
    return view('pdf.tripulacion_retorno',compact('tripulacion_auxiliar','tripulacion_conductores'));
});

Route::get('/export-reporte-peajes-razon-social',function (){
    //reporte de peajes por razon social agrupado por fecha BETWEEN '2021-01-01' AND '2021-01-31'
    $fecha_inicio = \request('fecha_inicio') ?? '';
    $fecha_fin = \request('fecha_fin') ?? '';

    $reporte = ReportePeajesRazonSocial::whereBetween('FECHA_ENTREGA',[$fecha_inicio,$fecha_fin])
                                        ->groupBy('BUS')
                                        ->get();

   //$reporte = ReportePeajesRazonSocial::get();

   return $reporte;
});

//GET all buses
Route::get('/getBusesAll',function (){
    $buses = \App\Models\Buses::all();
    return response($buses,200);
});

//obtiene el usuario logeado
Route::get('/getUsuarioLogeado',[App\Http\Controllers\UserController::class,'getUserLogeado']);
//logs sistema
Route::get('/logs', [App\Http\Controllers\sistema\LogSistemaController::class,'index'])->name('logs.index');
//logSistema
Route::get('/getLogSistema',[App\Http\Controllers\sistema\LogSistemaController::class,'getLogSistema']);

Route::get('/bus-dibujo',function (){
    return view('bus');
});

Route::get('/rolesUsuario', [\App\Http\Controllers\RoleController::class,'rolesUsuario']);
Route::get('/assignarRolesTripulacion', [\App\Http\Controllers\UserController::class,'assignTripulanteRole']);
