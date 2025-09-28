<li class="flex items-center font-sans text-sm antialiased font-normal leading-normal transition-colors duration-300 cursor-pointer text-blue-gray-900 hover:text-light-blue-500">
    <a href="{{ $link }}" class="opacity-60">
        {{ $name }}
    </a>
    @if ($link <> "#")
        <span
            class="mx-2 font-sans text-sm antialiased font-normal leading-normal pointer-events-none select-none text-blue-gray-500">
            /
        </span>
    @endif
</li>