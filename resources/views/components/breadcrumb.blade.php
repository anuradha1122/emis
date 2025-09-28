<div>
    <nav class="flex pt-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            @foreach ($items as $label => $url)
                @if (!$loop->last)
                    <li class="inline-flex items-center">
                        <a href="{{ $url }}"
                            class="text-gray-300 dark:text-white-300 hover:text-gray-900 dark:hover:text-white inline-flex items-center">
                            @if ($loop->first)
                                <!-- Home Icon -->
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                            @else
                                <!-- Arrow Icon -->
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endif
                            <span class="text-gray-300 dark:text-white ml-1 md:ml-2 text-sm font-medium"
                                aria-current="page">
                            {{ $label }}
                            </span>
                        </a>
                    </li>
                @else
                    <!-- Current Page -->
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 dark:text-gray-500 ml-1 md:ml-2 text-sm font-medium"
                                aria-current="page">
                                {{ $label }}
                            </span>
                        </div>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>

</div>
