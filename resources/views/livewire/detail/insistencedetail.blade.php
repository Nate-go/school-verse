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
                        Insistence detail</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-2 md:row-span-2">
                        <label>At: {{ $time }}</label>
                        <div>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="shrink-0 col-span-1 flex items-center justify-center">
                                    <img id='preview_img' class="h-24 w-24 object-cover rounded-full"
                                        src="{{ $imageUrl }}"
                                        alt="Current profile photo" />
                                </div>
                                <label class="col-span-1 flex items-center justify-center">
                                    <div>{{ $username }}</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2 md:row-span-3">
                        <label>Content</label>
                        <textarea class="h-30 border mt-1 rounded px-4 w-full bg-gray-50" rows="10" {{ ($isAdmin or $selectedStatus != self::PENDDING) ? 'readonly' : '' }}  wire:model='content'></textarea>
                    </div>

                    <div class="md:col-span-2 md:row-span-3">
                        <label>Feedback</label>
                        <textarea class="h-30 border mt-1 rounded px-4 w-full bg-gray-50" rows="10" {{ $isAdmin ? '' : 'readonly' }} wire:model='feedback'></textarea>
                    </div>

                    <div class="md:col-span-1">
                        <label>Role</label>
                        <input type="text" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $role }}" readonly />
                    </div>
                    
                    <div class="md:col-span-1">
                        <label>Status</label>
                        @if ($isAdmin)
                            <select wire:model='selectedStatus'
                                class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                                @foreach ($statuses as $status)
                                <option {{ $selectedStatus==$status['value'] ? 'selected' : '' }} value="{{$status['value']}}">
                                    {{$status['name']}}</option>
                                @endforeach
                            </select>
                        @else
                            @php
                                $name = '';
                                foreach ($statuses as $status) {
                                    if($status['value'] == $selectedStatus) {
                                        $name = $status['name'];
                                        break;
                                    }
                                }
                            @endphp
                            <input type="text" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ $name }}" readonly />
                        @endif
                        
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

                    @if (!$isAdmin)
                        <div class="md:col-span-2 flex grid-cols-2 gap-2">
                            <button wire:click='delete'
                                class="col-span-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-eraser"></i>
                                <p>Delete</p>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
