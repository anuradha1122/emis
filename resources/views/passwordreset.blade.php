<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.change.submit') }}">
        @csrf

        <!-- Password -->
        <div>

            <!-- 🔐 Hidden NIC input -->
            <input type="hidden" name="nic" value="{{ $nic }}">

            <x-input-label for="newpassword" :value="__('New Password')" />

            <x-text-input id="newpassword" class="block mt-1 w-full"
                            type="password"
                            name="newpassword"
                            required autocomplete="current-password" />

            <x-input-label for="confirmpassword" :value="__('Confirm Password')" />

            <x-text-input id="confirmpassword" class="block mt-1 w-full"
                            type="password"
                            name="confirmpassword"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('newpassword')" class="mt-2" />



        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
        <div class="mt-4 text-sm text-left">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                {{ __('← Back to login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
