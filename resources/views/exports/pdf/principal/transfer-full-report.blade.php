<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF</title>

  <style>
    .center {
      text-align: center;
    }
    .center img {
      display: block;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .font-bold {
      font-weight: bold;
    }
    .page-break {
      page-break-after: always;
    }

    .footer {
      width: 100%;
      text-align: center;
      position: fixed;
      bottom: 0px;
    }
  </style>
</head>
<body>
    @foreach ($results as $result)
    <div>
      <table style="width: 100%; text-align: center; text-transform: uppercase;">
        <tbody>
          <tr>
            <!-- <td style="width: 15%; vertical-align: middle;"><img src="{{ public_path('storage/systemphotos/logo.jpeg') }}" alt="" style="width: 80px;"></td> -->
            <td>
              <p style="border: 1px solid #333; border-radius: 20px; padding: 10px; font-size: 11px;">Ministry of education and provincial department of education sabaragamuwa province
              </br>
                Sipthathu Education Management And Information System (SEMIS)
              </p>
            </td>
            <!-- <td style="width: 15%; vertical-align: middle;"><img src="{{ public_path('storage/systemphotos/flag.jpeg') }}" alt="" style="width: 80px;"></td> -->
          </tr>
        </tbody>
      </table>
    </div>

    @foreach($results as $result)
        <div style="width: 100%; padding-bottom: 40px;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #777;">
                <tr>
                    <td style="width: 30%; vertical-align: middle; border: 1px solid #777;">Reference No</td>
                    <td style="width: 70%; vertical-align: middle; border: 1px solid #777;">{{ $result->refferenceNo }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Name</td>
                    <td style="border: 1px solid #777;">{{ $result->userService->user->nameWithInitials ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">NIC</td>
                    <td style="border: 1px solid #777;">{{ $result->userService->user->nic ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Appointment Letter No</td>
                    <td style="border: 1px solid #777;">{{ $result->appointmentLetterNo ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Service Confirmed</td>
                    <td style="border: 1px solid #777;">
                        {{ $result->serviceConfirm == 1 ? 'Yes' : ($result->serviceConfirm == 2 ? 'No' : 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">School</td>
                    <td style="border: 1px solid #777;">{{ $result->userService->currentAppointment?->workPlace?->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Current Position</td>
                    <td style="border: 1px solid #777;">
                        {{ match((int) $result->position) {
                            1 => 'Principal',
                            2 => 'Vice Principal',
                            3 => 'Assistant Principal',
                            default => 'N/A',
                        } }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #777;">Gender</td>
                    <td style="border: 1px solid #777;">
                        {{ $result->userService->user->personalInfo?->genderId == 1 ? 'Male' : ($result->userService->user->personalInfo?->genderId == 2 ? 'Female' : 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Birth Day</td>
                    <td style="border: 1px solid #777;">{{ $result->userService->user->personalInfo?->birthDay ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Service Appointed Date</td>
                    <td style="border: 1px solid #777;">{{ $result->userService?->appointedDate ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">School Appointed Date</td>
                    <td style="border: 1px solid #777;">{{ $result->userService->currentAppointment?->appointedDate ?? '' }}</td>
                </tr>

                {{-- Expected Schools and Distances --}}
                @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td style="border: 1px solid #777;">Expected School {{ $i }}</td>
                        <td style="border: 1px solid #777;">
                            {{ $result->{'school'.$i}?->workPlace?->name ?? '' }}
                            @if($result->{'distance'.$i})
                                ({{ $result->{'distance'.$i} }} km)
                            @endif
                        </td>
                    </tr>
                @endfor


                <tr>
                    <td style="border: 1px solid #777;">Special Children</td>
                    <td style="border: 1px solid #777;">
                        {{ $result->specialChildren == 1 ? 'Yes' : ($result->specialChildren == 2 ? 'No' : 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Any School</td>
                    <td style="border: 1px solid #777;">
                        {{ $result->anySchool == 1 ? 'Yes' : ($result->anySchool == 2 ? 'No' : 'N/A') }}
                    </td>
                </tr>
                {{-- <tr>
                    <td style="border: 1px solid #777;">Reasons</td>
                    <td style="border: 1px solid #777;">{{ $result->reason ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #777;">Mentions</td>
                    <td style="border: 1px solid #777;">{{ $result->mention ?? '' }}</td>
                </tr> --}}

            </table>
        </div>
    @endforeach

    @endforeach
    <div class="footer">
      {{ date("Y") }} &copy; Sipthathu
    </div>
  </body>
</html>
