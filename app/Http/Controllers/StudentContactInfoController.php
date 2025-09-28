<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentContactInfoRequest;
use App\Http\Requests\UpdateStudentContactInfoRequest;
use App\Models\StudentContactInfo;

class StudentContactInfoController extends Controller
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
    public function store(StoreStudentContactInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentContactInfo $studentContactInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentContactInfo $studentContactInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentContactInfoRequest $request, StudentContactInfo $studentContactInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentContactInfo $studentContactInfo)
    {
        //
    }
}
