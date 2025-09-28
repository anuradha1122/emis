<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//use Spatie\Image\Image;
use App\Models\Student;
use App\Models\StudentContactInfo;
use App\Models\StudentPersonalInfo;
use App\Models\StudentLocationInfo;
use App\Models\StudentSchool;
use App\Models\Race;
use App\Models\Religion;
use App\Models\BloodGroup;
use App\Models\GuardianRelationship;
use App\Models\ClassList;
use App\Models\SchoolClassStudent;
use App\Models\Illness;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $option = ['Dashboard' => 'dashboard'];
        $gradeStudentsQuery = DB::table('school_class_students')
            ->join('school_class_lists', 'school_class_students.schoolClassId', '=', 'school_class_lists.id')
            ->join('class_lists', 'school_class_lists.classId', '=', 'class_lists.id')
            ->join('grades', 'class_lists.gradeId', '=', 'grades.id')
            ->join('student_personal_infos', 'school_class_students.studentId', '=', 'student_personal_infos.studentId');

        // Check which variable is set: $schoolId or $officeId
        if (session('schoolId')) {
            $gradeStudentsQuery->where('school_class_lists.schoolId', session('schoolId'));
        } elseif (session('officeId') AND session('officeTypeId') == 3) {
            $gradeStudentsQuery->join('schools', 'school_class_lists.schoolId', '=', 'schools.id')
                ->where('schools.officeId', session('officeId'));
        } elseif (session('officeId') AND session('officeTypeId') == 2) {
            $gradeStudentsQuery->join('schools', 'school_class_lists.schoolId', '=', 'schools.id')
                ->join('offices', 'schools.officeId', '=', 'offices.id')
                ->where('offices.higherOfficeId', session('officeId'));
        } elseif (session('officeId') AND session('officeTypeId') == 1) {
            $gradeStudentsQuery->join('schools', 'school_class_lists.schoolId', '=', 'schools.id')
                ->join('offices AS divisions', 'schools.officeId', '=', 'divisions.id')
                ->join('offices AS zones', 'divisions.higherOfficeId', '=', 'zones.id')
                ->where('zones.higherOfficeId', session('officeId'));
        } else{
            //all
        }

        $gradeStudents = $gradeStudentsQuery
            ->where('school_class_lists.active', 1)
            ->whereIn('student_personal_infos.genderId', [1, 2])
            ->select(
                'grades.name as name',
                DB::raw('SUM(CASE WHEN student_personal_infos.genderId = 1 THEN 1 ELSE 0 END) as maleCount'),
                DB::raw('SUM(CASE WHEN student_personal_infos.genderId = 2 THEN 1 ELSE 0 END) as femaleCount')
            )
            ->groupBy('grades.name')
            ->orderBy('grades.name')
            ->get();


        return view('student/dashboard',compact('option','gradeStudents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $races = Race::where('active', 1)->get();
        $religions = Religion::where('active', 1)->get();
        $genders = collect([
            (object) ['id' => 1, 'name' => 'Male'],
            (object) ['id' => 2, 'name' => 'Female'],
        ]);
        $bloodGroups = BloodGroup::where('active', 1)->get();
        $illnesses = Illness::where('active', 1)->get();
        $guardianRelationships = GuardianRelationship::where('active', 1)->get();

        $classes = ClassList::join('school_class_lists', 'class_lists.id', '=', 'school_class_lists.classId')
                            ->select('school_class_lists.id AS id', 'class_lists.name AS name')
                            ->where('school_class_lists.active', 1)
                            ->where('school_class_lists.schoolId', session('schoolId'))
                            ->get();

        $option = [
            'Dashboard' => 'dashboard',
            'Student Dashboard' => 'student.dashboard',
            'Student Registration' => 'student.register'
        ];

        return view('student/register',compact('option','races','religions','genders','bloodGroups','illnesses','guardianRelationships','classes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        // dd($request->class);
        //dd($request->all());

        //dd($request->hasFile('photo'));
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('studentphotos', 'public');
            //$photoPath = Image::load($request->file('photo'))->resize(100,100)->save('studentphotos', 'public');
            $profileImage = Storage::url($photoPath);
        } else {
            $profileImage = null;
        }
        //dd($photoPath);
        // $image_path = Storage::url('');
        // //dd($image_path);
        // $profileImage = $image_path.$photoPath;
        //dd($profileImage);
        // Generate 'name with initials'
        $nameParts = explode(' ', $request->name);
        $lastName = ucfirst(array_pop($nameParts));
        $initials = implode('.', array_map(fn($part) => strtoupper(substr($part, 0, 1)), $nameParts)) . '.';
        $nameWithInitials = $initials . ' ' . $lastName;

        // Calculate the day count considering leap years
        $birthDate = \Carbon\Carbon::parse($request->birthDay);
        $year = $birthDate->year;
        $month = $birthDate->month;
        $day = $birthDate->day;

        // Day count calculation considering leap years
        $dayCount = 0;
        for ($i = 1; $i < $month; $i++) {
            $dayCount += \Carbon\Carbon::create($year, $i, 1)->daysInMonth;
        }
        $dayCount += $day;

        // Adjust day count based on gender
        if ($request->gender == 'female') {
            $dayCount += 500;
        }

        // Format studentNo
        $student = Student::create([
            'name' => $request->name,
            'nameWithInitials' => $nameWithInitials,
            'nic' => $request->nic,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'identificationNo' => $request->identificationNo,
            'registerNo' => $request->registerNo,
        ]);


        // Generate studentNo
        $studentNo = $year . str_pad($dayCount, 3, '0', STR_PAD_LEFT) . str_pad($student->id, 7, '0', STR_PAD_LEFT);

        // Update the student record with generated studentNo
        $student->update(['studentNo' => $studentNo]);

        // Insert into 'student_contact_infos' table
        //dd($request->guardianNic);
        StudentContactInfo::create([
            'studentId' => $student->id,
            'addressLine1' => $request->addressLine1,
            'addressLine2' => $request->addressLine2,
            'addressLine3' => $request->addressLine3,
            'mobile' => $request->mobile,

            // Guardian Info
            'guardianName' => $request->guardianName,
            'guardianNic' => $request->guardianNic,
            'guardianRelationshipId' => $request->guardianRelationship,
            'guardianEmail' => $request->guardianEmail,
            'guardianMobile' => $request->guardianMobile,

            // Mother Info
            'motherName' => $request->motherName,
            'motherNic' => $request->motherNic,
            'motherMobile' => $request->motherMobile,
            'motherEmail' => $request->motherEmail,

            // Father Info
            'fatherName' => $request->fatherName,
            'fatherNic' => $request->fatherNic,
            'fatherMobile' => $request->fatherMobile,
            'fatherEmail' => $request->fatherEmail,

            'active' => 1,
        ]);


        // Insert into 'student_location_infos' table


        StudentLocationInfo::create([
            'studentId' => $student->id,
            'educationDivisionId' => $request->division,
            'gnDivisionId' => $request->gnDivision,
        ]);

        //dd($profileImage);
        // Insert into 'student_personal_infos' table
        StudentPersonalInfo::create([
            'studentId' => $student->id,
            'profilePicture' => $profileImage,
            'raceId' => $request->race,
            'religionId' => $request->religion,
            'genderId' => $request->gender,
            'bloodGroupId' => $request->bloodGroup,
            'illness' => $request->illness,
            'birthDay' => $request->birthDay,
            'birthCertificate' => $request->birthCertificate,
            'birthDsDivision' => $request->birthDsDivision,
        ]);
        //dd($profileImage);
        // Insert into 'student_schools' table
        StudentSchool::create([
            'studentId' => $student->id,
            'schoolId' => session('schoolId'),
            'appointedDate' => $request->registerDate,
        ]);
        //dd($request->class);
        SchoolClassStudent::create([
            'schoolClassId' => $request->class,
            'studentId' => $student->id,
        ]);

        // Redirect or return response
        return redirect()->back()->with('success', 'Student information saved successfully.');
    }

    public function search()
    {
        $option = [
            'Dashboard' => 'dashboard',
            'Student Dashboard' => 'student.dashboard',
            'Student Search' => 'student.search'
        ];
        return view('student/search',compact('option'));
    }

    public function profile(Request $request)
    {
        if($request->has('id')){
            try{

                $decryptedId = Crypt::decryptString($request->id);
                $option = [
                    'student Dashboard' => 'student.dashboard',
                    'student Search' => 'student.search',
                    'Student Profile' => route('student.profile', ['id' => $request->id]),
                ];

                $student = DB::table('students')
                ->leftjoin('student_personal_infos', 'student_personal_infos.studentId', '=', 'students.id')
                ->leftjoin('student_contact_infos', 'student_contact_infos.studentId', '=', 'students.id')
                ->leftjoin('student_location_infos', 'student_location_infos.studentId', '=', 'students.id')
                ->leftjoin('student_schools', 'student_schools.studentId', '=', 'students.id')
                ->leftjoin('school_class_students', 'school_class_students.studentId', '=', 'students.id')
                ->leftjoin('races', 'races.id', '=', 'student_personal_infos.raceId')
                ->leftjoin('religions', 'religions.id', '=', 'student_personal_infos.religionId')
                ->leftjoin('blood_groups', 'blood_groups.id', '=', 'student_personal_infos.bloodGroupId')
                ->leftjoin('illnesses', 'illnesses.id', '=', 'student_personal_infos.illnessId')
                ->leftjoin('ds_divisions AS birth_ds_divisions', 'birth_ds_divisions.id', '=', 'student_personal_infos.birthDsDivisionId')
                ->leftjoin('guardian_relationships', 'guardian_relationships.id', '=', 'student_contact_infos.guardianRelationshipId')
                ->leftjoin('offices', 'offices.id', '=', 'student_location_infos.educationDivisionId')
                ->leftjoin('work_places AS work_place_divisions', 'work_place_divisions.id', '=', 'offices.workPlaceId')
                ->leftjoin('gn_divisions', 'gn_divisions.id', '=', 'student_location_infos.gnDivisionId')
                ->leftjoin('ds_divisions', 'ds_divisions.id', '=', 'gn_divisions.dsId')
                ->leftjoin('districts', 'districts.id', '=', 'ds_divisions.districtId')
                ->leftjoin('provinces', 'provinces.id', '=', 'districts.provinceId')
                ->leftjoin('schools', 'schools.id', '=', 'student_schools.schoolId')
                ->leftjoin('work_places AS work_place_schools', 'work_place_schools.id', '=', 'schools.workPlaceId')
                ->leftjoin('school_class_lists', 'school_class_lists.id', '=', 'school_class_students.schoolClassId')
                ->leftjoin('class_lists', 'class_lists.id', '=', 'school_class_lists.classId')
                ->select(
                    'students.*',
                    'student_personal_infos.*',
                    'student_contact_infos.*',
                    'student_location_infos.*',
                    'guardian_relationships.name AS guardianRelationship',
                    'races.name as race',
                    'religions.name as religion',
                    'blood_groups.name as bloodGroup',
                    'illnesses.name as illness',
                    'birth_ds_divisions.name as birthDsDivision',
                    DB::raw("CASE WHEN student_personal_infos.genderId = 1 THEN 'Boy' WHEN student_personal_infos.genderId = 2 THEN 'Girl' END as gender"),
                    'work_place_divisions.name as educationDivision',
                    'gn_divisions.name as gnDivision',
                    'ds_divisions.name as dsDivision',
                    'districts.name as district',
                    'provinces.name as province',
                    'work_place_schools.name as school',
                    'class_lists.name as class'
                )
                ->where('students.id', $decryptedId)
                ->where('students.active', 1)
                ->where('student_personal_infos.active', 1)
                ->where('student_contact_infos.active', 1)
                ->where('student_location_infos.active', 1)
                ->where('student_schools.active', 1)
                ->where('school_class_students.active', 1)
                ->where('student_schools.current', 1) // Ensuring the current school is selected
                ->first();
                if ($student) {
                    $student->cryptedId = $request->id;
                }
                else {
                    // Redirect or show an error if no student is found
                    return redirect()->route('student.search')->with('error', 'Student not found.');
                }

                return view('student/profile',compact('student','option'));

            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Redirect to the search page or show an error message for invalid ID
                return redirect()->route('student.search')->with('error', 'Invalid student ID provided.');
            }

        }else{
            return redirect()->route('student.search');
        }
    }

    public function reports()
    {
        $option = [
            'Dashboard' => 'dashboard',
            'Student Dashboard' => 'student.dashboard',
            'Student Reports' => 'student.reports'
        ];
        return view('student/reports',compact('option'));
    }


    public function idPdf($studentNo)
    {
        //$qrCode = base64_encode(QrCode::format('png')->size(50)->generate('123456789'));
        //dd($studentNo);

        $studentData = DB::table('students')
            ->join('student_schools', 'students.id', '=', 'student_schools.studentId')
            ->join('schools', 'student_schools.schoolId', '=', 'schools.id')
            ->join('work_places', 'schools.workPlaceId', '=', 'work_places.id')
            ->join('student_personal_infos', 'students.id', '=', 'student_personal_infos.studentId')
            ->where('students.studentNo', $studentNo)
            ->select(
                'students.*',
                'student_schools.schoolId',
                'work_places.name as workplace_name',
                'student_personal_infos.profilePicture'
            )
            ->first();

                //dd($studentData->profilePicture);

        $pdf = Pdf::loadView('student.pdf.student-id-pdf', compact('studentData'));

        return $pdf->download('student-id.pdf');

        //return $pdf->download();
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
