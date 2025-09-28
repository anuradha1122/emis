<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="p-1 rounded shadow-md flex justify-end space-x-2">
                
                <x-link-icon-button 
                    :linkId="session('schoolId') ? '' : ($school_detail->id ?? '')"
                    background="bg-red-500"
                    textcolor="text-white"
                    link="school.classprofile"
                    icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                    text="Class Management"
                />
                <x-link-icon-button 
                    background="bg-green-500" 
                    textcolor="text-white" 
                    link="school.search" 
                    icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" 
                    text="6/2021" 
                />
                <x-link-icon-button 
                    background="bg-green-500" 
                    textcolor="text-white" 
                    link="school.search" 
                    icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" 
                    text="DMS" 
                />
            </div>
            
            <x-profile-heading image="" heading="{{ $school_detail->name }}" subHeading="{{ $school_detail->division }}" />
            
            <div class="p-1 px-0 overflow-scroll">
                <table class="w-full mt-4 text-left table-auto min-w-max">
                    <thead>
                    <tr>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Class/Grade
                        </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Count
                        </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Status
                        </p>
                        </th>
                        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
                        <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                        </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($card_pack_1 as $card)
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
                                                d="M3.75 9L12 3.75 20.25 9M4.5 10.5h15M6 20.25h12M9 20.25V14.25m6 6V14.25" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                                {{ $card->name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex flex-col">
                                        <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900 opacity-70">
                                        {{ $card->user_count }}
                                        </p>
                                    </div>
                                </td>
                                
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="flex gap-2">
                                        @if ($card->name == null OR $card->user_count == null)
                                            <div class="rounded-md flex items-center bg-red-100 py-0.5 px-2.5 border border-transparent text-sm text-red-800 transition-all shadow-sm">
                                                <div class="mx-auto block h-2 w-2 rounded-full bg-red-800 mr-2"></div>
                                                Incomplete 
                                            </div>
                                        @else
                                            <div class="rounded-md flex items-center bg-green-100 py-0.5 px-2.5 border border-transparent text-sm text-green-800 transition-all shadow-sm">
                                                <div class="mx-auto block h-2 w-2 rounded-full bg-green-800 mr-2"></div>
                                                Complete
                                            </div>
                                        @endif
                                        
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <button
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                        <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                            class="w-4 h-4">
                                            <path
                                            d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                            </path>
                                        </svg>
                                        </span>
                                    </button>
                                </td>
                            </tr> 
                        @endforeach        
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</x-app-layout>

