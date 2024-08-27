<?php

namespace App\Http\Controllers;

use App\Models\CargaFamiliar;
use App\Models\GestionTripulacion;
use App\Models\Prevision;
use App\Models\PrevisionTrabajador;
use App\Models\Remuneraciones\LiquidacionTrabajador;
use App\Models\LiquidacionTrabajador as Liquidaciones;
use App\Models\SaludTrabajador;
use App\Models\Trabajador;
use Gfarias\PreviScraper\PreviScraper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\This;

class LiquidacionSueldoController extends Controller
{
   protected $mes = 0;
   protected $year = 0;
   protected $sueldo_base = 0;
   protected $sueldo_base_con_fallas = 0;//sueldo base en caso de haber fallas
   protected $rut = '';
   protected $nombre_completo = '';
   protected $rut_empleador = '';
   protected $empleador = '';
   protected $cargo = '';
   protected $afp = '';
   protected $trabajador_id = 0;
   protected $dias_fallas = 0;
   protected $codigo_entidad = 0;
   protected $dias_trabajados = 0;
   protected $tipo_contrato = '';
   protected $fecha_ingreso = '';
   protected $porcentaje = 0;
   protected $salud = '';
   protected $plan_salud =0;
   protected $bonos_imponibles = [];
   protected $gratificacion = 0;
   protected $horas_extras_total = 0;
   protected $horas_extras = 0;
   protected $bonos_imponibles_gratificables = [];
   protected $total_gratificable = 0; // sueldo base + bonos
   //no imponibles
   protected $numero_carga_familiar = 0; //ejemplo 5 cargas
   protected $carga_familiar_total = 0; // ejemplo total a pagar segun numero de carga y tramo - se considera el sueldo base
   protected $bono_movilizacion = 0;
   protected $bono_colaccion = 0;
   protected $otros_bonos_no_imponibles = []; //viene desde la consulta de asignaciones mensuales

    //totales
    protected $total_sueldo_imponible = 0;
    protected $total_sueldo_no_imponible = 0;
    protected $total_sueldo_bruto = 0;

   protected $total_descuentos = 0;
   //descuentos
   protected $anticipos = 0;
   protected $total_afp = 0;
   protected $total_salud = 0;
   protected $aporte_seguro_cesantia = 0;
   protected $impuesto_renta = 0;
   protected $cuota_credito_social= 0;

   //valores previred

   protected $valores_previred = '';

   protected $trabajadores;
   protected $prevision;

   public function __construct()
   {
       $this->mes = date('m');
       $this->year = date('Y');
       $this->trabajadores = $this->cabezera_remuneracion();
        $this->valores_previred = $this->obtener_valores_previred();
        //asignacion de valor
       $this->trabajador_id = $this->trabajadores->id;
       $this->rut = $this->trabajadores->rut;
       $this->nombre_completo = $this->trabajadores->primer_nombre.' '.$this->trabajadores->segundo_nombre.' '.$this->trabajadores->primer_apellido.' '.$this->trabajadores->segundo_apellido ?? '';

       $this->sueldo_base = $this->trabajadores->contrato->sueldo_base;
       $this->rut_empleador = $this->trabajadores->contrato->empleador->rut;
       $this->empleador = $this->trabajadores->contrato->empleador->nombre_empleador;
       $this->cargo = $this->trabajadores->contrato->cargo->nombre_cargo;
       //dias trabajador y fallas del mes
       $this->dias_fallas = $this->calcular_dias_trabajados($this->trabajadores->id);
       $this->dias_trabajados = (30 - $this->calcular_dias_trabajados($this->trabajadores->id));

       $this->fecha_ingreso = $this->trabajadores->contrato->fecha_ingreso;
       $this->tipo_contrato = $this->trabajadores->contrato->tipo_contrato;
       $this->bonos_imponibles_gratificables = $this->obtener_bonos_imponibles($this->trabajador_id);
       $this->gratificacion = $this->calcular_gratificacion($this->trabajador_id);
       $this->total_sueldo_imponible = $this->calcular_sueldo_imponible();

       $this->otros_bonos_no_imponibles = $this->getHaberesNoImponibles();
       $this->carga_familiar_total = $this->calcular_carga_familiar(); //debe llegar al calculo de carga familiar
       $this->total_sueldo_no_imponible = $this->calcular_sueldo_no_imponible();
       //descuentos
       $this->prevision = $this->devuelve_afp_trabajador($this->trabajador_id);
       $this->codigo_entidad = $this->prevision->prevision->codigo;
       $this->afp = $this->prevision->prevision->nombre_prevision;
       $this->porcentaje = $this->prevision->prevision->porcentaje_prevision;

       //calculo descuentos
       $this->total_afp = $this->calcular_prevision();
       $this->total_salud = $this->calcular_salud();
       $this->anticipos = $this->obtiene_anticipo($this->trabajador_id);
       $this->aporte_seguro_cesantia = $this->calcular_seguro_cesantia();

   }

   public function getLiquidacionesMensual($mes){
       try {
            $paginas = \request('perpage');
           $liquidacion = LiquidacionTrabajador::where('MES','=',$mes)->paginate($paginas);

           return response($liquidacion,200);

       }catch (\Exception $exception){
           return response($exception,422);
       }
   }

    public function index(){
       return view('liquidaciones.index',[
           'mes'=>$this->mes,
           'year'=>$this->year,
           'notificaciones'=>auth()->user()->unreadNotifications
       ]);
    }

    public function liquidacion_mensual_all($id){
       try{
           $trabajadores = \App\Models\Trabajador::find($id);
           $mes = request('mes');

         $trabajador =  Liquidaciones::create(
               [
                   'trabajador_id'=>$id,
                   'total_haberes'=>1010000,
                   'total_descuentos'=>450000,
                   'total_a_pagar'=>850000,
                   'resumen_detalle'=>json_encode($this->calculo_remuneraciones($mes,date('Y'))),
                   'mes'=>$mes,
                   'year'=>date('Y'),
                   'estado'=>'OPEN'
               ]
           );

          return response($trabajador,200);
       }catch (\Exception $exception){
           return response($exception,422);
       }

    }

    public function obtener_valores_previred(){

       /* $previScraper = new \Gfarias\PreviScraper\PreviScraper();
        $previred = $previScraper->previred();
        return (json_encode($previred->all()));*/
    }

    public function calculo_remuneraciones($mes,$year)
    {

        $datos = [
          'cabezera' =>[
                    'trabajador_id'=>$this->trabajador_id,
                    'rut'=>$this->rut,
                    'full_name'=>$this->nombre_completo,
                    'sueldo_base'=>$this->sueldo_base,
                    'rut_empleador'=>$this->rut_empleador,
                    'empleador'=>$this->empleador,
                    'cargo'=>$this->cargo,
                    'tipo_contrato'=>$this->tipo_contrato,
                    'fecha_ingreso'=>$this->fecha_ingreso,
                    'dias_fallas'=>$this->dias_fallas,
                    'dias_trabajados'=>$this->dias_trabajados,
                    'afp'=> $this->afp ? $this->afp : '',
                    'entidad_salud'=>'',
                    'plan_salud'=>'',
                    'codigo'=>$this->codigo_entidad ? $this->codigo_entidad : '',
                    'porcentaje'=>$this->porcentaje ? $this->porcentaje : ''
          ],
            'haberes_imponibles'=>[

                'bonos'=>$this->bonos_imponibles_gratificables,
                'gratificacion' =>  $this->gratificacion,
                'hora_extra'=>$this->horas_extras,
                'sueldo_base'=> $this->sueldo_base
            ],
            'haberes_no_imponible'=>[
                'carga_familiar'=> $this->carga_familiar_total ,//llamar al calculo
                'otros_bonos_no_imponibles' => $this->otros_bonos_no_imponibles,
                'viatico'=>0,
                'movilizacion'=>0,
                'alimentacion'=>0
            ],
            'descuentos'=>[
                'total_afp'=> $this->total_afp,
                'total_salud'=>$this->total_salud,
                'anticipo'=>$this->anticipos,
                'seguro_cesantia'=>$this->aporte_seguro_cesantia,
                'impuesto'=>0,
                'cuota_credito_social'=> $this->cuota_credito_social
            ],
            'totales'=>[
                'total_imponible'=>$this->total_sueldo_imponible,
                'total_no_imponible'=>0,
                'total_leyes_soc'=>0,
                'total_descuentos'=>0,
                'total_haberes'=>0,
                'total_a_liquido_a_pagar'=>0,
                 'total_escrito_a_pagar'=>''
            ]
        ];

        return $datos;
    }

    public function cabezera_remuneracion(){
        try {
            //trae la cabezara
            $trabajador = Trabajador::with('contrato','contrato.ubicacion','contrato.empleador','contrato.cargo','previsiontrabajador','saludtrabajador')
                                    ->filtros()
                                    ->first();

            return $trabajador;
        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function calcular_dias_trabajados($id){
       try {
           //aqui se necesita un count
           $dias_trabajados = DB::table('gestion_trabajadores')
                                        ->where('trabajador_id','=',$id)
                                        ->where('tipo','=','falla')
                                        ->count();

            return  $dias_trabajados;
       }catch (Exception $exception){
           return $exception;
       }
   }

    public function devuelve_afp_trabajador($id){
      try {
          $afp_trabajador = PrevisionTrabajador::with('prevision')
                                      ->where('trabajador_id','=',$id)
                                      ->first();
        return $afp_trabajador;
      }catch (\Exception $exception){
            return $exception;
      }
  }

    public function devuelve_plan_salud_trabajador($id){
        try {

         $salud_trabajador = SaludTrabajador::with('salud')
                          ->where('trabajador_id','=',$id)
                          ->first();

        return $salud_trabajador;

        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function obtener_bonos_imponibles($id){
        try {
            $bonos_gratificables =  DB::select("select bh.descripcion as DESCRIPCION,bh.monto as MONTO_PREV, bh.categoria,bt.monto as MONTO_ACT
                                from bono_haberes bh
                                    join bono_trabajador bt on bt.bonos_id = bh.id
                            where bt.trabajador_id = {$id} and
                                  bh.categoria = 'BONOS' and
                                  bh.aplica_gratificacion = 'SI'");
            return $bonos_gratificables != null ? $bonos_gratificables : 0 ;
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function calcular_gratificacion($id){
      try {
          $sueldo_min = 350000; //definir parametro en base de datos
          $sueldo_base = $this->sueldo_base_con_fallas == 0 ? $this->sueldo_base : $this->sueldo_base_con_fallas;
          $tope = (4.75*$sueldo_min)/12;
          $bonos_gratificables= [];
          $bonos_gratificables = $this->bonos_imponibles_gratificables;


             foreach ($bonos_gratificables as $bonos){
                 if ($bonos->MONTO_ACT > 0){
                     $sueldo_base+=$bonos->MONTO_ACT;
                 }else{
                     $sueldo_base+=$bonos->MONTO_PREV;
                 }
             }



          $sueldo_gratificable = $sueldo_base * 0.25;

          if ($sueldo_gratificable < $tope){
                return $sueldo_gratificable;
          }else{
              return $tope;
          }
          return 0;
      }catch (Exception $exception){
            return $exception;
      }
  }

    public function calcular_sueldo_imponible(){
      try {
          $sueldo_imponible = 0;
          $bono = 0;
          $sueldo_base = $this->sueldo_base_con_fallas == 0 ? $this->sueldo_base : $this->sueldo_base_con_fallas;
          $bonos_gratificables = $this->bonos_imponibles_gratificables;
          foreach ($bonos_gratificables as $bonos){
              if ($bonos->MONTO_ACT > 0){
                  $bono+=$bonos->MONTO_ACT;
              }else{
                  $bono+=$bonos->MONTO_PREV;
              }
          }

          $sueldo_imponible = $sueldo_base  + $this->horas_extras + $bono + $this->gratificacion;

          return $sueldo_imponible;

      }catch (Exception $exception){
          return $exception;
      }

  }

    public  function getHaberesNoImponibles(){
       try {
           $bonos_no_imponibles =  DB::select("select bh.descripcion as DESCRIPCION,bh.monto as MONTO_PREV, bh.categoria,bt.monto as MONTO_ACT
                                from bono_haberes bh
                                    join bono_trabajador bt on bt.bonos_id = bh.id
                            where bt.trabajador_id = {$this->trabajador_id} and
                                  bh.categoria = 'HABERES NO IMPONIBLES'");

           return $bonos_no_imponibles != null ? $bonos_no_imponibles : 0;

       }catch (\Exception $exception){
           return $exception;
       }
   }

    public function calcular_sueldo_no_imponible(){
        try {

            $haberes_no_imponibles = 0;



        }catch (Exception $exception){
            return $exception;
        }
    }

    public function calcular_prevision(){
           if ($this->total_sueldo_imponible>0){
               $total_afp =  (($this->total_sueldo_imponible * $this->porcentaje)/100); //((350.000 * 11,44)/100) = 40.040

               return $total_afp;
           }else{
               return 0;
           }
       }

    public function calcular_salud(){
          if ($this->total_sueldo_imponible>0){
              $total_salud =  (($this->total_sueldo_imponible * 7)/100); //((350.000 * 7)/100) = 40.040

              return $total_salud;
          }else{
              return 0;
          }
       }

    public function obtiene_anticipo($id){
           try {

               $anticipo =  DB::select("select bh.descripcion as DESCRIPCION,bh.monto as MONTO_PREV, bh.categoria,bt.monto as MONTO_ACT
                                    from bono_haberes bh
                                        join bono_trabajador bt on bt.bonos_id = bh.id
                                where bt.trabajador_id = {$id} and
                                      bh.categoria = 'ANTICIPOS' ");

            $cantidad = count($anticipo);
            if ($anticipo > 0){
                foreach ($anticipo as $item){
                    $anticipo_monto = $item->MONTO_PREV > 0  ? $item->MONTO_ACT : 0;
                }

                return isset($anticipo_monto) ? $anticipo_monto : 0;
            }else{
                return 0;
            }
            return 0;

           }catch (\Exception $exception){
                return $exception;
           }
       }

    public function calcular_seguro_cesantia(){
        try {

            $seguro_censantia = ( $this->total_sueldo_imponible  * 0.6 ) /100;

          return $seguro_censantia > 0 ? $seguro_censantia : 0;

        }catch (Exception $exception){
            return $exception;
        }
    }


    public function cambiosEstado(Request $request){
        try {

            foreach ($request->datos as $datos){

                $liquidacion = Liquidaciones::find($datos);

                $liquidacion->estado = $request->estado;

                $liquidacion->save();

            }

            return response('success',200);

        }catch (\Exception $exception){

            return response($exception,422);
        }
    }

    //int sueldo base
    public function calcular_carga_familiar(){
       //$sueldo_base = $this->sueldo_base;
       $sueldo_base = 600000;

     $posee_carga_familiar = Trabajador::where('id','=',5)
                                      //->where('tiene_familia','=','si')
                                      ->first();

     if ($posee_carga_familiar->tiene_familia == 'si'){
        //cantidad de familiares
         $cantidad_carga_familiar = CargaFamiliar::where('trabajador_id','=',5)->count();
         if ($sueldo_base <= 366987){
             //tramo A
             $carga_familiar =  14366 * $cantidad_carga_familiar;
         }

         if ($sueldo_base > 366987  && $sueldo_base <= 536023 ){
             //tramo B
             $carga_familiar =  8815 * $cantidad_carga_familiar;
         }

         if ($sueldo_base > 536023  && $sueldo_base <= 836014 ){
             //tramo C
             $carga_familiar =  2786 * $cantidad_carga_familiar;
         }

         if ($sueldo_base > 836014){
             //tramo D
             $carga_familiar =  0;
         }

         return $carga_familiar;
     }else{
         return 0;
     }

    }

    public function eliminacionMasiva(Request $request){
        try {

            foreach ($request->datos as $datos){

                $trabajador_liquidacion = Liquidaciones::find($datos);

                //  $trabajador_bono->estado = $request->estado;

                $trabajador_liquidacion->delete();

            }

            return response('success',200);

        }catch (\Exception $exception){

            return response($exception,422);
        }
    }


}
