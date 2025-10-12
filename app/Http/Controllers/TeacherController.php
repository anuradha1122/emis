<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Subject;
use App\Models\AppointmentMedium;
use App\Models\AppointmentCategory;
use App\Models\Rank;
use App\Models\User;
use App\Models\UserInService;
use App\Models\Service;
use App\Models\UserServiceInRank;
use App\Models\UserServiceAppointment;
use App\Models\UserServiceAppointmentPosition;
use App\Models\TeacherService;
use App\Models\ContactInfo;
use App\Models\PersonalInfo;
use App\Models\LocationInfo;
use App\Models\Province;
use App\Models\School;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Position;
use App\Models\EducationQualification;
use App\Models\ProfessionalQualification;
use App\Models\FamilyMemberType;
use App\Models\FamilyInfo;
use App\Models\EducationQualificationInfo;
use App\Models\ProfessionalQualificationInfo;
use App\Models\WorkPlace;
use App\Models\Office;
use App\Models\District;
use App\Models\SchoolAuthority;
use App\Models\SchoolEthnicity;
use App\Models\SchoolClass;
use App\Models\SchoolDensity;
use App\Models\SchoolFacility;
use App\Models\SchoolGender;
use App\Models\SchoolLanguage;
use App\Models\AppointmentTermination;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Services\UserDashboardService;
use Mpdf\Mpdf;

class TeacherController extends Controller
{

    protected $teacherService;

    public function __construct(UserDashboardService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teacherCounts = $this->teacherService->getTeacherStatsFor(auth()->user());
        return view('teacher.dashboard',compact('teacherCounts'));
    }

    public function reportlist()
    {
        return view('teacher.reportlist');
    }

    public function fullreport()
    {
        return view('teacher.full-report');
    }

    public function fullreportPDF()
    {
        $schoolAuthorityList = SchoolAuthority::select('id','name')->get();
        $schoolEthnicityList = SchoolEthnicity::select('id','name')->get();
        $schoolClassList = SchoolClass::select('id','name')->get();
        $schoolDensityList = SchoolDensity::select('id','name')->get();
        $schoolFacilityList = SchoolFacility::select('id','name')->get();
        $schoolGenderList = SchoolGender::select('id','name')->get();
        $schoolLanguageList = SchoolLanguage::select('id','name')->get();
        $raceList = Race::select('id','name')->get();
        $religionList = Religion::select('id','name')->get();
        $civilStatusList = CivilStatus::select('id','name')->get();
        $genderList = collect([
            (object)['id' => 1, 'name' => 'Male'],
            (object)['id' => 2, 'name' => 'Female'],
        ]);

        return view('teacher.full-report-pdf',compact('schoolAuthorityList', 'schoolEthnicityList', 'schoolClassList', 'schoolDensityList', 'schoolFacilityList', 'schoolGenderList', 'schoolLanguageList', 'raceList', 'religionList', 'civilStatusList', 'genderList'));
    }

    public function exportfullreportPDF(Request $request)
    {
        $query = User::query()
            ->with([
                'personalInfo',
                'currentTeacherService.currentAppointment.workPlace.school'
            ])
            ->whereHas('currentTeacherService');

        // 🏫 Location-based filters
        if ($request->filled('school')) {
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->where('id', $request->school));
        } elseif ($request->filled('division')) {
            $division = Office::with('schools')->find($request->division);
            $schoolIds = $division?->schools->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($request->filled('zone')) {
            $zone = Office::with('subOffices.schools')->find($request->zone);
            $schoolIds = $zone?->subOffices->flatMap(fn($d) => $d->schools)->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($request->filled('district')) {
            $district = District::with('zones.subOffices.schools')->find($request->district);
            $schoolIds = $district?->zones
                ->flatMap(fn($zone) => $zone->subOffices
                    ->flatMap(fn($d) => $d->schools))
                ->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($request->filled('province')) {
            $province = Province::with('districts.zones.subOffices.schools')->find($request->province);
            $schoolIds = $province?->districts
                ->flatMap(fn($district) => $district->zones
                    ->flatMap(fn($zone) => $zone->subOffices
                        ->flatMap(fn($d) => $d->schools)))
                ->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        }

        // 🏫 School attributes
        foreach ([
            'schoolAuthority' => 'authorityId',
            'schoolEthnicity' => 'ethnicityId',
            'schoolClass' => 'classId',
            'schoolDensity' => 'densityId',
            'schoolFacility' => 'facilityId',
            'schoolGender' => 'genderId',
            'schoolLanguage' => 'languageId',
        ] as $property => $column) {
            if ($request->filled($property)) {
                $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                    fn($q) => $q->where($column, $request->$property));
            }
        }

        // 👤 Personal Info filters
        if ($request->filled('race')) {
            $query->whereHas('personalInfo', fn($q) => $q->where('raceId', $request->race));
        }
        if ($request->filled('religion')) {
            $query->whereHas('personalInfo', fn($q) => $q->where('religionId', $request->religion));
        }
        if ($request->filled('civilStatus')) {
            $query->whereHas('personalInfo', fn($q) => $q->where('civilStatusId', $request->civilStatus));
        }
        if ($request->filled('gender')) {
            $query->whereHas('personalInfo', fn($q) => $q->where('genderId', $request->gender));
        }
        if ($request->filled('birthDayStart')) {
            $query->whereHas('personalInfo', fn($q) => $q->where('birthDay', '>=', $request->birthDayStart));
        }
        if ($request->filled('birthDayEnd')) {
            $query->whereHas('personalInfo', fn($q) => $q->where('birthDay', '<=', $request->birthDayEnd));
        }

        // 📅 Service filters
        if ($request->filled('serviceStart')) {
            $query->whereHas('currentTeacherService', fn($q) => $q->where('appointedDate', '>=', $request->serviceStart));
        }
        if ($request->filled('serviceEnd')) {
            $query->whereHas('currentTeacherService', fn($q) => $q->where('appointedDate', '<=', $request->serviceEnd));
        }
        if ($request->filled('schoolAppointStart')) {
            $query->whereHas('currentTeacherService.currentAppointment',
                fn($q) => $q->where('appointedDate', '>=', $request->schoolAppointStart));
        }
        if ($request->filled('schoolAppointEnd')) {
            $query->whereHas('currentTeacherService.currentAppointment',
                fn($q) => $q->where('appointedDate', '<=', $request->schoolAppointEnd));
        }

        // 🔹 Chunked query to prevent memory issues


        // 🔹 Generate PDF with mPDF
        $mpdf = new Mpdf([
            'format' => 'A4-P', // landscape
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        // 🔹 Chunked query to prevent memory & backtrack issues
        $chunkSize = 100; // adjust if needed

        $query->chunk($chunkSize, function($results) use ($mpdf) {
            $html = view('exports.pdf.teacher.full-report', compact('results'))->render();
            $mpdf->WriteHTML($html);
            $mpdf->AddPage(); // automatically add page break after each chunk
        });

        return response($mpdf->Output('teacher_full_report.pdf', \Mpdf\Output\Destination::DOWNLOAD));
    }

    public function create()
    {

        $subjects = Subject::where('active', 1)->get();
        $appointedMediums = AppointmentMedium::where('active', 1)->get();
        $appointmentCategories = AppointmentCategory::where('active', 1)->get();
        $office = auth()->user()?->currentService?->currentAppointment?->workPlace?->office;

        if ($office && $office->officeTypeId == 2) {
            $schools = $office->allZoneSchools()
            ->with('workPlace')
            ->get()
            ->map(fn($school) => (object)[
                'id'   => $school->workPlace->id,
                'name' => $school->workPlace->name,
            ]);

        } else {
            $schools = collect(); // empty collection
        }

        $ranks = Rank::where('active', 1)
            ->where('serviceId', 1) // Filter by serviceId
            ->get();

        return view('teacher/register',compact('subjects', 'appointedMediums', 'appointmentCategories', 'ranks', 'schools'));
    }


    public function store(StoreTeacherRequest $request)
    {
        //dd($request);
        //DB::beginTransaction();

        try {
            // Handle profile photo
            $profileImage = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('userphotos', 'public');
                $profileImage = Storage::url($photoPath);
            }

            // Format name to initials
            $nameParts = explode(' ', $request->name);
            $lastName = array_pop($nameParts);
            $initials = array_map(fn($part) => strtoupper($part[0]) . '.', $nameParts);
            $nameWithInitials = implode('', $initials) . ' ' . $lastName;

            // Detect gender from NIC
            $nic = strtoupper($request->nic);
            $gender = null;

            if (preg_match('/^\d{9}[vVxX]$/', $nic)) {
                $day = (int) substr($nic, 2, 3);
                $gender = $day < 500 ? 1 : 2;
            } elseif (preg_match('/^\d{12}$/', $nic)) {
                $day = (int) substr($nic, 4, 3);
                $gender = $day < 500 ? 1 : 2;
            }

            // Optional: throw if gender detection fails
            if (is_null($gender)) {
                throw new \Exception('Invalid NIC format. Gender could not be determined.');
            }

            // Create user
            $user = User::create([
                'name' => ucwords(strtolower($request->name)),
                'nameWithInitials' => $nameWithInitials,
                'nic' => $nic,
                'password' => Hash::make(substr($nic, 0, 6)),
            ]);

            // Service details
            $userInService = UserInService::create([
                'userId' => $user->id,
                'serviceId' => 1,
                'appointedDate' => $request->serviceDate,
            ]);

            UserServiceInRank::create([
                'userServiceId' => $userInService->id,
                'rankId' => $request->ranks,
                'rankedDate' => $request->serviceDate,
            ]);

            TeacherService::create([
                'userServiceId' => $userInService->id,
                'appointmentSubjectId' => $request->subject,
                'mainSubjectId' => $request->subject,
                'appointmentMediumId' => $request->medium,
                'appointmentCategoryId' => $request->category,
            ]);

            $userServiceAppointment = UserServiceAppointment::create([
                'userServiceId' => $userInService->id,
                'workPlaceId' => $request->school,
                'appointedDate' => $request->serviceDate,
                'appointmentType' => 1,
            ]);

            ContactInfo::create([
                'userId' => $user->id,
                'permAddressLine1' => ucwords(strtolower($request->addressLine1)),
                'permAddressLine2' => ucwords(strtolower($request->addressLine2)),
                'permAddressLine3' => ucwords(strtolower($request->addressLine3)),
                'mobile1' => $request->mobile,
            ]);

            PersonalInfo::create([
                'userId' => $user->id,
                'profilePicture' => $profileImage,
                'genderId' => $gender,
                'birthDay' => $request->birthDay,
            ]);

            LocationInfo::create([
                'userId' => $user->id,
            ]);

            UserServiceAppointmentPosition::create([
                'userServiceAppId' => $userServiceAppointment->id,
                'positionId' => 1,
                'positionedDate' => $request->serviceDate,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Teacher information saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to save teacher: ' . $e->getMessage()]);
        }
    }

    public function profile(Request $request)
    {
        $decryptedId = Crypt::decryptString($request->id);

        // ---------- Teacher profile ----------
        $teacher = User::with([
                'personalInfo.race',
                'personalInfo.religion',
                'personalInfo.civilStatus',
                'contactInfo',
                'locationInfo.gnDivision.dsDivision.district.province',
                'locationInfo.office',
                'educationQualificationInfos.educationQualification',
                'professionalQualificationInfos.professionalQualification',
                'familyInfos.memberTypeRelation',
                'familyInfos.school.workPlace',
            ])
            ->find($decryptedId);
        //dd($teacher->familyInfos?->school);
        //dd($teacher);
        if (!$teacher) {
            abort(404, 'Teacher not found');
        }

        $teacher->cryptedId = $request->id;
        $teacher->gender = match(optional($teacher->personalInfo)->genderId) {
            1 => 'Male',
            2 => 'Female',
            default => 'Unknown',
        };
        $teacher->race = optional(optional($teacher->personalInfo)->race)->name;
        $teacher->religion = optional(optional($teacher->personalInfo)->religion)->name;
        $teacher->civilStatus = optional(optional($teacher->personalInfo)->civilStatus)->name;
        $teacher->birthDay = optional($teacher->personalInfo)->birthDay;

        $teacher->educationDivision = $teacher->locationInfo?->office?->educationDivision?->name;
        $teacher->gnDivision = $teacher->locationInfo?->gnDivision?->name;
        $teacher->dsDivision = $teacher->locationInfo?->gnDivision?->dsDivision?->name;
        $teacher->district = $teacher->locationInfo?->gnDivision?->dsDivision?->district?->name;
        $teacher->province = $teacher->locationInfo?->gnDivision?->dsDivision?->district?->province?->name;
        $teacher->permAddress = trim(implode(', ', array_filter([
            optional($teacher->contactInfo)->permAddressLine1,
            optional($teacher->contactInfo)->permAddressLine2,
            optional($teacher->contactInfo)->permAddressLine3,
        ])));
        $teacher->tempAddress = trim(implode(', ', array_filter([
            optional($teacher->contactInfo)->tempAddressLine1,
            optional($teacher->contactInfo)->tempAddressLine2,
            optional($teacher->contactInfo)->tempAddressLine3,
        ])));
        $teacher->mobile1 = optional($teacher->contactInfo)->mobile1;
        $teacher->mobile2 = optional($teacher->contactInfo)->mobile2;

        $teacher->educationDivision = $teacher->locationInfo->office->workPlace->name ?? 'No office assigned';

        // ---------- Current Service ----------
        $currentService = UserInService::with([
            'service',
            'serviceInRanks' => fn($q) => $q->where('active', 1)->with('rank'), // only active ranks
            'teacherService.appointmentSubject',
            'teacherService.mainSubject',
            'teacherService.appointmentMedium',
            'teacherService.appointmentCategory',
        ])
        ->where('userId', $decryptedId)
        ->current() // current service only (releasedDate is null)
        ->first();

        // Redirect if current service does not have a teacherService
        if (!$currentService || $currentService->serviceId != 1) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Current service is not a teaching service.');
        }

        $currentServiceRanks = $currentService
            ? $currentService->serviceInRanks->map(fn($rank) => [
                'rankId'      => $rank->rankId,
                'rankedDate'  => $rank->rankedDate,
                'current'     => $rank->current,
                'rankName'    => $rank->rank?->name,
                'userServiceId' => $currentService->id,
                'serviceName' => $currentService->service?->name,
            ])
            : collect();
        //dd($currentServiceRanks);


        // ---------- Previous Services ----------
        $previousServices = UserInService::with([
                'service',
                'appointments' => fn($q) => $q->whereNotNull('releasedDate')->where('active', 1)->with(['workPlace', 'positions.position'])
            ])
            ->where('userId', $decryptedId)
            ->previous()
            ->get();

        // Current appointments (appointmentType = 1, releasedDate null)
        $currentAppointments = $currentService
        ? $currentService->appointments()
            ->where('appointmentType', 1)
            ->whereNull('releasedDate') // <-- current appointment
            ->get()
            ->map(fn($app) => [
                'id' => $app->id,
                'workPlace' => optional($app->workPlace)->name,
                'appointedDate' => $app->appointedDate,
                'currentPositions' => $app->positions
                    ->where('active', 1)
                    ->map(fn($pos) => [
                        'id' => $pos->id,
                        'positionName' => optional($pos->position)->name,
                        'positionedDate' => $pos->positionedDate,
                    ])
                    ->values()
                    ->toArray(),
            ])
            ->toArray()
        : [];

        // Previous appointments (appointmentType = 1, releasedDate not null)
        $previousAppointments = $currentService
        ? $currentService->appointments()
            ->where('appointmentType', 1)
            ->whereNotNull('releasedDate') // <-- previous appointment
            ->get()
            ->map(fn($app) => [
                'id' => $app->id,
                'workPlace' => optional($app->workPlace)->name,
                'appointedDate' => $app->appointedDate,
                'releasedDate' => $app->releasedDate,
                'positions' => $app->positions
                    ->where('active', 1)
                    ->map(fn($pos) => [
                        'id' => $pos->id,
                        'positionName' => optional($pos->position)->name,
                        'positionedDate' => $pos->positionedDate,
                        'releasedDate' => $pos->releasedDate,
                    ])
                    ->values()
                    ->toArray(),
            ])
            ->toArray()
        : [];
        //dd($previousAppointments);

        // Current attached appointments (appointmentType = 2, releasedDate null)
        $currentAttachedAppointments = $currentService
        ? $currentService->appointments()
            ->where('appointmentType', 2)
            ->whereNull('releasedDate')
            ->get()
            ->map(fn($app) => [
                'id' => $app->id,
                'workPlace' => optional($app->workPlace)->name,
                'appointedDate' => $app->appointedDate,
                'positions' => $app->positions
                    ->where('active', 1)
                    ->map(fn($pos) => [
                        'id' => $pos->id,
                        'positionName' => optional($pos->position)->name,
                        'positionedDate' => $pos->positionedDate,
                    ])
                    ->values()
                    ->toArray(),
            ])
            ->toArray()
        : [];

        // Previous attached appointments (appointmentType = 2, releasedDate not null)
        $previousAttachedAppointments = $currentService
        ? $currentService->appointments()
            ->where('appointmentType', 2)
            ->whereNotNull('releasedDate')
            ->get()
            ->map(fn($app) => [
                'id' => $app->id,
                'workPlace' => optional($app->workPlace)->name,
                'appointedDate' => $app->appointedDate,
                'releasedDate' => $app->releasedDate,
                'positions' => $app->positions
                    ->where('active', 1)
                    ->map(fn($pos) => [
                        'id' => $pos->id,
                        'positionName' => optional($pos->position)->name,
                        'positionedDate' => $pos->positionedDate,
                        'releasedDate' => $pos->releasedDate,
                    ])
                    ->values()
                    ->toArray(),
            ])
            ->toArray()
        : [];


        //dd($currentAppointments, $previousAppointments);
        // ---------- Education & Professional Qualifications ----------
        $educationQualifications = $teacher->educationQualificationInfos
            ->map(fn($info) => optional($info->educationQualification)->name . ' Effective from ' . $info->effectiveDate)
            ->implode("\n");

        $professionalQualifications = $teacher->professionalQualificationInfos
            ->map(fn($info) => optional($info->professionalQualification)->name . ' Effective from ' . $info->effectiveDate)
            ->implode("\n");

        // ---------- Family ----------
        $family = $teacher->familyInfos->map(function ($member) {
            return [
                'relation'   => optional($member->memberTypeRelation)->name,
                'name'       => $member->name,
                'nic'        => $member->nic,
                'profession' => $member->profession,
                'school'     => optional($member->school?->workPlace)?->name,
            ];
        });

        //dd($family);


        // ---------- Return to Blade ----------
        return view('teacher/profile', compact(
            'teacher',
            'currentService',
            'previousServices',
            'currentServiceRanks',
            'currentAppointments',
            'currentAttachedAppointments',
            'previousAppointments',
            'previousAttachedAppointments',
            'educationQualifications',
            'professionalQualifications',
            'family'
        ));
    }

    public function profileEdit(Request $request)
    {
        try {
            $decryptedId = Crypt::decryptString($request->id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->route('teacher.search')
                            ->with('error', 'Invalid teacher ID provided.');
        }

        // Section to show in the form (default 'personal')
        $section = $request->get('section', 'personal');

        // Dropdown options from DB
        $races = Race::where('active', 1)->get(['id', 'name']);
        $religions = Religion::where('active', 1)->get(['id', 'name']);
        $civilStatuses = CivilStatus::where('active', 1)->get(['id', 'name']);
        $genders = collect([
            (object)['id' => 1, 'name' => 'Male'],
            (object)['id' => 2, 'name' => 'Female']
        ]);

        $subjectLists = Subject::where('active', 1)->get(['id', 'name']);
        $appointmentMediums = AppointmentMedium::where('active', 1)->get(['id', 'name']);
        $appointmentCategories = AppointmentCategory::where('active', 1)->get(['id', 'name']);

        // Ranks related to teacher's current service
        $teacher = User::with([
            'personalInfo',
            'contactInfo',
            'locationInfo',
            'currentTeacherService.serviceInRanks.rank', // load related rank names
            'currentTeacherService.teacherService',
        ])->findOrFail($decryptedId);

        //dd($teacher);
        // Get the current teacher service (serviceId = 1)
        $userService = $teacher->currentTeacherService()
        ->with(['serviceInRanks' => function($query) {
            $query->where('active', 1)->with('rank');
        }])
        ->first();

        $allUserServices = UserInService::with('service:id,name')
            ->where('userId', $decryptedId)
            ->orderBy('appointedDate', 'desc')
            ->get()
            ->map(fn($service) => (object)[
                'id'   => $service->id,                 // keep 'id' for Blade
                'name' => $service->service->name ?? 'N/A', // keep 'name' for Blade
            ]);


        $userServiceId = $userService->id ?? null;

        $appointments = $userServiceId
            ? UserServiceAppointment::with('workPlace')
                ->where('userServiceId', $userServiceId)
                ->orderBy('appointedDate', 'desc')
                ->get()
            : collect(); // empty collection if no service found
        //dd($appointments);
        $positions = Position::where('active', 1)->get(['id', 'name']);

        $existingPositions = UserServiceAppointmentPosition::where('active', 1)
        ->whereHas('appointment.userInService', function ($q) use ($decryptedId) {
            $q->where('userId', $decryptedId);
        })
        ->with(['appointment.workPlace', 'position'])
        ->orderBy('positionedDate', 'desc')
        ->get();


        //dd($userPositions);
        //dd($positions);

        $familyMemberTypes = FamilyMemberType::where('active', 1)->get(['id', 'name']);
        $familyInfos = $teacher->familyInfos()->where('active', 1)->get(['id', 'name']);
        //dd($familyInfos);

        $ranks = Rank::where('serviceId', 1)->where('active', 1)->get(['id', 'name']);

        $services = Service::where('active', 1)->get(['id', 'name']);

        $appointmentTypes = collect([
            ['id' => 1, 'name' => 'Permanent'],
            ['id' => 2, 'name' => 'Attachment'],
        ])->map(fn($a) => (object) $a); // cast to object

        //dd($services);
        $educationQualifications = EducationQualification::where('active', 1)->get(['id', 'name']);
        $professionalQualifications = ProfessionalQualification::where('active', 1)->get(['id', 'name']);

        $encryptedId = $request->id;

        return view('teacher.profile-edit', compact(
            'encryptedId',
            'decryptedId',
            'section',
            'teacher',
            'races',
            'religions',
            'civilStatuses',
            'genders',
            'subjectLists',
            'appointmentMediums',
            'appointmentCategories',
            'ranks',
            'services',
            'userService',
            'allUserServices',
            'appointments',
            'positions',
            'existingPositions',
            'appointmentTypes',
            'familyMemberTypes',
            'familyInfos',
            'educationQualifications',
            'professionalQualifications'
        ));
    }

    public function profileUpdate(UpdateTeacherRequest $request)
    {
        $teacherId = $request->input('id');
        $section = $request->input('section');

        $teacher = User::with(['personalInfo', 'contactInfo', 'locationInfo', 'currentTeacherService.serviceInRanks'])->findOrFail($teacherId);

        switch ($section) {

            case 'personal':
                // Update Users table
                $teacher->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'nic' => $request->nic,
                ]);

                // Update or create PersonalInfo (birthDay)
                $personalInfo = $teacher->personalInfo ?? new PersonalInfo(['userId' => $teacher->id]);
                $personalInfo->birthDay = $request->birthDay;
                $personalInfo->save();

                // Update or create ContactInfo
                $contactInfo = $teacher->contactInfo ?? new ContactInfo(['userId' => $teacher->id]);
                $contactInfo->fill([
                    'permAddressLine1' => $request->perm_address1,
                    'permAddressLine2' => $request->perm_address2,
                    'permAddressLine3' => $request->perm_address3,
                    'tempAddressLine1' => $request->res_address1,
                    'tempAddressLine2' => $request->res_address2,
                    'tempAddressLine3' => $request->res_address3,
                    'mobile1' => $request->mobile1,
                    'mobile2' => $request->mobile2,
                ])->save();
                break;

            case 'personal-info':
                $personalInfo = $teacher->personalInfo ?? new PersonalInfo(['userId' => $teacher->id]);

                if ($request->filled('race')) {
                    $personalInfo->raceId = $request->race;
                }
                if ($request->filled('religion')) {
                    $personalInfo->religionId = $request->religion;
                }
                if ($request->filled('civilStatus')) {
                    $personalInfo->civilStatusId = $request->civilStatus;
                }
                if ($request->filled('genders')) {
                    $personalInfo->genderId = $request->genders;
                }
                if ($request->filled('birthDay')) {
                    $personalInfo->birthDay = $request->birthDay;
                }

                $personalInfo->save();
                break;

            case 'location-info':
                // Get existing or create a new location record for the teacher
                $locationInfo = $teacher->locationInfo ?? new LocationInfo(['userId' => $teacher->id]);

                $updated = false;

                // 🔹 Update only if fields are provided
                if ($request->filled('eduDivision')) {
                    $locationInfo->educationDivisionId = $request->eduDivision;
                    $updated = true;
                }

                if ($request->filled('gnDivision')) {
                    $locationInfo->gnDivisionId = $request->gnDivision;
                    $updated = true;
                }

                // 🔹 Save if at least one field was provided
                if ($updated) {
                    $locationInfo->save();
                    return redirect()->back()->with('success', 'Location information updated successfully!');
                }

                // 🔹 No data provided
                return redirect()->back()->with('warning', 'No location data provided.');


            case 'rank-info':
                $userService = $teacher->currentTeacherService()->first();
                if (!$userService) {
                    return redirect()->back()->with('error', 'No active teacher service found!');
                }

                $action = $request->input('form_action');

                // 🔹 DELETE rank
                if ($action === 'delete') {
                    if ($request->filled('rankId')) {
                        $rankRow = $userService->serviceInRanks()
                            ->where('rankId', $request->rankId)
                            ->where('active', 1)
                            ->first();

                        if ($rankRow) {
                            $rankRow->update(['active' => 0]);
                            return redirect()->back()->with('success', 'Rank deleted successfully!');
                        }

                        return redirect()->back()->with('error', 'Rank not found!');
                    }

                    return redirect()->back()->with('error', 'No rank selected to delete!');
                }

                // 🔹 SAVE rank
                if ($action === 'save') {
                    if ($request->filled('rankId') && $request->filled('rankedDate')) {
                        // If new current rank added, reset previous ones (optional)
                        if ($request->boolean('current')) {
                            $userService->serviceInRanks()->update(['current' => 0]);
                        }

                        $rankRow = $userService->serviceInRanks()
                            ->where('rankId', $request->rankId)
                            ->first();

                        $data = [
                            'rankedDate' => $request->rankedDate,
                            'current'    => $request->boolean('current'),
                            'active'     => 1,
                        ];

                        if ($rankRow) {
                            $rankRow->update($data);
                        } else {
                            $userService->serviceInRanks()->create(array_merge(['rankId' => $request->rankId], $data));
                        }

                        return redirect()->back()->with('success', 'Rank saved successfully!');
                    }

                    return redirect()->back()->with('error', 'Rank or ranked date missing!');
                }

                break;



            case 'family-info':
                $userService = $teacher->currentTeacherService()->first();
                if (!$userService) {
                    return redirect()->back()->with('error', 'No active teacher service found!');
                }

                // 🔹 DELETE FAMILY MEMBER
                if ($request->input('form_action') === 'delete') {
                    $familyId = $request->input('family_id');
                    if ($familyId) {
                        $familyRow = FamilyInfo::where('id', $familyId)
                                                ->where('userId', $teacher->id)
                                                ->where('active', 1)
                                                ->first();
                        if ($familyRow) {
                            $familyRow->active = 0; // soft delete
                            $familyRow->save();

                            return redirect()->back()->with('success', 'Family member deleted successfully!');
                        }
                    }
                    return redirect()->back()->with('error', 'Family member not found!');
                }

                // 🔹 ADD NEW FAMILY MEMBER
                $familyData = $request->input('family.new', []);
                $schoolId = $request->input('school', null);

                if (!empty($familyData) && !empty($familyData['memberType']) && !empty($familyData['name'])) {
                    FamilyInfo::create([
                        'userId'       => $teacher->id,
                        'memberTypeId' => $familyData['memberType'],
                        'name'         => $familyData['name'],
                        'nic'          => $familyData['nic'] ?? null,
                        'profession'   => $familyData['profession'] ?? null,
                        'schoolId'     => $schoolId ?? null,
                        'active'       => 1,
                    ]);

                    return redirect()->back()->with('success', 'Family member added successfully!');
                }

                return redirect()->back()->with('error', 'Family information not updated!');


            case 'education-info':
                $teacher = User::with('educationQualificationInfos')->findOrFail($teacher->id);
                $eduData = $request->input('education', []);

                foreach ($eduData as $key => $data) {

                    // 🔹 Handle delete
                    if (isset($data['delete']) && $data['delete'] && isset($data['id'])) {
                        $eduRow = EducationQualificationInfo::where('id', $data['id'])
                                    ->where('userId', $teacher->id)
                                    ->first();
                        if ($eduRow) {
                            $eduRow->active = 0; // Soft delete
                            $eduRow->save();
                        }
                        continue;
                    }

                    // 🔹 Skip if required fields missing
                    if (empty($data['educationQualificationId']) || empty($data['effectiveDate'])) {
                        continue;
                    }

                    // 🔹 Update or create new
                    $eduRow = EducationQualificationInfo::where('userId', $teacher->id)
                                ->where('eduQualiId', $data['educationQualificationId'])
                                ->where('active', 1)
                                ->first();

                    if ($eduRow) {
                        $eduRow->effectiveDate = $data['effectiveDate'];
                        $eduRow->save();
                    } else {
                        EducationQualificationInfo::create([
                            'userId'        => $teacher->id,
                            'eduQualiId'    => $data['educationQualificationId'],
                            'effectiveDate' => $data['effectiveDate'],
                            'active'        => 1,
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'Education qualification info updated successfully!');

            case 'professional-info':
                $teacher = User::with('professionalQualificationInfos')->findOrFail($teacher->id);

                $profData = $request->input('professional', []);

                foreach ($profData as $key => $data) {

                    // 🔹 Handle soft delete
                    if (isset($data['delete']) && $data['delete'] && isset($data['id'])) {
                        $profRow = ProfessionalQualificationInfo::where('id', $data['id'])
                                    ->where('userId', $teacher->id)
                                    ->first();
                        if ($profRow) {
                            $profRow->active = 0;
                            $profRow->save();
                        }
                        continue;
                    }

                    // 🔹 Skip if required fields are missing
                    if (empty($data['professionalQualificationId']) || empty($data['effectiveDate'])) {
                        continue;
                    }

                    // 🔹 Check if this qualification already exists (active)
                    $profRow = ProfessionalQualificationInfo::where('userId', $teacher->id)
                                ->where('profQualiId', $data['professionalQualificationId'])
                                ->where('active', 1)
                                ->first();

                    if ($profRow) {
                        // Update effective date
                        $profRow->effectiveDate = $data['effectiveDate'];
                        $profRow->save();
                    } else {
                        // Create new qualification
                        ProfessionalQualificationInfo::create([
                            'userId'        => $teacher->id,
                            'profQualiId'   => $data['professionalQualificationId'],
                            'effectiveDate' => $data['effectiveDate'],
                            'active'        => 1,
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'Professional qualification info updated successfully!');

            case 'teacher-info':

                //dd('teacher info update');
                // 🔹 Get the active UserService for this teacher
                $userService = $teacher->currentTeacherService()->first();

                if (!$userService) {
                    return redirect()->back()->with('error', 'No active teacher service found!');
                }

                // 🔹 Validate incoming data
                $validated = $request->validate([
                    'appointment_subject' => 'nullable|exists:subjects,id',
                    'main_subject'        => 'nullable|exists:subjects,id',
                    'medium'              => 'nullable|exists:appointment_media,id',
                    'category'            => 'nullable|exists:appointment_categories,id',
                ]);

                // 🔹 Prepare data for insert/update
                $data = [
                    'userServiceId'         => $userService->id,
                    'appointmentSubjectId'  => $request->appointment_subject,
                    'mainSubjectId'         => $request->main_subject,
                    'appointmentMediumId'   => $request->medium,
                    'appointmentCategoryId' => $request->category,
                ];

                // 🔹 Fetch existing teacher_service records for this userService
                $teacherServices = $userService->teacherService()->get(); // assuming hasMany relationship

                if ($teacherServices->count() === 0) {
                    // ✅ Create new record if none exists
                    $userService->teacherService()->create($data);
                    return redirect()->back()->with('success', 'Teacher information created successfully!');
                }

                if ($teacherServices->count() === 1) {
                    // ✅ Update the existing record
                    $teacherService = $teacherServices->first();
                    $teacherService->update($data);
                    return redirect()->back()->with('success', 'Teacher information updated successfully!');
                }

                if ($teacherServices->count() > 1) {
                    // ✅ If multiple exist → delete all and recreate one clean record
                    $userService->teacherService()->delete();
                    $userService->teacherService()->create($data);
                    return redirect()->back()->with('warning', 'Multiple records found. Reset and created a new one successfully!');
                }

                break;


            case 'service-info':
                $teacherId = $teacher->id;

                // ✅ Check if delete button submitted
                if ($request->filled('delete_service_id')) {
                    $deleteId = $request->input('delete_service_id');

                    $serviceToDelete = UserInService::find($deleteId);
                    if ($serviceToDelete) {
                        // Delete related appointments first
                        $serviceToDelete->appointments()->delete();
                        $serviceToDelete->delete();

                        return back()->with('success', 'Service record deleted successfully!');
                    }

                    return back()->with('error', 'Service record not found.');
                }
                $serviceData = $request->input('service.new', []);
                $serviceId = $serviceData['serviceId'] ?? null;
                $appointmentType = $serviceData['appointmentType'] ?? 1; // 1 = Permanent, 2 = Attachment
                $appointedDate = $serviceData['appointedDate'] ?? null;
                $releasedDate = $serviceData['releasedDate'] ?? null;

                if (!$serviceId && !$appointedDate && !$releasedDate) {
                    return back()->with('error', 'Service data missing.');
                }

                // Get current active service
                $currentService = UserInService::where('userId', $teacherId)
                    ->whereNull('releasedDate')
                    ->latest('appointedDate')
                    ->first();

                // ================= CASE 1: Both appointedDate and releasedDate provided =================
                if ($appointedDate && $releasedDate) {
                    $existing = UserInService::where('userId', $teacherId)
                        ->where('serviceId', $serviceId)
                        ->where('appointedDate', $appointedDate)
                        ->where('releasedDate', $releasedDate)
                        ->first();

                    if ($existing) {
                        $existing->touch(); // optionally update timestamp
                    } else {
                        UserInService::create([
                            'userId' => $teacherId,
                            'serviceId' => $serviceId,
                            'appointedDate' => $appointedDate,
                            'releasedDate' => $releasedDate,
                        ]);
                    }
                }

                // ================= CASE 2: Only appointedDate provided =================
                elseif ($appointedDate && !$releasedDate) {
                    if ($currentService) {
                        // Close current service
                        $currentService->releasedDate = $appointedDate;
                        $currentService->save();

                        // Update appointments for the current service
                        $currentService->appointments()
                            ->whereNull('releasedDate')
                            ->update(['releasedDate' => $appointedDate]);
                    }

                    // Check if a current service with the same serviceId exists
                    $existingService = UserInService::where('userId', $teacherId)
                        ->where('serviceId', $serviceId)
                        ->whereNull('releasedDate')
                        ->first();

                    if ($existingService) {
                        // Update appointedDate only
                        $existingService->appointedDate = $appointedDate;
                        $existingService->save();
                    } else {
                        // No current service: check for previous service with same serviceId
                        $previousService = UserInService::where('userId', $teacherId)
                            ->where('serviceId', $serviceId)
                            ->latest('appointedDate')
                            ->first();

                        if ($previousService) {
                            // Replace previous service: update appointedDate and set releasedDate null
                            $previousService->appointedDate = $appointedDate;
                            $previousService->releasedDate = null;
                            $previousService->save();
                        } else {
                            // Create new service record
                            UserInService::create([
                                'userId' => $teacherId,
                                'serviceId' => $serviceId,
                                'appointedDate' => $appointedDate,
                                'releasedDate' => null,
                            ]);
                        }
                    }
                }


                // ================= CASE 3: Only releasedDate provided =================
                elseif (!$appointedDate && $releasedDate) {
                    if ($currentService) {
                        // Update current service releasedDate
                        $currentService->releasedDate = $releasedDate;
                        $currentService->save();

                        // Update all current appointments for this service
                        $currentService->appointments()
                            ->whereNull('releasedDate')
                            ->update(['releasedDate' => $releasedDate]);
                    }
                }

                return redirect()->back()->with('success', 'Service updated successfully!');


            case 'appointment-info':

                if ($request->filled('delete_appointment_id')) {
                    $deleteId = $request->input('delete_appointment_id');
                    $appointment = UserServiceAppointment::find($deleteId);

                    if ($appointment) {
                        // Delete related positions first (if exists)
                        $appointment->positions()->delete();
                        $appointment->delete();

                        return redirect()->back()->with('success', 'Appointment deleted successfully!');
                    } else {
                        return redirect()->back()->with('error', 'Appointment not found.');
                    }
                }

                $serviceData = $request->input('service.new', []);
                $schoolId = $request->input('school'); // from Livewire

                $appointmentType = $serviceData['appointmentType'] ?? 1; // 1 = Permanent, 2 = Attachment
                $appointedDate = $serviceData['appointedDate'] ?? null;
                $releasedDate = $serviceData['releasedDate'] ?? null;

                $workPlaceId = School::where('id', $schoolId)->value('workPlaceId');
                $userServiceId = $serviceData['userInServiceId'] ?? null;

                if (!$userServiceId || !$schoolId) {
                    return back()->with('error', 'Service and School selection required.');
                }

                // Helper function to create appointment + linked position
                $createAppointment = function($userServiceId, $workPlaceId, $appointmentType, $appointedDate, $releasedDate) {
                    $appointment = UserServiceAppointment::create([
                        'userServiceId'  => $userServiceId,
                        'workPlaceId'    => $workPlaceId,
                        'appointmentType'=> $appointmentType,
                        'appointedDate'  => $appointedDate,
                        'releasedDate'   => $releasedDate,
                    ]);

                    // Create linked position record (positionId = 1)
                    UserServiceAppointmentPosition::create([
                        'userServiceAppId' => $appointment->id,
                        'positionId'       => 1,
                        'positionedDate'   => $appointedDate,
                    ]);
                };

                // ----------------------------------
                // APPOINTMENT TYPE = 1 (PERMANENT)
                // ----------------------------------
                if ($appointmentType == 1) {

                    // Case 1: Only appointedDate
                    if ($appointedDate && !$releasedDate) {
                        UserServiceAppointment::where('userServiceId', $userServiceId)
                            ->where('appointmentType', 1)
                            ->whereNull('releasedDate')
                            ->update(['releasedDate' => $appointedDate]);

                        $createAppointment($userServiceId, $workPlaceId, 1, $appointedDate, null);
                    }

                    // Case 2: Only releasedDate
                    elseif (!$appointedDate && $releasedDate) {
                        UserServiceAppointment::where('userServiceId', $userServiceId)
                            ->where('appointmentType', 1)
                            ->whereNull('releasedDate')
                            ->update(['releasedDate' => $releasedDate]);
                    }

                    // Case 3: Both appointedDate & releasedDate
                    elseif ($appointedDate && $releasedDate) {
                        $createAppointment($userServiceId, $workPlaceId, 1, $appointedDate, $releasedDate);
                    }
                }

                // ----------------------------------
                // APPOINTMENT TYPE = 2 (ATTACHMENT)
                // ----------------------------------
                elseif ($appointmentType == 2) {

                    // Case 1: Only appointedDate
                    if ($appointedDate && !$releasedDate) {
                        UserServiceAppointment::where('userServiceId', $userServiceId)
                            ->where('appointmentType', 2)
                            ->whereNull('releasedDate')
                            ->update(['releasedDate' => $appointedDate]);

                        $createAppointment($userServiceId, $workPlaceId, 2, $appointedDate, null);
                    }

                    // Case 2: Only releasedDate
                    elseif (!$appointedDate && $releasedDate) {
                        UserServiceAppointment::where('userServiceId', $userServiceId)
                            ->where('appointmentType', 2)
                            ->whereNull('releasedDate')
                            ->update(['releasedDate' => $releasedDate]);
                    }

                    // Case 3: Both appointedDate & releasedDate
                    elseif ($appointedDate && $releasedDate) {
                        $createAppointment($userServiceId, $workPlaceId, 2, $appointedDate, $releasedDate);
                    }
                }



                return redirect()->back()->with('success', 'Service updated successfully!');

            case 'position-info':
                $formAction = $request->input('form_action'); // "save" or "delete"

                if ($formAction === 'delete') {
                    $data = $request->validate([
                        'position.delete.id' => 'required|exists:user_service_appointment_positions,id',
                    ]);

                    $position = \App\Models\UserServiceAppointmentPosition::find($data['position']['delete']['id']);

                    if (!$position) {
                        return redirect()->back()->with('error', 'Position not found!');
                    }

                    // Soft delete if column exists
                    if (Schema::hasColumn('user_service_appointment_positions', 'active')) {
                        $position->update(['active' => 0]);
                    } else {
                        $position->delete();
                    }

                    return redirect()->back()->with('success', 'Position deleted successfully!');
                }

                if ($formAction === 'save') {
                    $data = $request->validate([
                        'position.new.userServiceAppId' => 'required|exists:user_service_appointments,id',
                        'position.new.positionId' => 'required|exists:positions,id',
                        'position.new.positionedDate' => 'required|date',
                    ]);

                    \App\Models\UserServiceAppointmentPosition::create([
                        'userServiceAppId' => $data['position']['new']['userServiceAppId'],
                        'positionId' => $data['position']['new']['positionId'],
                        'positionedDate' => $data['position']['new']['positionedDate'],
                        'active' => 1,
                    ]);

                    return redirect()->back()->with('success', 'Position added successfully!');
                }

                break;




                default:
                    return redirect()->back()->with('error', 'Invalid section!');
        }

        return redirect()->back()->with('success', 'Section updated successfully!');
    }



}
