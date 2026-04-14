<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function relatedLists()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return response()->json([
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }
    public function index(Request $request)
    {
        // return response()->json(['message' => 'unauthorized'], 403);
        $users = User::query()
            ->with('permissions', 'roles')
            ->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                $query->whereAny(['name_en', 'name_ar', 'email'], 'like', '%' . $search . '%');
            })
            ->when($request->is_active, function ($query, $is_active) {
                switch ($is_active) {
                    case 'active':
                        $query->where('is_active', true);
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                    default:
                        break;
                }
            })
            ->when($request->permissions, function ($query, $permissions) {
                // Filter users who have *all* the given permissions,
                // either directly or via their roles.
                $permissionCount = is_array($permissions) ? count($permissions) : 0;
                if ($permissionCount > 0) {
                    $query->where(function ($q) use ($permissions, $permissionCount) {
                        // Users with all permissions directly
                        $q->whereHas('permissions', function ($q2) use ($permissions) {
                            $q2->whereIn('permissions.id', $permissions);
                        }, '=', $permissionCount)
                        // OR users with all permissions via roles
                        ->orWhereHas('roles', function ($q3) use ($permissions, $permissionCount) {
                            $q3->whereHas('permissions', function ($q4) use ($permissions) {
                                $q4->whereIn('permissions.id', $permissions);
                            }, '=', $permissionCount);
                        });
                    });
                }
            })
            ->paginate(20);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'is_active' => 'required|boolean',
            'permissions' => 'nullable|array|exclude',
            'permissions.*' => 'nullable|exists:permissions,id|exclude',
            'roles' => 'nullable|array|exclude',
            'roles.*' => 'nullable|exists:roles,id|exclude',
        ]);
        DB::beginTransaction();
        try {
            $user = User::create($validated);
            if ($request->has('permissions')) {
                $user->permissions()->sync($request->permissions);
            }
            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }
            DB::commit();
            return response()->json($user->load('permissions', 'roles'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(User $user, Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:3|exclude',
            'is_active' => 'required|boolean',
            'permissions' => 'nullable|array|exclude',
            'permissions.*' => 'nullable|exists:permissions,id|exclude',
            'roles' => 'nullable|array|exclude',
            'roles.*' => 'nullable|exists:roles,id|exclude',
        ]);
        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }
        DB::beginTransaction();
        try {
            $user->update($validated);
            if ($request->has('permissions')) {
                $user->permissions()->sync($request->permissions);
            }
            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }
            DB::commit();
            return response()->json($user->load('permissions', 'roles'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user);
    }
}
