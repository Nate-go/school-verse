<div class="flex-col">
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Account</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                    <div class="md:col-span-2">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='email' placeholder="email@domain.com" />
                    </div>
    
                    <div class="md:col-span-2">
                        <label for="full_name">Password</label>
                        <input type="text" 
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='password' />
                    </div>
    
                    <div class="md:col-span-2">
                        <label for="address">User name</label>
                        <input type="text"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='username' placeholder="" />
                    </div>
    
                    <div class="md:col-span-1">
                        <label for="country">Role</label>
                        <select wire:change='changeRole($event.target.value)' name="" id=""
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            <option {{$isTeacher ? 'selected' : ''}} value="1">Teacher</option>
                            <option {{$isTeacher ? '' : 'selected'}} value="2">Student</option>
                        </select>
                    </div>
    
                    <div class="md:col-span-1">
                        <label for="state">Status</label>
                        <select wire:model='status'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @foreach ($statuses as $status)
                                <option {{ $status === $status['value'] ? 'selected' : '' }} value="{{$status['value']}}">{{$status['name']}}</option>
                            @endforeach
                        </select>
                    </div>
    
                </div>
                <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                    <div class="md:col-span-2 flex grid-cols-2 gap-2">
                        <button wire:click='createAccount'
                            class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                            <i class="fa-solid fa-user-plus"></i>
                            <p>Add</p>
                        </button>
                        <button wire:click='accountFormGenerate'
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
    
                <div class="relative pt-5">
                    <div class="flex items-center justify-center gap-2 absolute top-1/2 right-0 text-sm">
                        <div wire:click='changeProfileState' 
                            class="flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                            <span class="rounded-md pl-4 font-bold -mr-2">Profile</span>
                            <button class="p-5 flex items-center justify-center rounded-full">
                                @if ($isProfileOpen)
                                    <i class="fa-solid fa-caret-down fa-rotate-180 fa-xl"></i>
                                @else
                                    <i class="fa-solid fa-caret-down fa-xl"></i>
                                @endif
                            </button>
                        </div>
                        <div wire:click='changeMoreActionState' 
                            class="flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                            <span class="rounded-md pl-4 font-bold -mr-2">More Action</span>
                            <button class="p-5 flex items-center justify-center rounded-full">
                                @if ($isMoreActionOpen)
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

    <div {{ $isProfileOpen ? '' : 'hidden'}}>
        <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
            <div wire:click='profileFormGenerate'
                class="absolute top-5 right-1 flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                <span class="rounded-md pl-4 -mr-2 text-base">refresh</span>
                <button class="px-3 pt-1 flex items-center justify-center rounded-full text-xs">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                <div class="">
                    <div class="text-center pb-4">
                        <h6
                            class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                            Profile</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
        
                        <div class="md:col-span-3">
                            <label for="full_name">Address</label>
                            <input type="text" name="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                wire:model='address' />
                        </div>
        
                        <div class="md:col-span-2">
                            <label for="country">Gender</label>
                            <select name="gender" id="" wire:model='gender'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @foreach ($genders as $gender)
                                <option {{ $gender['value']===$gender ? 'selected' : '' }} value="{{ $gender['value'] }}">
                                    {{$gender['name']}}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <div class="md:col-span-3">
                            <label>Phonenumber</label>
                            <input type="text" name="phonenumber" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                wire:model='phoneNumber' class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                placeholder="" />
                        </div>
        
                        <div class="md:col-span-2">
                            <label>Date of birth</label>
                            <input type="date" name="dateOfBirth" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                wire:model='dateOfDate' placeholder="" />
                        </div>
        
                    </div>
        
                </div>
            </div>
        </div>
        
        <div class="bg-transparent h-6"></div>
    </div>
    
    <div {{ $isMoreActionOpen ? '' : 'hidden'}}>
        <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
            <div wire:click='moreactionFormGenerate'
                class="absolute top-5 right-1 flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                <span class="rounded-md pl-4 -mr-2 text-base">refresh</span>
                <button class="px-3 pt-1 flex items-center justify-center rounded-full text-xs">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                <div class="">
                    <div class="text-center pb-4">
                        <h6
                            class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                            More action</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
        
                        <div class="md:col-span-1 flex-col">
                            <label for="full_name">Role</label>
                            <input disabled type="text" name="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                value="{{ $isTeacher ? 'Teacher' : 'Student'}}" />
                        </div>
        
                        <div class="md:col-span-2">
                            <label for="country">Grade</label>
                            <select name="" id="" wire:change="selectGrade($event.target.value)"
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                <option hidden selected>{{ implode(', ', $selectedGradeNames) }}</option>
                                @foreach ($grades as $grade)
                                <option class="{{ in_array($grade['id'], $selectedGrades) ? 'bg-green-500' : '' }}"
                                    value="{{$grade['id']}}">{{$grade['name']}}</option>
                                @endforeach
                            </select>
                        </div>
        
                        @if ($isTeacher)
                        <div class="md:col-span-2">
                            <label for="country">Subjects</label>
                            <select wire:change="selectSubject($event.target.value)" name="" id=""
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (empty($selectedGrades))
                                <option hidden selected>{{'Select grade(s) to select subject'}}</option>
                                @else
                                <option hidden selected>{{ implode(', ', $selectedSubjectNames) }}</option>
                                @foreach ($subjects as $subject)
                                <option class="{{ in_array($subject['id'], $selectedSubjects) ? 'bg-green-500' : '' }}"
                                    value="{{$subject['id']}}">
                                    {{$subject['name']}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @else
        
                        <div class="md:col-span-2">
                            <label for="country">Room</label>
                            <select wire:change='selectRoom($event.target.value)' name="" id=""
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @if (empty($selectedGrades))
                                <option hidden selected>{{'Select grade to select room'}}</option>
                                @else
                                @foreach ($rooms as $room)
                                <option value="{{$room['id']}}" {{($selectedRoom==$room['id']) ? "selected" : '' }}>
                                    {{$room['name']}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

