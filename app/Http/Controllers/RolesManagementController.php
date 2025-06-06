<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesManagementController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return Inertia::render('roles-management/index', [
            'roles' => $roles
        ]);
    }

    public function edit(Role $role)
    {
        return Inertia::render('roles-management/edit', [
            'role' => $role->load('permissions'),
            'allPermissions' => Permission::all()
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'required|array'
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('roles-management.index');
    }
}
