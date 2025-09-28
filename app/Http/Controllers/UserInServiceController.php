<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserInServiceRequest;
use App\Http\Requests\UpdateUserInServiceRequest;
use App\Models\UserInService;

class UserInServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teacher/dashboard');
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
    public function store(StoreUserInServiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserInService $userInService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserInService $userInService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserInServiceRequest $request, UserInService $userInService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInService $userInService)
    {
        //
    }
}
