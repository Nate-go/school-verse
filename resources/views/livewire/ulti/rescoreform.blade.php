<div class="flex-col">
    <div wire:loading.delay.longest>
        @livewire('fregment.loading')
    </div>
    <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
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
                            <img class="w-6 h-6 rounded-full"
                                src="{{$data['teacherImage'] ?? asset('storage/images/default-image.png')}}">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $data['teacherName'] }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label>Student</label>
                        <div class="h-10 border mt-1 rounded px-2 w-full bg-gray-50 flex gap-2 items-center">
                            <img class="w-6 h-6 rounded-full"
                                src="{{$data['studentImage'] ?? asset('storage/images/default-image.png')}}">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $data['studentName'] }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label>Content</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            value="{{$data['examContent']}}" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Type</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            value="{{$data['examType']}}" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Subject</label>
                        <div class="h-10 border mt-1 rounded px-2 w-full bg-gray-50 flex gap-2 items-center">
                            <img class="w-6 h-6 rounded-full"
                                src="{{$data['subjectImage'] ?? asset('storage/images/default-image.png')}}">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $data['subjectName'] }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label>Block day</label>
                        @php
                            $dateTime = new DateTime($data['rescored_at']);
                            $value = $dateTime->format('Y-m-d');
                        @endphp
                        <input type="date" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$value}}" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Score</label>
                        <input type="number" placeholder="enter score" min="0" max="100" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='score' />
                    </div>

                    <div class="md:col-span-4 md:row-span-3">
                        <label>Review</label>
                        <textarea
                            class="h-30 border mt-1 rounded px-4 w-full pt-1 bg-gray-50" rows="10"
                            wire:model='review'></textarea>
                    </div>
                </div>

                <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
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
                </div>
            </div>
        </div>
    </div>
</div>