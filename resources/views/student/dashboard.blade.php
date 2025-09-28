<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="p-1 rounded shadow-md flex justify-end space-x-2">
                <x-link-icon-button background="bg-red-500" textcolor="text-white" link="student.reports" icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" text="Reports" />
                <x-link-icon-button background="bg-green-500" textcolor="text-white" link="student.search" icon="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" text="Search" />
                @if (session('workPlaceCategoryId') == 1 && in_array(session('positionId'), [1, 2, 3]))
                    <x-link-icon-button background="bg-green-500" textcolor="text-white" link="student.register" icon="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" text="Create" />
                @endif
            </div>
            <x-profile-heading image="" heading="{{ session('workPlaceName') }}" subHeading="Student Section" />
            <div class="p-1 px-0 overflow-scroll">
                <table class="w-full mt-4 text-left table-auto min-w-max">
                    <thead>
                    <tr>
                        <x-table-heading heading="Grade\Class" />
                        <x-table-heading heading="Girls" />
                        <x-table-heading heading="Boys" />
                        <x-table-heading heading="Status" />
                        <x-table-heading heading="" />
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($gradeStudents as $card)
                            <tr>
                                <x-table-icon-text-detail icon="M3.75 9L12 3.75 20.25 9M4.5 10.5h15M6 20.25h12M9 20.25V14.25m6 6V14.25" text="{{ $card->name }}" />
                                <x-table-text-detail text="{{ $card->femaleCount }}" />
                                <x-table-text-detail text="{{ $card->maleCount }}" />
                                @if ($card->femaleCount == null OR $card->maleCount == null)
                                    <x-table-status-detail text="Incomplete" textColor="text-red-800" bgColor="bg-red-100" />
                                @else
                                    <x-table-status-detail text="Incomplete" textColor="text-green-800" bgColor="bg-green-100" />
                                @endif
                                <x-table-action action="0" link="" />
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
