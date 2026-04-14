<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function relatedLists()
    {
        $permissions = Permission::all();
        return response()->json([
            'permissions' => $permissions,
        ]);
    }
    public function index(Request $request)
    {
        $roles = Role::query()
            ->with('permissions')
            ->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                $query->whereAny(['name_en', 'name_ar'], 'like', '%' . $search . '%');
            })
            ->when($request->permissions, function ($query, $permissions) {
                $query->whereHas('permissions', function ($query) use ($permissions) {
                    $query->whereIn('permissions.id', $permissions);
                });
            })
            ->paginate(20);
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'permissions' => 'nullable|array|exclude',
            'permissions.*' => 'nullable|exists:permissions,id|exclude',
        ]);
        DB::beginTransaction();
        try {
        $role = Role::create($validated);
            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }
            DB::commit();
            return response()->json($role->load('permissions'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Role $role, Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'permissions' => 'nullable|array|exclude',
            'permissions.*' => 'nullable|exists:permissions,id|exclude',
        ]);
        DB::beginTransaction();
        try {
            $role->update($validated);
            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }
            DB::commit();
            return response()->json($role->load('permissions'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json($role);
    }
}
