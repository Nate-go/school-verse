<div class="flex-col">
    <div wire:loading wire:target='selectGrades,create,formGenerate,addAndNext'>
        @livewire('fregment.loading')
    </div>
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Student</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">

                    <div class="md:col-span-2">
                        <label>Student</label>
                        <select wire:model='selectedStudent'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedStudent)
                            <option selected hidden>You haven't selected yet</option>
                            @endif
                            @foreach ($students as $student)
                            <option {{ $selectedStudent==$student['id'] ? 'selected' : '' }} value="{{$student['id']}}">
                                {{$student['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label>Search student's name contain</label>
                        <input type="text" placeholder="Find student's name you want"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model.debounce.1500ms='studentName' />
                    </div>

                    <div class="md:col-span-2">
                        <label for="country">Grades</label>
                        <select wire:change="selectGrades($event.target.value)" name="" id=""
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (empty($selectedGrades))
                            <option hidden selected>{{'Select grade(s)'}}</option>
                            @else
                            <option hidden selected>{{ implode(', ', $selectedGradeNames) }}</option>
                            @endif
                            @foreach ($grades as $grade)
                            <option class="{{ in_array($grade['id'], $selectedGrades) ? 'bg-green-500' : '' }}"
                                value="{{$grade['id']}}">
                                {{$grade['name']}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="country">Rooms</label>
                        <select wire:change="selectrooms($event.target.value)" name="" id=""
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (empty($selectedGrades))
                            <option hidden selected>{{'Select grade(s) to select room'}}</option>
                            @else
                            <option hidden selected>{{ empty($selectedRoomNames) ? 'You have not selected room
                                yet' : implode(', ', $selectedRoomNames) }}</option>
                            @foreach ($rooms as $room)
                            <option class="{{ in_array($room['id'], $selectedRooms) ? 'bg-green-500' : '' }}"
                                value="{{$room['id']}}">
                                {{$room['name']}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                </div>
                <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                    <div class="md:col-span-2 flex grid-cols-2 gap-2">
                        <button wire:click='create'
                            class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                            <i class="fa-regular fa-square-plus fa-lg"></i>
                            <p>Add</p>
                        </button>
                        <button wire:click='formGenerate'
                            class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                            <p>Cancel</p>
                        </button>
                    </div>

                    <div class="md:col-span-2">
                        <button wire:click='addAndNext'
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                            <i class="fa-solid fa-caret-right fa-xl"></i>
                            <p>Add and next</p>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>