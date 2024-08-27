<?php

namespace App\Http\Controllers\rrhh;

use App\Exports\Trabajadores;
use App\Http\Controllers\Controller;
use App\Models\AhorroVoluntarioTrabajador;
use App\Models\BancoTrabajador;
use App\Models\CargaFamiliar;
use App\Models\Contacto;
use App\Models\Contrato;
use App\Models\Empleador;
use App\Models\LicenciaConducir;
use App\Models\PrevisionTrabajador;
use App\Models\SaludDiscapacidad;
use App\Models\SaludEnfermedad;
use App\Models\SaludTrabajador;
use App\Models\Trabajador;
use App\Models\User;
use App\Models\Vistas\Desvinculados;
use App\Models\Vistas\TrabajadorDesvinculados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use \App\Models\Vistas\Trabajador as TrabajadorVista;
use Maatwebsite\Excel\Facades\Excel;

class TrabajadorController extends Controller
{

    /**
     * This function retrieves a list of workers (trabajadores) based on the provided request parameters.
     *
     * @param Request $request The request object containing all the necessary parameters.
     *
     * @return \Illuminate\Http\Response Returns a response object with the status code and the data.
     *
     * @throws \Exception If there is any error during the execution, an Exception will be thrown.
     *
     * The function first checks the 'opciones' parameter from the request to determine the type of retrieval:
     * - If 'opciones' is 'listPage', it will paginate the results based on the 'perpage' parameter from the request.
     * - Otherwise, it retrieves all workers.
     *
     * The function applies several filters to the query based on the request parameters:
     * - filtros()
     * - filtroCargo()
     * - filtroEmpleador()
     * - filtroUbicacion()
     * - estados()
     * - UserRole()
     *
     * The function also eager loads several related models for each worker:
     * - buses
     * - contrato.ubicacion
     * - contrato.cargo
     * - contrato.empleador
     * - user.roles
     *
     * The function orders the results based on the 'orderPor' and 'order' parameters from the request.
     *
     * Finally, the function returns a response with the status code 200 and the data. If there is any error during the execution, it will return a response with the status code 500 and the error message.
     */
    public function getTrabajadores(Request $request){
        try {
            $opciones = request('opciones');
            $cargo = $request->cargo_id;
            // con paginacion o sin paginacion
            if ($opciones == 'listPage'){
                //trabajadores por paginas

                $paginate =  request('perpage');
                $trabajador = TrabajadorVista::filtros()
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

            return response(['error'=>$exception->getMessage()],500);
        }
    }

    public function create($id = 0)
    {
        // Set a default value for $id when it is not provided or is zero
        $id = $id > 0 ? $id : null;

        return view('trabajador.create', ['id' => $id]);
    }

    public function getTrabajador($id){
        try {
            $trabajador = Trabajador::with([
                'contrato',
                'previsiontrabajador',
                'saludtrabajador',
                'ahorroTrabajador',
                'contacto',
                'bancotrabajador',
                'cargaFamiliares'
               ])
                ->where('id',$id)
                ->first();
            return response($trabajador,200);

        } catch (\Exception $exception){

            return response(['error'=>$exception->getMessage()],500);
        }
    }

    /**
     * Crea o edita un usuario
     *
     * @return $user
     */
    private function storeUser($request, $user_id)
    {
        $user = User::firstOrNew(['id' => $user_id]);
        $user->name = $request->primer_nombre;

        // Verificar si estamos actualizando el usuario (user_id > 0) y si el rut ha cambiado.
        if ($user_id > 0 && $user->rut !== $request->rut) {
            // Aquí podrías agregar una validación adicional para asegurarte de que el nuevo RUT es único
            $user->rut = $request->rut;
        } else if ($user_id == 0) {
            // Para nuevos usuarios, simplemente asigna el RUT
            $user->rut = $request->rut;
        }

        $user->apellidos = $request->primer_apellido . ' ' . $request->segundo_apellido;
        $user->email = $request->correo;
        $user->password = $user_id == 0 ? bcrypt('pluss2021') : $user->password; // Solo asignar nueva contraseña si es un nuevo usuario
        $user->primer_login = 'Y';
        $user->cambio_contrasena = 'N';
        $user->oficina_id = 17;

        $user->save();

        /********************************************************/
        /*            ASIGNAR  ROL TRABAJADOR                ***/
        /******************************************************/
        if ($user_id == 0) { // Solo asignar el rol si es un nuevo usuario
            $user->assignRole('trabajador');
        }

        return $user;
    }

    private function validateRequest($request,$id = 0)
    {
        $request->validate([
            'rut'=> 'required|unique:trabajadores|unique:users',
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
            'nacionalidad_id'=>'required',
            'ubicacion_id'=>'required',
            'fecha_ingreso'=>'required',
            'fecha_antiguidad'=>'required',
            'fecha_vencimiento_contrato'=>'required',
            'area_id'=>'required',
            'cargo_id'=>'required' ,
           /* 'prevision_id'=>'required',
            'salud_id'=>'required',*/
            'centro_costo'=>'required',
            'tipo_jornada'=>'required',
            'tipo_contrato'=>'required',
            'empleador_id'=>'required'
        ]);
    }

    public function store(Request $request, $id = 0)
    {
        try {
            /*** Validar datos ***/
            if ($id == 0){
                $this->validateRequest($request);
            }


            //*** Trabajador existe ***/

            $trabajador = Trabajador::firstOrNew(['id' => $id]);

            /********************************************************/
            /*               NUEVO USUARIO                       ***/
            /******************************************************/
            $user = $this->storeUser($request, $trabajador->user_id ?? 0);

            /*** Crear trabajador ***/
            /********************************************************/
            /*          GENERA CODIGO DE TRABAJAR                ***/
            /******************************************************/
            if($request->has('empleador_id') && $id == 0) {
                $empleador =  Empleador::find($request->empleador_id);

               $codigoTrabajador = $empleador->codigo_empresa.'-00'.rand(1,500);

            }
            /********************************************************/
            /*           CREAR  O ACTUALIZAR                       ***/
            /******************************************************/
            $trabajador->codigo_trabajador = $codigoTrabajador ?? $trabajador->codigo_trabajador;
            $trabajador_id = $this->addEmployee($trabajador,$request,$user,$id);

            /********************************************************/
            /*           CREAR  CONTRATO                         ***/
            /******************************************************/
            $contrato = $this->addWorkcontract($request,$trabajador);


            /********************************************************/
            /*           CREAR  Prevision                         ***/
            /******************************************************/
           $prevision = $this->createOrUpdatePrevisionTrabajador($request, $trabajador->id);

            /********************************************************/
            /*           CREAR  Salud                            ***/
            /******************************************************/
            $salud = $this->createOrUpdateSaludTrabajador($request, $trabajador->id);

            /********************************************************/
            /*           CREAR  Ahorro                           ***/
            /******************************************************/
            $this->createOrUpdateAhorroVoluntarioTrabajador($request);

            /********************************************************/
            /*           CREAR  CONTACTO                         ***/
            /******************************************************/

            $contactos= $this->createOrUpdateContacto($request, $trabajador->id);

            /********************************************************/
            /*           CREAR  BANCOS                         ***/
            /******************************************************/
              $this->createOrUpdateBancoTrabajador($request, $trabajador->id);


            /********************************************************/
            /*           CREAR  Carga familiar                     ***/
            /******************************************************/
           // $this->createOrUpdateCargaFamiliar($request, $trabajador->id);

            /********************************************************/
            /*           CREAR  licencias                         ***/
            /******************************************************/

         //$this->createOrUpdateLicenciaConducir($request, $trabajador->id);
            /********************************************************/
            /*           CREAR  Discapacidad                     ***/
            /******************************************************/
            //$this->createOrUpdateSaludDiscapacidad($request, $trabajador->id);


            /********************************************************/
            /*           CREAR  Enfermedad                     ***/
            /******************************************************/
           // $this->createOrUpdateSaludEnfermedad($request, $trabajador->id);

            Log::info('Trabajador creado con exito', ['trabajador' => $trabajador]);

            return response()->json([
                'message' => 'Trabajador creado con éxito!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear trabajador',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function addEmployee($trabajador,$request,$user,$id = 0)
    {
        $trabajador->rut = $id > 0 ? $trabajador->rut : $request->rut;
        $trabajador->primer_nombre = $request->primer_nombre;
        $trabajador->segundo_nombre = $request->has('segundo_nombre') ? $request->segundo_nombre : '';
        $trabajador->primer_apellido = $request->primer_apellido;
        $trabajador->segundo_apellido = $request->has('segundo_apellido') ? $request->segundo_apellido : '';
        $trabajador->fecha_nac = $request->fecha_nac;
        $trabajador->estado_civil = $request->estado_civil;
        $trabajador->sexo = $request->sexo;
        $trabajador->grado_escolaridad = $request->grado_escolaridad;
        $trabajador->telefono_local = $request->has('telefono_local') ? $request->telefono_local : '';
        $trabajador->telefono_celular = $request->telefono_celular;
        $trabajador->correo = $request->correo;
        $trabajador->direccion = $request->direccion;
        $trabajador->region_id = $request->region_id;
        $trabajador->comuna_id = $request->comuna_id;
        $trabajador->nacionalidad_id = $request->nacionalidad_id;
        $trabajador->pertenece_pueblo_originario = $request->pertenece_pueblo_originario ?? 'no';
        // Asegúrate de que pueblo_originario_id se establezca a null si es necesario
        if ($request->pertenece_pueblo_originario === 'si') {
            $trabajador->pueblo_originario_id = $request->pueblo_originario_id;
        }

        $trabajador->tiene_familia = $request->carga_familiar ?? 'no';
        $trabajador->user_id = $user->id;
        $trabajador->tiene_discapacidad = $request->tiene_alguna_discapacidad ?? 'no';
        $trabajador->estado = 'contratado';
        $trabajador->condicion = 'disponible';
        $trabajador->save();
        return $trabajador->id;
    }

    private function addWorkcontract($request,$trabajador)
    {
        /********************************************************/
        /*           CREAR  CONTRATO                         ***/
        /******************************************************/

        $contrato = Contrato::firstOrNew(['trabajador_id' => $trabajador->id]);
        $contrato->ubicacion_id = $request->ubicacion_id;
        $contrato->fecha_ingreso = $request->fecha_ingreso;
        $contrato->fecha_antiguidad = $request->fecha_antiguidad;
        $contrato->fecha_vencimiento_contrato = $request->fecha_vencimiento_contrato;
        $contrato->fecha_segundo_vencimiento = $request->fecha_segundo_vencimiento;
        $contrato->area_id = $request->area_id > 0 ? $request->area_id : null ;
        $contrato->cargo_id = $request->cargo_id > 0 ? $request->cargo_id : null ;
        $contrato->trabajador_id = $trabajador->id;
        $contrato->centro_costo = $request->centro_costo;
        $contrato->tipo_jornada = $request->tipo_jornada;
        $contrato->jornada_excepcional = $request->jornada_excepcional;
        $contrato->empleador_id = $request->empleador_id;
        $contrato->tipo_contrato = $request->tipo_contrato;
        $contrato->save();

        return $contrato;
    }


    private function createOrUpdatePrevisionTrabajador($request, $trabajadorId)
    {

        $prevision = PrevisionTrabajador::firstOrNew(['trabajador_id' => $trabajadorId]);
        $prevision->tipo_entidad = $request->tipo_entidad;
        $prevision->prevision_id = $request->prevision_id;
        $prevision->prevision_inp_id = $request->tipo_entidad == 'inp' ? $request->prevision_inp_id : null;
        $prevision->save();

        return $prevision;
    }

    private function createOrUpdateSaludTrabajador($request, $trabajadorId)
    {
        $salud = SaludTrabajador::firstOrNew(['trabajador_id' => $trabajadorId]);
        $salud->salud_id = $request->salud_id;
        $salud->cotiza_siete_porciento = $request->cotiza_siete_porciento;
        $salud->tipo_plan_salud = $request->tipo_plan_salud;
        $salud->monto_peso = $request->monto_peso;
        $salud->monto_uf = $request->monto_uf;
        $salud->save();

        return $salud;
    }

    private function createOrUpdateAhorroVoluntarioTrabajador($request)
    {
        // Verifica si el campo 'ahorros' está presente y no está vacío
        if ($request->has('ahorros') && !empty($request->ahorros)) {
            $ahorros = json_decode($request->ahorros, true); // Convertir JSON string a array PHP

            if (is_null($ahorros)) {
                // Puedes optar por registrar un error o simplemente retornar si la decodificación falla
                Log::error('Error al decodificar el JSON de ahorros voluntarios.');
                return;
            }

            foreach ($ahorros as $ahorro) {
                $ahorroVoluntarioTrabajador = AhorroVoluntarioTrabajador::firstOrNew([
                    'tipo_ahorro' => $ahorro['tipo_ahorro'],
                    'ahorro_voluntario_id' => $ahorro['ahorro_voluntario_id'],
                ]);

                $ahorroVoluntarioTrabajador->tipo_moneda = $ahorro['tipo_moneda'];
                $ahorroVoluntarioTrabajador->monto = $ahorro['monto'];
                $ahorroVoluntarioTrabajador->forma_pago = $ahorro['forma_pago'];
                $ahorroVoluntarioTrabajador->save();
            }
        }
        // Si no hay datos de ahorro, la función simplemente termina sin hacer nada
    }


    private function createOrUpdateContacto($request, $trabajadorId)
    {
        // Verifica si el campo 'contacto' está presente y no está vacío
        if ($request->has('contactos') && !empty($request->contactos)) {
            $contactos = json_decode($request->contactos);

            // Verifica que la decodificación haya sido exitosa
            if (is_null($contactos)) {
                Log::error('Error al decodificar el JSON de contactos.');
                return;
            }

            foreach ($contactos as $item) {
                $contacto = Contacto::firstOrNew(['id' => $item->id ?? null]);
                $contacto->nombre = $item->nombre ?? '';
                $contacto->apellido = $item->apellido ?? '';
                $contacto->correo = $item->correo ?? '';
                $contacto->telefono = $item->telefono ?? '';
                $contacto->direccion = $item->direccion ?? '';
                $contacto->region_id = $item->region_id ?? null; // Asumiendo que puede ser null
                $contacto->comuna_id = $item->comuna_id ?? null; // Asumiendo que puede ser null
                $contacto->parentesco = $item->parentesco ?? '';
                $contacto->otro_parentesco = $item->otro_parentesco ?? '';
                $contacto->trabajador_id = $trabajadorId;
                $contacto->save();
            }
        }
    }


    private function createOrUpdateBancoTrabajador($request, $trabajadorId)
    {
        // Verifica si el campo 'bancosTrabajador' está presente y no está vacío
        if ($request->has('bancos') && !empty($request->bancos)) {
            $banco_trabajador = json_decode($request->bancos);

            // Verifica que la decodificación haya sido exitosa
            if (is_null($banco_trabajador)) {
                Log::error('Error al decodificar el JSON de bancosTrabajador.');
                return;
            }

            foreach ($banco_trabajador as $item) {
                $bancoTrabajador = BancoTrabajador::firstOrNew([
                    'banco_id' => $item->banco_id,
                    'trabajador_id' => $trabajadorId
                ]);

                $bancoTrabajador->fecha_ingreso_cuenta = $item->fecha_ingreso_cuenta ?? null; // Asumiendo que puede ser null
                $bancoTrabajador->nro_cuenta = $item->nro_cuenta ?? '';
                $bancoTrabajador->tipo_cuenta = $item->tipo_cuenta ?? '';
                $bancoTrabajador->predeterminado = isset($item->predeterminado) && $item->predeterminado ? 'Y' : 'N';
                $bancoTrabajador->save();
            }
        }
    }


    private function createOrUpdateCargaFamiliar($request, $trabajadorId)
    {
        // Verifica si el campo 'cargaFamiliar' está presente y no está vacío
        if($request->has('familiar') && !empty($request->familiar)) {
            $carga_familiar = json_decode($request->familiar);

            // Verifica que la decodificación haya sido exitosa
            if (is_null($carga_familiar)) {
                Log::error('Error al decodificar el JSON de cargaFamiliar.');
                return;
            }

            foreach ($carga_familiar as $item) {
                $cargaFamiliar = CargaFamiliar::firstOrNew([
                    'rut' => $item->rut,
                    'trabajador_id' => $trabajadorId
                ]);

                $cargaFamiliar->nombres = $item->nombres ?? '';
                $cargaFamiliar->apellidos = $item->apellidos ?? '';
                $cargaFamiliar->fecha_nacimiento = $item->fecha_nacimiento ?? null; // Asumiendo que puede ser null
                $cargaFamiliar->fecha_vencimiento_carga = $item->fecha_vencimiento_carga ?? null; // Asumiendo que puede ser null
                $cargaFamiliar->parentesco_id = $item->parentesco_id ?? null; // Asumiendo que puede ser null si no se proporciona
                $cargaFamiliar->save();
            }
        }
    }


    private function createOrUpdateLicenciaConducir($request, $trabajadorId)
    {
        if($request->has('licencia')) {
            $licenciaConducir = LicenciaConducir::firstOrNew([
                'tipo_licencia_id' => $request->tipo_licencia_id,
                'trabajador_id' => $trabajadorId
            ]);

            $licenciaConducir->nro_serie = $request->nro_serie;
            $licenciaConducir->fecha_de_ingreso = $request->fecha_de_ingreso;
            $licenciaConducir->fecha_de_vencimiento = $request->fecha_de_vencimiento;
            $licenciaConducir->save();
        }
    }
    private function createOrUpdateSaludDiscapacidad($request, $trabajadorId)
    {
        $saludDiscapacidad = SaludDiscapacidad::firstOrNew(['trabajador_id' => $trabajadorId]);
        $saludDiscapacidad->posee_carnet = $request->posee_carnet;
        $saludDiscapacidad->discpacidad = $request->discapacidad;
        $saludDiscapacidad->causa_principal = $request->causa_principal;
        $saludDiscapacidad->causa_secundaria = $request->causa_secundaria;
        $saludDiscapacidad->capacidad_reducidad = $request->capacidad_reducidad;
        $saludDiscapacidad->save();

        return $saludDiscapacidad;
    }

    private function createOrUpdateSaludEnfermedad($request, $trabajadorId)
    {
        $enfermedad = SaludEnfermedad::firstOrNew(['trabajador_id' => $trabajadorId]);
        $enfermedad->enfermedad_prexistente = $request->enfermedad_prexistente;
        $enfermedad->tipo_sangre = $request->tipo_sangre;
        $enfermedad->enfermedades = $request->enfermedades;
        $enfermedad->medicamentos = $request->medicamentos;
        $enfermedad->save();

        return $enfermedad;
    }

    public function destroy(Request $request,$id)
    {
        try {
            $trabajador = Trabajador::findOrFail($id);
            $trabajador->delete();
            //aqui llamar a la variable el por que desde la desvinculacion no se puede eliminar el usuario
            $user = User::findOrFail($trabajador->user_id);
            $user->delete();

            //Detalles de las desvinculaciones

            $trabajador->historial()->create([
                'fecha_desvinculacion'=>$request->fecha_desvinculacion,
                'causal_de_hecho'=>$request->causal_hecho,
                'motivo_interno_empresa'=>$request->motivo_interno_empresa,
                'motivo_id'=>$request->derecho,
                'trabajador_id'=>$trabajador->id
            ]);

            $trabajador->estado = 'desvinculado';
            $trabajador->save();

            return response()->json([
                'message' => 'Trabajador eliminado con éxito!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar trabajador',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function unlinkTrabajador()
    {
        try {
            $trabajador = TrabajadorDesvinculados::orderBY('FECHA_DESVINCULACION','DESC')->paginate(10);
            return response($trabajador,200);

        } catch (\Exception $exception){

            return response(['error'=>$exception->getMessage()],500);
        }
    }


    public function descargar()
    {
        return Excel::download(new Trabajadores, 'trabajadores.xlsx');
    }

    public function descargar_devinculados()
    {
        return Excel::download(new Trabajadores, 'trabajadores.xlsx');
    }


}
