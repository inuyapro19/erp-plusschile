<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checklist\CheckListTypes; // Asegúrate de que este modelo exista

class TipoController extends Controller
{
    public function index()
    {
        try {
            $types = CheckListTypes::with('category')
                                        ->orderBy('name')
                                        ->get();

            return response()->json($types);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
            ]);

            if ($id) {
                $type = CheckListTypes::findOrFail($id);
                $type->update($request->all());
            } else {
                $type = CheckListTypes::create($request->all());
            }

            return response()->json($type);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $type = CheckListTypes::findOrFail($id);
            $type->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
