<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contact</title>

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

    <!-- Styles / Livewire. -->
    @livewireStyles

</head>

<body>
    @include('landing-partials.loading')
    @include('landing-partials.header')

    <div class="min-h-screen bg-gray-50 py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto my-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Information Card -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                            Contact <span class="text-indigo-600">Us</span>
                        </h2>
                        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                            We'd love to hear from you! <br> Reach out through any of these channels or send us a message.
                        </p>
                    </div>
                    <div class="space-y-8">
                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                <i data-lucide="map-pin" class="text-indigo-600 w-6 h-6"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-semibold text-gray-900">Our Office</h3>
                                <p class="mt-2 text-gray-600">Sabaragamuwa Provincial Department of Education,<br> Ratnapura,
                                    Sri Lanka
                                </p>
                            </div>
                        </div>

                        <!-- Contact Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i data-lucide="phone" class="text-indigo-600 w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Call Us</h3>
                                    <p class="mt-1 text-gray-600">+94 (45) 2222 184</p>
                                </div>
                            </div>

                            <!-- Fax -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i data-lucide="phone-incoming" class="text-indigo-600 w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Fax</h3>
                                    <p class="mt-1 text-gray-600">+94 (45) 2222 184</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i data-lucide="mail" class="text-indigo-600 w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Email</h3>
                                    <p class="mt-1 text-gray-600">info@semis.com</p>
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i data-lucide="globe" class="text-indigo-600 w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Website</h3>
                                    <p class="mt-1 text-gray-600">www.semis.com</p>
                                </div>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                <i data-lucide="clock" class="text-indigo-600 w-6 h-6"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Working Hours</h3>
                                <p class="mt-1 text-gray-600">
                                    Monday - Friday: 8:00 AM - 5:00 PM<br>
                                    Saturday: 8:00 AM - 12:00 PM<br>
                                    Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Card -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    @livewire('contact-form')
                </div>
            </div>
        </div>
    </div>

    @include('landing-partials.footer')
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
