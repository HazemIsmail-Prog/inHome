<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json(['message' => 'unauthorized'], 403);
        if (!$request->user()->hasPermission('permissions_view')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }
        $permissions = Permission::query()
            ->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                $query->whereAny(['name_en', 'name_ar'], 'like', '%' . $search . '%');
            })
            ->paginate(20);
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);
        $permission = Permission::create($validated);
        return response()->json($permission);
    }

    public function update(Permission $permission, Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);
        $permission->update($validated);
        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json($permission);
    }
}
