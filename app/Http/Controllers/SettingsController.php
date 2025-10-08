<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\UserDashboardService;


class SettingsController extends Controller
{
    protected $settingsDashboard;

    public function __construct(UserDashboardService $settingsDashboard)
    {
        $this->settingsDashboard = $settingsDashboard;
    }

    public function index()
    {
        $settingsCount = $this->settingsDashboard->getSettingsStatsFor();
        $permissions = Permission::active()->get();
        return view('settings.dashboard', compact('permissions', 'settingsCount'));
    }

    public function permissionlist()
    {
        $permissions = Permission::active()->paginate(5); // 10 per page
        return view('settings.permissionlist', compact('permissions'));
    }

    public function updatePermission()
    {
        $roles = Role::where('active', 1)
             ->where('status', 2)
             ->get();

        $permissions = Permission::where('active', 1)
        ->orderBy('categoryId', 'asc')
        ->get();
        return view('settings.update-permission', compact('roles', 'permissions'));
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $roleId = $request->input('role_id');
        $permissionIds = $request->input('permissions', []); // default empty array if none selected

        // 1. Delete existing permissions for this role
        DB::table('role_permissions')->where('roleId', $roleId)->delete();

        // 2. Insert new permissions
        $insertData = [];
        foreach ($permissionIds as $pid) {
            $insertData[] = [
                'roleId' => $roleId,
                'permissionId' => $pid,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($insertData)) {
            DB::table('role_permissions')->insert($insertData);
        }

        return redirect()->back()->with('success', 'Permissions updated successfully for the role.');
    }

    public function rolePermission()
    {
        $roles = Role::where('active', 1)
             ->where('status', 2)
             ->get();
        return view('settings.role-permission', compact('roles'));
    }


    public function storeRolePermission(Request $request)
    {
        $request->validate([
            'nic' => 'required|exists:users,nic',
            'role' => 'nullable|exists:roles,id',
        ]);

        $user = User::where('nic', $request->nic)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if ($request->filled('role')) {
            // 🟢 Assign role
            $user->roleId = $request->role;
            $user->save();

            // Optional: Assign role permissions if your system uses a pivot
            // $user->syncPermissions(Role::find($request->role)->permissions);

            return back()->with('success', 'Role assigned successfully.');
        } else {
            // 🔴 Remove role
            $user->roleId = 0;
            $user->save();

            // Optional: Remove permissions too
            // $user->syncPermissions([]);

            return back()->with('success', 'Role removed successfully.');
        }
    }


}
