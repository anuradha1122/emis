<div class="p-4">
    <div class="relative">
        <input
            class="appearance-none border pl-10 border-gray-300 hover:border-gray-400 transition-colors rounded-md w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-blue-600 focus:border-blue-600 focus:shadow-outline"
            name="search" id="search" wire:model.live="search" type="text" placeholder="Search..." autocomplete="off" />
        <div class="absolute right-0 inset-y-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-5 w-5 text-gray-400 hover:text-gray-500"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <div class="absolute left-0 inset-y-0 flex items-center">
            <button class=" hover:text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 text-gray-400 hover:text-gray-500"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="flex w-full my-4">

        <div class="bg-white w-full shadow-sm border border-gray-200 rounded-lg p-1">
            <ul class="space-y-1">
                @foreach ($searchResults as $principal)
                <li class="p-2 rounded-md bg-gray-100 duration-300 flex items-center gap-2">
                    <img src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1114445501.jpg"
                        alt="" class="w-12 h-12 rounded-full" />
                    <a href="{{ route('principal.profile', ['id' => $principal->usId ]) }}" class=" w-full">
                        <div>
                            <span class="font-medium block">{{ $principal->name }}</span>
                            <span class="text-gray-600 text-sm">{{ $principal->nic }}</span>
                        </div>
                    </a>
                </li>
                @endforeach

            </ul>
        </div>

    </div>

</div>