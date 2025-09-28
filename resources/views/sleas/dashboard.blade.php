<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="p-1 rounded shadow-md flex justify-end space-x-2">
                <x-link-icon-button background="bg-red-500" textcolor="text-white" link="sleas.reports" icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" text="Reports" />
                <x-link-icon-button background="bg-green-500" textcolor="text-white" link="sleas.search" icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" text="Search" />
                <x-link-icon-button background="bg-green-500" textcolor="text-white" link="sleas.register" icon="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" text="Create" />
            </div>
            <x-profile-heading image="" heading="{{ session('workPlaceName') }}" subHeading="SLEAS Section" />
            <div class="p-1 px-0 overflow-scroll">
                <table class="w-full mt-4 text-left table-auto min-w-max">=
                    <thead>
                    <tr>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Age Gap
                        </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Male SLEAS
                        </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Female SLEAS
                        </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($sleasCounts as $card)
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="relative inline-block h-9 w-9 text-blue-gray-900">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 18H8M6 18V12M10 14H14M12 14V8M16 10H20M18 10V4"
                                            />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                20-30
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->female_20_30 }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->male_20_30 }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="relative inline-block h-9 w-9 text-blue-gray-900">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 18H8M6 18V12M10 14H14M12 14V8M16 10H20M18 10V4"
                                            />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                30-40
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->female_30_40 }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->male_30_40 }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="relative inline-block h-9 w-9 text-blue-gray-900">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 18H8M6 18V12M10 14H14M12 14V8M16 10H20M18 10V4"
                                            />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                40-50
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->female_40_50 }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->male_40_50 }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="relative inline-block h-9 w-9 text-blue-gray-900">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 18H8M6 18V12M10 14H14M12 14V8M16 10H20M18 10V4"
                                            />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                50-55
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->female_50_55 }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->male_50_55 }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="relative inline-block h-9 w-9 text-blue-gray-900">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 18H8M6 18V12M10 14H14M12 14V8M16 10H20M18 10V4"
                                            />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                55-59
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->female_55_59 }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->male_55_59 }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="relative inline-block h-9 w-9 text-blue-gray-900">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 18H8M6 18V12M10 14H14M12 14V8M16 10H20M18 10V4"
                                            />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                59-60
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->female_59_60 }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->male_59_60 }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
