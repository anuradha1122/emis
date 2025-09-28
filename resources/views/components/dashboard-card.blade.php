<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
    <div class="flex items-center justify-between mb-2">
        <div class="text-gray-500 dark:text-gray-400">{{ $title }}</div>
        <div class="bg-{{ $trendColor }}-100 dark:bg-{{ $trendColor }}-700 p-1 rounded">
            <i data-lucide="{{ $icon }}" class="text-{{ $trendColor }}-600 dark:text-{{ $trendColor }}-300"></i>
        </div>
    </div>
    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</div>
    @if ($trend)
        <div class="flex items-center text-sm">
            <span class="text-{{ $trendColor }}-600 dark:text-{{ $trendColor }}-400 flex items-center gap-2">
                <i data-lucide="trending-up"></i>
                <span>{{ $trend }}</span>
            </span>
            <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $trendText }}</span>
        </div>
    @endif
</div>
