<div class="flex-col">
    <div wire:loading>
        @livewire('fregment.loading')
    </div>
    <div class="relative bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div
            class="absolute top-2 right-1 flex items-center bg-white rounded-full p-1 hover:text-blue-600 cursor-pointer">
            <button class="px-3 pt-1 flex items-center justify-center rounded-full text-xl" wire:click="close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Exam action</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                    <div class="md:col-span-2">
                        <label>Content</label>
                        <input type="text" placeholder="enter content" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='content' />
                    </div>
                    <div class="md:col-span-2">
                        <label>Type</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            value="{{$exam['type']['name']}}" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Student in class</label>
                        <select wire:model='selectedStudent'
                            class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1 w-full">
                            @if (!$selectedStudent)
                                <option selected hidden>
                                    Selelect to add student</option>                             
                            @endif  
                            <option value="-1">
                                All</option>
                            @foreach ($studentInRooms as $student)
                            <option
                                value="{{$student['studentId']}}">
                                {{$student['studentName']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label>Action</label>
                        <form wire:submit.prevent="import" class="flex gap-1 items-center">
                            <input type="file" wire:model="csvFile">
                            <button type="submit"
                                class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center h-10 border mt-1">
                                <i class="fa-solid fa-upload"></i>
                                <p>Import</p>
                            </button>
                        </form>
                    </div>

                    <div class="md:col-span-4 max-h-96 overflow-auto px-1">
                        <table class="w-full min-w-[640px] table-autos">
                            <thead class="sticky top-0 z-20">
                                <tr class='bg-slate-100'>
                                    <th class="pl-2 border-b border-blue-gray-50 py-3 px-2 text-left">
                                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                            Student</p>
                                    </th>

                                    <th class="border-b border-blue-gray-50 py-3 px-2 text-center">
                                        <p
                                            class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                            Score</p>
                                    </th>
                                    <th class="border-b border-blue-gray-50 py-3 px-2 text-center">
                                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                            Review</p>
                                    </th>
                                    <th class="border-b border-blue-gray-50 py-3 px-2 text-center">
                                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                                            Delete</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="overflow-y-auto">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($body as $item)
                                <tr class='{{ $count%2 === 1 ? ' bg-slate-100' : '' }} hover:bg-blue-100'>
                                    <td class="cursor-pointer pl-2 py-3 px-5 border-b border-blue-gray-50 {{ $item['isMissing'] ? 'bg-red-500 text-white' : ''}}">
                                        <div class="flex gap-2 items-center ">
                                            <img class="w-6 h-6 rounded-full"
                                                src="{{$item['studentImage'] ?? asset('storage/images/default-image.png')}}">
                                            <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                {{ $item['studentName'] ?? 'null'}}
                                            </p>
                                        </div>
                    
                                    </td>
                                    <td class="py-3 px-5 border-b border-blue-gray-50">
                                        <div class="py-1 px-1.5 rounded-md text-center">
                                            <input {{ $enable ? '': 'readonly'}} oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                class="w-10 h-6 px-1 rounded-md bg-transparent" type="text" wire:model='body.{{$count}}.score'>
                                        </div>
                    
                                    </td>

                                    <td class="py-3 px-5 border-b border-blue-gray-50">
                                        <div class="py-1 px-1.5 rounded-md text-center bg-transparent">
                                            <textarea {{ $enable ? '': 'readonly'}} class="rounded-md h-30 border mt-1 px-2 w-full pt-1 bg-transparent"
                                                rows="3" wire:model='body.{{$count}}.review'></textarea>
                                        </div>
                                    
                                    </td>
                    
                                    <td class="py-3 px-5 flex justify-center items-center h-max">
                                        <button wire:click='deleteStudent({{$item['studentId']}})'
                                            class="hover:bg-slate-200 text-center uppercase transition-all w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400"
                                            type="button"><i class="fa-solid fa-eraser"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php
                                    $count += 1;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($enable)
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
                    
                    
                        <div class="md:col-span-2">
                            <button wire:click='delete'
                                class="col-span-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded gap-2 flex items-center">
                                <i class="fa-solid fa-eraser"></i>
                                <p>Delete</p>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex pt-5 gap-2 gap-y-2 text-sm grid-cols-1 md:grid-cols-4">
                        Overtime to do anything
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>