<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4">
    <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">{{ $title }}</h4>
    <ul class="list-disc ml-6 text-sm text-gray-500 dark:text-gray-300">
        @foreach($positions as $pos)
            <li>{{ $pos['positionName'] ?? 'N/A' }} ({{ $pos['positionedDate'] ?? 'N/A' }})</li>
        @endforeach
    </ul>
</div>
