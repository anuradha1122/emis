<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //dd(Session::all());
        // Example: render different views
        if (session('workPlaceCategoryId') == 1) {
            return view('dashboard');
        }

        if (session('workPlaceCategoryId') == 2) {
            switch (session('officeTypeId')) {
                case 1:
                    return view('dashboard');
                case 2:
                    return view('dashboard');
                case 3:
                    return view('dashboard');
            }
        }

        if (session('workPlaceCategoryId') == 3) {
            return view('dashboard');
        }

        // Fallback view
        return view('dashboard');
    }

    public function dashboard()
    {
        $students = [
            'sabaragamuwa' => 10100,
            'western' => 10100,
            'central' => 10100,
            'southern' => 10100,
            'eastern' => 10100,
            'northern' => 10100,
            'uva' => 10100,
            'north-western' => 10100,
            'north-central' => 10100,
        ];

        $data = [
            'teacher' => [
                'male' => 200000,
                'female' => 300000,
            ],
            'student' => [
                'male' => 2000000,
                'female' => 3000000,
            ],
        ];

        return view('dashboard', compact('students', 'data'));
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
    public function store(StoreDashboardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDashboardRequest $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
