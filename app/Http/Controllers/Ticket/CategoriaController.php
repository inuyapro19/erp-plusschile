<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Checklist\CheckListCategory;

// Asegúrate de que este modelo exista

class CategoriaController extends Controller
{
    public function index()
    {
        try {
            $categories = ChecklistCategory::orderBy('name')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            // Aquí puedes manejar la excepción como quieras, por ejemplo, devolver una respuesta con un mensaje de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        try {
            // Validaciones
            $request->validate([
                'name' => 'required|max:255', // Asegúrate de cambiar estas reglas de validación según tus necesidades
                'description' => 'required', // Asegúrate de cambiar estas reglas de validación según tus necesidades
            ]);

            if ($id) {
                // Si se proporciona un ID, entonces actualizamos la categoría existente
                $category = ChecklistCategory::findOrFail($id);
                $category->update($request->all());
            } else {
                // Si no se proporciona un ID, entonces creamos una nueva categoría
                $category = ChecklistCategory::create($request->all());
            }

            return response()->json($category);
        } catch (\Exception $e) {
            // Aquí puedes manejar la excepción como quieras, por ejemplo, devolver una respuesta con un mensaje de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = ChecklistCategory::findOrFail($id);
            $category->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            // Aquí puedes manejar la excepción como quieras, por ejemplo, devolver una respuesta con un mensaje de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
