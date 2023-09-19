<div class="flex-col">
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Subject detail</h6>
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
                        <label>Name</label>
                        <input type="text" placeholder="Your room name"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='name' />
                    </div>

                    <div class="md:col-span-2">
                        <label>Grade</label>
                        <input type="text" readonly class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                            wire:model='grade' />
                    </div>

                    <div class="md:col-span-2">
                        <label>Coefficient</label>
                        <input wire:model='coefficient' type="number" placeholder=""
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" />
                    </div>

                    <div class="md:col-span-2">
                        <label>Number of lesson</label>
                        <input wire:model='numberOfLesson' type="number" placeholder=""
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" />
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
            </div>
        </div>
    </div>
</div>
