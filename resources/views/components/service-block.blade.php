<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4">
    <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">
        {{ $title }}
    </h4>
    @if($service)
        <p class="text-gray-700 dark:text-gray-300">
            <strong>Service:</strong> {{ optional($service->service)->name ?? 'N/A' }}
        </p>

        @if(isset($service->teacherService))
            <p class="text-gray-600 dark:text-gray-400">
                <strong>Appointment Subject:</strong> {{ optional($service->teacherService->appointmentSubject)->name ?? 'N/A' }}<br>
                <strong>Main Subject:</strong> {{ optional($service->teacherService->mainSubject)->name ?? 'N/A' }}<br>
                <strong>Medium:</strong> {{ optional($service->teacherService->appointmentMedium)->name ?? 'N/A' }}<br>
                <strong>Category:</strong> {{ optional($service->teacherService->appointmentCategory)->name ?? 'N/A' }}
            </p>
        @endif

        @if(!empty($ranks))
            <ul class="list-disc ml-6 mt-2 text-sm text-gray-500 dark:text-gray-300">
                @foreach($ranks as $rank)
                    <li>{{ $rank['rankName'] ?? 'N/A' }} ({{ $rank['rankedDate'] ?? 'N/A' }})</li>
                @endforeach
            </ul>
        @endif
    @else
        <p class="text-gray-500 dark:text-gray-400">No {{ strtolower($title) }} available.</p>
    @endif
</div>
