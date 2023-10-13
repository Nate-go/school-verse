<div>
    <div class="sticky top-0 bg-white p-4 shadow z-40 rounded-2xl">
        <div wire:loading
            >
            @livewire('fregment.loading')
        </div>
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-3">
        
            <div class="md:col-span-3 flex gap-4">
                <div>
                    <label>Change label</label>
                    <button wire:click='changeLabelDisplay'
                        class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center h-10 border mt-1">
                        <i class="fa-solid fa-tags"></i>
                        <p>Display labels</p>
                    </button>
                </div>
                <div>
                    <label>Display student</label>
                    <button wire:click='displayStudent'
                        class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center h-10 border mt-1">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <p>Display student</p>
                    </button>
                </div>
                
            </div>

            <div class="md:col-span-1">
                <label>School years</label>
                <select wire:model='selectedSchoolYear'
                    class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                    <option {{ $selectedSchoolYear==self::ALL ? 'selected' : '' }} value={{self::ALL}}>
                        ALL</option>
                    @foreach ($schoolYears as $schoolYear)
                    <option {{ $selectedSchoolYear==$schoolYear['id'] ? 'selected' : '' }} value="{{$schoolYear['id']}}">
                        {{$schoolYear['name']}}</option>
                    @endforeach
                </select>
            </div>

            @if ($selectedSchoolYear != self::ALL)
                <div class="md:col-span-1">
                    <label>Grades</label>
                    <select wire:model='selectedGrade'
                        class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                        <option {{ $selectedGrade==self::ALL ? 'selected' : '' }} value={{self::ALL}}>
                            ALL</option>
                        @foreach ($grades as $grade)
                        <option {{ $selectedGrade==$grade['id'] ? 'selected' : '' }} value="{{$grade['id']}}">
                            {{$grade['name']}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($selectedGrade != self::ALL)
            <div class="md:col-span-1">
                <label>Classes</label>
                <select wire:model='selectedRoom'
                    class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                    <option {{ $selectedRoom==self::ALL ? 'selected' : '' }} value={{self::ALL}}>
                        ALL</option>
                    @foreach ($rooms as $room)
                    <option {{ $selectedRoom==$room['id'] ? 'selected' : '' }} value="{{$room['id']}}">
                        {{$room['name']}}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
    </div>

    @if ($selectedGrade != self::ALL and $selectedRoom == self::ALL)
        <div class="container mx-auto p-4 sm:p-0 mt-8 rounded-xl">
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="shadow rounded-2xl p-4 border bg-white flex-1" style="height: 32rem;">
                    <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}"
                        :column-chart-model="$columnChartModel" />
                </div>

                <div class="shadow rounded-2xl p-4 border bg-white flex-1" style="height: 32rem;">
                    <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}" :pie-chart-model="$pieChartModel" />
                </div>
            </div>
        </div>
    @else
        <div class="container mx-auto p-4 sm:p-0 mt-8 rounded-xl">
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="shadow rounded-2xl p-4 border bg-white flex-1" style="height: 32rem;">
                    <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}"
                        :column-chart-model="$columnChartModel" />
                </div>
        
                <div class="shadow rounded-2xl p-4 border bg-white flex-1" style="height: 32rem;">
                    <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}" :pie-chart-model="$pieChartModel" />
                </div>
            </div>
        </div>
    @endif

    @if ($displayStudent)
        <div class="bg-transparent h-10"></div>

        <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4 overflow-auto">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                <div class="">
                    <div class="text-center pb-4">
                        <h6
                            class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                            Students</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                        <div class="md:col-span-6">
                            @if (!empty($students) and $students)
                            <table class="w-full min-w-[640px] table-autos">
                                <thead class="sticky top-0 z-20">
                                    <tr class='bg-slate-100'>
                                        <th class="pl-2 border-b border-blue-gray-50 py-3 px-2 text-left">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Student</p>
                                        </th>
        
                                        <th class="border-b border-blue-gray-50 py-3 text-left -z-50">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Schoo year</p>
                                        </th>
        
                                        <th class="border-b border-blue-gray-50 py-3 text-left -z-50">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Class</p>
                                        </th>
        
                                        <th class="border-b border-blue-gray-50 py-3 text-left -z-50">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Final score</p>
                                        </th>
        
                                        <th class="border-b border-blue-gray-50 py-3 text-left -z-50">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Rank</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="overflow-y-auto">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($students as $item)
                                        @if (($selectedRank == self::ALL or $selectedRank == $item['rank']) and ($selectedRoomCompare == self::ALL or $selectedRoomCompare == $item['roomName']))
                                            <tr class='{{ $count%2 === 1 ? ' bg-slate-100' : '' }} hover:bg-blue-100'>
                                                <td class="cursor-pointer pl-2 py-3 px-5 border-b border-blue-gray-50">
                                                    <div class="flex gap-2 items-center">
                                                        <img class="w-6 h-6 rounded-full" src="{{$item['imageUrl'] ?? asset('storage/images/default-image.png')}}">
                                                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                            {{ $item['username'] ?? 'null'}}
                                                        </p>
                                                    </div>
                                            
                                                </td>
                                            
                                                <td class="py-3 border-b border-blue-gray-50">
                                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                        {{ $item['schoolYearName'] }}
                                                    </p>
                                                </td>
                                            
                                                <td class="py-3 border-b border-blue-gray-50">
                                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                        {{ $item['roomName'] }}
                                                    </p>
                                                </td>
                                            
                                                <td class="py-3 border-b border-blue-gray-50">
                                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                        {{ $item['score'] }}
                                                    </p>
                                                </td>
                                            
                                                <td class="py-3 border-b border-blue-gray-50">
                                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                        {{ $item['rank'] }}
                                                    </p>
                                                </td>
                                            </tr>
                                            @php
                                            $count += 1;
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div>Data is empty</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
</div>