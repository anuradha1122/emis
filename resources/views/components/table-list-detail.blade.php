<td class="p-4 border-b border-blue-gray-50">
    <div class="flex flex-col space-y-2">
        @foreach ($list as $key => $value)
        <li class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
            <span class="font-medium text-blue-gray-700">{{ ucfirst($key) }}</span>
            <span class="block text-blue-gray-900">
                @if (empty($value))
                    <em>No {{ ucfirst($key) }}</em>
                @elseif (is_array($value))
                    {!! nl2br(e(implode("\n", $value))) !!}
                @else
                    {!! nl2br(e($value)) !!}
                @endif
            </span>
        </li>
        @endforeach
    </div>
</td>
