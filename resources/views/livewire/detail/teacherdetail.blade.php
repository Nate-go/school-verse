<div>
    <div class="bg-white rounded-xl shadow-lg p-4 px-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Filter</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-2 md:row-span-2">
                        <div>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="shrink-0 col-span-1 flex items-center justify-center">
                                    <img id='preview_img' class="h-24 w-24 object-cover rounded-full"
                                        src="{{ $imageUrl ?? asset('storage/images/default-image.png') }}"
                                        alt="Current profile photo" />
                                </div>
                                <label class="col-span-1 flex items-center justify-center">
                                    <p>{{ $username }}</p>
                                </label>
                            </div>
                        </div>
                    </div>
    
                    <div class="md:col-span-2">
                        <label>Grade</label>
                        <select wire:model='selectedGrade'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedGrade)
                            <option selected hidden>You haven't selected yet</option>
                            @endif
                            @foreach ($grades as $grade)
                            <option {{ $selectedGrade==$grade['value'] ? 'selected' : '' }}
                                value="{{$grade['value']}}">
                                {{$grade['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label>Class</label>
                        <select wire:model='selectedRoom'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedRoom)
                            <option selected hidden>You haven't selected yet</option>
                            @endif
                            @foreach ($rooms as $room)
                                @if ($room['value'] == -1 or $room['grade'] == $selectedGrade or $selectedGrade == -1)
                                    <option {{ $selectedRoom==$room['value'] ? 'selected' : '' }} value="{{$room['value']}}">
                                        {{$room['name']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label>Subject</label>
                        <select wire:model='selectedSubject'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedSubject)
                            <option selected hidden>You haven't selected yet</option>
                            @endif
                            @foreach ($subjects as $subject)
                                @if ($subject['value'] == -1 or $subject['grade'] == $selectedGrade or $selectedGrade == -1)
                                    <option {{ $selectedSubject==$subject['value'] ? 'selected' : '' }} value="{{$subject['value']}}">
                                        {{$subject['name']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label>School year</label>
                        <select wire:model='selectedSchoolYear'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedSchoolYear)
                            <option selected hidden>You haven't selected yet</option>
                            @endif
                            @foreach ($schoolYears as $schoolYear)
                            <option {{ $selectedSchoolYear==$schoolYear['value'] ? 'selected' : '' }} value="{{$schoolYear['value']}}">
                                {{$schoolYear['name']}}</option>
                            @endforeach
                        </select>
                    </div>
    
                </div>
            </div>
        </div>
    </div>

    <div class="bg-transparent h-5"></div>

    <div class="p-5 bg-white rounded-2xl flex-col">
        <div class="">
            <h6 class="block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-2">
                Classes</h6>
            <div class="mt-6 flex overflow-x-auto gap-8 scroll">
                @foreach ($displayRooms as $room)
                <div
                    class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-gray-700 shadow-none min-w-[250px]">
                    <div
                        class="relative bg-clip-border rounded-xl overflow-hidden bg-gray-500 text-white shadow-gray-500/40 shadow-lg mx-0 mt-0 mb-2 h-64 xl:h-40">
                        <img src="{{$room['roomImage'] ?? asset('storage/images/default-image.png')}}"
                            class="h-full w-full object-cover">
                    </div>
                    <div class="pt-2 px-2">
                        <h5
                            class="block antialiased tracking-normal font-sans text-base font-semibold leading-snug text-blue-gray-900 mt-1 mb-2">
                            {{$room['roomName']}}</h5>
                        <div class="flex gap-2">
                            <img class="w-5 h-5 rounded-full" src="{{$room['subjectImage'] ?? asset('storage/images/default-image.png')}}">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{$room['subjectName']}}
                            </p>
                        </div>
                        
                    </div>
                    <div class="p-6 flex items-center justify-between py-4 px-1">
                        <a href="{{ ($room['subjectName'] == 'Homeroom' ? '/homerooms' : '/teacher-rooms') . '/' . $room['id']  }}">
                            <button
                                class="middle none font-sans font-bold center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg border border-blue-500 text-blue-500 hover:opacity-75 focus:ring focus:ring-blue-200 active:opacity-[0.85]"
                                type="button">view room</button></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
