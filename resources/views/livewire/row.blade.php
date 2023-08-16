<tr>
    @foreach ($header as $column)
        <td>
            @php
                $value = $item;
                foreach ($column->attributesName as $attributename) {
                    $value = $value->$attributename;
                    if($value === null) {
                        break;
                    }
                }
            @endphp
            
            @if ($column->type === 0)
                <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{$value ?? 'null'}}</p>
            @else
                <img src="{{$value ?? 'null'}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md">
            @endif
        </td>
    @endforeach
    <td class="py-3 px-5 border-b border-blue-gray-50">
        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">checkbox</p>
    </td>
</tr>