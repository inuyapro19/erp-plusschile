<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }

    public function store(Request $request)
    {
        if ($request->has('id')) {
            // Update existing permission
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->save();
        } else {
            // Create new permission
            $permission = Permission::create(['name' => $request->name]);
        }

        return response()->json($permission, 201);
    }

    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return response()->json($permission, 200);
    }

}
