<div>
    <x-form-input-label for="nic" value="NIC" />

    <x-form-text-input-field
        id="nic"
        name="nic"
        value="{{ old('nic') }}"
        wire:model.live="nic"
    />

    {{-- Validation error --}}
    @error('nic')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

    {{-- NIC existence / format message --}}
    @if ($nicMessage)
        <span class="text-sm {{ $nicExists ? 'text-green-600' : 'text-red-600' }}">
            {{ $nicMessage }}
        </span>
    @endif
</div>
