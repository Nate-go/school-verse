<div class="flex-col">
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Room detail</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-7">
                    <div class="md:col-span-2 md:row-span-3">
                        <label> School year: {{ $room['schoolYearName'] }}</label><br>
                        <label> Class: {{ $room['roomName'] }}</label>
                        <div>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="shrink-0 col-span-1 flex items-center justify-center">
                                    <img id='preview_img' class="h-24 w-24 object-cover rounded-full"
                                        src="{{ $room['roomImage'] ?? asset('storage/images/default-image.png') }}"
                                        alt="Current profile photo" />
                                </div>
                                <div class="col-span-1 flex gap-2">
                                    <p>
                                        Homeroom teacher:
                                    </p>
                                    <br>
                                    <img class="w-6 h-6 rounded-full"
                                        src="{{$room['teacherImage'] ?? asset('storage/images/default-image.png')}}">
                                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                        {{ $room['teacherName'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 md:row-span-3">
                        <label> Subject teacher</label><br>
                        <div>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="shrink-0 col-span-1 flex items-center justify-center">
                                    <img id='preview_img' class="h-24 w-24 object-cover rounded-full"
                                        src="{{ $teacher['image'] ?? asset('storage/images/default-image.png') }}"
                                        alt="Current profile photo" />
                                </div>
                                <div class="col-span-1 flex-col gap-2">
                                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500 text-center">
                                        {{'name: ' . $teacher['name'] }}
                                    </p>
                                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500 text-center">
                                        {{'subject: ' . $teacher['subjectName'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-3 md:row-span-3">
                        <label>Teacher list</label>
                        <ul class="max-w divide-y divide-gray-20 max-h-52 overflow-auto">
                            @foreach ($roomTeachers as $roomTeacher)
                            <li class="py-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full" src="{{$roomTeacher['image_url']}}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $roomTeacher['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $roomTeacher['email'] }}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $roomTeacher['subject'] }}
                                    </div>
                                </div>
                    
                            </li>
                            @endforeach
                    
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="bg-transparent h-10"></div>

    <div class="flex-col">
        <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                <div class="">
                    <div class="text-center pb-4">
                        <h6
                            class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                            Exam create</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
    
                        <div class="md:col-span-2">
                            <label>Exam Type</label>
                            <select wire:model='selectedExamType'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (!$selectedExamType)
                                <option selected hidden>You haven't selected yet</option>
                                @endif
                                @foreach ($examTypes as $examType)
                                <option {{ $selectedExamType==$examType['value'] ? 'selected' : '' }} value="{{$examType['value']}}">
                                    {{$examType['name']}}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="md:col-span-2">
                            <label>Student(s)</label>
                            <select wire:model='selectedStudent'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (!$selectedStudent)
                                <option selected hidden>You haven't selected yet</option>
                                @endif
                                <option {{ $selectedStudent==-1 ? 'selected' : '' }} value="-1">
                                    All</option>
                                @foreach ($students as $student)
                                <option {{ $selectedStudent==$student['studentId'] ? 'selected' : '' }} value="{{$student['studentId']}}">
                                    {{$student['studentName']}}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="md:col-span-2">
                            <label>Action</label>
                            <button wire:click='createExam'
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center h-10 border mt-1">
                                <i class="fa-regular fa-floppy-disk fa-xl"></i>
                                <p>Create</p>
                            </button>
                        </div>
    
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="bg-transparent h-10"></div>

    <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4 overflow-auto">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Subject teacher</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-3">

                    <div class="md:col-span-3">
                        @if (!empty($header) and !empty($body))
                        <table class="w-full min-w-[640px] table-autos">
                            <thead class="sticky top-0 z-20">
                                <tr class='bg-slate-100'>
                                    <th class="pl-2 border-b border-blue-gray-50 py-3 px-2 text-left">
                                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                            Student</p>
                                    </th>
                    
                                    @foreach ($header as $column)
                                    <th class="border-b border-blue-gray-50 py-3 px-2 text-left">
                                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                            {{$column['name']}}</p>
                                    </th>
                                    @endforeach
                    
                                    <th class="border-b border-blue-gray-50 py-3 px-2 text-center">
                                        <p
                                            class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                            Final score</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="overflow-y-auto">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($body as $item)
                                <tr class='{{ $count%2 === 1 ? ' bg-slate-100' : '' }} hover:bg-blue-100'>
                                    <td class="cursor-pointer pl-2 py-3 px-5 border-b border-blue-gray-50"
                                        wire:click="changeToStudentView({{$item['student']['studentId']}})">
                                        <div class="flex gap-2s">
                                            <img class="w-6 h-6 rounded-full"
                                                src="{{$item['student']['studentImage'] ?? asset('storage/images/default-image.png')}}">
                                            <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                {{ $item['student']['studentName'] ?? 'null'}}
                                            </p>
                                        </div>
                    
                                    </td>
                                    @foreach ($header as $column)
                                    <td class="py-3 px-5 border-b border-blue-gray-50">
                                        @if (empty($item['scores']))
                                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                    
                                        </p>
                                        @else
                                        <div class="flex gap-1">
                                            @foreach ($item['scores'] as $score)
                                                @if ($score['type'] == $column['value'])
                                                <div class="py-1 px-1.5 bg-blue-300 rounded-md cursor-pointer">
                                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                        {{ $score['score'] }}
                                                    </p>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        @endif
                    
                                    </td>
                                    @endforeach
                    
                                    <td class="py-3 px-5 border-b border-blue-gray-50">
                                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                            {{ $item['totalScore'] }}
                                        </p>
                                    </td>
                                </tr>
                                @php
                                    $count += 1;
                                @endphp
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
</div>