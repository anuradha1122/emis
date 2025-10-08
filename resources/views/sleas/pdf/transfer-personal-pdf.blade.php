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
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Transfer Type</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->typeName }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Transfer Reason</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->reasonName }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 1</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school1Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 2</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school2Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 3</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school3Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 4</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school4Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 5</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->school5Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">If there aren’t vacancies in the requested zone, do you like to be transferred to any school in the requested zone</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->anySchoolText }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Current teaching grades (Only for teachers who teach in primary grades)</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->gradeName }}</td>
        </tr>
    </table>

        <p style="padding: 10px; font-size: 11px;">If current school service period is more than 5 years,  expected schools to be transfer within the zone</p>
    <table style="border: 1px solid #777;">
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 1</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->alterSchool1Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 2</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->alterSchool2Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 3</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->alterSchool3Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 4</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->alterSchool4Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">School 5</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->alterSchool5Name }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">Other extra-curricular activities entrusted in the present school</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->extraCurricular }}</td>
        </tr>
        <tr style="border: 1px solid #777;">
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">If you have anything else to mention, please mention it in this column</td>
            <td style="width: 30px; vertical-align: middle; border: 1px solid #777;">{{ $transfer->mention }}</td>
        </tr>
      </table>
    </div>

    <div class="footer">
      {{ date("Y") }} &copy; Sipthathu
    </div>
  </body>
</html>
