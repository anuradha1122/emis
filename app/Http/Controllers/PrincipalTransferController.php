<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePrincipalTransferRequest;
use App\Http\Requests\UpdatePrincipalTransferRequest;
use App\Models\PrincipalTransfer;
use App\Models\UserServiceAppointment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class PrincipalTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(session('appointmentId'));
        $userServiceAppointment = UserServiceAppointment::where('id', session('appointmentId'))->first();


        // Assuming $userServiceAppointment->appointedDate is a valid date (e.g., '2020-01-15')
        $appointedDate = Carbon::parse($userServiceAppointment->appointedDate);
        $comparisonDate = Carbon::parse('2025-07-01');
        $years = $appointedDate->diffInYears($comparisonDate);


        $option = [
            'Dashboard' => 'principal.transferdashboard',
        ];
        return view('principal/transfer-dashboard',compact('option','years'));
    }

    public function principalindex()
    {
        //dd(session('higherZoneId'));
        // $transferTypes = TransferType::where('active', 1)->get();
        // $transferReasons = TransferReason::where('active', 1)->get();
        $binaryList = collect([
            (object)['id' => 1, 'name' => 'yes'],
            (object)['id' => 2, 'name' => 'no'],
        ]);

        $positionList = collect([
            (object)['id' => 1, 'name' => 'Principal'],
            (object)['id' => 2, 'name' => 'Vice Principal'],
            (object)['id' => 3, 'name' => 'Assistant Principal'],
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
            'Dashboard' => 'principal.transferdashboard',
            'Transfer Form' => 'principal.transfer',
        ];
        return view('principal/transferform',compact('option','positionList','binaryList','zoneSchools'));
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
    public function store(StorePrincipalTransferRequest $request)
    {
        //
    }

    public function principalstore(StorePrincipalTransferRequest $request)
    {
        //dd(session()->all());

        $userServiceId = session('userServiceId');
        //dd($request->all());
        PrincipalTransfer::where('userServiceId', $userServiceId)
            ->where('active', 1)
            ->update(['active' => 0]);

        $referenceNo = now()->format('Ymd') . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PrincipalTransfer::create([
            'refferenceNo'       => $referenceNo,
            'userServiceId'      => $userServiceId,
            'appointmentLetterNo' => $request->appointmentLetterNo,
            'serviceConfirm'     => $request->serviceConfirm,
            'schoolDistance'     => $request->schoolDistance,
            'position'           => $request->position,
            'specialChildren'    => $request->specialChildren,
            'expectTransfer'     => $request->expectTransfer,
            'reason'           => $request->reason,
            'school1Id'          => $request->school1,
            'distance1'          => $request->distance1,
            'school2Id'          => $request->school2,
            'distance2'          => $request->distance2,
            'school3Id'          => $request->school3,
            'distance3'          => $request->distance3,
            'school4Id'          => $request->school4,
            'distance4'          => $request->distance4,
            'school5Id'          => $request->school5,
            'distance5'          => $request->distance5,
            'anySchool'          => $request->otherSchool,
            'mention'            => $request->mention,
            'active'             => 1,
        ]);


        $typeId = $request->type;
        $option = [
            'Transfer Form' => 'principal.transfer',
        ];

        return view('principal/after-transfer-form',compact('option'));
        //dd($request->all());
    }

    public function principalPersonalPdf(Request $request)
    {
        $typeId = $request->query('typeId'); // or $request->get('typeId');

        $userServiceId = session('userServiceId'); // get from session
        $typeId = $typeId; // passed from controller or request

        $transfer = DB::table('principal_transfers')
            // joins same as before ...
            ->leftJoin('schools as s1', 'principal_transfers.school1Id', '=', 's1.id')
            ->leftJoin('work_places as wp1', 's1.workPlaceId', '=', 'wp1.id')
            ->leftJoin('schools as s2', 'principal_transfers.school2Id', '=', 's2.id')
            ->leftJoin('work_places as wp2', 's2.workPlaceId', '=', 'wp2.id')
            ->leftJoin('schools as s3', 'principal_transfers.school3Id', '=', 's3.id')
            ->leftJoin('work_places as wp3', 's3.workPlaceId', '=', 'wp3.id')
            ->leftJoin('schools as s4', 'principal_transfers.school4Id', '=', 's4.id')
            ->leftJoin('work_places as wp4', 's4.workPlaceId', '=', 'wp4.id')
            ->leftJoin('schools as s5', 'principal_transfers.school5Id', '=', 's5.id')
            ->leftJoin('work_places as wp5', 's5.workPlaceId', '=', 'wp5.id')
            ->select(
                'principal_transfers.*',
                'wp1.name as school1Name',
                'wp2.name as school2Name',
                'wp3.name as school3Name',
                'wp4.name as school4Name',
                'wp5.name as school5Name',

                DB::raw("CASE principal_transfers.anySchool WHEN 1 THEN 'Yes' WHEN 2 THEN 'No' ELSE 'N/A' END as anySchool"),
                DB::raw("CASE principal_transfers.serviceConfirm WHEN 1 THEN 'Yes' WHEN 2 THEN 'No' ELSE 'N/A' END as serviceConfirm"),
                DB::raw("CASE principal_transfers.specialChildren WHEN 1 THEN 'Yes' WHEN 2 THEN 'No' ELSE 'N/A' END as specialChildren"),
                DB::raw("CASE principal_transfers.expectTransfer WHEN 1 THEN 'Yes' WHEN 2 THEN 'No' ELSE 'N/A' END as expectTransfer"),
                DB::raw("CASE principal_transfers.position
                            WHEN 1 THEN 'Principal'
                            WHEN 2 THEN 'Vice Principal'
                            WHEN 3 THEN 'Assistant Principal'
                            ELSE 'N/A' END as position"),
                DB::raw("DATE_FORMAT(principal_transfers.created_at, '%Y-%m-%d') as createdDate")
            )

            ->where('principal_transfers.userServiceId', $userServiceId)
            ->where('principal_transfers.active', 1)

            ->first(); // or ->get() if you want multiple rows


        $pdf = Pdf::loadView('principal.pdf.transfer-personal-pdf', compact('transfer'));

        return $pdf->download('principal-transfer.pdf');
    }


    public function principaltransferzonelist()
    {
        //dd(session('officeId'));
        $principals = User::join('user_in_services', 'users.id', '=', 'user_in_services.userId')
        ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
        ->join('work_places', 'user_service_appointments.workPlaceId', '=', 'work_places.id')
        ->join('schools', 'work_places.id', '=', 'schools.workPlaceId')
        ->join('offices', 'schools.officeId', '=', 'offices.id')
        ->join('principal_transfers', 'user_in_services.id', '=', 'principal_transfers.userServiceId')
        ->where('offices.higherOfficeId', session('officeId'))
        ->whereNull('user_service_appointments.releasedDate')
        ->whereNull('user_in_services.releasedDate')
        ->where('principal_transfers.active', 1)
        ->select(
            'users.id AS userId',
            'users.name AS principal',
            'users.nic',
            'work_places.name AS workPlace',
            'principal_transfers.zonalId',
            'principal_transfers.zonalReason1',
            'principal_transfers.zonalReason2',
            'principal_transfers.zonalReason3',
            'principal_transfers.zonalReason4',
            'principal_transfers.refferenceNo'
        )
        ->orderByRaw('CASE WHEN principal_transfers.zonalId IS NULL THEN 0 ELSE 1 END')
        ->orderBy('work_places.name')          // first order by workplace
        ->get()
        ->map(function ($item) {
            $item->refferenceNo = Crypt::encryptString($item->refferenceNo);
            return $item;
        });

        //dd($principals);
        $option = [
            'Dashboard' => 'dashboard',
        ];

        return view('principal/transfer-zone-list',compact('option', 'principals'));
    }

    public function principaltransferzonalprofile(Request $request)
    {
        try {
            $referenceNo = Crypt::decryptString($request->id);
            //dd($referenceNo);
            $principal = User::join('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
            ->join('principal_transfers', 'user_in_services.id', '=', 'principal_transfers.userServiceId')

            // Normal school preferences
            ->leftJoin('schools as ns1', 'principal_transfers.school1Id', '=', 'ns1.id')
            ->leftJoin('work_places as nwp1', 'ns1.workPlaceId', '=', 'nwp1.id')

            ->leftJoin('schools as ns2', 'principal_transfers.school2Id', '=', 'ns2.id')
            ->leftJoin('work_places as nwp2', 'ns2.workPlaceId', '=', 'nwp2.id')

            ->leftJoin('schools as ns3', 'principal_transfers.school3Id', '=', 'ns3.id')
            ->leftJoin('work_places as nwp3', 'ns3.workPlaceId', '=', 'nwp3.id')

            ->leftJoin('schools as ns4', 'principal_transfers.school4Id', '=', 'ns4.id')
            ->leftJoin('work_places as nwp4', 'ns4.workPlaceId', '=', 'nwp4.id')

            ->leftJoin('schools as ns5', 'principal_transfers.school5Id', '=', 'ns5.id')
            ->leftJoin('work_places as nwp5', 'ns5.workPlaceId', '=', 'nwp5.id')



            ->where('principal_transfers.refferenceNo', $referenceNo)
            ->where('principal_transfers.active', 1)

            ->select(
                'users.id AS userId',
                'users.name AS principal',
                'users.nic',
                'principal_transfers.refferenceNo',
                'principal_transfers.reason',

                // Normal schools + workplaces
                'nwp1.name as workPlace1',
                'nwp2.name as workPlace2',
                'nwp3.name as workPlace3',
                'nwp4.name as workPlace4',
                'nwp5.name as workPlace5',

            )
            ->first();

            if ($principal) {
                $zoneReasons = [
                    1 => 'This principal can be released without a successor as he/she is an excess principal.',
                    2 => 'This principal can be released only if a suitable successor is provided.',
                    3 => 'This principal can be released without a successor.',
                    4 => 'This principal can’t be released.',
                ];

                $principal->zoneReasonText = $zoneReasons[$principal->zoneReason] ?? 'Pending';
            }

            //dd($principal);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Invalid or tampered payload.');
        }
        //dd($principal);
        $option = [
            'Dashboard' => 'dashboard',
            'Transfer List' => 'principal.transferzonelist',
        ];

        $decision1 = collect([
            (object) ['id' => 1, 'name' => 'The service of this principal has been confirmed.'],
            (object) ['id' => 2, 'name' => 'The service of this principal has not been confirmed.'],
        ]);

        $decision2 = collect([
            (object) ['id' => 1, 'name' => 'There are disciplinary or audit queries against this principal.'],
            (object) ['id' => 2, 'name' => 'There aren’t disciplinary or audit queries against this principal.'],
        ]);

        $decision3 = collect([
            (object) ['id' => 1, 'name' => 'This principal is Supernumeric.'],
            (object) ['id' => 2, 'name' => 'This principal is Principal Graded.'],
        ]);

        $decision4 = collect([
            (object) ['id' => 1, 'name' => 'This principal can be released with a successor.'],
            (object) ['id' => 2, 'name' => 'This principal can be released without a successor.'],
            (object) ['id' => 3, 'name' => 'This transfer was rejected (due to insufficient service period or other).'],
        ]);



        return view('principal/transfer-zonal-confirm',compact('option','principal', 'decision1','decision2','decision3', 'decision4', 'referenceNo'));
    }


    public function principaltransferzonalprofilestore(UpdatePrincipalTransferRequest $request)
    {
        //dd($request);
        $transfer = PrincipalTransfer::where('refferenceNo', $request->referenceNo)->first();
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

        return redirect()->route('principal.transferzonelist')->with('success', 'zonal Director recommendation saved successfully.');
    }

    public function transfersummary()
    {
        $option = [
            'Dashboard' => 'principal.dashboard',
        ];
        return view('principal/transfer-summary',compact('option'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PrincipalTransfer $principalTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrincipalTransfer $principalTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrincipalTransferRequest $request, PrincipalTransfer $principalTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrincipalTransfer $principalTransfer)
    {
        //
    }
}
