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

    <div>
      <table style="width: 100%; text-align: center; text-transform: uppercase;">
        <tbody>
          <tr>
            <td style="width: 15%; vertical-align: middle;"><img src="{{ public_path('storage/systemphotos/logo.jpeg') }}" alt="" style="width: 80px;"></td>
            <td>
              <p style="border: 1px solid #333; border-radius: 20px; padding: 10px; font-size: 11px;">Ministry of education and provincial department of education sabaragamuwa province
              </br>
                Sipthathu Education Management And Information System (SEMIS)
              </p>
            </td>
            <td style="width: 15%; vertical-align: middle;"><img src="{{ public_path('storage/systemphotos/flag.jpeg') }}" alt="" style="width: 80px;"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="width: 100%; padding-bottom: 40px;">
      <table style="border: 1px solid #777;">
        {{-- <thead>
          <tr style="border: 1px solid #777;">
            <th style="width: 30px; vertical-align: middle; border: 1px solid #777;">Column 1</th>
            <th style="width: 30px; vertical-align: middle; border: 1px solid #777;">Column 2</th>
          </tr>
        </thead> --}}
        <tr style="border: 1px solid #777;">
          <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Refference No</td>
          <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->refferenceNo }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Name</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ Auth::user()->name; }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">NIC</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ Auth::user()->nic; }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Appointment Letter No</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->appointmentLetterNo }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Service Conformation</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->serviceConfirm }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Distance Between Current School & home</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->schoolDistance." Km" }}</td>
        </tr>

        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Transfer Reason</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->reason }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 1</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school1Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 1 To Home Distance</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">@if($transfer->distance1 != NULL){{ $transfer->distance1." Km" }}@else{{ " " }}@endif</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 2</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school2Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 2 To Home Distance</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">@if($transfer->distance2 != NULL){{ $transfer->distance2." Km" }}@else{{ " " }}@endif</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 3</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school3Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 3 To Home Distance</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">@if($transfer->distance3 != NULL){{ $transfer->distance3." Km" }}@else{{ " " }}@endif</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 4</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school4Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 4 To Home Distance</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">@if($transfer->distance4 != NULL){{ $transfer->distance4." Km" }}@else{{ " " }}@endif</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 5</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school5Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 5 To Home Distance</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">@if($transfer->distance5 != NULL){{ $transfer->distance5." Km" }}@else{{ " " }}@endif</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">If there aren’t vacancies in the requested zone, do you like to be transferred to any school in the requested zone</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->anySchool }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Have children with special needs</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->specialChildren }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Are you looking for a transfer</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->expectTransfer }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Current Position</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->position }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Reasons for requesting transfer or not</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->reason }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Mentions</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->mention }}</td>
        </tr>
    </table>

    </div>

    <div class="footer">
      {{ date("Y") }} &copy; Sipthathu
    </div>
  </body>
</html>
