<div
    class="flex flex-col rounded-xl bg-white text-gray-700 shadow-md xl:col-span-2 overflow-visible">

    
    <div
        class="bg-clip-border rounded-xl bg-transparent text-gray-700 shadow-none m-0 flex items-center justify-between p-6 overflow-visible">
        <div>
            <h6
                class="capitalize block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900 mb-1">
                {{ $tableSource['name'] }}</h6>
            <p
                class="antialiased font-sans text-sm leading-normal flex items-center gap-1 font-normal text-blue-gray-600">
                <i class="fa-solid fa-magnifying-glass"></i><strong>{{ $data->lastPage() }}</strong> pages found
            </p>
        </div>
        <div class='flex gap-1'>
            <select class='capitalize antialiased border-2 rounded-md' wire:change="changeColumnSearch($event.target.value)"">
                @foreach ($filterForm['search']['elements'] as $element)
                    @if ($filterForm['search']['value']['element'] === $element['column'])
                        <option selected value="{{ $element['column'] }}" class='capitalize antialiased'>
                            {{$header[$element['column']]['name']}}
                        </option>
                    @else
                        <option value="{{ $element['column'] }}" class='capitalize antialiased'>
                            {{$header[$element['column']]['name']}}
                        </option>
                    @endif
                @endforeach
            </select>
            <select class='antialiased border-2 rounded-md' wire:change='changeTypeSearch($event.target.value)'>
                @foreach ($filterForm['search']['elements'][$filterForm['search']['value']['element']]['types'] as $type)
                    <option {{$filterForm['search']['value']['type']===$loop->index ? 'selected' : ''}} value={{$loop->index}}>
                        {{ucfirst(strtolower($type['name']))}}
                    </option>
                @endforeach
            </select>

            <div class="relative w-full min-w-[120px] h-10">
                <input type="text" value='{{$filterForm['search']['value']['value']}}' wire:input.debounce.1500ms='changeData($event.target.value)'
                    class="border-4 peer w-full h-full bg-transparent text-blue-gray-700 font-sans font-normal outline outline-0 focus:outline-0 disabled:bg-blue-gray-50 disabled:border-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 border-t-transparent focus:border-t-transparent text-sm px-3 py-2.5 rounded-[7px] border-blue-gray-200 focus:border-blue-500"
                    placeholder=" "><label
                    class="flex w-full h-full select-none pointer-events-none absolute left-0 font-normal peer-placeholder-shown:text-blue-gray-500 leading-tight peer-focus:leading-tight peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 transition-all -top-1.5 peer-placeholder-shown:text-sm text-[11px] peer-focus:text-[11px] before:content[' '] before:block before:box-border before:w-2.5 before:h-1.5 before:mt-[6.5px] before:mr-1 peer-placeholder-shown:before:border-transparent before:rounded-tl-md before:border-t peer-focus:before:border-t-2 before:border-l peer-focus:before:border-l-2 before:pointer-events-none before:transition-all peer-disabled:before:border-transparent after:content[' '] after:block after:flex-grow after:box-border after:w-2.5 after:h-1.5 after:mt-[6.5px] after:ml-1 peer-placeholder-shown:after:border-transparent after:rounded-tr-md after:border-t peer-focus:after:border-t-2 after:border-r peer-focus:after:border-r-2 after:pointer-events-none after:transition-all peer-disabled:after:border-transparent peer-placeholder-shown:leading-[3.75] text-blue-gray-400 peer-focus:text-blue-500 before:border-blue-gray-200 peer-focus:before:border-blue-500 after:border-blue-gray-200 peer-focus:after:border-blue-500">
                    Type here</label>
            </div>

        </div>
        @livewire('table.tableaction', ['filterForm' => $filterForm])
    </div>
    <div class=" overflow-x-auto px-0 pt-0 z-10 flex-col table-wrp block max-h-[32.5rem] rounded-b-xl">
        <table class="w-full min-w-[640px] table-autos">
            <thead class="sticky top-0 z-20">
                <tr class='bg-slate-100'>
                    @foreach ($header as $column)
                        @if ($column['sortable'])
                            <th class="border-b border-blue-gray-50 py-3 px-6 text-left cursor-pointer" wire:click="sort({{$loop->index}})">
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
                        @foreach ($header as $column)
                            <td class="py-3 px-5 border-b border-blue-gray-50">
                                @php
                                    $attributeName = $column['attributesName'];
                                    $value = $item->$attributeName;
                                @endphp
                                @switch($column['type'])
                                    @case(App\Constant\HeaderTypes::TEXT_TYPE)
                                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{ $value ?? 'null'}}
                                        </p>
                                    @break
                                    @case(App\Constant\HeaderTypes::TEXTARE_TYPE)
                                        <div class='h-20 w-full'>
                                            <textarea class="h-full w-full resize-none bg-transparent" readonly>{{$value ?? 'null'}}</textarea>
                                        </div>
                                
                                    @break
                                    @case(App\Constant\HeaderTypes::MIX_TYPE)
                                        <div class="flex gap-1 items-center justify-center">
                                            @php
                                                $img_url = $column['attributesName'] . '_image_url';
                                            @endphp
                                            <img src="{{ $item->$img_url ?? ''}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md z-0">
                                            <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600 text-center">{{ $value ?? 'null'}}
                                            </p>
                                        </div>
                                    @break
                                    @default
                                        <img src="{{$value ?? 'null'}}" class="inline-block relative object-cover object-center w-9 h-9 rounded-md z-0">
                                @endswitch
                            </td>
                        @endforeach
                        <td class="py-3 px-5 flex justify-center items-center">
                            <a href="{{$detailUrl . $item->id}}">
                                <button
                                    class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                    type="button"><i class="fa-solid fa-eye"></i>
                                </button>
                            </a>
                            <button
                                class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                wire:click="delete({{$item->id}})" type="button"><i class="fa-solid fa-eraser"></i>
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
