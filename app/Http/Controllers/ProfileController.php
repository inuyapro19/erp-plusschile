<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\User;
use App\Models\Contacto;
use App\Models\Contrato;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $trabajador = Trabajador::with(['user', 'contacto.region','contacto.comuna', 'contrato.cargo','contrato.area','contrato.ubicacion','region','comuna'])
            ->where('user_id', auth()->user()->id)
            ->first();

        return response()->json($trabajador);
    }

    public function edit()
    {

        return view('profile.edit');
    }

    public function update(Request $request, $id)
    {
        $trabajador = Trabajador::find($id);
        $trabajador->update($request->all());

        $trabajador->user->update($request->all());

        if ($request->has('contactos')) {
            foreach ($request->input('contactos') as $index => $contactoData) {
                if ($index >= 2) {
                    break;
                }

                if (isset($trabajador->contacto[$index])) {
                    $trabajador->contacto[$index]->update($contactoData);
                } else {
                    $trabajador->contacto()->create($contactoData);
                }
            }
        }

        $trabajador->contratos->update($request->all());

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }


}
