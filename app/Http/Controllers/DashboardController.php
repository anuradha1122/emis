<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Models\Dashboard;
use App\Services\UserDashboardService;

class DashboardController extends Controller
{
    protected $mainDashboard;

    public function __construct(UserDashboardService $mainDashboard)
    {
        $this->mainDashboard = $mainDashboard;
    }

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
        $mainCount = $this->mainDashboard->getMainStatsFor();
        return view('dashboard', compact('mainCount'));
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
