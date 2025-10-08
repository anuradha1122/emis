<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePrincipalRequest;
use App\Http\Requests\UpdatePrincipalRequest;
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
use App\Models\PrincipalService;
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
use App\Models\Province;
use App\Models\School;
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

class PrincipalController extends Controller
{
    protected $principalService;

    public function __construct(UserDashboardService $principalService)
    {
        $this->principalService = $principalService;
    }

    public function index()
    {
        $principalCounts = $this->principalService->getPrincipalStatsFor(auth()->user());
        return view('principal.dashboard',compact('principalCounts'));
    }

    public function reportlist()
    {
        return view('principal.reportlist');
    }

    public function fullreport()
    {
        return view('principal.full-report');
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

        return view('principal.full-report-pdf',compact('schoolAuthorityList', 'schoolEthnicityList', 'schoolClassList', 'schoolDensityList', 'schoolFacilityList', 'schoolGenderList', 'schoolLanguageList', 'raceList', 'religionList', 'civilStatusList', 'genderList'));
    }

    public function exportfullreportPDF(Request $request)
    {
        $query = User::query()
            ->with([
                'personalInfo',
                'currentPrincipalService.currentAppointment.workPlace.school'
            ])
            ->whereHas('currentPrincipalService');

        // 🏫 Location-based filters
        if ($request->filled('school')) {
            $query->whereHas('currentPrincipalService.currentAppointment.workPlace.school',
                fn($q) => $q->where('id', $request->school));
        } elseif ($request->filled('division')) {
            $division = Office::with('schools')->find($request->division);
            $schoolIds = $division?->schools->pluck('id')->toArray() ?? [];
            $query->whereHas('currentPrincipalService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($request->filled('zone')) {
            $zone = Office::with('subOffices.schools')->find($request->zone);
            $schoolIds = $zone?->subOffices->flatMap(fn($d) => $d->schools)->pluck('id')->toArray() ?? [];
            $query->whereHas('currentPrincipalService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($request->filled('district')) {
            $district = District::with('zones.subOffices.schools')->find($request->district);
            $schoolIds = $district?->zones
                ->flatMap(fn($zone) => $zone->subOffices
                    ->flatMap(fn($d) => $d->schools))
                ->pluck('id')->toArray() ?? [];
            $query->whereHas('currentPrincipalService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($request->filled('province')) {
            $province = Province::with('districts.zones.subOffices.schools')->find($request->province);
            $schoolIds = $province?->districts
                ->flatMap(fn($district) => $district->zones
                    ->flatMap(fn($zone) => $zone->subOffices
                        ->flatMap(fn($d) => $d->schools)))
                ->pluck('id')->toArray() ?? [];
            $query->whereHas('currentPrincipalService.currentAppointment.workPlace.school',
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
                $query->whereHas('currentPrincipalService.currentAppointment.workPlace.school',
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
            $query->whereHas('currentPrincipalService', fn($q) => $q->where('appointedDate', '>=', $request->serviceStart));
        }
        if ($request->filled('serviceEnd')) {
            $query->whereHas('currentPrincipalService', fn($q) => $q->where('appointedDate', '<=', $request->serviceEnd));
        }
        if ($request->filled('schoolAppointStart')) {
            $query->whereHas('currentPrincipalService.currentAppointment',
                fn($q) => $q->where('appointedDate', '>=', $request->schoolAppointStart));
        }
        if ($request->filled('schoolAppointEnd')) {
            $query->whereHas('currentPrincipalService.currentAppointment',
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
            $html = view('exports.pdf.principal.full-report', compact('results'))->render();
            $mpdf->WriteHTML($html);
            $mpdf->AddPage(); // automatically add page break after each chunk
        });

        return response($mpdf->Output('principal_full_report.pdf', \Mpdf\Output\Destination::DOWNLOAD));
    }



    public function create()
    {
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
            ->where('serviceId', 3) // Filter by serviceId
            ->get();

        return view('principal/register',compact( 'ranks', 'schools'));
    }


    public function store(StorePrincipalRequest $request)
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
                'serviceId' => 3,
                'appointedDate' => $request->serviceDate,
            ]);

            UserServiceInRank::create([
                'userServiceId' => $userInService->id,
                'rankId' => $request->ranks,
                'rankedDate' => $request->serviceDate,
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
            return redirect()->back()->with('success', 'Principal information saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to save Principal: ' . $e->getMessage()]);
        }
    }

    public function profile(Request $request)
    {
        $decryptedId = Crypt::decryptString($request->id);

        // ---------- Teacher profile ----------
        $principal = User::with([
                'personalInfo.race',
                'personalInfo.religion',
                'personalInfo.civilStatus',
                'contactInfo',
                'locationInfo.gnDivision.dsDivision.district.province',
                'locationInfo.office',
                'educationQualificationInfos.educationQualification',
                'professionalQualificationInfos.professionalQualification',
                'familyInfos.memberTypeRelation',
            ])
            ->find($decryptedId);

        //dd($principal);
        if (!$principal) {
            abort(404, 'Principal not found');
        }

        $principal->cryptedId = $request->id;
        $principal->gender = match(optional($principal->personalInfo)->genderId) {
            1 => 'Male',
            2 => 'Female',
            default => 'Unknown',
        };
        $principal->race = optional($principal->personalInfo->race)->name;
        $principal->religion = optional($principal->personalInfo->religion)->name;
        $principal->civilStatus = optional($principal->personalInfo->civilStatus)->name;
        $principal->birthDay = optional($principal->personalInfo)->birthDay;
        $principal->educationDivision = $principal->locationInfo?->office?->educationDivision?->name;
        $principal->gnDivision = $principal->locationInfo?->gnDivision?->name;
        $principal->dsDivision = $principal->locationInfo?->gnDivision?->dsDivision?->name;
        $principal->district = $principal->locationInfo?->gnDivision?->dsDivision?->district?->name;
        $principal->province = $principal->locationInfo?->gnDivision?->dsDivision?->district?->province?->name;
        $principal->permAddress = trim(implode(', ', array_filter([
            optional($principal->contactInfo)->permAddressLine1,
            optional($principal->contactInfo)->permAddressLine2,
            optional($principal->contactInfo)->permAddressLine3,
        ])));
        $principal->tempAddress = trim(implode(', ', array_filter([
            optional($principal->contactInfo)->tempAddressLine1,
            optional($principal->contactInfo)->tempAddressLine2,
            optional($principal->contactInfo)->tempAddressLine3,
        ])));
        $principal->mobile1 = optional($principal->contactInfo)->mobile1;
        $principal->mobile2 = optional($principal->contactInfo)->mobile2;

        $principal->educationDivision = $principal->locationInfo->office->workPlace->name ?? 'No office assigned';

        // ---------- Current Service ----------
        $currentService = UserInService::with([
                'service',
                'serviceInRanks' => fn($q) => $q->where('current', 1)->with('rank'),
                'appointments' => fn($q) => $q->whereNull('releasedDate')->where('active', 1)->with(['workPlace', 'positions.position'])
            ])
            ->where('userId', $decryptedId)
            ->current()
            ->first();

        // Current service rank
        $currentRank = $currentService?->serviceInRanks->first();
        $currentServiceRanksArray = $currentService
        ? $currentService->serviceInRanks
            ->where('current', 1)
            ->map(fn($rank) => [
                'userServiceId' => $currentService->id,
                'serviceName'   => optional($currentService->service)->name,
                'serviceRankId' => $rank->id,
                'rankId'        => $rank->rankId,
                'rankedDate'    => $rank->rankedDate,
                'currentRank'   => $rank->current,
                'rank'          => optional($rank->rank)->name,
            ])
            ->toArray()
        : [];


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
                    ->where('current', 1)
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
            ])
            ->toArray()
        : [];

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
            ])
            ->toArray()
        : [];

        //dd($currentAppointments, $previousAppointments);
        // ---------- Education & Professional Qualifications ----------
        $educationQualifications = $principal->educationQualificationInfos
            ->map(fn($info) => optional($info->educationQualification)->name . ' Effective from ' . $info->effectiveDate)
            ->implode("\n");

        $professionalQualifications = $principal->professionalQualificationInfos
            ->map(fn($info) => optional($info->professionalQualification)->name . ' Effective from ' . $info->effectiveDate)
            ->implode("\n");

        // ---------- Family ----------
        $family = $principal->familyInfos->map(function ($member) {
            return [
                'relation'   => optional($member->memberTypeRelation)->name,
                'name'       => $member->name,
                'nic'        => $member->nic,
                'profession' => $member->profession,
            ];
        });


        // ---------- Return to Blade ----------
        return view('principal/profile', compact(
            'principal',
            'currentService',
            'previousServices',
            'currentServiceRanksArray',
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
            return redirect()->route('principal.search')
                            ->with('error', 'Invalid principal ID provided.');
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

        // Ranks related to principal's current service
        $principal = User::with([
            'personalInfo',
            'contactInfo',
            'locationInfo',
            'currentprincipalService.serviceInRanks.rank' // load related rank names
        ])->findOrFail($decryptedId);

        // Get the current principal service (serviceId = 1)
        $userService = $principal->currentPrincipalService()
        ->with(['serviceInRanks' => function($query) {
            $query->where('active', 1)->with('rank');
        }])
        ->first();

        $familyMemberTypes = FamilyMemberType::where('active', 1)->get(['id', 'name']);


        $ranks = Rank::where('serviceId', 1)->where('active', 1)->get(['id', 'name']);

        $educationQualifications = EducationQualification::where('active', 1)->get(['id', 'name']);
        $professionalQualifications = ProfessionalQualification::where('active', 1)->get(['id', 'name']);

        $encryptedId = $request->id;

        return view('principal.profile-edit', compact(
            'encryptedId',
            'decryptedId',
            'section',
            'principal',
            'races',
            'religions',
            'civilStatuses',
            'genders',
            'ranks',
            'userService',
            'familyMemberTypes',
            'educationQualifications',
            'professionalQualifications'
        ));
    }

    public function profileUpdate(UpdatePrincipalRequest $request)
    {
        $principalId = $request->input('id');
        $section = $request->input('section');

        $principal = User::with(['personalInfo', 'contactInfo', 'locationInfo', 'currentPrincipalService.serviceInRanks'])->findOrFail($principalId);

        switch ($section) {

            case 'personal':
                // Update Users table
                $principal->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'nic' => $request->nic,
                ]);

                // Update or create PersonalInfo (birthDay)
                $personalInfo = $principal->personalInfo ?? new PersonalInfo(['userId' => $principal->id]);
                $personalInfo->birthDay = $request->birthDay;
                $personalInfo->save();

                // Update or create ContactInfo
                $contactInfo = $principal->contactInfo ?? new ContactInfo(['userId' => $principal->id]);
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
                $personalInfo = $principal->personalInfo ?? new PersonalInfo(['userId' => $principal->id]);

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
                $locationInfo = $principal->locationInfo ?? new LocationInfo(['userId' => $principal->id]);

                if ($request->filled('eduDivision')) {
                    $locationInfo->educationDivisionId = $request->eduDivision;
                }

                if ($request->filled('gnDivision')) {
                    $locationInfo->gnDivisionId = $request->gnDivision;
                }

                if ($locationInfo->isDirty(['educationDivisionId', 'gnDivisionId'])) {
                    $locationInfo->save();
                }
                break;

            case 'rank-info':
                $userService = $principal->currentPrincipalService()->first();
                //dd($userService);
                if (!$userService) {
                    return redirect()->back()->with('error', 'No active principal service found!');
                }

                // Delete rank
                if ($request->filled('deleteRank') && $request->deleteRank) {
                    if ($request->filled('rankId')) {
                        $rankRow = $userService->serviceInRanks()->where('rankId', $request->rankId)->first();
                        if ($rankRow) {
                            $rankRow->update(['active' => 0]); // Only update active
                        }
                    }
                    return redirect()->back()->with('success', 'Rank deleted successfully!');
                }

                // Create or update rank
                if ($request->filled('rankId') && $request->filled('rankedDate')) {

                    // If "current" checked, reset other ranks
                    if ($request->filled('current') && $request->current) {
                        $userService->serviceInRanks()->update(['current' => 0]);
                    }

                    $rankRow = $userService->serviceInRanks()->where('rankId', $request->rankId)->first();

                    $data = [
                        'current' => $request->filled('current') && $request->current ? 1 : 0,
                        'active' => 1,
                    ];

                    if ($request->filled('rankedDate')) {
                        $data['rankedDate'] = $request->rankedDate;
                    }

                    if ($rankRow) {
                        $rankRow->update($data);
                    } else {
                        $userService->serviceInRanks()->create(array_merge(['rankId' => $request->rankId], $data));
                    }
                }

                return redirect()->back()->with('success', 'Rank saved successfully!');

            case 'family-info':
                    $userService = $principal->currentPrincipalService()->first();
                    //dd($userService);
                    if (!$userService) {
                        return redirect()->back()->with('error', 'No active principal service found!');
                    }

                    $familyData = $request->input('family', []);
                    //dd($familyData);
                    foreach ($familyData as $key => $data) {
                        // Handle delete for existing members
                        if (isset($data['delete']) && $data['delete'] && isset($data['id'])) {
                            $familyRow = FamilyInfo::where('id', $data['id'])
                                                   ->where('userId', $principal->id)
                                                   ->first();
                            if ($familyRow) {
                                $familyRow->active = 0;
                                $familyRow->save();
                            }
                            continue;
                        }

                        // Add new member only if memberType and name are filled
                        if (!isset($data['id']) && !empty($data['memberType']) && !empty($data['name'])) {
                            FamilyInfo::create([
                                'userId'     => $principal->id,
                                'memberTypeId' => $data['memberType'],
                                'name'       => $data['name'],
                                'nic'        => $data['nic'] ?? null,
                                'profession' => $data['profession'] ?? null,
                                'active'     => 1,
                            ]);
                        }
                    }

                    return redirect()->back()->with('success', 'Family information updated successfully!');

            case 'education-info':
                $principal = User::with('educationQualificationInfos')->findOrFail($principal->id);

                $eduData = $request->input('education', []); // form sends education data as 'education'

                foreach ($eduData as $key => $data) {

                    // Soft delete existing qualification
                    if (isset($data['delete']) && $data['delete'] && isset($data['id'])) {
                        $eduRow = EducationQualificationInfo::where('id', $data['id'])
                                    ->where('userId', $principal->id)
                                    ->first();
                        if ($eduRow) {
                            $eduRow->active = 0;
                            $eduRow->save();
                        }
                        continue;
                    }

                    // Skip if required fields are missing
                    if (empty($data['educationQualificationId']) || empty($data['effectiveDate'])) {
                        continue;
                    }

                    // Check if this qualification already exists (active = 1)
                    $eduRow = EducationQualificationInfo::where('userId', $principal->id)
                                ->where('eduQualiId', $data['educationQualificationId'])
                                ->where('active', 1)
                                ->first();

                    if ($eduRow) {
                        // Update effective date
                        $eduRow->effectiveDate = $data['effectiveDate'];
                        $eduRow->save();
                    } else {
                        // Create new
                        EducationQualificationInfo::create([
                            'userId'                   => $principal->id,
                            'eduQualiId' => $data['educationQualificationId'],
                            'effectiveDate'            => $data['effectiveDate'],
                            'active'                   => 1,
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'Education qualification info updated successfully!');

            case 'professional-info':
                    $principal = User::with('professionalQualificationInfos')->findOrFail($principal->id);

                    $profData = $request->input('professional', []); // form sends professional data as 'professional'

                    foreach ($profData as $key => $data) {

                        // Soft delete existing qualification
                        if (isset($data['delete']) && $data['delete'] && isset($data['id'])) {
                            $profRow = ProfessionalQualificationInfo::where('id', $data['id'])
                                        ->where('userId', $principal->id)
                                        ->first();
                            if ($profRow) {
                                $profRow->active = 0;
                                $profRow->save();
                            }
                            continue;
                        }

                        // Skip if required fields are missing
                        if (empty($data['professionalQualificationId']) || empty($data['effectiveDate'])) {
                            continue;
                        }

                        // Check if this qualification already exists (active = 1)
                        $profRow = ProfessionalQualificationInfo::where('userId', $principal->id)
                                    ->where('profQualiId', $data['professionalQualificationId'])
                                    ->where('active', 1)
                                    ->first();

                        if ($profRow) {
                            // Update effective date
                            $profRow->effectiveDate = $data['effectiveDate'];
                            $profRow->save();
                        } else {
                            // Create new
                            ProfessionalQualificationInfo::create([
                                'userId'                     => $principal->id,
                                'profQualiId' => $data['professionalQualificationId'],
                                'effectiveDate'              => $data['effectiveDate'],
                                'active'                     => 1,
                            ]);
                        }
                    }

                    return redirect()->back()->with('success', 'Professional qualification info updated successfully!');

            case 'service-info':
                $principal = User::with('currentPrincipalService')->findOrFail($principal->id);
                //dd($request->all(), $principal);
                $userService = $principal->currentPrincipalService;
                if (!$userService) {
                    return redirect()->back()->with('error', 'No active principal service found!');
                }

                $appointedDate = $request->input('appointedDate');
                $schoolId = $request->input('school');

                $school = School::find($schoolId);

                if (!$school) {
                    return redirect()->back()->with('error', 'Selected school not found.');
                }

                $workPlaceId = $school->workPlaceId;

                if (!$appointedDate || !$workPlaceId) {
                    return redirect()->back()->with('error', 'Please provide both Work Place and Appointment Date.');
                }

                // Close old appointment (if any)
                $currentAppointment = $userService->appointments()
                    ->where('appointmentType', 1)
                    ->whereNull('releasedDate')
                    ->first();

                if ($currentAppointment) {
                    $currentAppointment->releasedDate = $appointedDate;
                    $currentAppointment->save();
                }

                // Create new appointment
                $userService->appointments()->create([
                    'workPlaceId'    => $workPlaceId,
                    'appointedDate'  => $appointedDate,
                    'appointmentType'=> 1,
                ]);

                return redirect()->back()->with('success', 'Appointment updated successfully!');


            default:
                return redirect()->back()->with('error', 'Invalid section!');
        }

        return redirect()->back()->with('success', 'Section updated successfully!');
    }
}
