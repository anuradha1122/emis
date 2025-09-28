<tr>
    <x-table-heading-detail heading="{{ $heading }}" d="{{ $d }}" />
    
    @if (is_array($detail))
        <x-table-list-detail :list="$detail" />
    @else
        <x-table-text-detail :text="$detail" />
    @endif

    <x-table-status-detail :variable="$detail" />
    <x-table-action />
</tr>