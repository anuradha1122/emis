<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Models\SchoolReligion;
use App\Models\SchoolAuthority;
use App\Models\SchoolClass;
use App\Models\SchoolDensity;
use App\Models\SchoolFacility;
use App\Models\SchoolGender;
use App\Models\SchoolLanguage;
use App\Models\SchoolEthnicity;
use App\Models\SchoolClassList;
use App\Models\WorkPlace;
use App\Models\WorkPlaceContactInfo;
use Illuminate\Support\Facades\DB;
use App\Services\UserDashboardService;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Http\Requests\StoreSchoolClassListRequest;
use Illuminate\Support\Facades\Crypt;

class SchoolController extends Controller
{

    protected $schoolData;

    public function __construct(UserDashboardService $schoolData)
    {
        $this->schoolData = $schoolData;
    }

    public function index()
    {
        $schoolCountsArray = $this->schoolData->getSchoolStatsFor(auth()->user());
        $schoolCounts = (object) $schoolCountsArray;
        return view('school.dashboard', compact('schoolCounts'));
    }


    public function search()
    {
        $option = [
            'Dashboard' => 'dashboard',
            'School Search' => 'school.search'
        ];
        return view('school/search',compact('option'));
    }

    public function profile(Request $request)
    {
        $decryptedId = Crypt::decryptString($request->id);

        // ---------- Teacher profile ----------
        $school = WorkPlace::with([
                'contactInfo',
                'school',
                'school.office',
                'school.authority',
                'school.classType',
                'school.density',
                'school.facility',
                'school.ethnicity',
                'school.language',
                'school.religion',
                'school.gender'
            ])
            ->find($decryptedId);
        //dd($school->school->authority->name);
        if (!$school) {
            abort(404, 'School not found');
        }

        // ---------- Return to Blade ----------
        return view('school.profile', compact(
            'school'
        ));
    }

    public function reportlist()
    {
        return view('school.reportlist');
    }

    public function fullreport()
    {
        return view('school.full-report');
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






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $schoolAuthorityList = SchoolAuthority::select('id','name')->get();
        $schoolEthnicityList = SchoolEthnicity::select('id','name')->get();
        $schoolClassList = SchoolClass::select('id','name')->get();
        $schoolDensityList = SchoolDensity::select('id','name')->get();
        $schoolFacilityList = SchoolFacility::select('id','name')->get();
        $schoolGenderList = SchoolGender::select('id','name')->get();
        $schoolLanguageList = SchoolLanguage::select('id','name')->get();
        $schoolMainReligionList = SchoolReligion::select('id','name')->get();

        $office = auth()->user()?->currentService?->currentAppointment?->workPlace?->office;

        return view('school.register',compact(
            'schoolAuthorityList',
            'schoolEthnicityList',
            'schoolClassList',
            'schoolDensityList',
            'schoolFacilityList',
            'schoolGenderList',
            'schoolLanguageList',
            'schoolMainReligionList',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        //dd($request->all());
        DB::beginTransaction();

        try {
            // 1️⃣ Create the workplace (core info)
            $workPlace = WorkPlace::create([
                'name'      => $request->name,
                'censusNo'  => $request->census,
                'categoryId'=> 1, // School category
            ]);
            //dd($workPlace);
            WorkPlaceContactInfo::create([
                'workPlaceId' => $workPlace->id,
                'addressLine1'     => $request->addressLine1,
                'addressLine2'     => $request->addressLine2,
                'addressLine3'     => $request->addressLine3,
                'mobile1'      => $request->mobile,
            ]);

            // 3️⃣ Create school with link to workplace
            School::create([
                'workPlaceId'   => $workPlace->id,
                'officeId'      => $request->division,
                'authorityId'   => $request->authorities,
                'ethnicityId'   => $request->ethnicity,
                'classId'       => $request->class,
                'densityId'     => $request->density,
                'facilityId'    => $request->facility,
                'genderId'      => $request->gender,
                'languageId'    => $request->language,
                'religionId'    => $request->religion,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'School information saved successfully.');
        } catch (\Exception $e) {
            //DB::rollBack();
            return back()->withErrors(['error' => 'Failed to register school: ' . $e->getMessage()]);
        }
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
