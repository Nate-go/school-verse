<div class='relative flex'>
    <div wire:loading wire:target='filter'>
        @livewire('fregment.loading')
    </div>
    <button
        class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
        wire:click='openAction'><i class="fa-solid fa-ellipsis-vertical text-xl"></i>
    </button>
    @if ($actionIsOpen)
        <div
            class="w-full absolute top-6 right-6 bg-white min-w-[240px] p-3 border border-blue-gray-50 rounded-md shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 overflow-auto focus:outline-none z-40">
            <ul>
                <li class="flex-col justify-between w-full pt-2 text-start leading-tight transition-all">
                    <p class='text-center antialiased pb-1 text-base font-bold rounded-md bg-blue-100 my-2'>Filter form</p>
                    <ul class='flex-col w-full'>
                        <li class='rounded-md bg-blue-100 my-2 px-2'>
                            <div class='py-1 flex items-center'>
                                <p class='pr-2'>Row per page </p>
                                <input type="number" value="{{$filterForm['perPage']}}"
                                    wire:change="perPageChange($event.target.value)"
                                    class="border h-7 w-14 rounded border-gray-200 sm:text-sm p-2" />
                            </div>
                        </li>
        
                        <li class="w-full">
                            <ul class='overflow-y-auto max-h-[210px] rounded-md bg-blue-100 mt-2 px-2 w-full'>
                                @foreach ($filterForm['filterElements'] as $element)
                                <li class='py-1'>
                                    <p class='text-bold pb-1 text-center capitalize font-bold'>{{ $element['name'] }}</p>
                                    <ul class="grid grid-cols-2 gap-2">
                                        @foreach ($element['resource'] as $item)
                                        <li class='flex items-center'>
                                            <input type="checkbox"
                                                wire:change="filterValueChange({{$loop->parent->index}},{{$loop->index}})"
                                                {{$item['isSelected'] ? 'checked' : '' }} class="checkbox checkbox-info" />
                                            <p class='pl-1 text-xs'>{{$item['name']}}</p>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                <li wire:click="filter"
                    class="hover:bg-slate-100 block w-full py-2 px-3 mt-2 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900">
        
                    <div class='text-center'>
                        <i class="fa-solid fa-filter pr-2"></i></i>Filter
                    </div>
                </li>
            </ul>
        </div>
    @endif
    
</div>


