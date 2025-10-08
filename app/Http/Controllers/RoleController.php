<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('status', 2)
             ->orderBy('id', 'asc')
             ->get();

        return view('settings.roleslist', compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        // Create new role with status = 1, active = 1 by default
        Role::create([
            'name' => $request->name,
            'status' => 2,
            'active' => 1,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Role added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function toggle(Role $role)
    {
        $role->update([
            'active' => !$role->active,
        ]);

        return redirect()->back()->with('success', 'Role active updated!');
    }

    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully!');
    }
}
