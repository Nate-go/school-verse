<div
    class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md overflow-hidden xl:col-span-2">
    @if ($actionIsOpen)
        <livewire:tableaction />
    @endif
    <div
        class="relative bg-clip-border rounded-xl overflow-hidden bg-transparent text-gray-700 shadow-none m-0 flex items-center justify-between p-6">
        <div>
            <h6
                class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900 mb-1">
                {{ $tableName }}</h6>
            <p
                class="antialiased font-sans text-sm leading-normal flex items-center gap-1 font-normal text-blue-gray-600">
                <i class="fa-solid fa-magnifying-glass"></i><strong>{{ $data->lastPage() }}</strong> pages found
            </p>
        </div>
        <button
            class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
            wire:click='openAction'><i class="fa-solid fa-ellipsis-vertical text-xl"></i>
        </button>
    </div>
    <div class="p-6 overflow-x-scroll px-0 pt-0 pb-2 z-10 flex-col">
        <table class="w-full min-w-[640px] table-auto">
            <thead>
                <tr>
                    @foreach ($header as $column)
                        <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                            <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                {{$column->name}}</p>
                        </th>
                    @endforeach
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                            select</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($data as $item)
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
                            <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{$value ?? 'null'}}
                            </p>
                            @else
                            <img src="{{$value ?? 'null'}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md">
                            @endif
                        </td>
                        @endforeach
                        <td class="py-3 px-5 border-b border-blue-gray-50">
                            <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">checkbox</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links('livewire.pagination') }}
    </div>
</div>
