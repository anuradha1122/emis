<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="CLASS SETUP" subheading="Class Setup Form" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('school.classstore') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-2 gap-y-4 sm:grid-cols-3">
                        
                        <x-form-number-input-section size="sm:col-span-1" name="grade1" id="grade1" value="0" label="Grade 1" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade2" id="grade2" value="0" label="Grade 2" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade3" id="grade3" value="0" label="Grade 3" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade4" id="grade4" value="0" label="Grade 4" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade5" id="grade5" value="0" label="Grade 5" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade6" id="grade6" value="0" label="Grade 6" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade7" id="grade7" value="0" label="Grade 7" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade8" id="grade8" value="0" label="Grade 8" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade9" id="grade9" value="0" label="Grade 9" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade10" id="grade10" value="0" label="Grade 10" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade11" id="grade11" value="0" label="Grade 11" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade12art" id="grade12art" value="0" label="Grade 12 Art" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade12commerce" id="grade12commerce" value="0" label="Grade 12 Commerce" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade12science" id="grade12science" value="0" label="Grade 12 Science" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade12technology" id="grade12technology" value="0" label="Grade 12 Technology" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade1213years" id="grade1213years" value="0" label="Grade 12-13 Years" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade13art" id="grade13art" value="0" label="Grade 12 Art" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade13commerce" id="grade13commerce" value="0" label="Grade 12 Commerce" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade13science" id="grade13science" value="0" label="Grade 12 Science" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade13technology" id="grade13technology" value="0" label="Grade 12 Technology" />
                        <x-form-number-input-section size="sm:col-span-1" name="grade1313years" id="grade1313years" value="0" label="Grade 12-13 Years" />
                        <x-form-number-input-section size="sm:col-span-1" name="specialedu" id="specialedu" value="0" label="Special Education" />

                
                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Setup" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>