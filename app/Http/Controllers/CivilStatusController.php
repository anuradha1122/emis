<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecivilStatusRequest;
use App\Http\Requests\UpdatecivilStatusRequest;
use App\Models\civilStatus;

class CivilStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorecivilStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(civilStatus $civilStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(civilStatus $civilStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecivilStatusRequest $request, civilStatus $civilStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(civilStatus $civilStatus)
    {
        //
    }
}
