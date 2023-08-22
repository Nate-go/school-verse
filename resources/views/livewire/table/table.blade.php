<div
    class="flex flex-col rounded-xl bg-white text-gray-700 shadow-md xl:col-span-2 overflow-y-hidden">
    <div class='relative flex'>
        @if ($actionIsOpen)
            @livewire('table.tableaction', ['filterForm' => $filterForm, 'selectedCount' => count($selectedItems)])
        @endif
    </div>
    
    <div
        class="bg-clip-border rounded-xl bg-transparent text-gray-700 shadow-none m-0 flex items-center justify-between p-6">
        <div>
            <h6
                class="capitalize block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900 mb-1">
                {{ $tableName }}</h6>
            <p
                class="antialiased font-sans text-sm leading-normal flex items-center gap-1 font-normal text-blue-gray-600">
                <i class="fa-solid fa-magnifying-glass"></i><strong>{{ $data->lastPage() }}</strong> pages found
            </p>
        </div>
        <div class='flex gap-1'>
            <div class='border-2 rounded-md'>
                <select name="" id="" class='capitalize antialiased' wire:change='changeColumnSearch($event.target.value)'>
                    @foreach ($tableHeader as $column)
                        @if ($column['searchable'])
                            @if ($column['attributesName'] === $search['columnName'])
                                <option selected value="{{$column['attributesName']}}" class='capitalize antialiased'>{{$column['name']}}</option>
                            @else
                                <option value="{{$column['attributesName']}}" class='capitalize antialiased'>{{$column['name']}}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
            <div class='border-2 rounded-md'>
                <select name="" id="" wire:change='changeTypeSearch($event.target.value)'>
                    @foreach ($types as $type)
                        @if ($search['type'] === $type)
                            <option selected value="{{$type}}">{{App\Services\ConstantService::getNameConstant(App\Constant\TableSetting::class, $type)}}
                                                    </option>
                        @else
                           <option value="{{$type}}">{{App\Services\ConstantService::getNameConstant(App\Constant\TableSetting::class, $type)}}
                                                </option> 
                        @endif
                    @endforeach
                </select>
            </div>
            <div class='border-2 rounded-md'>
                <input type="text" value='{{$search['data']}}' wire:input.debounce.1500ms='changeData($event.target.value)'>
            </div>
        </div>
        <button
            class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
            wire:click='openAction'><i class="fa-solid fa-ellipsis-vertical text-xl"></i>
        </button>
    </div>
    <div class=" overflow-x-auto px-0 pt-0 z-10 flex-col table-wrp block max-h-[32.5rem]">
        <table class="w-full min-w-[640px] table-autos h-[28rem]">
            <thead class="sticky top-0 z-20">
                <tr class='bg-slate-100'>
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        @php
                            $all = [];
                            foreach ($data as $item) {
                                $all[] = $item->id;
                            }
                        @endphp
                        <div  class="flex antialiased font-sans text-lg font-medium uppercase text-blue-gray-400 items-center gap-2">
                            <i wire:click='selectAll({{json_encode($all)}})' class="fa-solid fa-list-check"></i>  <p>({{count($selectedItems)}})</p>  <i wire:click='unselectAll()' class="fa-solid fa-square-xmark"></i></div>
                    </th>
                    @foreach ($tableHeader as $column)
                        @if ($column['sortable'])
                            <th class="border-b border-blue-gray-50 py-3 px-6 text-left cursor-pointer" wire:click="sort('{{$column['name']}}', '{{$column['attributesName']}}')">
                                <div class='flex items-center justify-center'>
                                    <i class="fa-solid fa-sort pr-2"></i>
                                    <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                        {{$column['name']}}</p>
                                </div>
                            </th>
                        @else
                            <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                    {{$column['name']}}</p>
                            </th>
                        @endif
                    @endforeach
                    
                </tr>
            </thead>
            <tbody class="overflow-y-auto">
                @php
                    $count = 0;
                @endphp
                @foreach ($data as $item)
                    <tr class='{{ $count%2 === 1 ? 'bg-slate-100' : '' }}  cursor-pointer hover:bg-blue-100 max-h-fit'>
                        <td class="py-5 pl-10 border-b border-blue-gray-50 felx justify-center ">
                            <input type="checkbox" {{ in_array($item->id, $selectedItems) ? 'checked' : ''}}
                            wire:change="selectChange({{$item->id}})" class="w-4 h-4 checkbox-info align-middle" />
                        </td>
                        @foreach ($tableHeader as $column)
                        <td class="py-3 px-5 border-b border-blue-gray-50">
                            @php
                            $value = $item[$column['attributesName']];
                            $count += 1;
                            @endphp
                    
                            @if ($column['type'] ===  App\Constant\TableSetting::TEXT_TYPE )
                                <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{$value ?? 'null'}}
                                </p>
                            @else
                                <img src="{{$value ?? 'null'}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md z-0">
                            @endif
                        </td>
                        @endforeach
                        
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="sticky bg-slate-200 rounded-md bottom-0">
                <tr>
                    <th colspan="100%" class="items-center py-1">{{ $data->links('livewire.table.pagination') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
