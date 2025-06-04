<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return Permission::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions',
            'endpoint' => 'required',
            'method' => 'required|in:GET,POST,PUT,DELETE,PATCH',
            'description' => 'nullable'
        ]);

        return Permission::create($validated);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'endpoint' => 'required',
            'method' => 'required|in:GET,POST,PUT,DELETE,PATCH',
            'description' => 'nullable'
        ]);

        $permission->update($validated);
        return $permission;
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
}
