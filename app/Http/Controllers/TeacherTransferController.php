<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreteacherTransferRequest;
use App\Http\Requests\UpdateteacherTransferRequest;
use App\Models\teacherTransfer;
use App\Models\User;
use App\Models\UserInService;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class TeacherTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(session('appointmentId'));
        $userInService = UserInService::where('id', session('userServiceId'))->first();


        // Assuming $userServiceAppointment->appointedDate is a valid date (e.g., '2020-01-15')
        $appointedDate = Carbon::parse($userInService->appointedDate);
        $comparisonDate = Carbon::parse('2025-07-01');
        $years = $appointedDate->diffInYears($comparisonDate);


        $transfers = DB::table('teacher_transfers')
        ->join('transfer_types', 'teacher_transfers.typeId', '=', 'transfer_types.id')
        ->where('teacher_transfers.userServiceId', session('userServiceId'))
        ->where('teacher_transfers.active', 1)
        ->select('teacher_transfers.*', 'transfer_types.name as typeName') // pick columns you need
        ->get();


        $principalReasons = [
            1 => 'This teacher can be released without a successor as he/she is an excess teacher.',
            2 => 'This teacher can be released only if a suitable successor is provided.',
            3 => 'This teacher can be released without a successor.',
            4 => 'This teacher can’t be released.',
        ];

        $decision1 = [
            1 => 'The service of this teacher has been confirmed.',
            2 => 'The service of this teacher has not been confirmed.',
        ];

        $decision2 = [
            1 => 'There are disciplinary or audit queries against this teacher.',
            2 => 'There aren’t disciplinary or audit queries against this teacher.',
        ];

        $decision3 = [
            1 => 'This teacher is qualified for the transfer (Completed minimum years / Application is complete / Not teaching in non-transferable grades).',
            2 => 'This teacher isn’t qualified for the transfer (Not completed minimum years / Application incomplete / Teaching in non-transferable grades).',
        ];

        $decision4 = [
            1 => 'This teacher can be released with a successor.',
            2 => 'This teacher can be released without a successor.',
            3 => 'This transfer was rejected (due to insufficient service period or other).',
        ];


        // Attach readable reason text to each transfer
        $transfers->map(function ($transfer) use ($principalReasons, $decision1, $decision2, $decision3, $decision4) {
            $transfer->principalReasonText = $principalReasons[$transfer->principalReason] ?? 'Pending';
            $transfer->zonalReason1Text   = $decision1[$transfer->zonalReason1] ?? 'Pending';
            $transfer->zonalReason2Text   = $decision2[$transfer->zonalReason2] ?? 'Pending';
            $transfer->zonalReason3Text   = $decision3[$transfer->zonalReason3] ?? 'Pending';
            $transfer->zonalReason4Text   = $decision4[$transfer->zonalReason4] ?? 'Pending';

            return $transfer;
        });

        $option = [
            'Dashboard' => 'teacher.transferdashboard',
        ];
        return view('teacher/transfer-dashboard',compact('option','years', 'transfers'));
    }

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
            ->where('schools.authorityId', 2)
            ->select('work_places.name', 'schools.id') // or choose specific columns
            ->get();

        //dd($zoneSchools);
        // $appointmentCategories = AppointmentCategory::where('active', 1)->get();
        // $ranks = Rank::where('active', 1)
        //     ->where('serviceId', 1) // Filter by serviceId
        //     ->get();


        $option = [
            'Dashboard' => 'teacher.transferdashboard',
            'Transfer Form' => 'teacher.transfer',
        ];
        return view('teacher/transferform',compact('option','binaryList','teachingGradeList','zoneSchools'));
    }

    public function transferreport()
    {
        return view('teacher.transfer-report');
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
    public function store(StoreteacherTransferRequest $request)
    {
        //
    }

    public function teacherstore(StoreteacherTransferRequest $request)
    {
        //dd(session()->all());

        $userServiceId = session('userServiceId');
        //dd($userServiceId);
        TeacherTransfer::where('userServiceId', $userServiceId)
            ->where('typeId', $request->type)
            ->where('active', 1)
            ->update(['active' => 0]);

        $referenceNo = now()->format('Ymd') . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        TeacherTransfer::create([
            'refferenceNo'       => $referenceNo,
            'userServiceId'      => $userServiceId,
            'typeId'             => $request->type,
            'reasonId'           => $request->reason,
            'school1Id'          => $request->school1,
            'school2Id'          => $request->school2,
            'school3Id'          => $request->school3,
            'school4Id'          => $request->school4,
            'school5Id'          => $request->school5,
            'alterSchool1Id'     => $request->alterSchool1,
            'alterSchool2Id'     => $request->alterSchool2,
            'alterSchool3Id'     => $request->alterSchool3,
            'alterSchool4Id'     => $request->alterSchool4,
            'alterSchool5Id'     => $request->alterSchool5,
            'anySchool'          => $request->alternativeSchool,
            'gradeId'            => $request->teachingGrades,
            'extraCurricular'    => $request->extraCurricular,
            'mention'            => $request->mention,
            'active'             => 1,
            'anyschool'          => $request->alternativeSchool,
        ]);


        $typeId = $request->type;
        $option = [
            'Transfer Form' => 'teacher.transfer',
        ];

        return view('teacher/after-transfer-form',compact('option', 'typeId'));
        //dd($request->all());
    }

    public function teacherPersonalPdf(Request $request)
    {
        $typeId = $request->query('typeId'); // or $request->get('typeId');
        //dd($typeId);
        $userServiceId = session('userServiceId'); // get from session
        //dd($userServiceId);
        $typeId = $typeId; // passed from controller or request

        $transfer = DB::table('teacher_transfers')
            // joins same as before ...
            ->leftJoin('schools as s1', 'teacher_transfers.school1Id', '=', 's1.id')
            ->leftJoin('work_places as wp1', 's1.workPlaceId', '=', 'wp1.id')
            ->leftJoin('schools as s2', 'teacher_transfers.school2Id', '=', 's2.id')
            ->leftJoin('work_places as wp2', 's2.workPlaceId', '=', 'wp2.id')
            ->leftJoin('schools as s3', 'teacher_transfers.school3Id', '=', 's3.id')
            ->leftJoin('work_places as wp3', 's3.workPlaceId', '=', 'wp3.id')
            ->leftJoin('schools as s4', 'teacher_transfers.school4Id', '=', 's4.id')
            ->leftJoin('work_places as wp4', 's4.workPlaceId', '=', 'wp4.id')
            ->leftJoin('schools as s5', 'teacher_transfers.school5Id', '=', 's5.id')
            ->leftJoin('work_places as wp5', 's5.workPlaceId', '=', 'wp5.id')

            ->leftJoin('schools as as1', 'teacher_transfers.alterSchool1Id', '=', 'as1.id')
            ->leftJoin('work_places as awp1', 'as1.workPlaceId', '=', 'awp1.id')
            ->leftJoin('schools as as2', 'teacher_transfers.alterSchool2Id', '=', 'as2.id')
            ->leftJoin('work_places as awp2', 'as2.workPlaceId', '=', 'awp2.id')
            ->leftJoin('schools as as3', 'teacher_transfers.alterSchool3Id', '=', 'as3.id')
            ->leftJoin('work_places as awp3', 'as3.workPlaceId', '=', 'awp3.id')
            ->leftJoin('schools as as4', 'teacher_transfers.alterSchool4Id', '=', 'as4.id')
            ->leftJoin('work_places as awp4', 'as4.workPlaceId', '=', 'awp4.id')
            ->leftJoin('schools as as5', 'teacher_transfers.alterSchool5Id', '=', 'as5.id')
            ->leftJoin('work_places as awp5', 'as5.workPlaceId', '=', 'awp5.id')

            ->leftJoin('transfer_types', 'teacher_transfers.typeId', '=', 'transfer_types.id')
            ->leftJoin('transfer_reasons', 'teacher_transfers.reasonId', '=', 'transfer_reasons.id')

            ->select(
                'teacher_transfers.*',
                'wp1.name as school1Name',
                'wp2.name as school2Name',
                'wp3.name as school3Name',
                'wp4.name as school4Name',
                'wp5.name as school5Name',
                'awp1.name as alterSchool1Name',
                'awp2.name as alterSchool2Name',
                'awp3.name as alterSchool3Name',
                'awp4.name as alterSchool4Name',
                'awp5.name as alterSchool5Name',
                'transfer_types.name as typeName',
                'transfer_reasons.name as reasonName',
                DB::raw("CASE teacher_transfers.anySchool WHEN 1 THEN 'Yes' WHEN 2 THEN 'No' ELSE 'N/A' END as anySchoolText"),
                DB::raw("CASE teacher_transfers.gradeId
                            WHEN 1 THEN 'Grade 1-2'
                            WHEN 2 THEN 'Grade 3-4'
                            WHEN 3 THEN 'Grade 5'
                            ELSE 'N/A' END as gradeName"),
                DB::raw("DATE_FORMAT(teacher_transfers.created_at, '%Y-%m-%d') as createdDate")
            )

            ->where('teacher_transfers.userServiceId', $userServiceId)
            ->where('teacher_transfers.typeId', $typeId)
            ->where('teacher_transfers.active', 1)

            ->first(); // or ->get() if you want multiple rows

        if (!$transfer) {
            return redirect()->back()->with('error', 'No active transfer found for the specified type.');
        }else{
            $pdf = Pdf::loadView('teacher.pdf.transfer-personal-pdf', compact('transfer'));

            return $pdf->download('teacher-transfer.pdf');
        }


    }

    public function teachertransferprincipallist()
    {
        //dd(session('workPlaceId'));
        $teachers = User::join('user_in_services', 'users.id', '=', 'user_in_services.userId')
        ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
        ->join('teacher_transfers', 'user_in_services.id', '=', 'teacher_transfers.userServiceId')
        ->join('transfer_types', 'teacher_transfers.typeId', '=', 'transfer_types.id')
        ->where('user_service_appointments.workPlaceId', session('workPlaceId'))
        ->where('user_service_appointments.releasedDate', NULL)
        ->where('teacher_transfers.active', 1)

        ->select(
            'users.id AS userId', 'users.name AS teacher', 'users.nic',
            'transfer_types.name AS transfer_type', // if needed
            'teacher_transfers.principalReason', 'teacher_transfers.refferenceNo'
        )
        ->get()
        ->map(function ($item) {
            $item->refferenceNo = Crypt::encryptString($item->refferenceNo);
            return $item;
        });
        //dd($teachers);
        $option = [
            'Dashboard' => 'dashboard',
        ];

        return view('teacher/transfer-principal-list',compact('option', 'teachers'));
    }

    public function teachertransferzonelist()
    {
        //dd(session('officeId'));
        $teachers = User::join('user_in_services', 'users.id', '=', 'user_in_services.userId')
        ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
        ->join('work_places', 'user_service_appointments.workPlaceId', '=', 'work_places.id')
        ->join('schools', 'work_places.id', '=', 'schools.workPlaceId')
        ->join('offices', 'schools.officeId', '=', 'offices.id')
        ->join('teacher_transfers', 'user_in_services.id', '=', 'teacher_transfers.userServiceId')
        ->join('transfer_types', 'teacher_transfers.typeId', '=', 'transfer_types.id')
        ->where('offices.higherOfficeId', session('officeId'))
        ->whereNull('user_service_appointments.releasedDate')
        ->whereNull('user_in_services.releasedDate')
        ->where('teacher_transfers.active', 1)
        ->select(
            'users.id AS userId',
            'users.name AS teacher',
            'users.nic',
            'work_places.name AS workPlace',
            'transfer_types.name AS transfer_type',
            'teacher_transfers.zonalId',
            'teacher_transfers.zonalReason1',
            'teacher_transfers.zonalReason2',
            'teacher_transfers.zonalReason3',
            'teacher_transfers.zonalReason4',
            'teacher_transfers.refferenceNo'
        )
        ->orderByRaw('CASE WHEN teacher_transfers.zonalId IS NULL THEN 0 ELSE 1 END')
        ->orderBy('work_places.name')          // first order by workplace
        ->orderBy('transfer_types.name')       // then by transfer type
        ->get()
        ->map(function ($item) {
            $item->refferenceNo = Crypt::encryptString($item->refferenceNo);
            return $item;
        });

        //dd($teachers);
        $option = [
            'Dashboard' => 'dashboard',
        ];

        return view('teacher/transfer-zone-list',compact('option', 'teachers'));
    }

    public function teachertransferprincipalprofile(Request $request)
    {
        try {
            $referenceNo = Crypt::decryptString($request->id);
            //dd($referenceNo);
            $teacher = User::join('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
            ->join('teacher_transfers', 'user_in_services.id', '=', 'teacher_transfers.userServiceId')
            ->join('transfer_types', 'teacher_transfers.typeId', '=', 'transfer_types.id')
            ->join('transfer_reasons', 'teacher_transfers.reasonId', '=', 'transfer_reasons.id')

            // Normal school preferences
            ->leftJoin('schools as ns1', 'teacher_transfers.school1Id', '=', 'ns1.id')
            ->leftJoin('work_places as nwp1', 'ns1.workPlaceId', '=', 'nwp1.id')

            ->leftJoin('schools as ns2', 'teacher_transfers.school2Id', '=', 'ns2.id')
            ->leftJoin('work_places as nwp2', 'ns2.workPlaceId', '=', 'nwp2.id')

            ->leftJoin('schools as ns3', 'teacher_transfers.school3Id', '=', 'ns3.id')
            ->leftJoin('work_places as nwp3', 'ns3.workPlaceId', '=', 'nwp3.id')

            ->leftJoin('schools as ns4', 'teacher_transfers.school4Id', '=', 'ns4.id')
            ->leftJoin('work_places as nwp4', 'ns4.workPlaceId', '=', 'nwp4.id')

            ->leftJoin('schools as ns5', 'teacher_transfers.school5Id', '=', 'ns5.id')
            ->leftJoin('work_places as nwp5', 'ns5.workPlaceId', '=', 'nwp5.id')

            // Alter school preferences
            ->leftJoin('schools as as1', 'teacher_transfers.alterSchool1Id', '=', 'as1.id')
            ->leftJoin('work_places as awp1', 'as1.workPlaceId', '=', 'awp1.id')

            ->leftJoin('schools as as2', 'teacher_transfers.alterSchool2Id', '=', 'as2.id')
            ->leftJoin('work_places as awp2', 'as2.workPlaceId', '=', 'awp2.id')

            ->leftJoin('schools as as3', 'teacher_transfers.alterSchool3Id', '=', 'as3.id')
            ->leftJoin('work_places as awp3', 'as3.workPlaceId', '=', 'awp3.id')

            ->leftJoin('schools as as4', 'teacher_transfers.alterSchool4Id', '=', 'as4.id')
            ->leftJoin('work_places as awp4', 'as4.workPlaceId', '=', 'awp4.id')

            ->leftJoin('schools as as5', 'teacher_transfers.alterSchool5Id', '=', 'as5.id')
            ->leftJoin('work_places as awp5', 'as5.workPlaceId', '=', 'awp5.id')

            ->where('teacher_transfers.refferenceNo', $referenceNo)
            ->where('teacher_transfers.active', 1)

            ->select(
                'users.id AS userId',
                'users.name AS teacher',
                'users.nic',
                'transfer_types.name AS transfer_type',
                'teacher_transfers.principalReason',
                'teacher_transfers.refferenceNo',
                'transfer_reasons.name AS reason',

                // Normal schools + workplaces
                'nwp1.name as workPlace1',
                'nwp2.name as workPlace2',
                'nwp3.name as workPlace3',
                'nwp4.name as workPlace4',
                'nwp5.name as workPlace5',

                // Alter schools + workplaces
                'awp1.name as alterWorkPlace1',
                'awp2.name as alterWorkPlace2',
                'awp3.name as alterWorkPlace3',
                'awp4.name as alterWorkPlace4',
                'awp5.name as alterWorkPlace5'
            )
            ->first();

            //dd($teacher);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Invalid or tampered payload.');
        }
        //dd($teacher);
        $option = [
            'Dashboard' => 'dashboard',
            'Transfer List' => 'teacher.transferprincipallist',
        ];

        $decisions = collect([
            ['id' => 1, 'name' => 'This teacher can be released without a successor as he/she is an excess teacher.'],
            ['id' => 2, 'name' => 'This teacher can be released only if a suitable successor is provided.'],
            ['id' => 3, 'name' => 'This teacher can be released without a successor.'],
            ['id' => 4, 'name' => 'This teacher can’t be released.'],
        ])->map(function ($item) {
            return (object) $item;
        });


        return view('teacher/transfer-principal-confirm',compact('option','teacher', 'decisions', 'referenceNo'));
    }

    public function teachertransferzonalprofile(Request $request)
    {
        try {
            $referenceNo = Crypt::decryptString($request->id);
            //dd($referenceNo);
            $teacher = User::join('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
            ->join('teacher_transfers', 'user_in_services.id', '=', 'teacher_transfers.userServiceId')
            ->join('transfer_types', 'teacher_transfers.typeId', '=', 'transfer_types.id')
            ->join('transfer_reasons', 'teacher_transfers.reasonId', '=', 'transfer_reasons.id')

            // Normal school preferences
            ->leftJoin('schools as ns1', 'teacher_transfers.school1Id', '=', 'ns1.id')
            ->leftJoin('work_places as nwp1', 'ns1.workPlaceId', '=', 'nwp1.id')

            ->leftJoin('schools as ns2', 'teacher_transfers.school2Id', '=', 'ns2.id')
            ->leftJoin('work_places as nwp2', 'ns2.workPlaceId', '=', 'nwp2.id')

            ->leftJoin('schools as ns3', 'teacher_transfers.school3Id', '=', 'ns3.id')
            ->leftJoin('work_places as nwp3', 'ns3.workPlaceId', '=', 'nwp3.id')

            ->leftJoin('schools as ns4', 'teacher_transfers.school4Id', '=', 'ns4.id')
            ->leftJoin('work_places as nwp4', 'ns4.workPlaceId', '=', 'nwp4.id')

            ->leftJoin('schools as ns5', 'teacher_transfers.school5Id', '=', 'ns5.id')
            ->leftJoin('work_places as nwp5', 'ns5.workPlaceId', '=', 'nwp5.id')

            // Alter school preferences
            ->leftJoin('schools as as1', 'teacher_transfers.alterSchool1Id', '=', 'as1.id')
            ->leftJoin('work_places as awp1', 'as1.workPlaceId', '=', 'awp1.id')

            ->leftJoin('schools as as2', 'teacher_transfers.alterSchool2Id', '=', 'as2.id')
            ->leftJoin('work_places as awp2', 'as2.workPlaceId', '=', 'awp2.id')

            ->leftJoin('schools as as3', 'teacher_transfers.alterSchool3Id', '=', 'as3.id')
            ->leftJoin('work_places as awp3', 'as3.workPlaceId', '=', 'awp3.id')

            ->leftJoin('schools as as4', 'teacher_transfers.alterSchool4Id', '=', 'as4.id')
            ->leftJoin('work_places as awp4', 'as4.workPlaceId', '=', 'awp4.id')

            ->leftJoin('schools as as5', 'teacher_transfers.alterSchool5Id', '=', 'as5.id')
            ->leftJoin('work_places as awp5', 'as5.workPlaceId', '=', 'awp5.id')

            ->where('teacher_transfers.refferenceNo', $referenceNo)
            ->where('teacher_transfers.active', 1)

            ->select(
                'users.id AS userId',
                'users.name AS teacher',
                'users.nic',
                'transfer_types.name AS transfer_type',
                'teacher_transfers.principalReason',
                'teacher_transfers.refferenceNo',
                'transfer_reasons.name AS reason',

                // Normal schools + workplaces
                'nwp1.name as workPlace1',
                'nwp2.name as workPlace2',
                'nwp3.name as workPlace3',
                'nwp4.name as workPlace4',
                'nwp5.name as workPlace5',

                // Alter schools + workplaces
                'awp1.name as alterWorkPlace1',
                'awp2.name as alterWorkPlace2',
                'awp3.name as alterWorkPlace3',
                'awp4.name as alterWorkPlace4',
                'awp5.name as alterWorkPlace5'
            )
            ->first();

            if ($teacher) {
                $principalReasons = [
                    1 => 'This teacher can be released without a successor as he/she is an excess teacher.',
                    2 => 'This teacher can be released only if a suitable successor is provided.',
                    3 => 'This teacher can be released without a successor.',
                    4 => 'This teacher can’t be released.',
                ];

                $teacher->principalReasonText = $principalReasons[$teacher->principalReason] ?? 'Pending';
            }

            //dd($teacher);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Invalid or tampered payload.');
        }
        //dd($teacher);
        $option = [
            'Dashboard' => 'dashboard',
            'Transfer List' => 'teacher.transferzonelist',
        ];

        $decision1 = collect([
            (object) ['id' => 1, 'name' => 'The service of this teacher has been confirmed.'],
            (object) ['id' => 2, 'name' => 'The service of this teacher has not been confirmed.'],
        ]);

        $decision2 = collect([
            (object) ['id' => 1, 'name' => 'There are disciplinary or audit queries against this teacher.'],
            (object) ['id' => 2, 'name' => 'There aren’t disciplinary or audit queries against this teacher.'],
        ]);

        $decision3 = collect([
            (object) ['id' => 1, 'name' => 'This teacher is qualified for the transfer (Completed minimum years / Application is complete / Not teaching in non-transferable grades).'],
            (object) ['id' => 2, 'name' => 'This teacher isn’t qualified for the transfer (Not completed minimum years / Application incomplete / Teaching in non-transferable grades).'],
        ]);

        $decision4 = collect([
            (object) ['id' => 1, 'name' => 'This teacher can be released with a successor.'],
            (object) ['id' => 2, 'name' => 'This teacher can be released without a successor.'],
            (object) ['id' => 3, 'name' => 'This transfer was rejected (due to insufficient service period or other).'],
        ]);



        return view('teacher/transfer-zonal-confirm',compact('option','teacher', 'decision1','decision2','decision3', 'decision4', 'referenceNo'));
    }

    public function teachertransferprincipalprofilestore(UpdateTeacherTransferRequest $request)
    {
        $transfer = TeacherTransfer::where('refferenceNo', $request->referenceNo)->first();

        if (!$transfer) {
            return redirect()->back()->with('error', 'Invalid reference number.');
        }

        // Update required fields
        $transfer->principalId = session('workPlaceId'); // Get principal's workplace from session
        $transfer->principalReason = $request->principal; // Radio button selection value
        $transfer->principalTime = Carbon::now(); // Current timestamp

        $transfer->save();

        return redirect()->route('teacher.transferprincipallist')->with('success', 'Principal’s recommendation saved successfully.');
    }

    public function teachertransferzonalprofilestore(UpdateTeacherTransferRequest $request)
    {
        //dd($request);
        $transfer = TeacherTransfer::where('refferenceNo', $request->referenceNo)->first();
        //dd($transfer);
        if (!$transfer) {
            return redirect()->back()->with('error', 'Invalid reference number.');
        }

        // Update required fields
        $transfer->zonalId = session('officeId');
        $transfer->zonalReason1 = $request->decision1;
        $transfer->zonalReason2 = $request->decision2;
        $transfer->zonalReason3 = $request->decision3;
        $transfer->zonalReason4 = $request->decision4;
        $transfer->zonalTime = Carbon::now();

        $transfer->save();

        return redirect()->route('teacher.transferzonelist')->with('success', 'zonal Director recommendation saved successfully.');
    }

    public function transfersummary()
    {
        $option = [
            'Dashboard' => 'teacher.dashboard',
        ];
        return view('teacher/transfer-summary',compact('option'));
    }


    /**
     * Display the specified resource.
     */
    public function show(teacherTransfer $teacherTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(teacherTransfer $teacherTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateteacherTransferRequest $request, teacherTransfer $teacherTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(teacherTransfer $teacherTransfer)
    {
        //
    }
}
