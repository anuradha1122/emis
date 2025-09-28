<span class="col-span-6">
    <div class="grid grid-cols-6">
        {{-- Heading --}}
        <div class="col-span-1 p-4">
            <p class="pt-4 block font-sans text-sm font-bold leading-normal text-blue-gray-900">
                {{ $heading }}
            </p>
        </div>

        {{-- Values --}}
        <div class="col-span-5 p-4">
            @if (is_array($values))
                <ul class="space-y-2">
                    @foreach ($values as $key => $value)
                        <li class="block font-sans text-sm font-normal leading-normal text-blue-gray-900 p-2 rounded">
                            <span class="font-medium text-blue-gray-100">{{ ucfirst($key) }}:</span>
                            <span class="block text-blue-gray-50">
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
                </ul>
            @else
                <p class="text-white">No values provided.</p>
            @endif
        </div>
    </div>
</span>
