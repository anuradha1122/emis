<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Transfer;
use App\Models\TransferType;
use App\Models\TransferReason;
use Illuminate\Support\Facades\DB;


class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $binaryList;
    public $teachingGradeList;

    public function teacherindex()
    {
        //dd(session('higherZoneId'));
        // $transferTypes = TransferType::where('active', 1)->get();
        // $transferReasons = TransferReason::where('active', 1)->get();
        $binaryList = collect([
            (object)['id' => 1, 'name' => 'yes'],
            (object)['id' => 2, 'name' => 'no'],
        ]);

        $teachingGradeList = collect([
            (object)['id' => 1, 'name' => '1-2'],
            (object)['id' => 2, 'name' => '3-4'],
            (object)['id' => 3, 'name' => '5'],
        ]);

        $zoneSchools = DB::table('work_places')
            ->join('schools', 'work_places.id', '=', 'schools.workPlaceId')
            ->join('offices', 'schools.officeId', '=', 'offices.id')
            ->where('offices.higherOfficeId', session('higherZoneId'))
            ->select('work_places.name', 'schools.id') // or choose specific columns
            ->get();

        //dd($zoneSchools);
        // $appointmentCategories = AppointmentCategory::where('active', 1)->get();
        // $ranks = Rank::where('active', 1)
        //     ->where('serviceId', 1) // Filter by serviceId
        //     ->get();


        $option = [
            'Transfer Form' => 'teacher.transfer',
        ];
        return view('teacher/transferform',compact('option','binaryList','teachingGradeList','zoneSchools'));
    }

    public function principalindex()
    {
        //
    }

    public function teacherstore(StoreTransferRequest $request)
    {
        dd($request->all());
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
    public function store(StoreTransferRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
