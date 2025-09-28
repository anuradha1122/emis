<div class="{{ $size }}">
    <x-form-input-label :for="$name" :value="$label" />
    <x-form-list-input-field :id="$id" :name="$name" :options="$options" autofocus />
    @error($name) <span  class="text-red-500">{{ $message }}</span> @enderror
</div>