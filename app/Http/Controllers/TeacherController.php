<?php

namespace App\Http\Controllers;

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
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
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
        $ranks = Rank::where('active', 1)
            ->where('serviceId', 1) // Filter by serviceId
            ->get();


        $option = [
            'Dashboard' => 'teacher.dashboard',
            'Teacher Registration' => 'teacher.register'
        ];
        return view('teacher/register',compact('option', 'subjects', 'appointedMediums', 'appointmentCategories', 'ranks'));
    }


    public function store(StoreTeacherRequest $request)
    {
        DB::beginTransaction();

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
                'userServiceAppointmentId' => $userServiceAppointment->id,
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
        if($request->has('id')){
            try{

                $option = [
                    'Dashboard' => 'dashboard',
                    'Teacher Dashboard' => 'teacher.dashboard',
                    'Teacher Search' => 'teacher.search',
                    'Teacher Profile' => route('teacher.profile', ['id' => $request->id]),
                ];

                $decryptedId = Crypt::decryptString($request->id);
                //dd($decryptedId);
                $teacher = User::leftjoin('personal_infos', 'users.id', '=', 'personal_infos.userId')
                ->leftjoin('races', 'personal_infos.raceId', '=', 'races.id')
                ->leftjoin('religions', 'personal_infos.religionId', '=', 'religions.id')
                ->leftjoin('civil_statuses', 'personal_infos.civilStatusId', '=', 'civil_statuses.id')
                ->leftjoin('contact_infos', 'users.id', '=', 'contact_infos.userId')
                ->leftjoin('location_infos', 'users.id', '=', 'location_infos.userId')
                ->leftJoin('offices', 'location_infos.educationDivisionId', '=', 'offices.id')
                ->leftJoin('work_places AS educationDivisions', 'offices.workPlaceId', '=', 'educationDivisions.id')
                ->leftjoin('gn_divisions', 'location_infos.gnDivisionId', '=', 'gn_divisions.id')
                ->leftjoin('ds_divisions', 'gn_divisions.dsId', '=', 'ds_divisions.id')
                ->leftjoin('districts', 'ds_divisions.districtId', '=', 'districts.id')
                ->leftjoin('provinces', 'districts.provinceId', '=', 'provinces.id')
                ->where('users.id', $decryptedId)
                ->select(
                    'users.id AS userId','users.name AS name','users.nic','users.email','users.nameWithInitials',
                    'personal_infos.birthDay','personal_infos.profilePicture',
                    DB::raw("CASE
                        WHEN personal_infos.genderId = 1 THEN 'Male'
                        WHEN personal_infos.genderId = 2 THEN 'Female'
                        ELSE 'Unknown'
                    END AS gender"),
                    'races.name AS race',
                    'religions.name AS religion',
                    'civil_statuses.name AS civilStatus',
                    'contact_infos.*',
                    'educationDivisions.name AS educationDivision',
                    'gn_divisions.name AS gnDivision',
                    'ds_divisions.name AS dsDivision',
                    'districts.name AS district',
                    'provinces.name AS province',
                )
                ->first();
                if ($teacher) {
                    $teacher->cryptedId = $request->id;
                }

                $combinedData = UserInService::join('services', function ($join) {
                        $join->on('user_in_services.serviceId', '=', 'services.id')
                            ->where('services.active', 1);
                    })
                    ->leftJoin('user_service_in_ranks', function ($join) {
                        $join->on('user_in_services.id', '=', 'user_service_in_ranks.userServiceId')
                            ->where('user_service_in_ranks.active', 1);
                    })
                    ->leftJoin('ranks', function ($join) {
                        $join->on('user_service_in_ranks.rankId', '=', 'ranks.id')
                            ->where('ranks.active', 1);
                    })
                    ->where('user_in_services.userId', $decryptedId)
                    ->where('user_in_services.active', 1)
                    ->select(
                        'user_in_services.id AS userServiceId',
                        'user_in_services.appointedDate',
                        'user_in_services.releasedDate',
                        'user_in_services.current AS currentService',
                        'services.name AS serviceName',
                        'user_service_in_ranks.id AS serviceRankId',
                        'user_service_in_ranks.rankId',
                        'user_service_in_ranks.rankedDate',
                        'user_service_in_ranks.current AS currentRank',
                        'ranks.name AS rank'
                    )
                    ->get();


                // Partition services into current and previous
                $partitionedData = $combinedData->partition(function ($item) {
                    return $item->currentService == 1 && is_null($item->releasedDate);
                });

                // Get distinct current services (no ranks)
                $currentService = $partitionedData[0]
                    ->unique('userServiceId')
                    ->map(function ($item) {
                        $servicePeriod = "from {$item->appointedDate} to " . ($item->releasedDate ?? 'present');
                        return [
                            'userServiceId' => $item->userServiceId,
                            'formattedService' => "{$item->serviceName} {$servicePeriod}",
                        ];
                    }); // Keep as a collection

                // Extract current service IDs
                $currentServiceIds = $currentService->pluck('userServiceId');

                // If you need to convert $currentService to an array for Blade:
                $currentServiceArray = $currentService->pluck('formattedService', 'userServiceId')->toArray();


                $previousServices = $partitionedData[1]
                ->unique('userServiceId')
                ->map(function ($item) {
                    $servicePeriod = "from {$item->appointedDate} to " . ($item->releasedDate ?? 'present');
                    return [
                        'userServiceId' => $item->userServiceId,
                        'formattedService' => "{$item->serviceName} {$servicePeriod}",
                    ];
                }); // Keep as a collection

                $previousServiceIds = $previousServices->pluck('userServiceId');

                // If you need to convert $previousServices to an array for Blade:
                $previousServicesArray = $previousServices->pluck('formattedService', 'userServiceId')->toArray();


                $currentServiceRanks = $combinedData->filter(function ($item) use ($currentServiceIds) {
                    return $currentServiceIds->contains($item->userServiceId) && !is_null($item->serviceRankId);
                })->map(function ($item) {
                    $rankPeriod = "from {$item->rankedDate}";
                    return [
                        'userServiceId' => $item->userServiceId,
                        'formattedRank' => "{$item->rank} {$rankPeriod}",
                    ];
                });
                //dd($currentServiceRanks);
                // Convert to an array for Blade if needed
                $currentServiceRanksArray = $currentServiceRanks->pluck('formattedRank')->toArray();
                //dd($currentServiceRanksArray);
                $previousServiceRanks = $combinedData->filter(function ($item) use ($previousServiceIds) {
                    return $previousServiceIds->contains($item->userServiceId) && !is_null($item->serviceRankId);
                })->map(function ($item) {
                    $rankPeriod = "from {$item->rankedDate}";
                    return [
                        'userServiceId' => $item->userServiceId,
                        'formattedRank' => "{$item->rank} {$rankPeriod}",
                    ];
                });


                // Convert to an array for Blade if needed
                $previousServiceRanksArray = $previousServiceRanks->pluck('formattedRank', 'userServiceId')->toArray();
                //dd($previousServiceRanksArray);

                // Fetch appointments and categorize them into current and previous based on the service IDs
                $appointments = UserServiceAppointment::join('work_places', 'user_service_appointments.workPlaceId', '=', 'work_places.id')
                ->whereIn('user_service_appointments.userServiceId', $currentServiceIds)
                ->orWhereIn('user_service_appointments.userServiceId', $previousServiceIds)
                ->select(
                    'user_service_appointments.*',
                    'work_places.name AS workPlaceName',
                    'work_places.censusNo AS censusNo',
                    'work_places.categoryId AS workPlaceCategory'
                )
                ->get();
                //dd($appointments);
                // Partition appointments into categories based on their attributes
                $appointmentsPartitioned = $appointments->groupBy(function ($appointment) {
                if (is_null($appointment->releasedDate)) {
                    return $appointment->appointmentType == 1 ? 'currentAppointments' : 'currentAttachAppointments';
                } elseif (!is_null($appointment->releasedDate)) {
                    return $appointment->appointmentType == 1 ? 'previousAppointments' : 'previousAttachAppointments';
                }
                return null; // Ignore other cases
                });
                //dd($appointmentsPartitioned);
                // Map the partitions to IDs
                $currentAppointmentIds = $appointmentsPartitioned->get('currentAppointments', collect())->pluck('id')->toArray();
                $previousAppointmentIds = $appointmentsPartitioned->get('previousAppointments', collect())->pluck('id')->toArray();
                $currentAttachAppointmentIds = $appointmentsPartitioned->get('currentAttachAppointments', collect())->pluck('id')->toArray();
                $previousAttachAppointmentIds = $appointmentsPartitioned->get('previousAttachAppointments', collect())->pluck('id')->toArray();

                // Format and return results for each category
                $currentAppointments = $appointmentsPartitioned->get('currentAppointments', collect())
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'formattedAppointment' => "{$appointment->workPlaceName} from {$appointment->appointedDate}",
                    ];
                })->pluck('formattedAppointment', 'id')->toArray();
                //dd($currentAppointments);
                $previousAppointments = $appointmentsPartitioned->get('previousAppointments', collect())
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'formattedAppointment' => "{$appointment->workPlaceName} from {$appointment->appointedDate} to {$appointment->releasedDate}",
                    ];
                })->pluck('formattedAppointment', 'id')->toArray();
                //dd($previousAppointments);
                $currentAttachAppointments = $appointmentsPartitioned->get('currentAttachAppointments', collect())
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'formattedAppointment' => "{$appointment->workPlaceName} from {$appointment->appointedDate}",
                    ];
                })->pluck('formattedAppointment', 'id')->toArray();
                //dd($currentAttachAppointments);
                $previousAttachAppointments = $appointmentsPartitioned->get('previousAttachAppointments', collect())
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'formattedAppointment' => "{$appointment->workPlaceName} from {$appointment->appointedDate} to {$appointment->releasedDate}",
                    ];
                })->pluck('formattedAppointment', 'id')->toArray();


                $positions = UserServiceAppointmentPosition::join('positions', 'user_service_appointment_positions.positionId', '=', 'positions.id')
                    ->whereIn('user_service_appointment_positions.userServiceAppointmentId', array_merge(
                        $currentAppointmentIds,
                        $previousAppointmentIds,
                        $currentAttachAppointmentIds,
                        $previousAttachAppointmentIds
                    ))
                    ->select(
                        'user_service_appointment_positions.*',
                        'positions.name AS position'
                    )
                    ->get();

                // Partition positions into categories based on appointment IDs
                $positionsPartitioned = $positions->groupBy(function ($position) use (
                    $currentAppointmentIds,
                    $previousAppointmentIds,
                    $currentAttachAppointmentIds,
                    $previousAttachAppointmentIds,
                ) {
                    if (in_array($position->userServiceAppointmentId, $currentAppointmentIds)) {
                        return 'currentPositions';
                    } elseif (in_array($position->userServiceAppointmentId, $previousAppointmentIds)) {
                        return 'previousPositions';
                    } elseif (in_array($position->userServiceAppointmentId, $currentAttachAppointmentIds)) {
                        return 'currentAttachPositions';
                    } elseif (in_array($position->userServiceAppointmentId, $previousAttachAppointmentIds)) {
                        return 'previousAttachPositions';
                    }
                    return null; // Ignore other cases
                });

                // Map the partitions to structured data
                $currentPositions = $positionsPartitioned->get('currentPositions', collect())
                    ->map(function ($position) {
                        return [
                            'id' => $position->id,
                            'positionName' => $position->position,
                            'details' => $position->toArray(),
                        ];
                })->values();

                $previousPositions = $positionsPartitioned->get('previousPositions', collect())
                    ->map(function ($position) {
                        return [
                            'id' => $position->id,
                            'positionName' => $position->position,
                            'details' => $position->toArray(),
                        ];
                })->values();

                $currentAttachPositions = $positionsPartitioned->get('currentAttachPositions', collect())
                    ->map(function ($position) {
                        return [
                            'id' => $position->id,
                            'positionName' => $position->position,
                            'details' => $position->toArray(),
                        ];
                })->values();

                $previousAttachPositions = $positionsPartitioned->get('previousAttachPositions', collect())
                    ->map(function ($position) {
                        return [
                            'id' => $position->id,
                            'positionName' => $position->position,
                            'details' => $position->toArray(),
                        ];
                })->values();


                $educationQualifications = EducationQualification::join('education_qualification_infos', 'education_qualification_infos.educationQualificationId', '=', 'education_qualifications.id')
                ->where('education_qualification_infos.userId', $decryptedId)
                ->where('education_qualification_infos.active', 1)
                ->where('education_qualifications.active', 1)
                ->selectRaw("GROUP_CONCAT(CONCAT(education_qualifications.name, ' Effective from ', education_qualification_infos.effectiveDate) SEPARATOR '\n') as formattedOutput")
                ->pluck('formattedOutput')
                ->first();


                $professionalQualifications = professionalQualification::join('professional_qualification_infos', 'professional_qualification_infos.professionalQualificationId', '=', 'professional_qualifications.id')
                ->where('professional_qualification_infos.userId', $decryptedId)
                ->where('professional_qualification_infos.active', 1)
                ->where('professional_qualifications.active', 1)
                ->selectRaw("GROUP_CONCAT(CONCAT(professional_qualifications.name, ' Effective from ', professional_qualification_infos.effectiveDate) SEPARATOR '\n') as formattedOutput")
                ->pluck('formattedOutput')
                ->first();

                $family = FamilyInfo::join('family_member_types', 'family_infos.memberType', '=', 'family_member_types.id')
                ->where('family_infos.userId', $decryptedId)
                ->where('family_infos.active', 1)
                ->selectRaw("GROUP_CONCAT(
                    CONCAT(
                        family_infos.name,
                        ' (',
                        IFNULL(family_infos.nic, ''),
                        ' ',
                        family_member_types.name,
                        ' ',
                        IFNULL(family_infos.profession, ''),
                        ')'
                    ) SEPARATOR '\n'
                ) as formattedOutput")
                ->pluck('formattedOutput')
                ->first();

                return view('teacher/profile', compact(
                    'teacher',
                    'currentServiceArray',
                    'previousServicesArray',
                    'currentServiceRanksArray',
                    'previousServiceRanksArray',
                    'currentAppointments',
                    'previousAppointments',
                    'currentAttachAppointments',
                    'previousAttachAppointments',
                    'currentPositions',
                    'previousPositions',
                    'currentAttachPositions',
                    'previousAttachPositions',
                    'educationQualifications',
                    'professionalQualifications',
                    'family',
                    'option'
                ));


            }catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Redirect to the search page or show an error message for invalid ID
                return redirect()->route('teacher.search')->with('error', 'Invalid teacher ID provided.');
            }

        }else{
            return redirect()->route('teacher.search');
        }
    }

    public function profileedit(Request $request)
    {
        if($request->has('id') && $request->has('category')){
            try{

                $option = [
                    'Dashboard' => 'dashboard',
                    'Teacher Dashboard' => 'teacher.dashboard',
                    'Teacher Search' => 'teacher.search',
                    'Teacher Profile' => route('teacher.profile', ['id' => $request->id]),
                    'Teacher Profile Edit' => htmlspecialchars_decode(route('teacher.profileedit',['id' => $request->id,'category' => $request->category])),
                ];

                $decryptedId = Crypt::decryptString($request->id);
                $category = $request->category;

                $teacher = User::find($decryptedId);

                $races = collect([]);
                $religions = collect([]);
                $civilStatuses = collect([]);
                if($category == 'userPersonal')
                {
                    $races = Race::where('active', 1)->get();
                    $religions = Religion::where('active', 1)->get();
                    $civilStatuses = CivilStatus::where('active', 1)->get();
                }


                $services = collect([]);
                $current_services = collect([]);
                if($category == 'service')
                {
                    $services = Service::where('active', 1)->get();
                    $current_services = DB::table('user_in_services')
                        ->join('services', 'user_in_services.serviceId', '=', 'services.id')
                        ->where('user_in_services.id', $teacher->id)
                        ->select('user_in_services.id AS id', 'services.name AS name') // adjust fields as needed
                        ->get();

                    //dd($user_services);
                }

                $appointment_termination_lists = collect([]);
                $zone_school_lists = collect([]);
                $appointment_lists = collect([]);
                $positions = collect([]);
                if($category == 'userAppointment')
                {
                    $zone_school_lists = WorkPlace::select('work_places.id', 'work_places.name as name')
                    ->join('schools', 'work_places.id', '=', 'schools.workPlaceId')
                    ->join('offices AS divisions', 'divisions.id', '=', 'schools.officeId')
                    ->where('work_places.active', 1)
                    ->where('divisions.active', 1)
                    ->where('schools.active', 1)
                    ->where('divisions.higherOfficeId', session('officeId'))
                    ->orderBy('work_places.name', 'ASC')
                    ->get();

                    $appointment_termination_lists = AppointmentTermination::where('active', 1)->get();
                    $positions = collect([
                        ['id' => 1, 'name' => 'School Regular'],
                        ['id' => 2, 'name' => 'School Data Officer'],
                        ['id' => 3, 'name' => 'School Administrator'],
                    ])->map(fn($item) => (object) $item);

                    $appointment_lists = DB::table('user_in_services')
                    ->join('services', 'user_in_services.serviceId', '=', 'services.id')
                    ->join('user_service_appointments', 'user_service_appointments.userServiceId', '=', 'user_in_services.id')
                    ->join('work_places', 'work_places.id', '=', 'user_service_appointments.workPlaceId')
                    ->where('user_in_services.userId', $teacher->id)
                    ->where('user_in_services.active', 1)
                    ->where('services.active', 1)
                    ->where('user_service_appointments.active', 1)
                    ->where('work_places.active', 1)
                    ->whereNotNull('user_service_appointments.releasedDate')
                    ->select(
                        'user_service_appointments.id as id',
                        DB::raw("CONCAT(services.name, ' | ', work_places.name, ' | ', user_service_appointments.appointedDate, ' - ', user_service_appointments.releasedDate) as name")
                    )
                    ->get();

                }

                $educationQualifications = collect([]);
                $professionalQualifications = collect([]);
                $userEducationalQualifications = collect([]);
                $userProfessionalQualifications = collect([]);

                if($category == 'userQualification')
                {
                    $educationQualifications = EducationQualification::where('active', 1)->get();
                    $professionalQualifications = ProfessionalQualification::where('active', 1)->get();
                    $userEducationalQualifications = DB::table('education_qualification_infos')
                    ->join('education_qualifications', 'education_qualification_infos.educationQualificationId', '=', 'education_qualifications.id')
                    ->where('education_qualification_infos.userId', $teacher->id)
                    ->where('education_qualification_infos.active', 1)
                    ->select(
                        'education_qualification_infos.id',
                        DB::raw("CONCAT(education_qualifications.name, ' (', education_qualification_infos.effectiveDate, ')') AS name")
                    )
                    ->get();

                    $userProfessionalQualifications = DB::table('professional_qualification_infos')
                    ->join('professional_qualifications', 'professional_qualification_infos.professionalQualificationId', '=', 'professional_qualifications.id')
                    ->where('professional_qualification_infos.userId', $teacher->id)
                    ->where('professional_qualification_infos.active', 1)
                    ->select(
                        'professional_qualification_infos.id',
                        DB::raw("CONCAT(professional_qualifications.name, ' (', professional_qualification_infos.effectiveDate, ')') AS name")
                    )
                    ->get();

                }

                $familyMemberTypes = collect([]);
                $familyInfos = collect([]);
                if($category == 'userFamily')
                {
                    $familyMemberTypes = FamilyMemberType::where('active', 1)
                    ->get();

                    $familyInfos = FamilyInfo::where('userId', $teacher->id)
                    ->where('active', 1)
                    ->get();

                }

                $ranks = collect([]);
                $userRanks = collect([]);
                if($category == 'userRank')
                {
                    $ranks = Rank::where('active', 1)
                    ->where('serviceId', 1)
                    ->get();

                    $userRanks = DB::table('user_service_in_ranks')
                    ->join('user_in_services', function ($join) use ($teacher) {
                        $join->on('user_service_in_ranks.userServiceId', '=', 'user_in_services.id')
                            ->where('user_in_services.active', 1)
                            ->where('user_in_services.current', 1)
                            ->whereNull('user_in_services.releasedDate')
                            ->where('user_in_services.userId', $teacher->id);
                    })
                    ->join('ranks', 'user_service_in_ranks.rankId', '=', 'ranks.id')
                    ->where('user_service_in_ranks.active', 1)
                    ->select(
                        'user_service_in_ranks.id',
                        DB::raw("CONCAT(ranks.name, ' (', user_service_in_ranks.rankedDate, ')') AS name")
                    )
                    ->get();


                }

                return view('teacher/profile-edit', compact(
                    'teacher',
                    'category',
                    'races',
                    'religions',
                    'civilStatuses',
                    'services',
                    'current_services',
                    'appointment_lists',
                    'zone_school_lists',
                    'appointment_termination_lists',
                    'positions',
                    'educationQualifications',
                    'professionalQualifications',
                    'userEducationalQualifications',
                    'userProfessionalQualifications',
                    'familyMemberTypes',
                    'familyInfos',
                    'ranks',
                    'userRanks',
                    'option'
                ));


            }catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Redirect to the search page or show an error message for invalid ID
                return redirect()->route('teacher.search')->with('error', 'Invalid teacher ID provided.');
            }

        }else{
            return redirect()->route('teacher.search');
        }
    }

    public function profileupdate(UpdateTeacherRequest $request)
    {

        $category = $request->input('category');
        $userId   = $request->input('userId');


        if ($category === 'userLogin') {
            $user     = User::findOrFail($userId);
            // Reset password to first 6 characters of NIC
            $nic          = $user->nic;
            $newPassword  = substr($nic, 0, 6);
            $user->password = Hash::make($newPassword);
            $user->save();

            return redirect()->back()->with('success', 'Password has been reset to the first 6 digits of NIC.');
        }

        if ($category === 'userNic') {
            $user     = User::findOrFail($userId);
            $user->nic          = $request->input('nic');
            $user->save();

            return redirect()->back()->with('success', 'NIC updated successfully!');
        }

        if ($category === 'userName') {
            $user     = User::findOrFail($userId);
            $name = $request->input('name');
            $nameParts = explode(' ', $name);
            $nameParts = array_map('ucfirst', $nameParts);
            $lastName = array_pop($nameParts);
            $initials = array_map(function($part) {
                return strtoupper($part[0]) . '.';
            }, $nameParts);
            $nameWithInitials = implode('', $initials) . ' ' . $lastName;

            $user->name = $name;
            $user->nameWithInitials = $nameWithInitials;

            $user->save();

            return redirect()->back()->with('success', 'Name updated successfully!');
        }

        if ($category === 'userContact') {
            $user = User::findOrFail($userId);
            $contact = ContactInfo::where('userId', $userId)->where('active', 1)->first();

            if (!$contact) {
                return back()->withErrors(['contact' => 'Contact information not found.']);
            }

            // Fields for contact_infos table
            $contactFields = [
                'permAddressLine1', 'permAddressLine2', 'permAddressLine3',
                'tempAddressLine1', 'tempAddressLine2', 'tempAddressLine3',
                'mobile1', 'mobile2',
            ];

            $contactUpdateData = [];

            if ($request->filled('permAddressLine1') && $request->filled('permAddressLine2')) {

                $contactUpdateData['permAddressLine1'] = $request->input('permAddressLine1');
                $contactUpdateData['permAddressLine2'] = $request->input('permAddressLine2');
                if($request->input('permAddressLine3')==NULL){
                    $contactUpdateData['permAddressLine3'] = '';
                }else{
                    $contactUpdateData['permAddressLine3'] = $request->input('permAddressLine3');
                }

            }

            if ($request->filled('tempAddressLine1') && $request->filled('tempAddressLine2')) {

                $contactUpdateData['tempAddressLine1'] = $request->input('tempAddressLine1');
                $contactUpdateData['tempAddressLine2'] = $request->input('tempAddressLine2');
                if($request->input('tempAddressLine3')==NULL){
                    $contactUpdateData['tempAddressLine3'] = '';
                }else{
                    $contactUpdateData['tempAddressLine3'] = $request->input('tempAddressLine3');
                }

            }

            foreach (['mobile1', 'mobile2'] as $field) {
                if ($request->filled($field)) {
                    $contactUpdateData[$field] = $request->input($field);
                }
            }


            //Handle email separately for users table
            $emailUpdate = [];
            if ($request->filled('email')) {
                $emailUpdate['email'] = $request->input('email');
            }

            $changesMade = false;

            if (!empty($contactUpdateData)) {
                $contact->update($contactUpdateData);
                $changesMade = true;
            }

            if (!empty($emailUpdate)) {
                $user->update($emailUpdate);
                $changesMade = true;
            }

            if ($changesMade) {
                return redirect()->back()->with('success', 'Contact information updated successfully!');
            }

            return redirect()->back()->with('error', 'No fields were updated.');
        }

        if ($category === 'userPersonal') {
            $personal = PersonalInfo::where('userId', $userId)->where('active', 1)->first();

            if (!$personal) {
                return back()->withErrors(['error' => 'Personal information not found.']);
            }

            // Map form fields to DB columns
            $fieldMap = [
                'race'        => 'raceId',
                'religion'    => 'religionId',
                'civilStatus' => 'civilStatusId',
                'birthDay'    => 'birthDay',
            ];

            $updateData = collect($fieldMap)
                ->filter(fn($dbColumn, $formField) => $request->filled($formField) && $request->input($formField) != 0)
                ->mapWithKeys(fn($dbColumn, $formField) => [$dbColumn => $request->input($formField)])
                ->toArray();

            if (!empty($updateData)) {
                $personal->update($updateData);
                return redirect()->back()->with('success', 'Personal information updated successfully!');
            }

            return redirect()->back()->with('error', 'No fields were updated.');
        }

        if ($category === 'userLocation') {
            $fieldMap = [
                'division'   => 'educationDivisionId',
                'gnDivision' => 'gnDivisionId',
            ];

            // Collect only filled and valid form inputs (not 0)
            $updateData = collect($fieldMap)
                ->filter(fn($dbColumn, $formField) => $request->filled($formField) && $request->input($formField) != 0)
                ->mapWithKeys(fn($dbColumn, $formField) => [$dbColumn => $request->input($formField)])
                ->toArray();

            if (empty($updateData)) {
                return redirect()->back()->with('error', 'No fields were updated.');
            }

            $location = LocationInfo::where('userId', $userId)->where('active', 1)->first();

            if ($location) {
                // Update existing record
                $location->update($updateData);
            } else {
                // Create new record with userId and active=1
                $updateData['userId'] = $userId;
                $updateData['active'] = 1;
                LocationInfo::create($updateData);
            }

            return redirect()->back()->with('success', 'Location information saved successfully!');
        }

        if ($category === 'userQualification') {
            // ====== EDUCATION QUALIFICATION ======
            if ($request->filled('educationQualification') && $request->input('educationQualification') != 0 && $request->filled('eduEffectiveDay')) {
                //dd('test');
                $edu = EducationQualificationInfo::where('userId', $userId)
                    ->where('educationQualificationId', $request->educationQualification)
                    ->first();

                $eduData = [
                    'effectiveDate' => $request->input('eduEffectiveDay'),
                    'description'   => $request->input('educationDescription'),
                    'educationQualificationId' => $request->input('educationQualification'),
                    'userId' => $userId,
                    'active' => 1
                ];

                if ($edu) {
                    $edu->update($eduData);
                } else {
                    EducationQualificationInfo::create($eduData);
                }

                return redirect()->back()->with('success', 'Qualification information updated successfully!');
            }


            // ====== PROFESSIONAL QUALIFICATION ======
            if ($request->filled('professionalQualification') && $request->input('professionalQualification') != 0 && $request->filled('profEffectiveDay')) {
                //dd('test');
                $prof = ProfessionalQualificationInfo::where('userId', $userId)
                    ->where('professionalQualificationId', $request->professionalQualification)
                    ->first();

                $profData = [
                    'effectiveDate' => $request->input('profEffectiveDay'),
                    'description'   => $request->input('professionalDescription'),
                    'professionalQualificationId' => $request->input('professionalQualification'),
                    'userId' => $userId,
                    'active' => 1
                ];
                //dd($profData);
                if ($prof) {
                    $prof->update($profData);
                } else {
                    ProfessionalQualificationInfo::create($profData);
                }

                return redirect()->back()->with('success', 'Qualification information updated successfully!');
            }

            if ($request->filled('userEduQualification')) {
                $selectedEduId = $request->input('userEduQualification');
                $eduQualification = EducationQualificationInfo::where('id', $selectedEduId)
                    ->where('userId', $userId)
                    ->first();

                if (!$eduQualification) {
                    return back()->withErrors(['userEduQualification' => 'Invalid education qualification selected for deletion.']);
                }

                $eduQualification->update(['active' => 0]);

                return redirect()->back()->with('success', 'Qualification information updated successfully!');
            }

            // Delete selected professional qualification if provided
            if ($request->filled('userProfQualification')) {
                $selectedProfId = $request->input('userProfQualification');
                $profQualification = ProfessionalQualificationInfo::where('id', $selectedProfId)
                    ->where('userId', $userId)
                    ->first();

                if (!$profQualification) {
                    return back()->withErrors(['userProfQualification' => 'Invalid professional qualification selected for deletion.']);
                }

                $profQualification->update(['active' => 0]);

                return redirect()->back()->with('success', 'Qualification information updated successfully!');
            }

            return redirect()->back()->with('error', 'No Qualification information Selected!');
        }

        if ($category === 'userFamily') {
            // ✅ DELETE if familyInfo is provided
            if ($request->filled('familyInfo')) {
                $selectedFamilyId = $request->input('familyInfo');

                $familyToDelete = FamilyInfo::where('id', $selectedFamilyId)
                    ->where('userId', $userId)
                    ->first();

                if (!$familyToDelete) {
                    return back()->withErrors(['familyInfo' => 'Invalid family member selected for deletion.']);
                }

                $familyToDelete->update(['active' => 0]);
                return redirect()->back()->with('success', 'Family member changes saved successfully!');
            }

            // ✅ ADD if new member name and type are filled
            if ($request->filled('familyMemberType') && $request->filled('familyMemberName')) {
                $newFamily = new FamilyInfo();
                $newFamily->userId = $userId;
                $newFamily->memberType = $request->input('familyMemberType');
                $newFamily->name = $request->input('familyMemberName');
                $newFamily->profession = $request->input('familyMemberProfession');
                $newFamily->active = 1;

                if ($request->filled('familyMemberNic')) {
                    $newFamily->nic = $request->input('familyMemberNic');
                }

                if ($request->filled('school')) {
                    $newFamily->school = $request->input('school');
                }

                $newFamily->save();

                return redirect()->back()->with('success', 'Family member changes saved successfully!');
            }
            return redirect()->back()->with('error', 'Not enough fields to submit!');

        }

        if ($category === 'userRank') {
            // Get current active service record
            $service = UserInService::where('userId', $userId)
                ->where('active', 1)
                ->where('current', 1)
                ->whereNull('releasedDate')
                ->first();

            if (!$service) {
                return back()->withErrors(['error' => 'No current active service record found.']);
            }

            // Delete Rank
            if ($request->filled('userRank')) {
                $existingRank = UserServiceInRank::where('id', $request->userRank)
                    ->where('userServiceId', $service->id)
                    ->where('active', 1)
                    ->first();

                if ($existingRank) {
                    $existingRank->update(['active' => 0]);
                }

                // 🔽 Reset current flags
                $ranks = UserServiceInRank::where('userServiceId', $service->id)
                ->where('active', 1)
                ->get();

                if ($ranks->isNotEmpty()) {
                    // 🔼 Find the record with the highest rankId
                    $highest = $ranks->sortBy('rankId')->first();

                    // 🔄 Update all records: set current = 1 for highest, others to 0
                    foreach ($ranks as $rank) {
                        $rank->update(['current' => $rank->id === $highest->id ? 1 : 0]);
                    }

                    return redirect()->back()->with('success', 'Rank information updated successfully!');
                }
            }

            if ($request->filled('rank') && $request->filled('rankedDate')) {
                $existing = UserServiceInRank::where('userServiceId', $service->id)
                    ->where('rankId', $request->rank)
                    ->first();
                //dd($existing);
                if ($existing) {
                    $existing->update([
                        'rankedDate' => $request->rankedDate,
                        'active' => 1,
                    ]);
                } else {
                    UserServiceInRank::create([
                        'userServiceId' => $service->id,
                        'rankId'        => $request->rank,
                        'rankedDate'    => $request->rankedDate,
                        'active'        => 1,
                    ]);
                }

                // 🔽 Reset current flags
                $ranks = UserServiceInRank::where('userServiceId', $service->id)
                ->where('active', 1)
                ->get();

                if ($ranks->isNotEmpty()) {
                    // 🔼 Find the record with the highest rankId
                    $highest = $ranks->sortBy('rankId')->first();

                    // 🔄 Update all records: set current = 1 for highest, others to 0
                    foreach ($ranks as $rank) {
                        $rank->update(['current' => $rank->id === $highest->id ? 1 : 0]);
                    }
                }

                return redirect()->back()->with('success', 'Rank information updated successfully!');
            }




            return redirect()->back()->with('error', 'No Fields updated!');
        }

        if($category == 'userAppointment'){
            //dd($request);
            if ($request->filled('newAppointmentSchool') && $request->newAppointmentSchool != 0 && $request->filled('newAppointmentStartDay')) {
                //dd('fsf');
                DB::beginTransaction();

                try {
                    $userId = $request->input('userId'); // or Auth::id() if applicable

                    // 1. Get active user_in_services record
                    $userInService = UserInService::where('userId', $userId)
                        ->whereNull('releasedDate')
                        ->firstOrFail();
                    //dd($userInService);
                    // 2. Find the current active user_service_appointment
                    UserServiceAppointment::where('userServiceId', $userInService->id)
                    ->whereNull('releasedDate')
                    ->update([
                        'releasedDate' => $request->input('newAppointmentStartDay')
                    ]);


                    // 4. Find the selected school
                    //$school = School::findOrFail($request->input('zoneSchool'));
                    //dd($school);
                    // 5. Create new appointment
                    $currentAppointment = UserServiceAppointment::create([
                        'userServiceId' => $userInService->id,
                        'appointedDate' => $request->input('newAppointmentStartDay'),
                        'workPlaceId'   => $request->input('newAppointmentSchool'),
                    ]);


                    UserServiceAppointmentPosition::create([
                        'userServiceAppointmentId' => $currentAppointment->id,
                        'positionId'               => 1,
                        'positionedDate'             => Carbon::today()->format('Y-m-d'),
                    ]);

                    DB::commit();

                    return redirect()->back()->with('success', 'Appointment updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
                }

            }

            if ($request->filled('newAttachmentSchool') && $request->newAttachmentSchool != 0 && $request->filled('newAttachmentStartDay')) {
                //dd('fsf');
                DB::beginTransaction();

                try {
                    $userId = $request->input('userId'); // or Auth::id() if applicable

                    // 1. Get active user_in_services record
                    $userInService = UserInService::where('userId', $userId)
                        ->whereNull('releasedDate')
                        ->firstOrFail();
                    //dd($userInService);
                    // 2. Find the current active user_service_appointment
                    UserServiceAppointment::where('userServiceId', $userInService->id)
                    ->whereNull('releasedDate')
                    ->where('appointmentType', 2)
                    ->update([
                        'releasedDate' => $request->input('newAttachmentStartDay')
                    ]);


                    // 4. Find the selected school
                    //$school = School::findOrFail($request->input('zoneSchool'));
                    //dd($school);
                    // 5. Create new appointment
                    $currentAppointment = UserServiceAppointment::create([
                        'userServiceId' => $userInService->id,
                        'appointedDate' => $request->input('newAttachmentStartDay'),
                        'workPlaceId'   => $request->input('newAttachmentSchool'),
                        'appointmentType' => 2,
                    ]);


                    UserServiceAppointmentPosition::create([
                        'userServiceAppointmentId' => $currentAppointment->id,
                        'positionId'               => 1,
                        'positionedDate'             => Carbon::today()->format('Y-m-d'),
                    ]);

                    DB::commit();

                    return redirect()->back()->with('success', 'Attachment updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
                }

            }

            if ($request->filled('previousSchool') && $request->previousSchool != 0 && $request->filled('previousAppointmentStartDay') && $request->filled('previousAppointmentEndDay')) {

                DB::beginTransaction();

                try {
                    $userId = $request->input('userId'); // or Auth::id() if applicable

                    $userInService = UserInService::where('userId', $userId)
                        ->whereNull('releasedDate')
                        ->firstOrFail();

                    $currentAppointment = UserServiceAppointment::create([
                        'userServiceId' => $userInService->id,
                        'appointedDate' => $request->input('previousAppointmentStartDay'),
                        'releasedDate'  => $request->input('previousAppointmentEndDay'),
                        'workPlaceId'   => $request->input('previousSchool'),
                        'appointmentType' => 1,
                    ]);

                    DB::commit();

                    return redirect()->back()->with('success', 'Appointment updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
                }

            }

            if ($request->filled('previousAttachedSchool') && $request->previousAttachedSchool != 0 && $request->filled('previousAttachmentStartDay') && $request->filled('previousAttachmentEndDay')) {

                DB::beginTransaction();

                try {
                    $userId = $request->input('userId'); // or Auth::id() if applicable

                    $userInService = UserInService::where('userId', $userId)
                        ->whereNull('releasedDate')
                        ->firstOrFail();

                    $previousAttach = UserServiceAppointment::create([
                        'userServiceId' => $userInService->id,
                        'appointedDate' => $request->input('previousAttachmentStartDay'),
                        'releasedDate'  => $request->input('previousAttachmentEndDay'),
                        'workPlaceId'   => $request->input('previousAttachedSchool'),
                        'appointmentType' => 2,
                    ]);

                    DB::commit();

                    return redirect()->back()->with('success', 'Appointment updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
                }

            }


            // ✅ Terminate appointment logic
            if ($request->filled('terminateReason') && $request->filled('terminateDate')) {
                DB::beginTransaction();

                try {
                    $userId = $request->input('userId'); // Or use Auth::id()

                    // Step 1: Find active user_in_services record
                    $userInService = UserInService::where('userId', $userId)
                        ->whereNull('releasedDate')
                        ->firstOrFail();

                    // Step 2: Find current active appointment
                    $currentAppointment = UserServiceAppointment::where('userServiceId', $userInService->id)
                        ->whereNull('releasedDate')
                        ->latest()
                        ->firstOrFail();
                    //dd($request->input('terminateReason'));
                    // Step 3: Update appointment termination info
                    $currentAppointment->update([
                        'reason'       => $request->input('terminateReason'),
                        'releasedDate' => $request->input('terminateDate'),
                        'current'      => 0,
                    ]);

                    DB::commit();

                    return redirect()->back()->with('success', 'Appointment terminated successfully.');

                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Error terminating appointment: ' . $e->getMessage());
                }
            }



            if ($request->filled('position') && $request->position != 0) {
                //dd('sds');
                DB::beginTransaction();

                try {
                    $userId = $request->input('userId'); // Or Auth::id()

                    // 1. Find active user_in_services record
                    $userInService = UserInService::where('userId', $userId)
                        ->whereNull('releasedDate')
                        ->firstOrFail();

                    // 2. Find current active appointment
                    $currentAppointment = UserServiceAppointment::where('userServiceId', $userInService->id)
                        ->whereNull('releasedDate')
                        ->latest()
                        ->firstOrFail();


                    // 3. Update the position for current appointment
                    $appointmentPosition = UserServiceAppointmentPosition::where('userServiceAppointmentId', $currentAppointment->id)->first();
                    //dd($currentAppointment->id,$request->input('position') );
                    if ($appointmentPosition) {
                        $appointmentPosition->update([
                            'positionId' => $request->input('position'),
                        ]);
                    } else {

                        UserServiceAppointmentPosition::where('userServiceAppointmentId', $currentAppointment->id)
                        ->update(['current' => 0]);
                        // Create position record if it doesn't exist
                        UserServiceAppointmentPosition::create([
                            'userServiceAppointmentId' => $currentAppointment->id,
                            'positionId'               => $request->input('position'),
                            'positionedDate'             => Carbon::today()->format('Y-m-d'),
                        ]);
                    }

                    DB::commit();

                    return redirect()->back()->with('success', 'Position updated for current appointment.');

                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Error updating position: ' . $e->getMessage());
                }

            }

            return redirect()->back()->with('error', 'No field updated');
        }

    }
}
