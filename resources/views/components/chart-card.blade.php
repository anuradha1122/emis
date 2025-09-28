<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $title ?? '' }}</h3>
        <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
            <i data-lucide="ellipsis-vertical"></i>
        </button>
    </div>
    <div class="flex justify-center">
        <div class="mx-auto">
            <canvas id="{{ $id }}"></canvas>
        </div>
    </div>

    @push('scripts')
    <script type="module">
        const ctx_{{ $id }} = document.getElementById('{{ $id }}').getContext('2d');
        new Chart(ctx_{{ $id }}, {
            type: '{{ $type ?? "bar" }}',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: '{{ $datasetLabel ?? "" }}',
                    data: {!! json_encode($data) !!},
                    backgroundColor: {!! json_encode($colors ?? ["#FF6384","#36A2EB","#FFCE56","#4BC0C0","#9966FF","#FF9F40","#C9CBCF"]) !!}
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: '{{ $legendPosition ?? "top" }}' },
                    title: {
                        display: {!! $titleDisplay ?? "true" !!},
                        text: '{{ $chartTitle ?? "" }}',
                        font: { size: 16 },
                        padding: { top: 10, bottom: 30 }
                    }
                }
            }
        });
    </script>
    @endpush
</div>
