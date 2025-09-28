<div >
    @if(!$edit)
        <x-profile-data-detail heading="{{ $heading }}" :detail="$gender" function="{{ $function }}" />
    @else
    <form wire:submit.prevent="{{ $formFunction }}" class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-2" enctype="multipart/form-data">
        @csrf
        <div class="sm:col-span-2">
            {{-- <x-profile-data-input-text inputWire="{{ $inputWire }}" name="{{ $name }}" id="{{ $id }}" /> --}}
        </div>
        <div class="sm:col-span-2">
            <x-form-button-primary size="" text="Update" modelBinding="click" name="{{ $name }}" />
        </div>
    </form>
    @endif
</div>