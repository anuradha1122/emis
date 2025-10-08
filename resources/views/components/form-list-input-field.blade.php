@props(['id', 'name', 'options', 'selected' => null])

<div class="mt-1">
    <select name="{{ $name }}" id="{{ $id }}" autocomplete="{{ $name }}"
        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm
               ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
        {{ $attributes->merge(['required' => $attributes->get('required', false)]) }}>
        <option value="">Choose...</option>
        @foreach($options as $option)
            <option value="{{ $option->id }}" {{ $option->id == $selected ? 'selected' : '' }}>
                {{ $option->name }}
            </option>
        @endforeach
    </select>
</div>

