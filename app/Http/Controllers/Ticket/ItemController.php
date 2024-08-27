<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Checklist\ChecklistItemField;
use Illuminate\Http\Request;
use App\Models\Checklist\Item;
use App\Imports\ItemImport;
use Maatwebsite\Excel\Facades\Excel;

// Asegúrate de que este modelo exista

class ItemController extends Controller
{
    public function index()
    {
        try {

            $items = Item::with(['type', 'responsables.trabajador', 'area', 'field'])
                ->join('checklist_types', 'checklist_types.id', '=', 'checklist_items.type_id')
                ->filtros()
                ->orderBy('checklist_types.id')
                ->select('checklist_items.*') // avoid column conflicts
                ->paginate(20);

            return response()->json($items);
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
                'type_id' => 'required|integer',
            ]);

            // Separate the responsables data from the rest of the request data
            $requestData = $request->except('responsables');
            $responsables = json_decode($request->responsibles, true);

            if ($id) {
                $item = Item::findOrFail($id);
                $item->update($requestData);
            } else {
                $item = Item::create($requestData);
            }

            //crea el campo de la lista de chequeo
            $fields = ChecklistItemField::firstOrNew(['id' => $request->field_id]);
            $fields->item_id = $item->id;
            $fields->field_type_id = 1;
            $fields->label = $item->name;
            $fields->options = $request->options;
            $fields->save();

            // Detach all existing responsables if updating
            if ($id) {
                $item->responsables()->detach();
            }

            // Attach the new responsables
            foreach ($responsables as $responsible) {
                $item->responsables()->attach($responsible['user_id'], ['item_id' => $item->id]);
            }

            // Load the responsables relationship so it's included in the response
            $item->load('responsables');

            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);

            // Delete the field
            $item->field()->delete();

            // Detach the responsables before deleting the item
            $item->responsables()->detach();

            $item->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function importItems(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt', // Cambiar a 'csv,txt'
        ]);

        $file = $request->file('file');

        $importer = new ItemImport;
        Excel::import($importer, $file);

        return response()->json([
            'message' => 'Importación finalizada',
            'errores' => $importer->getErrores(),
            'filasErroneas' => $importer->getFilasErroneas()
        ], 200);

    }

}
