<tr>
    <x-table-heading-detail heading="{{ $heading }}" d="{{ $d }}" />

    @if (is_array($values))
        <x-table-list-detail :list="$values" />
    @else
        <x-table-text-detail :text="$values" />
    @endif

    @if (is_array($values) && collect($values)->contains(function ($value) {
            if (is_null($value) || $value === '') {
                return true;
            }
            // If $value is an array, check its keys and values
            if (is_array($value)) {
                return collect($value)->contains(function ($innerValue) {
                    return is_null($innerValue) || $innerValue === '';
                });
            }
            return false;
        }))
        <x-table-status-detail text="require" bgColor="bg-red-100" textColor="text-red-800" />
    @else
        <x-table-status-detail text="full" bgColor="bg-green-100" textColor="text-green-800" />
    @endif


    <x-table-action action="{{ $action }}" link="{{ $link }}" :params="$params" />
</tr>
