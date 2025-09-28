<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIllnessRequest;
use App\Http\Requests\UpdateIllnessRequest;
use App\Models\Illness;

class IllnessController extends Controller
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
    public function store(StoreIllnessRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Illness $illness)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Illness $illness)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIllnessRequest $request, Illness $illness)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Illness $illness)
    {
        //
    }
}
