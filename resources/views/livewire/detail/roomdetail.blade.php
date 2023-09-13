<div class="flex-col">
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Room detail</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-2 md:row-span-2">
                        <div>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="shrink-0 col-span-1 flex items-center justify-center">
                                    <img id='preview_img' class="h-24 w-24 object-cover rounded-full"
                                        src="{{ $image ? $image->temporaryUrl() : $imageUrl}}"
                                        alt="Current profile photo" />
                                </div>
                                <label class="col-span-1 flex items-center justify-center">
                                    <input type="file" wire:model="image" class="cursor-pointer block w-56 text-sm text-slate-500
                                                            file:mr-4 file:py-2 file:px-4
                                                            file:rounded-full file:border-0
                                                            file:text-sm file:font-semibold
                                                            file:bg-violet-50 file:text-violet-700
                                                            hover:file:bg-violet-100
                                                            " />
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label>Name</label>
                        <input type="text" placeholder="Your room name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='name' />
                    </div>
                    
                    <div class="md:col-span-2">
                        <label>Grade</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='grade' />
                    </div>
                    
                    <div class="md:col-span-2">
                        <label>Teacher</label>
                        <select wire:model='selectedTeacher'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedTeacher)
                            <option selected hidden>You haven't selected yet</option>
                            @endif
                            @foreach ($teachers as $teacher)
                            <option {{ $selectedTeacher==$teacher['value'] ? 'selected' : '' }} value="{{$teacher['value']}}">
                                {{$teacher['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label>Search teacher's name contain</label>
                        <input type="text" placeholder="Find teacher's name you want"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model.debounce.1500ms='teacherName' />
                    </div>
                    
                </div>
                <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                    <div class="md:col-span-2 flex grid-cols-2 gap-2">
                        <button wire:click='save'
                            class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                            <i class="fa-regular fa-floppy-disk fa-xl"></i>
                            <p>Save</p>
                        </button>
                        <button wire:click='formGenerate'
                            class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                            <p>Cancel</p>
                        </button>
                    </div>
                </div>

                <div class="relative pt-5">
                    <div class="flex items-center justify-center gap-2 absolute top-1/2 right-0 text-sm">
                        <div wire:click='changeTeacherState'
                            class="flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                            <span class="rounded-md pl-4 font-bold -mr-2">Teacher</span>
                            <button class="p-5 flex items-center justify-center rounded-full">
                                @if ($isTeachersOpen)
                                <i class="fa-solid fa-caret-down fa-rotate-180 fa-xl"></i>
                                @else
                                <i class="fa-solid fa-caret-down fa-xl"></i>
                                @endif
                            </button>
                        </div>
                        <div wire:click='changeStudentState'
                            class="flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                            <span class="rounded-md pl-4 font-bold -mr-2">Student</span>
                            <button class="p-5 flex items-center justify-center rounded-full">
                                @if ($isStudentsOpen)
                                <i class="fa-solid fa-caret-down fa-rotate-180 fa-xl"></i>
                                @else
                                <i class="fa-solid fa-caret-down fa-xl"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-transparent h-10"></div>

    <div {{ $isTeachersOpen ? '' : 'hidden' }}>
        <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                <div class="">
                    <div class="text-center pb-4">
                        <h6
                            class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                            Teachers</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">

                        <div class="md:col-span-2 md:row-span-3">
                            <label for="full_name">Teacher list</label>
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
                                            <div>
                                                <button
                                                    class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                                    wire:click="deleteSubjectTeacher({{$roomTeacher['value']}})" type="button"><i class="fa-solid fa-eraser"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="md:col-span-2">
                            <label >Subject</label>
                            <select wire:model='selectedSubject'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (!$selectedSubject)
                                    <option selected hidden>
                                        Select subject</option>
                                @endif
                                @foreach ($subjects as $subject)
                                <option {{ $subject['value'] === $selectedSubject ? 'selected' : '' }}
                                    value="{{ $subject['value'] }}">
                                    {{$subject['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label >Subject teacher</label>
                            <select wire:model='selectedSubjectTeacher'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (!$selectedSubjectTeacher)
                                    <option selected hidden>
                                        Select teacher
                                    </option>
                                @endif
                                @foreach ($subjectTeachers as $subjectTeacher)
                                <option {{ $subjectTeacher['value']===$selectedSubjectTeacher ? 'selected' : '' }} value="{{ $subjectTeacher['value'] }}">
                                    {{$subjectTeacher['name']}}</option>
                                @endforeach
                                
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <button wire:click='addSubjectTeacher'
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-user-plus"></i>
                                <p>Add</p>
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="bg-transparent h-6"></div>
    </div>

    <div {{ $isStudentsOpen ? '' : 'hidden' }}>
        <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                <div class="">
                    <div class="text-center pb-4">
                        <h6
                            class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                            Students</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">

                        <div class="md:col-span-2 md:row-span-2">
                            <label for="full_name">Student list</label>
                            <ul class="max-w divide-y divide-gray-200 max-h-36 overflow-auto">
                                @foreach ($roomStudents as $student)
                                <li class="py-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="{{$student['image_url']}}" alt="Neil image">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ $student['name'] }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                {{ $student['email'] }}
                                            </p>
                                        </div>
                                        <div>
                                            <button
                                                class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                                wire:click="deleteStudent({{$student['value']}})" type="button"><i class="fa-solid fa-eraser"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label>Student</label>
                            <select wire:model='selectedStudent'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (!$selectedStudent)
                                <option selected hidden>
                                    Select student
                                </option>
                                @endif
                                @foreach ($students as $student)
                                <option {{ $student['value']===$selectedStudent ? 'selected' : '' }}
                                    value="{{ $student['value'] }}">
                                    {{$student['name']}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <button wire:click='addStudent'
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-user-plus"></i>
                                <p>Add</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>