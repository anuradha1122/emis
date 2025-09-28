<div class="{{ $size }}">
    <x-form-input-label :for="$name" :value="$label" />
    <x-form-date-input-field :id="$id" :name="$name" :value="$value" />
    @error($name) <span  class="text-red-500">{{ $message }}</span> @enderror
</div>
