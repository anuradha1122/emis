<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4">
    <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">{{ $title }}</h4>

    @forelse($appointments as $app)
        <p class="text-gray-700 dark:text-gray-300">
            <strong>Workplace:</strong> {{ $app['workPlace'] ?? 'N/A' }} <br>
            <strong>From:</strong> {{ $app['appointedDate'] ?? 'N/A' }}
            @if(isset($app['releasedDate']))
                <strong>To:</strong> {{ $app['releasedDate'] ?? 'Present' }}
            @endif
        </p>
    @empty
        <p class="text-gray-500 dark:text-gray-400">No {{ strtolower($title) }} found.</p>
    @endforelse
</div>
