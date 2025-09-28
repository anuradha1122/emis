<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\StoreSchoolClassListRequest;
use App\Http\Requests\UpdateSchoolRequest;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\SchoolClassList;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{

    public function search()
    {
        $option = [
            'Dashboard' => 'dashboard',
            'School Search' => 'school.search'
        ];
        return view('school/search',compact('option'));
    }

    public function profile($id = null)
    {
        if(!session('schoolId') && isset($id)){
            $schoolId = $id;
            $chartData = [
                ['Book Catagory', 'Amount'],
                ["Novels", 44],
                ["Short Story", 31],
                ["Documantary", 12],
                ["Children's Boos", 10],
                ['Other', 3]
            ];
            $option = [
                'Dashboard' => 'dashboard',
                'School Search' => 'school.search',
                'School Dashboard' => route('school.profile', ['id' => $id]),
            ];

            $card_pack_1 = collect([
                (object) [
                    'id' => 1,
                    'name' => 'Teacher',
                    'user_count' => 15,
                ],
                (object) [
                    'id' => 2,
                    'name' => 'Principal',
                    'user_count' => 5,
                ],
                (object) [
                    'id' => 3,
                    'name' => 'SLEAS',
                    'user_count' => 10,
                ],
                (object) [
                    'id' => 4,
                    'name' => 'SLAS',
                    'user_count' => 8,
                ],
                (object) [
                    'id' => 5,
                    'name' => 'Development Officer',
                    'user_count' => 12,
                ],
            ]);
            //dd($card_pack_1);

        }elseif (session('schoolId') && !isset($id)) {
            $schoolId = session('schoolId');
            $chartData = [
                ['Book Catagory', 'Amount'],
                ["Novels", 44],
                ["Short Story", 31],
                ["Documantary", 12],
                ["Children's Boos", 10],
                ['Other', 3]
            ];
            $option = [
                'Dashboard' => 'dashboard',
                'School Profile' => route('school.profile'),
            ];

            $card_pack_1 = collect([
                (object) [
                    'id' => 1,
                    'name' => 'Teacher',
                    'user_count' => 5,
                ],
                (object) [
                    'id' => 2,
                    'name' => 'Principal',
                    'user_count' => 5,
                ],
                (object) [
                    'id' => 3,
                    'name' => 'SLEAS',
                    'user_count' => 10,
                ],
                (object) [
                    'id' => 4,
                    'name' => 'SLAS',
                    'user_count' => 8,
                ],
                (object) [
                    'id' => 5,
                    'name' => 'Development Officer',
                    'user_count' => 12,
                ],
            ]);

        }
        else{
            return redirect()->route('dashboard');
        }

        $school_detail = School::join('work_places', 'schools.workPlaceId', '=', 'work_places.id')
        ->join('offices', 'schools.officeId', '=', 'offices.id')
        ->join('work_places AS divisions', 'offices.workPlaceId', '=', 'divisions.id')
        ->where('schools.id', $schoolId)
        ->where('schools.active', 1)
        ->select(
            'schools.id',
            'work_places.name',
            'divisions.name AS division',
        )
        ->first();

        return view('school/dashboard',compact('option','card_pack_1','chartData','school_detail'));
    }

    /**
     * Display a listing of the resource.
     */

    public function classprofile($id = null)
    {
        //dd($id);
        if(!session('schoolId') && isset($id)){

            $schoolId = $id;
            $option = [
                'Dashboard' => 'dashboard',
                'School Search' => 'school.search',
                'School Dashboard' => route('school.profile', ['id' => $schoolId]),
                'Class Profile' => route('school.classprofile', ['id' => $schoolId]),
            ];
            //dd($option);

        }elseif (session('schoolId') && !isset($id)) {

            $schoolId = session('schoolId');
            $option = [
                'Dashboard' => 'dashboard',
                'School Profile' => route('school.profile'),
                'Class Profile' => 'school.classprofile',
            ];

        }
        else{
            return redirect()->route('dashboard');
        }
        $school_detail = School::join('work_places', 'schools.workPlaceId', '=', 'work_places.id')
        ->join('offices', 'schools.officeId', '=', 'offices.id')
        ->join('work_places AS divisions', 'offices.workPlaceId', '=', 'divisions.id')
        ->where('schools.id', $schoolId)
        ->where('schools.active', 1)
        ->select(
            'schools.id',
            'work_places.name',
            'divisions.name AS division',
        )
        ->first();
        //dd($schoolId);
        $classes = SchoolClassList::join('class_lists', 'school_class_lists.classId', '=', 'class_lists.id')
        ->join('grades', 'class_lists.gradeId', '=', 'grades.id')
        ->leftjoin('users', 'school_class_lists.teacherId', '=', 'users.id')
        ->leftjoin('class_media', 'school_class_lists.mediumId', '=', 'class_media.id')
        ->where('school_class_lists.schoolId', $schoolId)
        ->where('school_class_lists.active', 1)
        ->select(
            'school_class_lists.id',
            'class_lists.name AS class',
            'grades.name AS grade',
            'school_class_lists.studentCount',
            'class_media.name AS medium',
            'users.nameWithInitials AS teacher',
        )
        ->paginate(10);
        //dd($classes);

        $chartData = [
            ['Book Catagory', 'Amount'],
            ["Novels", 44],
            ["Short Story", 31],
            ["Documantary", 12],
            ["Children's Boos", 10],
            ['Other', 3]
        ];
        //dd($option);
        return view('school/classdashboard',compact('option','classes','chartData','school_detail'));
    }

    public function classsetup()
    {

        $option = [
            'Dashboard' => 'dashboard',
            'School Profile' => route('school.profile'),
            'Class Profile' => 'school.classprofile',
            'Class Setup' => 'school.classsetup',
        ];
        return view('school/classsetup',compact('option'));
    }

    public function classstore(StoreSchoolClassListRequest $request)
    {


        $schoolId = session('schoolId');

        if (!$schoolId) {
            return view('dashboard',compact('option'));
        }

        // Check if the schoolId exists in the table
        $exists = DB::table('school_class_lists')
            ->where('schoolId', $schoolId)
            ->exists();

        if (!$exists) {
            // Prepare 550 rows with incrementing classIds
            $data = [];
            for ($classId = 1; $classId <= 550; $classId++) {
                $data[] = [
                    'schoolId' => $schoolId,
                    'classId' => $classId,
                ];
            }

            // Insert data in bulk
            DB::table('school_class_lists')->insert($data);
        }

        // Assuming $grades is an array containing the grade values sent from the form
        $grades = $request->only([
            'grade1', 'grade2', 'grade3', 'grade4', 'grade5', 'grade6',
            'grade7', 'grade8', 'grade9', 'grade10', 'grade11',
            'grade12art', 'grade12commerce', 'grade12science',
            'grade12technology', 'grade1213years', 'grade13art',
            'grade13commerce', 'grade13science', 'grade13technology',
            'grade1313years', 'specialedu'
        ]);

        $schoolId = session('schoolId'); // Get the school ID from the session

        // Loop through each grade
        foreach ($grades as $key => $grade) {
            $startClass = $this->getClassRangeStart($key); // Custom function to determine class range based on grade key
            $endClass = $startClass + 24; // Class range is 25 (e.g., for grade1: 1-25, grade3: 51-75)

            // Update the "active" column based on the grade value
            for ($i = $startClass; $i <= $endClass; $i++) {
                $activeStatus = ($i <= ($startClass + $grade - 1)) ? 1 : 0;

                // Update the database for the current class and school
                DB::table('school_class_lists')
                    ->where('schoolId', $schoolId)
                    ->where('classId', $i)
                    ->update(['active' => $activeStatus]);
            }
        }

        $school_detail = School::join('work_places', 'schools.workPlaceId', '=', 'work_places.id')
        ->join('offices', 'schools.officeId', '=', 'offices.id')
        ->join('work_places AS divisions', 'offices.workPlaceId', '=', 'divisions.id')
        ->where('schools.id', $schoolId)
        ->where('schools.active', 1)
        ->select(
            'schools.id',
            'work_places.name',
            'divisions.name AS division',
        )
        ->first();

        $classes = SchoolClassList::join('class_lists', 'school_class_lists.classId', '=', 'class_lists.id')
        ->join('grades', 'class_lists.gradeId', '=', 'grades.id')
        ->leftjoin('users', 'school_class_lists.teacherId', '=', 'users.id')
        ->leftjoin('class_media', 'school_class_lists.mediumId', '=', 'class_media.id')
        ->where('school_class_lists.schoolId', $schoolId)
        ->where('school_class_lists.active', 1)
        ->select(
            'school_class_lists.id',
            'class_lists.name AS class',
            'grades.name AS grade',
            'school_class_lists.studentCount',
            'class_media.name AS medium',
            'users.nameWithInitials AS teacher',
        )
        ->paginate(10);


        $chartData = [
            ['Book Catagory', 'Amount'],
            ["Novels", 44],
            ["Short Story", 31],
            ["Documantary", 12],
            ["Children's Boos", 10],
            ['Other', 3]
        ];

        $option = [
            'Dashboard' => 'dashboard',
            'School Profile' => route('school.profile'),
            'Class Profile' => 'school.classprofile',
        ];

        //dd($card_pack_1);
        return view('school/classdashboard',compact('option','classes','chartData','school_detail'));

    }

    // Custom function to determine class range start based on the grade key
    public function getClassRangeStart($gradeKey)
    {
        switch ($gradeKey) {
            case 'grade1':
                return 1;
            case 'grade2':
                return 26;
            case 'grade3':
                return 51;
            case 'grade4':
                return 76;
            case 'grade5':
                return 101;
            case 'grade6':
                return 126;
            case 'grade7':
                return 151;
            case 'grade8':
                return 176;
            case 'grade9':
                return 201;
            case 'grade10':
                return 226;
            case 'grade11':
                return 251;
            case 'grade12art':
                return 276;
            case 'grade12commerce':
                return 301;
            case 'grade12science':
                return 326;
            case 'grade12technology':
                return 351;
            case 'grade1213years':
                return 376;
            case 'grade13art':
                return 401;
            case 'grade13commerce':
                return 426;
            case 'grade13science':
                return 451;
            case 'grade13technology':
                return 476;
            case 'grade1313years':
                return 501;
            case 'specialedu':
                return 526;
            default:
                return 1; // Default to class 1 if no match
        }
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
    public function store(StoreSchoolRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
    }



    // public function reports()
    // {
    //     $option = [
    //         'School Dashboard' => 'school.dashboard',
    //         'School Reports' => 'school.reports'
    //     ];
    //     return view('school/reports',compact('option'));
    //}


}
