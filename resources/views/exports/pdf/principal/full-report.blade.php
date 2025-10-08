<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>NIC</th>
            <th>Name With Initials</th>
            <th>School</th>
            <th>Gender</th>
            <th>Service Started</th>
            <th>Current Appointment Started</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $index => $result)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $result->nic }}</td>
            <td>{{ $result->nameWithInitials }}</td>
            <td>{{ $result->currentTeacherService?->currentAppointment?->workPlace?->name }}</td>
            <td>
                @if($result->personalInfo?->genderId == 1) Male
                @elseif($result->personalInfo?->genderId == 2) Female
                @else N/A
                @endif
            </td>
            <td>{{ $result->currentTeacherService?->appointedDate }}</td>
            <td>{{ $result->currentTeacherService?->currentAppointment?->appointedDate }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
