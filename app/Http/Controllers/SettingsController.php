<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Position;


class SettingsController extends Controller
{
    public function index()
    {
        $permissions = Permission::active()->get();
        return view('settings.dashboard', compact('permissions'));
    }

    public function permissionlist()
    {
        $permissions = Permission::active()->paginate(5); // 10 per page
        return view('settings.permissionlist', compact('permissions'));
    }

    public function updatePermission()
    {
        $positions = Position::where('active', 1)->get();
        $permissions = Permission::where('active', 1)->get();
        return view('settings.update-permission', compact('positions', 'permissions'));
    }

    public function storePermission(Request $request)
    {
        $position = Position::findOrFail($request->position_id);
        $position->permissions()->sync($request->permissions); // assign selected permissions
        return redirect()->back()->with('success', 'Permissions assigned successfully!');
    }

}
