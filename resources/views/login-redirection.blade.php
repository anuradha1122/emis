<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h2 class="text-lg font-extrabold text-center my-3 text-blue-500">Login As</h2>

    <div class="flex flex-col gap-4 pb-6">
        <!-- Personal -->
        <a href="{{ route('login') }}"
            class="flex items-center justify-between bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
            <div class="flex items-center gap-3">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span>Personal</span>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>

        <!-- School -->
        <a href="{{ route('login') }}" target="_blank"
            class="flex items-center justify-between bg-gradient-to-r from-green-400 to-emerald-600 hover:from-green-500 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
            <div class="flex items-center gap-3">
                <i data-lucide="school" class="w-5 h-5"></i>
                <span>School</span>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>

        <!-- Division Office -->
        <a href="{{ route('login') }}" target="_blank"
            class="flex items-center justify-between bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
            <div class="flex items-center gap-3">
                <i data-lucide="building" class="w-5 h-5"></i>
                <span>Division Office</span>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>

        <!-- Zonal Office -->
        <a href="{{ route('login') }}" target="_blank"
            class="flex items-center justify-between bg-gradient-to-r from-yellow-400 to-amber-600 hover:from-yellow-500 hover:to-amber-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
            <div class="flex items-center gap-3">
                <i data-lucide="map" class="w-5 h-5"></i>
                <span>Zonal Office</span>
            </div>
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>
    </div>

</x-guest-layout>
