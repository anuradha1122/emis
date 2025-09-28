<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Welcome back, Madusanka! Here's what's happening today.
                    </p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <x-dashboard-card
                        title="Schools"
                        icon="school"
                        value="10194"
                        trend="change"
                        trendText="School"
                        trendColor="green"
                    />

                    <x-dashboard-card
                        title="Teachers"
                        icon="users"
                        value="254323"
                        trend="change"
                        trendText="Teachers"
                        trendColor="blue"
                    />

                    <x-dashboard-card
                        title="principals"
                        icon="user-check"
                        value="6543"
                        trend="change"
                        trendText="Principals"
                        trendColor="yellow"
                    />

                    <x-dashboard-card
                        title="Students"
                        icon="globe"
                        value="4534543"
                        trend="change"
                        trendText="Students"
                        trendColor="purple"
                    />
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Sales Chart -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100"></h3>
                            <button
                                class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                <i data-lucide="ellipsis-vertical"></i>
                            </button>
                        </div>
                        <div class="flex justify-center">
                            <div class="mx-auto">
                                <canvas id="genderChart" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Traffic Sources -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100"></h3>
                            <button
                                class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                <i data-lucide="ellipsis-vertical"></i>
                            </button>
                        </div>
                        <div class="flex justify-center">
                            <div class="mx-auto">
                                <canvas id="provinceChart" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Recent Orders</h3>
                        <button
                            class="px-4 py-2 bg-primary-500 dark:bg-primary-600 text-white rounded-lg hover:bg-primary-600 dark:hover:bg-primary-700 text-sm">View
                            All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Order ID</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Customer</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">#1001</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Alice Johnson</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs text-white bg-green-500 rounded">Completed</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Mar 12, 2025</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">$320.00</td>
                                    <td class="py-3 px-4">
                                        <button class="text-blue-500 dark:text-blue-400 hover:underline">View</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">#1002</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Michael Smith</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs text-white bg-yellow-500 rounded">Pending</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Mar 11, 2025</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">$150.00</td>
                                    <td class="py-3 px-4">
                                        <button class="text-blue-500 dark:text-blue-400 hover:underline">View</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">#1003</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Sophia Brown</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs text-white bg-red-500 rounded">Cancelled</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Mar 10, 2025</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">$75.00</td>
                                    <td class="py-3 px-4">
                                        <button class="text-blue-500 dark:text-blue-400 hover:underline">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script type="module">
        // Students Province Pie Chart
        const ctx = document.getElementById('provinceChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($students)) !!},
                datasets: [{
                    label: 'Number of Students',
                    data: {!! json_encode(array_values($students)) !!},
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40',
                        '#C9CBCF', '#00A36C', '#B5651D'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    title: {
                        display: true,
                        text: 'Provinces Vs total students',
                        font: {
                            size: 16
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    }
                }

            }
        });
    </script>

    <script>
        // Teacher vs Student Bar Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx1 = document.getElementById('genderChart').getContext('2d');

            // Data from Laravel
            const chartData = {
                labels: ['Teachers', 'Students'],
                datasets: [{
                        label: 'Male',
                        data: [
                            {{ $data['teacher']['male'] }},
                            {{ $data['student']['male'] }}
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Female',
                        data: [
                            {{ $data['teacher']['female'] }},
                            {{ $data['student']['female'] }}
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            };

            new Chart(ctx1, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: false,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Gender Distribution Among Teachers and Students',
                            font: {
                                size: 16
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuad'
                    }
                }
            });
        });
    </script>



</x-app-layout>
