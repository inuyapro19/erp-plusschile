<?php

namespace App\Http\Controllers;

use App\Models\sistema\Destinatario;
use Illuminate\Http\Request;

class DestinatarioController extends Controller
{
    public function index()
    {
        return view('destinatarios.index');
    }

    //get method

    public function getDestinatarios()
    {
        try{
            $destinatarios = Destinatario::all();
            return response()->json($destinatarios, 200);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //store edit and create methods

    public function store(Request $request,$id = 0)
    {
      try{
          //validate
            $request->validate([
                'email' => 'required|email',
                'type' => 'required',
            ]);

            //create or update first o new
            $destinatario = Destinatario::firstOrNew(['id' => $id]);

            $destinatario->email = $request->email;
            $destinatario->type = $request->type;

            $destinatario->save();

            return response()->json(['success' => 'Destinatario guardado correctamente'], 200);

      }catch (\Exception $e){
          return response()->json(['error' => $e->getMessage()], 500);
      }
    }

    //delete method
    public function destroy($id)
    {
        try{
            $destinatario = Destinatario::find($id);
            $destinatario->delete();

            return response()->json(['success' => 'Destinatario eliminado correctamente'], 200);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
