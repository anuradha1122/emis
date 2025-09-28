<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <x-search-heading heading="PRINCIPAL SEARCH" subheading="search by name,NIC OR telephone" />
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                @livewire('principal-search', ['size' => 'sm:col-span-2'])
            </div>
        </div>
    </div>
</x-app-layout>