<!DOCTYPE html>
<html lang="en">

@livewire('head', ['name' => 'rooms'])

<body>
    <div id='root' class='bg-slate-300'>
        <div class='min-h-screen'>
            @livewire('fregment.sidebar')
            <div class="p-4 md:ml-72">
                @livewire('fregment.header')
                <main class='overflow-x-hidden mt-6 flex flex-col gap-4 overflow-visible min-h-screen'>    
                    <a href="rooms/create"
                        class="cursor-pointer bg-blue-600 hover:bg-blue-500 gap-2 text-white font-bold py-2 px-3 rounded inline-flex items-center w-fit">
                        <i class="fa-regular fa-square-plus fa-lg"></i>
                        <span>Add room</span>
                    </a>                
                    @livewire('table.roomtable', ['tableSource' => $tableSource])
                </main>
            </div>
        </div>
        <livewire:fregment.settingbutton/>
    </div>
    @livewireScripts
    @livewire('foot')
</body>
</html>
