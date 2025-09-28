<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />

            <x-search-heading heading="STUDENT REPORTS" subheading="select critaria" />
            <div class="grid grid-cols-1 gap-x-8 gap-y-6">
                @livewire('studentReports')
            </div>
        </div>
    </div>
</x-app-layout>