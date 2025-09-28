<div >
    <x-profile-data-detail heading="Guardian Info" :detail="$values" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 2c2.623 0 5.023 1.002 6.828 2.636a3 3 0 00-3.535-.523A6.992 6.992 0 0012 7c-1.631 0-3.13-.523-4.293-1.415a3 3 0 00-3.535.523A9.956 9.956 0 0112 4zm-7 8a8 8 0 1116 0c0 1.336-.33 2.593-.915 3.682A4.998 4.998 0 0012 13a4.998 4.998 0 00-8.085 2.682A7.963 7.963 0 015 12zm2 6c.419 0 .828-.043 1.227-.125C7.806 17.318 7 16.105 7 14.75c0-1.519.884-2.843 2.227-3.409C9.085 11.597 9 10.813 9 10c0-2.485 2.018-4.5 4.5-4.5S18 7.515 18 10c0 .813-.085 1.597-.227 2.341C19.116 11.907 20 13.231 20 14.75c0 1.355-.806 2.568-2.227 3.125.399.082.808.125 1.227.125a6.962 6.962 0 001.85-.257 8.01 8.01 0 01-3.528 2.258 8.021 8.021 0 01-5.242 0 8.01 8.01 0 01-3.528-2.258A6.962 6.962 0 007 18z" />

    {{-- @if(!$edit)
        <x-profile-data-detail heading="{{ $heading }}" :detail="$addressLine1 . '<br>' . $addressLine2 . '<br>' . $addressLine3" function="{{ $function }}" />
    @else
    <form wire:submit.prevent="{{ $formFunction }}" class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-2" enctype="multipart/form-data">
        @csrf
        <div class="sm:col-span-2"> --}}
            {{-- <x-profile-data-input-text inputWire="{{ $inputWire }}" name="{{ $name }}" id="{{ $id }}" /> --}}
        {{-- </div>
        <div class="sm:col-span-2">
            <x-form-button-primary size="" text="Update" modelBinding="click" name="{{ $name }}" />
        </div>
    </form>
    @endif --}}
</div>