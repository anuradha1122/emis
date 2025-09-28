<div>
    <!-- Transparent Navbar -->
    <nav class="fixed top-0 left-0 w-full z-20 bg-gray-700 backdrop-blur-sm bg-gradient-to-br from-gray-900 to-gray-800 text-white overflow-hidden" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition duration-500">
                        <img class="h-10 w-auto bg-white rounded-full" src="{{ asset('images/log.png') }}" alt="Logo">
                    </div>
                    <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                        EMIS
                    </h2>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{route('landing.index')}}" class="text-white hover:text-blue-400 transition">Home</a>
                    <a href="{{route('landing.about')}}" class="text-white hover:text-blue-400 transition">About</a>
                    {{-- <a href="{{route('landing.features')}}" class="text-white hover:text-blue-400 transition">Features</a> --}}
                    <a href="{{route('landing.contact')}}" class="text-white hover:text-blue-400 transition">Contact</a>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 text-white border border-white/30 hover:border-white rounded-lg text-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 text-white border border-white/30 hover:border-white rounded-lg text-sm">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 text-white border border-white/30 hover:border-white rounded-lg text-sm">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="md:hidden">
                    <button @click="open = !open" :aria-expanded="open.toString()" class="p-2 text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white rounded-md">
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition class="md:hidden bg-black/80 backdrop-blur-sm">
            <div class="space-y-1 px-4 pt-4 pb-3">
                <a href="{{route('landing.index')}}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white/10">Home</a>
                <a href="{{route('landing.about')}}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white/10">About</a>
                {{-- <a href="{{route('landing.features')}}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white/10">Features</a> --}}
                <a href="{{route('landing.contact')}}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white/10">Contact</a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white/10">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('landing.login-redirection') }}" class="block text-white px-3 py-2 rounded-md text-base font-medium hover:bg-white/10">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block w-full text-center bg-white text-indigo-600 px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>
</div>
