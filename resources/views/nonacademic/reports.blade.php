<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />

            <x-search-heading heading="TEACHER REPORTS LIST" subheading="select critaria" />
            <div class="p-1 px-0 overflow-scroll">
                <table class="w-full mt-4 text-left table-auto min-w-max">
                    <thead>
                    <tr>
                        <x-table-heading heading="Report Name" />
                        <x-table-heading heading="Report Type" />
                        <x-table-heading heading="" />
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <x-table-icon-text-detail icon="M3.75 9L12 3.75 20.25 9M4.5 10.5h15M6 20.25h12M9 20.25V14.25m6 6V14.25" text="Teacher Full Report" />
                            <x-table-status-detail text="Detailed" textColor="text-green-800" bgColor="bg-green-100" />
                            <x-table-action action="1" link="teacher.fullreportcurrent" />
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
