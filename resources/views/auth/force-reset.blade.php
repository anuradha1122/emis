<x-guest-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-semibold mb-4">Reset Your Password</h2>

        @if(session('message'))
            <div class="mb-4 text-red-600">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('password.force.update') }}">
            @csrf
            <input type="hidden" name="nic" value="{{ $nic }}">

            <div class="mb-4">
                <label for="password" class="block mb-1">New Password</label>
                <input id="password" type="password" name="password" required class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Password</button>
        </form>
    </div>
</x-guest-layout>
