<div>
    <x-form-input-label for='nic' value='NIC' />
    <x-form-text-input-field id="nic" name="nic" value="{{ old('nic') }}" wire:model.live='nic' />
    @error('nic') <span class="text-red-500">{{ $message }}</span> @enderror
    @if ($genderValue)
    <x-form-input-label for="{{$gender}}" value="Gender :{{$gender}}" />
    <x-form-hidden-input-field id="gender" name="gender" value="{{ $genderValue }}" />
    @endif
</div>
    
    
    