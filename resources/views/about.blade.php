<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About Us</title>

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

    <div class="sm:flex items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="sm:w-1/2 p-10">
            <div class="image object-center text-center">
                <img src="{{ asset('images/about.png') }}" alt="About Image" class="w-full h-auto">
            </div>
        </div>
        <div class="sm:w-1/2 p-5">
            <div class="text">
                <span class="text-gray-500 border-b-2 border-indigo-600 uppercase">Semis.lk</span>
                <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">About <span class="text-indigo-600">Sipthathu</span>
                </h2>
                <p class="text-gray-700 py-4">
                    Sipthathu is the official School Education Management Information System (SEMIS) for the Sabaragamuwa Provincial Department of Education. Developed collaboratively by educators, it serves as a critical tool for decision-making and administrative efficiency.
                </p>
                <p class="text-gray-700 py-4">
                    Our mission is to streamline educational management, from automating teacher cadre determination and transfers to monitoring school projects and performance. By integrating data for teachers, principals, students, and resources into a single platform, we provide real-time insights to foster a more effective and responsive education system in the province.
                </p>
            </div>
        </div>
    </div>
    @include('landing-partials.footer')

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    @livewireScripts
</body>

</html>
