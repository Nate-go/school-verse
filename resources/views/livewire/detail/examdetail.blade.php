<div class="flex-col">
    <div wire:loading.delay.longest>
        @livewire('fregment.loading')
    </div>
    <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div
            class="absolute top-2 right-1 flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
            <button class="px-3 pt-1 flex items-center justify-center rounded-full text-xl" wire:click="closeModal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Exam detail</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">

                    <div class="md:col-span-2">
                        <label>Teacher</label>
                        <div class="h-10 border mt-1 rounded px-2 w-full bg-gray-50 flex gap-2 items-center">
                            <img class="w-6 h-6 rounded-full" src="{{$data['teacherImage'] ?? asset('storage/images/default-image.png')}}">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $data['teacherName'] }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label>Student</label>
                        <div class="h-10 border mt-1 rounded px-2 w-full bg-gray-50 flex gap-2 items-center">
                            <img class="w-6 h-6 rounded-full" src="{{$data['studentImage'] ?? asset('storage/images/default-image.png')}}">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $data['studentName'] }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label>Content</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$data['examContent']}}" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Type</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            value="{{$data['examType']}}" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Subject</label>
                        <div class="h-10 border mt-1 rounded px-2 w-full bg-gray-50 flex gap-2 items-center">
                            <img class="w-6 h-6 rounded-full" src="{{$data['subjectImage'] ?? asset('storage/images/default-image.png')}}">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $data['subjectName'] }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label>Score</label>
                        <input type="number" placeholder="enter score" min="0" max="100" {{ ($isPermissionUpdate and $enable) ? '': 'readonly'}}
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='score' />
                    </div>

                    <div class="md:col-span-4 md:row-span-3">
                        <label>Review</label>
                        <textarea  {{ ($isPermissionUpdate and $enable) ? '': 'readonly'}}
                        class="h-30 border mt-1 rounded px-4 w-full pt-1 bg-gray-50" rows="10" wire:model='review'></textarea>
                    </div>
                </div>

                @if (($isPermissionDelete or $isPermissionUpdate) and $enable)
                    <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                        @if ($isPermissionUpdate)
                        <div class="md:col-span-2 flex grid-cols-2 gap-2">
                            <button wire:click='save'
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-regular fa-floppy-disk"></i>
                                <p>Save</p>
                            </button>
                            <button wire:click='formGenerate'
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                                <p>Cancel</p>
                            </button>
                    
                        </div>
                        @endif
                    
                    
                        @if ($isPermissionDelete)
                        <div class="md:col-span-2">
                            <button wire:click='delete'
                                class="col-span-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-eraser"></i>
                                <p>Delete</p>
                            </button>
                        </div>
                        @endif
                    
                    </div>
                @endif

                @if ($isRescoreable)
                    <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                        <div class="md:col-span-2">
                            <button wire:click='rescore'
                                class="col-span-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-eraser"></i>
                                <p>Rescore</p>
                            </button>
                        </div>
                    </div>
                @endif
                
                
            </div>
        </div>
    </div>
</div>
