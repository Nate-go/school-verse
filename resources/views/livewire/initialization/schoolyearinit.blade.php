<div class="flex-col">
    <div wire:loading wire:target='create,formGenerate,addAndNext'>
        @livewire('fregment.loading')
    </div>
    <div class="bg-white rounded-xl shadow-lg p-4 px-4 md:p-4">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
            <div class="">
                <div class="text-center pb-4">
                    <h6
                        class="capitalize block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        School year</h6>
                </div>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                    <div class="md:col-span-2">
                        <label>Name</label>
                        <input type="text" placeholder="Your school year name"
                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='name' />
                    </div>

                    <div class="md:col-span-2">
                        <label>Start at</label>
                        <input type="date" name="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='startAt'
                            placeholder="" />
                    </div>

                    <div class="md:col-span-2">
                        <label>End at</label>
                        <input type="date" name="" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" wire:model='endAt'
                            placeholder="" />
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