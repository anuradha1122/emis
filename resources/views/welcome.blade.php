<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" /> --}}

    <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
    <link rel="shortcut icon" href="favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Sipthathu" />
    <link rel="manifest" href="favicon/site.webmanifest" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif

    @livewireStyles

</head>

<body>
    @include('landing-partials.loading')
    @include('landing-partials.header')
    {{-- Hero Section --}}
    <section class="pt-8 lg:pt-32 bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-center bg-cover">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative text-center">
            <div class="border border-indigo-600 p-1 w-60 mx-auto rounded-full flex items-center justify-between mb-4">
                <span class="font-inter text-xs font-medium text-gray-900 ml-3">Explore how to use for brands.</span>
                <a href="javascript:;" class="w-8 h-8 rounded-full flex justify-center items-center bg-indigo-600">
                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.83398 8.00019L12.9081 8.00019M9.75991 11.778L13.0925 8.44541C13.3023 8.23553 13.4073 8.13059 13.4073 8.00019C13.4073 7.86979 13.3023 7.76485 13.0925 7.55497L9.75991 4.22241"
                            stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <h1
                class="max-w-2xl mx-auto text-center font-manrope font-bold text-4xl text-gray-900 mb-5 md:text-5xl leading-[50px]">
                Single Unique
                <span
                    class="font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">Platform</span>
            </h1>
            <h2
                class="mx-auto text-center font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                Enhancing Learning Through Efficient Data Management
            </h2>
            <p class="max-w-xl mx-auto text-center text-base font-normal leading-7 text-gray-500 my-6">
                Sipthathu is the award-winning Education Management Information System serving the Sabaragamuwa
                Province. We revolutionize how schools, teachers, students, and administrators collaborate through
                comprehensive digital solutions.
            </p>
            <a href="javascript:;"
                class="w-full md:w-auto mb-14 inline-flex items-center justify-center py-3 px-7 text-base font-semibold text-center text-white rounded-full bg-indigo-600 shadow-xs hover:bg-indigo-700 transition-all duration-500">
                Create an account
                <svg class="ml-2" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <div class="flex justify-center">
                <img src="{{ asset('/images/dashboard.png') }}" alt="Dashboard image" />
            </div>
        </div>
    </section>

    <section>
        <div
            class="p-5 pt-8 border ignore border-gray-200 not-prose dark:border-gray-800 relative bg-gray-50 dark:bg-gray-800">
            <div
                class="absolute w-auto rounded-b-lg border-b uppercase -translate-y-px tracking-wide leading-none border-l border-r border-gray-200 dark:border-gray-800 shadow-sm top-0 left-1/2 -translate-x-1/2 px-3 pt-1 pb-2 bg-white dark:bg-black text-gray-400 text-[0.65rem]">
                🤩 Our Amazing Services 👇</div>
            <div class="max-w-5xl mx-auto">
                <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3  gap-3 sm:gap-5 not-prose">
                    <a href="#"
                        class="relative flex flex-col items-start justify-between p-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-black bg-white group">
                        <span
                            class="absolute w-full h-full bg-white dark:bg-black inset-0 dark:group-hover:bg-gray-900 group-hover:bg-gray-50 group-hover:bg-opacity-30"></span>
                        <div class="flex items-center justify-between w-full mb-4">
                            <div class="relative items-center justify-between md:h-6 flex gap-2">
                                <div class="flex w-10 h-10 items-center justify-center bg-blue-50 rounded-lg p-1">
                                    <i data-lucide="user-check" class="w-6 h-6 text-blue-500 font-extrabold"></i>
                                </div>
                                <span class=" text-blue-500 font-bold text-xl">Real-time Analytics</span>
                            </div>
                        </div>
                        <span class="relative text-xs md:text-sm text-gray-600 dark:text-gray-400">
                            Comprehensive reporting and data visualization for informed decision making.
                        </span>
                    </a>
                    <a href="#"
                        class="relative flex flex-col items-start justify-between p-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-black bg-white group">
                        <span
                            class="absolute w-full h-full bg-white dark:bg-black inset-0 dark:group-hover:bg-gray-900 group-hover:bg-gray-50 group-hover:bg-opacity-30"></span>
                        <div class="flex items-center justify-between w-full mb-4">
                            <div class="relative items-center justify-between md:h-6 flex gap-2">
                                <div class="flex w-10 h-10 items-center justify-center bg-blue-50 rounded-lg p-1">
                                    <i data-lucide="shield-check" class="w-6 h-6 text-blue-500 font-extrabold"></i>
                                </div>
                                <span class=" text-blue-500 font-bold text-xl">Secure Platform</span>
                            </div>
                        </div>
                        <span class="relative text-xs md:text-sm text-gray-600 dark:text-gray-400">
                            Enterprise-grade security with role-based access control and data protection.
                        </span>
                    </a>
                    <a href="#"
                        class="relative flex flex-col items-start justify-between p-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-black bg-white group">
                        <span
                            class="absolute w-full h-full bg-white dark:bg-black inset-0 dark:group-hover:bg-gray-900 group-hover:bg-gray-50 group-hover:bg-opacity-30"></span>
                        <div class="flex items-center justify-between w-full mb-4">
                            <div class="relative items-center justify-between md:h-6 flex gap-2">
                                <div class="flex w-10 h-10 items-center justify-center bg-blue-50 rounded-lg p-1">
                                    <i data-lucide="clock-8" class="w-6 h-6 text-blue-500 font-extrabold"></i>
                                </div>
                                <span class=" text-blue-500 font-bold text-xl">Attendance Tracking</span>
                            </div>
                        </div>
                        <span class="relative text-xs md:text-sm text-gray-600 dark:text-gray-400">
                            Automated attendance management with real-time notifications to parents.
                        </span>
                    </a>
                    <a href="#"
                        class="relative flex flex-col items-start justify-between p-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-black bg-white group">
                        <span
                            class="absolute w-full h-full bg-white dark:bg-black inset-0 dark:group-hover:bg-gray-900 group-hover:bg-gray-50 group-hover:bg-opacity-30"></span>
                        <div class="flex items-center justify-between w-full mb-4">
                            <div class="relative items-center justify-between md:h-6 flex gap-2">
                                <div class="flex w-10 h-10 items-center justify-center bg-blue-50 rounded-lg p-1">
                                    <i data-lucide="database" class="w-6 h-6 text-blue-500 font-extrabold"></i>
                                </div>
                                <span class=" text-blue-500 font-bold text-xl">Data Management</span>
                            </div>
                        </div>
                        <span class="relative text-xs md:text-sm text-gray-600 dark:text-gray-400">
                            Centralized database system for efficient storage and retrieval of educational data.
                        </span>
                    </a>
                    <a href="#"
                        class="relative flex flex-col items-start justify-between p-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-black bg-white group">
                        <span
                            class="absolute w-full h-full bg-white dark:bg-black inset-0 dark:group-hover:bg-gray-900 group-hover:bg-gray-50 group-hover:bg-opacity-30"></span>
                        <div class="flex items-center justify-between w-full mb-4">
                            <div class="relative items-center justify-between md:h-6 flex gap-2">
                                <div class="flex w-10 h-10 items-center justify-center bg-blue-50 rounded-lg p-1">
                                    <i data-lucide="card-sim" class="w-6 h-6 text-blue-500 font-extrabold"></i>
                                </div>
                                <span class=" text-blue-500 font-bold text-xl">Mobile Access</span>
                            </div>
                        </div>
                        <span class="relative text-xs md:text-sm text-gray-600 dark:text-gray-400">
                            Responsive design ensuring seamless access across all devices and platforms.
                        </span>
                    </a>
                    <a href="#"
                        class="relative flex flex-col items-start justify-between p-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-black bg-white group">
                        <span
                            class="absolute w-full h-full bg-white dark:bg-black inset-0 dark:group-hover:bg-gray-900 group-hover:bg-gray-50 group-hover:bg-opacity-30"></span>
                        <div class="flex items-center justify-between w-full mb-4">
                            <div class="relative items-center justify-between md:h-6 flex gap-2">
                                <div class="flex w-10 h-10 items-center justify-center bg-blue-50 rounded-lg p-1">
                                    <i data-lucide="notepad-text" class="w-6 h-6 text-blue-500 font-extrabold"></i>
                                </div>
                                <span class=" text-blue-500 font-bold text-xl">Report Generation</span>
                            </div>
                        </div>
                        <span class="relative text-xs md:text-sm text-gray-600 dark:text-gray-400">
                            Automated report generation for academic progress, attendance, and administrative needs.
                        </span>
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl">
                        <span>Complete Education </span>
                        <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">Management
                            Suite</span>
                    </p>
                    <p class="mt-4 max-w-xl text-sm text-gray-500 lg:mx-auto">
                        Sipthathu provides a comprehensive platform that connects all stakeholders in the education
                        ecosystem with powerful tools designed specifically for Sri Lankan education standards.
                    </p>
                </div>

                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-r from-cyan-400 to-blue-500 text-white">
                                    <i data-lucide="building-2" class="w-10 h-10"></i>
                                </div>
                                <p class="ml-20 text-lg leading-6 font-medium text-gray-900">School Management</p>
                            </dt>
                            <dd class="mt-2 ml-20 text-base text-gray-500">
                                Comprehensive school administration with student enrollment, attendance tracking, and
                                institutional data management.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-r from-cyan-400 to-blue-500 text-white">
                                    <i data-lucide="user-check" class="w-10 h-10"></i>
                                </div>
                                <p class="ml-20 text-lg leading-6 font-medium text-gray-900">Teacher Portal</p>
                            </dt>
                            <dd class="mt-2 ml-20 text-base text-gray-500">
                                Dedicated dashboard for educators to manage classes, assignments, grades, and
                                communicate with students and parents.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-r from-cyan-400 to-blue-500 text-white">
                                    <i data-lucide="graduation-cap" class="w-10 h-10"></i>
                                </div>
                                <p class="ml-20 text-lg leading-6 font-medium text-gray-900">Student Management</p>
                            </dt>
                            <dd class="mt-2 ml-20 text-base text-gray-500">
                                Complete student lifecycle management from admission to graduation with academic records
                                and progress tracking.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-16 w-16 rounded-md bg-gradient-to-r from-cyan-400 to-blue-500 text-white">
                                    <i data-lucide="settings" class="w-10 h-10"></i>
                                </div>
                                <p class="ml-20 text-lg leading-6 font-medium text-gray-900">Administrator Tools</p>
                            </dt>
                            <dd class="mt-2 ml-20 text-base text-gray-500">
                                Powerful administrative interface for education officials to oversee multiple
                                institutions and generate reports.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    <section class="text-gray-600 body-font bg-gray-100 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl flex md:px-24 md:py-10 md:flex-row flex-col items-center">
            <div
                class="lg:flex-grow mt-5 md:mt-0   md:w-1.5/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                <div class="flex items-center justify-center mb-4 text-sm bg-amber-200 py-1 px-4 rounded-full gap-2">
                    <i data-lucide="trophy" class="w-5 h-5"></i>
                    <span>Recognition & Awards</span>
                </div>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl">
                    <span>Internationally </span>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                        Recognized
                    </span>
                </p>
                <p class="mb-8 md:pl-0  pl-2 pr-2 leading-relaxed dark:text-gray-300">
                    Sipthathu has been honored with prestigious awards recognizing our innovation in education
                    technology and commitment to transforming learning experiences across Sri Lanka.
                </p>
                <div class="flex justify-center">
                    <a href="#" class="inline-flex text-gray-700 bg-gray-200 border-0 py-2 px-6 focus:outline-none hover:bg-gray-300 rounded-full text-lg">Read
                        articles
                    </a>
                </div>
            </div>
            <div class="lg:max-w-lg lg:w-full mb-5 md:mb-0 md:w-1/2 w-3/6">
                <img class="object-cover object-center rounded" alt="hero"
                    src="https://www.svgrepo.com/show/490900/hot-air-balloon.svg">
            </div>
        </div>
    </section>



    @include('landing-partials.footer')

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    <!-- Scripts -->
    @livewireScripts
</body>

</html>
