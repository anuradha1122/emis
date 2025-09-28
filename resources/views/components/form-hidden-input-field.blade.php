<input type="hidden" name="{{ $name }}" id="{{ $id }}" 
           {{ $attributes->merge(['required' => $attributes->get('required', false)]) }}>