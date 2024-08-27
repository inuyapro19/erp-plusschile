<?php

namespace App\Http\Controllers;


use App\Exports\Trabajadores as TrabajadoresExport;
use App\Imports\TrabajadoresImport;

use App\Models\AhorroVoluntarioTrabajador;
use App\Models\BancoTrabajador;
use App\Models\CargaFamiliar;
use App\Models\Cargo;
use App\Models\Comunas;
use App\Models\Contacto;
use App\Models\Contrato;
use App\Models\Empleador;
use App\Models\LicenciaConducir;
use App\Models\Prevision;
use App\Models\PrevisionTrabajador;
use App\Models\Region;
use App\Models\Salud;
use App\Models\SaludDiscapacidad;
use App\Models\SaludEnfermedad;
use App\Models\SaludTrabajador;
use App\Models\Trabajador;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

use mysql_xdevapi\Exception;
use Session;

class TrabajadorController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth','active_user']);
        //Session::flash('notificaciones',auth()->user()->unreadNotifications);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $cargos = Cargo::orderBy('nombre_cargo','asc')->get();
        $empresas = Empleador::orderBy('nombre_empleador','asc')->get();
        $ubicaciones = Ubicacion::orderBy('id','asc')->get();

        if (empty('rol')){
           $roles = 'no';
        }else{
            $roles = request('rol');
        }

        return view('trabajador.index',[
            'cargos'=>$cargos,
            'empresas'=>$empresas,
            'ubicaciones'=>$ubicaciones,
            'notificaciones'=>auth()->user()->unreadNotifications,
            'roles'=>$roles ?? 'no'
        ]);
    }

    public function getTrabajadores(Request $request){
        try {
           $opciones = request('opciones');
            $cargo = $request->cargo_id;
           // con paginacion o sin paginacion
            if ($opciones == 'listPage'){
                //trabajadores por paginas

                    $paginate =  request('perpage');
                    $trabajador = \App\Models\Vistas\Trabajador::filtros()
                        ->orderBy(request('orderPor'),request('order'))
                        ->paginate($paginate);


            }else{
                //todos los trabajadores
                $trabajador = Trabajador::with(['buses','contrato.ubicacion','contrato.cargo','contrato.empleador','user.roles'])
                    ->filtros()
                    ->filtroCargo()
                    ->filtroEmpleador()
                    ->filtroUbicacion()
                    ->estados()
                    ->UserRole()
                    ->get();
            }
            return response($trabajador,200);

        } catch (\Exception $exception){

            return response(['error'=>$exception->getMessage()],422);

        }

    }

    public function getFiltro(Request $request){
        try {
            //return response($request->all());
            $trabajador = DB::select('select t.id, t.codigo_trabajador, t.rut, t.primer_nombre ,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,
               t.telefono_local, t.telefono_celular, t.fecha_nac, t.estado_civil, t.sexo, t.grado_escolaridad, t.direccion,
               t.pertenece_pueblo_originario, t.tiene_familia,
               t.tiene_discapacidad, t.user_id, t.correo, t.estado,c.empleador_id,e.nombre_empleador
               ,c3.nombre_comuna,r.nombre_region,n.descripcion_nacionalidad,po.pueblo_originario,c.cargo_id,c2.nombre_cargo,u.nombre_ubicacion,pre.nombre_prevision
                from trabajadores t
                left join contrato c on t.id = c.trabajador_id
                left join prevision_trabajadores pt on c.prevision_id = pt.prevision_id
                left join previsiones pre on pt.prevision_id = pre.id
                left join cargos c2 on c2.id = c.cargo_id
                left join empleadores e on c.empleador_id = e.id
                left join ubicaciones u on c.ubicacion_id = u.id
                left join pueblo_originarios po on t.pueblo_originario_id = po.id
                left join regiones r on t.region_id = r.id
                left join comunas c3 on t.comuna_id = c3.id
                left join nacionalidades n on t.nacionalidad_id = n.id
                where  estado != "desvinculado"
                or t.rut = '.$request->rut.'
                and c.cargo_id  = '.$request->cargo_id.'
                and c.empleador_id = '.$request->empleador_id.'
                order by t.rut asc');

            return response($trabajador,200);

        }catch (\Exception $exception){
            return response($exception,302);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trabajador.create',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }
    /**
     * Valida los datos de la solicitud.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateRequest($request)
    {
        $request->validate([
            'rut'=>'required|unique:trabajadores|unique:users',
            'primer_nombre'=>'required',
            'primer_apellido'=>'required',
            'fecha_nac'=>'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'sexo'=>'required',
            'grado_escolaridad'=>'required',
            'estado_civil'=>'required',
            'telefono_celular'=>'required',
            'correo'=>'required|email|regex:/(.+)@(.+)\.(.+)/i',
            'confirmar_correo'=>'required|email|regex:/(.+)@(.+)\.(.+)/i',
            'direccion'=>'required',
            'region_id'=>'required',
            'comuna_id'=>'required',
            'nacionalidad'=>'required',
            'ubicacion_id'=>'required',
            'fecha_ingreso'=>'required',
            'fecha_antiguidad'=>'required',
            'fecha_vencimiento_contrato'=>'required',
            'area_id'=>'required',
            'cargo_id'=>'required' ,
            'prevision_id'=>'required',
            'salud_id'=>'required',
            'centro_costo'=>'required',
            'tipo_jornada'=>'required',
            'tipo_contrato'=>'required',
            'empleador_id'=>'required'
        ]);
    }
    /**
     * crea el trabajador y el usuario y todos los datos relacionados
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            /********************************************************/
            /*               Validaciones                        ***/
            /******************************************************/

            $this->validateRequest($request);

            /********************************************************/
            /*               NUEVO USUARIO                       ***/
            /******************************************************/
            $user = new User();
            $user->rut = $request->rut;
            $user->name = $request->primer_nombre;
            $user->apellidos = $request->primer_apellido;
            $user->email = $request->correo;

            /*         Contraseña de temporal           */
            $user->password = bcrypt('pluss2021'); //settear desde setting o paramentros

            $user->primer_login = 'Y';
            $user->cambio_contrasena = 'N';
            $user->oficina_id = 17;

            $user->save();
            /********************************************************/
            /*            ASIGNAR  ROL TRABAJADOR                ***/
            /******************************************************/
            $user->assignRole('trabajador');

            /********************************************************/
            /*          GENERA CODIGO DE TRABAJAR                ***/
            /******************************************************/
            if($request->has('empleador_id')) {
                $empleador =  Empleador::find($request->empleador_id);

                $id = $empleador->codigo_empresa.'-00'.rand(1,500);

            }

           // return $request->all();

            /********************************************************/
            /*           CREAR  TRABAJADOR                       ***/
            /******************************************************/
            $trabajador = Trabajador::create([
                'codigo_trabajador'=>$id,
                'rut'=>$request->rut,
                'primer_nombre'=>$request->primer_nombre,
                'segundo_nombre'=>$request->has('segundo_nombre') ? $request->segundo_nombre : ' ',
                'primer_apellido'=>$request->primer_apellido,
                'segundo_apellido'=>$request->has('segundo_apellido') ? $request->segundo_apellido : ' ',
                'fecha_nac'=>$request->fecha_nac,
                'estado_civil'=>$request->estado_civil,
                'sexo'=>$request->sexo,
                'grado_escolaridad'=>$request->grado_escolaridad,
                'telefono_local'=>$request->telefono_local,
                'telefono_celular'=>$request->telefono_celular,
                'correo'=>$request->correo,
                'direccion'=>$request->direccion,
                'user_id'=>$user->id,
                'region_id'=>$request->region_id,
                'comuna_id'=>$request->comuna_id,
                'nacionalidad_id'=>$request->nacionalidad,
                'pertenece_pueblo_originario'=>$request->pertenece_pueblo_originario,
                'pueblo_originario_id'=>$request->pueblo_originario_id > 0 ? $request->pueblo_originario_id : null ,
                'tiene_familia'=>$request->carga_familiar,
                'tiene_discapacidad'=>$request->tiene_alguna_discapacidad,
                'estado'=>'contratado',
                'condicion'=>'disponible',
            ]);

            /********************************************************/
            /*           CREAR  CONTRATO                         ***/
            /******************************************************/
            $contrato = Contrato::create([
                'ubicacion_id'=>$request->ubicacion_id,
                'fecha_ingreso'=>$request->fecha_ingreso,
                'fecha_antiguidad'=>$request->fecha_antiguidad,
                'fecha_vencimiento_contrato'=>$request->fecha_vencimiento_contrato,
                'fecha_segundo_vencimiento'=>$request->fecha_vencimiento_contrato_segundo,
                'area_id'=>$request->area_id > 0 ? $request->area_id : null ,
                'cargo_id'=>$request->cargo_id > 0 ? $request->cargo_id : null ,
                'trabajador_id'=>$trabajador->id,
                'centro_costo'=>$request->centro_costo,
                'tipo_jornada'=>$request->tipo_jornada,
                'jornada_excepcional'=>$request->jornada_excepcional,
                'empleador_id'=>$request->empleador_id,
                'tipo_contrato'=>$request->tipo_contrato
            ]);
            /********************************************************/
            /*           CREAR  Prevision                         ***/
            /******************************************************/
            $prevision = PrevisionTrabajador::create([
                'tipo_entidad'=>$request->tipo_prevision,
                'prevision_id'=>$request->prevision_id,
                'prevision_inp_id'=>$request->tipo_entidad =='inp' ? $request->prevision_inp_id : null,
                'trabajador_id'=>$trabajador->id
            ]);

            /********************************************************/
            /*           CREAR  Salud                            ***/
            /******************************************************/
            $salud = SaludTrabajador::create([
                'salud_id'=>$request->salud_id,
                'cotiza_siete_porciento'=>$request->cotiza_siete_porciento,
                'tipo_plan_salud'=>$request->tipo_plan_salud,
                'monto_peso'=>$request->monto_peso,
                'monto_uf'=>$request->monto_uf,
                'trabajador_id'=>$trabajador->id
            ]);
            /********************************************************/
            /*           CREAR  Ahorro                           ***/
            /******************************************************/
            $ahorros = json_decode($request->prevision_ahorro);
            //dd(json_decode($contactos));
            foreach ($ahorros as $ahorro )
            {
                foreach($ahorro as $item)
                {
                    AhorroVoluntarioTrabajador::create([
                        'tipo_ahorro'=>$item->tipo_ahorro,
                        'ahorro_voluntario_id'=>$item->ahorro_voluntario_id,
                        'tipo_moneda'=>$item->tipo_moneda,
                        'monto'=>$item->monto,
                        'forma_pago'=>$item->forma_pago
                    ]);
                }
            }


            /********************************************************/
            /*           CREAR  CONTACTO                         ***/
            /************************************** ****************/
           $contactos = json_decode($request->contacto);
            //dd(json_decode($contactos));
            foreach ($contactos as $contacto )
            {
                foreach($contacto as $item)
                {
                    Contacto::create([
                        'nombre'=>$item->nombre,
                        'apellido'=>$item->apellido,
                        'correo'=>$item->correo,
                        'telefono'=>$item->telefono,
                        'direccion'=>$item->direccion,
                        'region_id'=>$item->region_id,
                        'comuna_id'=>$item->comuna_id,
                        'parentesco' => $item->parentesco,
                        'otro_parentesco' =>$item->otro_parentesco,
                        'trabajador_id'=>$trabajador->id
                    ]);
                }
            }
            /*
             * controto_instlacion: [{id: 1, nombre: "Contrato de instalación"}, {id: 2, nombre: "Contrato de instalación"}]
             *
             * */

            /********************************************************/
            /*           CREAR  BANCOS                         ***/
            /******************************************************/

            $banco_trabajador = json_decode($request->bancosTrabajador);

            foreach ($banco_trabajador as $bancos )
            {
                foreach($bancos as $item)
                {
                    BancoTrabajador::create([
                        'banco_id' =>$item->banco_id,
                        'trabajador_id'=>$trabajador->id,
                        'fecha_ingreso_cuenta'=>$item->fecha_ingreso_cuenta,
                        'nro_cuenta'=>$item->nro_cuenta,
                        'tipo_cuenta'=>$item->tipo_cuenta,
                        'predeterminado'=>$item->predeterminado ? 'Y':'N'
                    ]);
                }
            }
            /********************************************************/
            /*           CREAR  Carga familiar                     ***/
            /******************************************************/
            if($request->has('cargaFamiliar'))
            {
                $carga_familiar = json_decode($request->cargaFamiliar);

                foreach ($carga_familiar as $carga)
                {
                    foreach($carga as $item)
                    {
                        CargaFamiliar::create([
                            'rut'=>$item->rut,
                            'nombres'=>$item->nombres,
                            'apellidos'=>$item->apellidos,
                            'fecha_nacimiento'=>$item->fecha_nacimiento,
                            'fecha_vencimiento_carga'=>$item->fecha_vencimiento_carga,
                            'parentesco_id'=>$item->parentesco_id,
                            'trabajador_id'=>$trabajador->id
                        ]);
                    }
                }
            }

            /********************************************************/
            /*           CREAR  licencias                         ***/
            /******************************************************/

            if($request->has('licencia'))
            {
                LicenciaConducir::create([
                    'tipo_licencia_id'=>$request->tipo_licencia_id,
                    'nro_serie'=>$request->nro_serie,
                    'fecha_de_ingreso'=>$request->fecha_de_ingreso,
                    'fecha_de_vencimiento'=>$request->fecha_de_vencimiento,
                    'trabajador_id'=>$trabajador->id
                ]);
            }
            /********************************************************/
            /*           CREAR  Discapacidad                     ***/
            /******************************************************/
            $saludDiscapacidad = SaludDiscapacidad::firstOrNew(['trabajador_id'=>$trabajador->id]);
            $saludDiscapacidad->posee_carnet = $request->posee_carnet;
            $saludDiscapacidad->discpacidad = $request->discapacidad;
            $saludDiscapacidad->causa_principal = $request->causa_principal;
            $saludDiscapacidad->causa_secundaria = $request->causa_secundaria;
            $saludDiscapacidad->capacidad_reducidad = $request->capacidad_reducidad;
            $saludDiscapacidad->trabajador_id;
            $saludDiscapacidad->save();

            /********************************************************/
            /*           CREAR  Enfermedad                     ***/
            /******************************************************/
            $enfermedad = SaludEnfermedad::firstOrNew(['trabajador_id'=>$trabajador->id]);

            $enfermedad->enfermedad_prexistente = $request->enfermedad_prexistente;
            $enfermedad->tipo_sangre = $request->tipo_sangre;
            $enfermedad->enfermedades = $request->enfermedades;
            $enfermedad->medicamentos = $request->medicamentos;
            $enfermedad->trabajador_id = $trabajador->id;
            $enfermedad->save();


            return response()->json(['message' => 'Trabajador creado con éxito'], 200);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            // Manejo de excepciones de validación
            return response()->json(['error' => 'Datos de entrada inválidos', 'details' => $ve->errors()], 422);
        } catch (\Illuminate\Database\QueryException $qe) {
            // Manejo de excepciones de base de datos
           // \Log::error("Error en base de datos: " . $qe->getMessage());
            return response()->json(['error' => 'Error al procesar la solicitud en la base de datos'], 500);
        } catch (\Exception $e) {
            // Manejo de cualquier otra excepción
            ///\Log::error("Error inesperado: " . $e->getMessage());
            return response()->json(['error' => 'Error inesperado al procesar la solicitud'], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //hacer modificacion de contacto

        $trabajador = Trabajador::with(['contrato','contacto','cargaFamiliares','previsiontrabajador','saludtrabajador','bancotrabajador.banco','user.roles'])
            ->where('id','=',$id)
            ->UserRole()
            ->first();

        return response($trabajador,200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */

    public function editAdmin($id)
    {
        $trabajador = Trabajador::with(['contrato','contacto','cargaFamiliares','previsiontrabajador','saludtrabajador','bancotrabajador.banco'])
            ->where('id','=',$id)
            ->first();
        //dd($trabajador);
        return view('trabajador.admin_edit',[
            'id'=>$id,
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);

    }



    public function update_admin(Request $request, $id){
        try {
            /********************************************************/
            /*               Validaciones                        ***/
            /******************************************************/
            //return response($request->all(),200);
            /*$request->validate([
                'rut' => 'required',
                'primer_nombre' => 'required',
                'primer_apellido' => 'required',
                'fecha_nac' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'sexo' => 'required',
                'grado_escolaridad' => 'required',
                'estado_civil' => 'required',
                'telefono_celular' => 'required',
                'correo' => 'email|regex:/(.+)@(.+)\.(.+)/i',
                'direccion' => 'required',
                'region_id' => 'required',
                'comuna_id' => 'required',
                'nacionalidad' => 'required',
                'ubicacion_id' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_antiguidad' => 'required',
                'fecha_vencimiento_contrato' => 'required',
                'cargo_id' => 'required',
                'centro_costo' => 'required',
                'tipo_jornada' => 'required',
                'empleador_id' => 'required'
            ]);*/

            $trabajador = Trabajador::find($id);

            $trabajador->update([
                'rut'=>$request->rut,
                'primer_nombre'=>$request->primer_nombre,
                'segundo_nombre'=>$request->has('segundo_nombre') ? $request->segundo_nombre : ' ',
                'primer_apellido'=>$request->primer_apellido,
                'segundo_apellido'=>$request->has('segundo_apellido') ? $request->segundo_apellido : ' ',
                'fecha_nac'=>$request->fecha_nac,
                'estado_civil'=>$request->estado_civil ,
                'sexo'=>$request->sexo,
                'grado_escolaridad'=>$request->grado_escolaridad,
                'telefono_local'=>$request->telefono_local,
                'telefono_celular'=>$request->telefono_celular,
                'correo'=>$request->correo,
                'direccion'=>$request->direccion,
                //'user_id'=>$user->id,
                'region_id'=>$request->region_id,
                'comuna_id'=>$request->comuna_id,
                'nacionalidad_id'=>$request->nacionalidad,
                'pertenece_pueblo_originario'=>$request->pertenece_pueblo_originario,
                'pueblo_originario_id'=>$request->pueblo_originario_id > 0 ? $request->pueblo_originario_id : null ,
                'tiene_familia'=>$request->carga_familiar,
                'tiene_discapacidad'=>$request->tiene_alguna_discapacidad,
            ]);

            /********************************************************/
            /*           CREAR  CONTRATO                         ***/
            /******************************************************/
            $contrato = Contrato::where('trabajador_id','=',$id)->firstOrNew();

            $contrato->ubicacion_id = $request->ubicacion_id;
            $contrato->fecha_ingreso=$request->fecha_ingreso;
            $contrato->fecha_antiguidad=$request->fecha_antiguidad;
            $contrato->fecha_vencimiento_contrato=$request->fecha_vencimiento_contrato;
            $contrato->fecha_segundo_vencimiento=$request->fecha_vencimiento_contrato_segundo;
            $contrato->area_id=$request->area_id > 0 ? $request->area_id : null ;
            $contrato->cargo_id=$request->cargo_id > 0 ? $request->cargo_id : null ;
            $contrato->trabajador_id=$trabajador->id;
            $contrato->centro_costo=$request->centro_costo;
            $contrato->tipo_jornada=$request->tipo_jornada;
            $contrato->jornada_excepcional = $request->jornada_excepcional;
            $contrato->empleador_id=$request->empleador_id;
            $contrato->tipo_contrato=$request->tipo_contrato;

            $contrato->save();
            /********************************************************/
            /*           CREAR  Prevision                         ***/
            /******************************************************/
            $prevision =  PrevisionTrabajador::firstOrNew(['trabajador_id'=>$trabajador->id]);

            $prevision->tipo_entidad=$request->tipo_prevision;
            $prevision->prevision_id=$request->prevision_id;
            $prevision->prevision_inp_id=$request->tipo_prevision =='inp' ? $request->prevision_inp_id : null;
            $prevision->trabajador_id =  $trabajador->id;

            $prevision->save();

            /********************************************************/
            /*           CREAR  Prevision                         ***/
            /******************************************************/
            $salud = SaludTrabajador::firstOrNew(['trabajador_id'=>$trabajador->id]);

            $salud->salud_id = $request->salud_id;
            $salud->cotiza_siete_porciento = $request->cotiza_siete_porciento;
            $salud->tipo_plan_salud=$request->tipo_plan_salud;
            $salud->monto_peso = $request->monto_peso;
            $salud->monto_uf =$request->monto_uf;
            $prevision->trabajador_id =  $trabajador->id;

            $salud->save();


            /********************************************************/
            /*           CREAR  Ahorro                           ***/
            /******************************************************/
            $ahorros = json_decode($request->prevision_ahorro);
            //dd(json_decode($contactos));
            foreach ($ahorros as $ahorro )
            {
                foreach($ahorro as $item)
                {
                    $voluntarios = AhorroVoluntarioTrabajador::firstOrNew(['trabajador_id'=>$trabajador->id]);

                    $voluntarios->tipo_ahorro=$item->tipo_ahorro;
                    $voluntarios->ahorro_voluntario_id=$item->ahorro_voluntario_id;
                    $voluntarios->tipo_moneda = $item->tipo_moneda;
                    $voluntarios->monto = $item->monto;
                    $voluntarios->forma_pago = $item->forma_pago;
                    $voluntarios->save();
                }
            }
            /********************************************************/
            /*           CREAR  CONTACTO                         ***/
            /******************************************************/
            $contactos = json_decode($request->contacto);
            //dd(json_decode($contactos));
            foreach ($contactos as $contacto )
            {
                foreach($contacto as $item)
                {
                    $contacto_trabajador = Contacto::firstOrNew(['id'=>$item->id]);

                    $contacto_trabajador->nombre=$item->nombre;
                    $contacto_trabajador->apellido=$item->apellido;
                    $contacto_trabajador->correo=$item->correo;
                    $contacto_trabajador->telefono=$item->telefono;
                    $contacto_trabajador->direccion=$item->direccion;
                    $contacto_trabajador->region_id=$item->region_id;
                    $contacto_trabajador->comuna_id=$item->comuna_id;
                    $contacto_trabajador->trabajador_id=$trabajador->id;
                    $contacto_trabajador->parentesco = $item->parentesco;
                    $contacto_trabajador->otro_parentesco = $item->otro_parentesco;
                    $contacto_trabajador->save();

                }
            }
            /********************************************************/
            /*           CREAR  BANCOS                         ***/
            /******************************************************/

            $banco_trabajador = json_decode($request->bancosTrabajador);

            foreach ($banco_trabajador as $bancos )
            {
                foreach($bancos as $item)
                {
                    $banco_edicion = BancoTrabajador::firstOrNew(['id'=>$item->id]);

                    $banco_edicion->banco_id =$item->banco_id;
                    $banco_edicion->trabajador_id=$trabajador->id;
                    $banco_edicion->nro_cuenta=$item->nro_cuenta;
                    $banco_edicion->tipo_cuenta=$item->tipo_cuenta;
                    $banco_edicion->fecha_ingreso_cuenta=$item->fecha_ingreso_cuenta;
                    $banco_edicion->predeterminado=$item->predeterminado ? 'Y':'N';
                    $banco_edicion->save();
                }
            }
            /********************************************************/
            /*           CREAR  Carga familiar                     ***/
            /******************************************************/
            if($request->has('cargaFamiliar'))
            {
                $carga_familiar = json_decode($request->cargaFamiliar);

                foreach ($carga_familiar as $carga)
                {
                    foreach($carga as $item)
                    {

                        $familiar =  CargaFamiliar::firstOrNew(['id'=>$item->id]);
                        $familiar->rut=$item->rut;
                        $familiar->nombres=$item->nombres;
                        $familiar->apellidos=$item->apellidos;
                        $familiar->fecha_nacimiento=$item->fecha_nacimiento;
                        $familiar->fecha_vencimiento_carga=$item->fecha_vencimiento_carga;
                        $familiar->parentesco_id=$item->parentesco_id;
                        $familiar->trabajador_id=$trabajador->id;

                        $familiar->save();

                    }
                }
            }

            /********************************************************/
            /*           CREAR  licencias                         ***/
            /******************************************************/

            if($request->has('licencia'))
            {
                $conducir = json_decode($request->licencia);
                foreach($conducir as $licencia_conducir){
                    foreach ($licencia_conducir as $item){
                        $licencias = LicenciaConducir::firstOrNew(['trabajador_id'=>$trabajador->id]);

                        $licencias->tipo_licencia_id=$item->tipo_licencia_id;
                        $licencias->tipo_licencia=$item->tipo_licencia_id;
                        $licencias->nro_serie=$item->nro_serie;
                        $licencias->fecha_de_ingreso=$item->fecha_de_ingreso;
                        $licencias->fecha_de_vencimiento=$item->fecha_de_vencimiento;
                        $licencias->trabajador_id=$trabajador->id;
                        $licencias->save();
                    }
                }
            }
            /********************************************************/
            /*           CREAR  Discapacidad                     ***/
            /******************************************************/
            $saludDiscapacidad = SaludDiscapacidad::firstOrNew(['trabajador_id'=>$trabajador->id]);
            $saludDiscapacidad->posee_carnet = $request->posee_carnet;
            $saludDiscapacidad->discpacidad = $request->discapacidad;
            $saludDiscapacidad->causa_principal = $request->causa_principal;
            $saludDiscapacidad->causa_secundaria = $request->causa_secundaria;
            $saludDiscapacidad->capacidad_reducidad = $request->capacidad_reducidad;
            $saludDiscapacidad->trabajador_id;
            $saludDiscapacidad->save();

            /********************************************************/
            /*           CREAR  Enfermedad                     ***/
            /******************************************************/
            $enfermedad = SaludEnfermedad::firstOrNew(['trabajador_id'=>$trabajador->id]);

            $enfermedad->enfermedad_prexistente = $request->enfermedad_prexistente;
            $enfermedad->tipo_sangre = $request->tipo_sangre;
            $enfermedad->enfermedades = $request->enfermedades;
            $enfermedad->medicamentos = $request->medicamentos;
            $enfermedad->trabajador_id = $trabajador->id;
            $enfermedad->save();


            return response('success',200);

        }catch (Exception $exception){
            return response($exception ,422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try{

            $find = (int) $id;
            $trabajador = Trabajador::find($find);
            $user = User::find($trabajador->user_id);
            $trabajador->delete();
            $user->delete();

            //Session::flash('success','Trabajador desvinculado exitosamente');
            return response($trabajador,200);
        }catch (\Throwable $e){
            return response($e,403);
        }
    }

    public function user_import()
    {
        return view('trabajador.import',['notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function user_import_excel(Request $request)
    {
        $request->validate([
            'excel'=>'required',
        ]) ;

        Excel::import(new TrabajadoresImport(),request()->file('excel'));

       return Redirect::to("/trabajador-import")->withSuccess('Importación  exitosa!');
    }

    public function reset($rut)
    {
      try{
         //restablecer contraseña
            $user = User::where('rut',$rut)->first();
            $user->password = Hash::make('pluss2021');
            $user->save();
            return response('success',200);

      }catch (\Throwable $e){
          return response($e,403);
      }
    }



    public function reincorporar($id){

        $trabajador = Trabajador::find($id);
        $user = User::find($trabajador->user_id);

        $trabajador->restore();
        $user->restore();

        return response('success',200);
    }

    public function descargar()
    {
        return Excel::download(new TrabajadoresExport, 'trabajadores.xlsx');
    }

}
