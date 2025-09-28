<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="p-1 rounded shadow-md flex justify-end space-x-2">
                <x-link-icon-button background="bg-red-500" textcolor="text-white" link="school.reports" icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" text="Reports" />
                <x-link-icon-button background="bg-green-500" textcolor="text-white" link="school.search" icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" text="Search" />
            </div>
            <div class="bg-white my-2 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">
                    <div class="mx-auto px-6 lg:px-8">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach ($card_pack_1 as $card)
                                <x-dashboard-card icon="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" text="{{ $card->name }}" number="{{ $card->user_count }}" linkid="{{ $card->id }}" link="teacher.dashboard" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white my-2 overflow-hidden shadow-sm sm:rounded-lg sm:block hidden">
                <div id="chart_div" class="w-full overflow-hidden"></div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(@json($chartData));

            var options = {
            legend: { position: 'none' },
            chart: {
                title: '',
                subtitle: '' },
            axes: {
                x: {
                0: { side: 'top', label: 'Catagory By Amount'} // Top x-axis.
                }
            },
            bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('chart_div'));
            // Convert the Classic options to Material options.
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
        window.addEventListener('resize', function(){
            drawChart();
        });
    });
</script>
