<td class="p-4 border-b border-blue-gray-50">
    @if($action == 1)
        <a href="{{ isset($params) ? route($link, $params) : route($link) }}"
            class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
            type="button">
            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" aria-hidden="true"
                    class="w-4 h-4">
                    <path
                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                    </path>
                </svg>
            </span>
        </a>
    @else
        <div class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" aria-hidden="true"
                    class="w-4 h-4">
                    <path
                        d="M16.862 3.487a2.625 2.625 0 013.712 3.712L6.925 20.849a5.25 5.25 0 01-2.214 1.32l-2.685.8a.75.75 0 01-.933-.933l.8-2.685a5.25 5.25 0 011.32-2.214L16.862 3.487zM3 3l18 18">
                    </path>
                </svg>
            </span>
        </div>
    @endif
</td>
