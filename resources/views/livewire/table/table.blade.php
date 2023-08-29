<div
    class="flex flex-col rounded-xl bg-white text-gray-700 shadow-md xl:col-span-2 overflow-visible">
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
            
            <select class='capitalize antialiased border-2 rounded-md' wire:change='changeColumnSearch($event.target.value)'>
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
            <select class='antialiased border-2 rounded-md' wire:change='changeTypeSearch($event.target.value)'>
                @foreach ($types as $type)
                    <option {{ $search['type'] === $type ? 'selected' : '' }} value="{{$type['value']}}">{{ucfirst(strtolower($type['name'])) }}
                    </option>
                @endforeach
            </select>

            <div class="relative w-full min-w-[120px] h-10">
                <input type="text" value='{{$search['data']}}' wire:input.debounce.1500ms='changeData($event.target.value)'
                    class="border-4 peer w-full h-full bg-transparent text-blue-gray-700 font-sans font-normal outline outline-0 focus:outline-0 disabled:bg-blue-gray-50 disabled:border-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 border-t-transparent focus:border-t-transparent text-sm px-3 py-2.5 rounded-[7px] border-blue-gray-200 focus:border-blue-500"
                    placeholder=" "><label
                    class="flex w-full h-full select-none pointer-events-none absolute left-0 font-normal peer-placeholder-shown:text-blue-gray-500 leading-tight peer-focus:leading-tight peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 transition-all -top-1.5 peer-placeholder-shown:text-sm text-[11px] peer-focus:text-[11px] before:content[' '] before:block before:box-border before:w-2.5 before:h-1.5 before:mt-[6.5px] before:mr-1 peer-placeholder-shown:before:border-transparent before:rounded-tl-md before:border-t peer-focus:before:border-t-2 before:border-l peer-focus:before:border-l-2 before:pointer-events-none before:transition-all peer-disabled:before:border-transparent after:content[' '] after:block after:flex-grow after:box-border after:w-2.5 after:h-1.5 after:mt-[6.5px] after:ml-1 peer-placeholder-shown:after:border-transparent after:rounded-tr-md after:border-t peer-focus:after:border-t-2 after:border-r peer-focus:after:border-r-2 after:pointer-events-none after:transition-all peer-disabled:after:border-transparent peer-placeholder-shown:leading-[3.75] text-blue-gray-400 peer-focus:text-blue-500 before:border-blue-gray-200 peer-focus:before:border-blue-500 after:border-blue-gray-200 peer-focus:after:border-blue-500">
                    Type here</label>
            </div>

        </div>
        <button
            class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
            wire:click='openAction'><i class="fa-solid fa-ellipsis-vertical text-xl"></i>
        </button>
    </div>
    <div class=" overflow-x-auto px-0 pt-0 z-10 flex-col table-wrp block max-h-[32.5rem] rounded-b-xl">
        <table class="w-full min-w-[640px] table-autos">
            <thead class="sticky top-0 z-20">
                <tr class='bg-slate-100'>
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        @php
                            $all = [];
                            foreach ($data as $item) {
                                $all[] = $item->id;
                            }
                        @endphp
                        <div  class="flex antialiased font-sans text-sm font-medium uppercase text-blue-gray-400 items-center gap-2">
                            <i wire:click='selectAll({{json_encode($all)}})' class="fa-solid fa-list-check"></i>  <p>({{count($selectedItems)}})</p>  <i wire:click='unselectAll()' class="fa-solid fa-square-xmark"></i></div>
                    </th>
                    @foreach ($tableHeader as $column)
                        @if ($column['name'] === '')
                            @continue
                        @endif
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
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-center">
                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                            Action</p>
                    </th>
                </tr>
            </thead>
            <tbody class="overflow-y-auto">
                @php
                    $count = 0;
                @endphp
                @foreach ($data as $item)
                    <tr class='{{ $count%2 === 1 ? 'bg-slate-100' : '' }}  cursor-pointer hover:bg-blue-100 items-center justify-between'>
                        <td class="py-3 px-5 flex justify-center items-center">
                            <div>
                                <input type="checkbox" {{ in_array($item->id, $selectedItems) ? 'checked' : ''}}
                                wire:change="selectChange({{$item->id}})" class="w-4 h-4 checkbox-info align-middle" />
                            </div>
                        </td>
                        @for ($i=0; $i< count($tableHeader); $i++)
                        <td class="py-3 px-5 border-b border-blue-gray-50">
                            @php
                                $column = $tableHeader[$i];
                                $value = $item[$column['attributesName']];
                                if($column['type'] === App\Constant\TableSetting::USER_TYPE) {
                                    $i += 1;
                                    $newColumn = $tableHeader[$i];
                                    $name = $item[$newColumn['attributesName']]; 
                                }
                            @endphp

                            @switch($column['type'])
                                @case(App\Constant\TableSetting::TEXT_TYPE)
                                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{$value ?? 'null'}}
                                        </p>
                                    @break
                                @case(App\Constant\TableSetting::TEXTARE_TYPE)
                                    <div class='h-20 w-full' >
                                        <textarea class="h-full w-full resize-none bg-transparent" readonly>{{$value ?? 'null'}}</textarea>
                                    </div>
                                    
                                    @break
                                @case(App\Constant\TableSetting::USER_TYPE)
                                    <div class="flex gap-1 items-center">
                                        <img src="{{$value ?? 'null'}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md z-0">
                                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{$name ?? 'null'}}
                                        </p>
                                    </div>
                                    @break
                                @default
                                    <img src="{{$value ?? 'null'}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md z-0">
                            @endswitch
                        </td>
                        @endfor
                        <td class="py-3 px-5 flex justify-center items-center">
                            <button
                                class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                wire:click="" type="button"><i class="fa-solid fa-eye"></i>
                            </button>
                            <button
                                class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                wire:click="" type="button"><i class="fa-solid fa-eraser"></i>
                            </button>
                        </td>
                    </tr>
                    @php
                        $count += 1;
                    @endphp
                @endforeach
            </tbody>
            <tfoot class="sticky bg-slate-200 rounded-b-md bottom-0">
                <tr>
                    <th colspan="100%" class="items-center py-1">{{ $data->links('livewire.table.pagination') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
