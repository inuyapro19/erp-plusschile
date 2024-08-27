<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Votacion;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
class VotacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


  public function categoria_votacion()
  {
      if(Auth::user()->primer_login == 'Y' && Auth::user()->cambio_contrasena == 'N'):
          Session::flash('danger','Debe cambiar la contraseña');
          return redirect(route('trabajadores.edit',Auth::user()->rut));
      else:
          return view('votacion.categorias');
      endif;

  }

    public function lista_votacion(Request $request , $clave)
    {

        if($request->has('busqueda')):
            $name = $request->input('busqueda');
        endif;

        if(Auth::user()->$clave == 'Y'):

            $lista = Categoria::with('users')
                ->where('nombre_categoria','=',$clave)
                ->first();

            /*User::where($clave,'=','Y')
                ->where('id','!=',Auth::user()->id)
                ->orderBy('name','asc')
                ->get();*/
        endif;

       // dd($lista);
        return view('votacion.index',[
            'lista'=>isset($lista) ? $lista : 0,
            'titulo' => $this->getTitulo($clave),
            'clave' => $clave
        ]);
    }


    public function busqueda(Request $request , $clave)
    {

       // dd($request->busqueda);

        if($request->has('busqueda')):
            $name = $request->input('busqueda');
        endif;

        if(Auth::user()->$clave == 'Y'):

            $lista = Categoria::with(['users'=>function($query) use ($name){
                 $query->where('name','LIKE','%'.$name.'%')->get();
            }])
                ->where('nombre_categoria','=',$clave)
                ->first();
           /* $lista = User::where($clave,'=','Y')
                ->where('id','!=',Auth::user()->id)
                ->where('name','LIKE','%'.$name.'%')
                ->orderBy('name','asc')
                ->get();*/
        endif;


       //dd($lista);

        return view('votacion.index',[
            'lista'=>isset($lista) ? $lista : 0,
            'titulo' => $this->getTitulo($clave),
            'clave' => $clave
        ]);
    }


    public function getTitulo($clave)
    {

        if ($clave == 'administracion')
        {
            return 'Administración';
        }

        if ($clave == 'tpluss')
        {
            return 'Transporte Pluss';
        }

    }


    public function enviar_voto(Request $request,$clave)
    {
            $request->validate([
               'voto_id'=>'required'
            ]);

          $votacion =  Votacion::create([
                'user_id'=>Auth::user()->id,
                'trabajador_id'=>$request->voto_id,
                'fecha_votacion'=>now(),
            ]);

          if($votacion):

              user::where('id','=',Auth::user()->id)
                  ->update([
                      $clave => 'V'
                  ]);

              Session::flash('success','mensaje');
              return redirect(route('votacion.categorias'));
          else:
              Session::flash('danger','mensaje');
              return redirect(route('votacion.categorias'));
          endif;


    }


    public function resultados($clave)
    {

        /*TODOS LOS VOTOS DE LAS CATEGORIAS*/
        $lista = DB::select("SELECT  u.rut , u.name ,u.apellidos , u.cargo ,c.nombre_categoria,COUNT(u.rut) as cantidad_votos
                                        FROM categoria_user as cu
                                        JOIN users AS u ON(cu.user_id = u.id)
                                        JOIN categorias AS c ON (cu.categoria_id = c.id)
                                        JOIN votaciones AS v ON (cu.user_id = v.trabajador_id)
                                        JOIN users u2 ON (u2.id = v.user_id)
                                        WHERE c.nombre_categoria ='".$clave."'
                                        GROUP by u.rut , c.nombre_categoria
                                        ORDER by cantidad_votos desc");

        return view('votacion.resultado_index',[
            'lista'=>isset($lista) ? $lista : 0,
            'titulo' => $this->getTitulo($clave),
            'clave' => $clave
        ]);
    }

}
