<a href="{{ route($link) }}" class="flex items-center w-full p-3 leading-tight transition-all rounded-lg outline-none text-start text-gray-50 hover:bg-gray-300 hover:text-gray-800 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900 overflow-hidden">
    <div class="grid mr-4 place-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-5 h-5">
            <path fill-rule="evenodd" d="{{ $icon }}" clip-rule="evenodd"></path>
        </svg>
    </div>
    <span class="truncate">{{ $name }}</span>
</a>