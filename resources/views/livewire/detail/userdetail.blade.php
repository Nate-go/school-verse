<div class="flex-col">
    <div wire:loading.delay.longest>
        @livewire('fregment.loading')
    </div>
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        User profile</h6>
                </div>
                
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-2 md:row-span-2">
                        <div>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="shrink-0 col-span-1 flex items-center justify-center">
                                    <img id='preview_img' class="h-24 w-24 object-cover rounded-full"
                                        src="{{$image ? $image->temporaryUrl() : $imageUrl}}"
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
                        <label>Uaername</label>
                        <input type="text" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='username' />
                    </div>

                    <div class="md:col-span-2">
                        <label>Role</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='role' />
                    </div>

                    <div class="md:col-span-2">
                        <label>Email</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='email' />
                    </div>
                    @if ($isAdmin and $role != 'ADMIN')
                        <div class="md:col-span-2">
                            <label>Status</label>
                            <select wire:model='selectedStatus' readonly
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @foreach ($statuses as $status)
                                <option {{ $selectedStatus==$status['value'] ? 'selected' : '' }} value="{{$status['value']}}">
                                    {{$status['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                
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
                        <div wire:click='changePasswordState'
                            class="flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
                            <span class="rounded-md pl-4 font-bold -mr-2">Change Password</span>
                            <button class="p-5 flex items-center justify-center rounded-full">
                                @if ($isChangePasswordOpen)
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

    <div {{ $isProfileOpen ? '' : 'hidden' }}>
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
                            <label >Address</label>
                            <input type="text" name="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                wire:model='address' />
                        </div>
    
                        <div class="md:col-span-2">
                            <label for="country">Gender</label>
                            <select name="gender" id="" wire:model='selectedGender'
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
                            <input type="date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                wire:model='dateOfBirth' placeholder="" />
                        </div>
    
                    </div>
    
                </div>
            </div>
        </div>
    
        <div class="bg-transparent h-6"></div>
    </div>

    <div {{ $isChangePasswordOpen ? '' : 'hidden' }}>
        <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
            <div wire:click='changePasswordFormGenerate'
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
                            Change Password</h6>
                    </div>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                        @if (!$isAdmin)
                        <div class="md:col-span-2">
                            <label>Current password</label>
                            <input type="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='currentPassword' />
                        </div>
                        @endif

                        <div class="{{ $isAdmin ? 'md:col-span-3' : 'md:col-span-2' }}">
                            <label>New password</label>
                            <input type="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='newPassword' />
                        </div>
                    
                        <div class="{{ $isAdmin ? 'md:col-span-3' : 'md:col-span-2' }}">
                            <label>New password again</label>
                            <input type="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='newPasswordAgain' />
                        </div>

                       
                    
                        <div class="md:col-span-2">
                            <button wire:click='saveChangePassword'
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-regular fa-floppy-disk fa-xl"></i>
                                <p>Save new password</p> 
                            </button>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
