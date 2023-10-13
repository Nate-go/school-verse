<!DOCTYPE html>
<html lang="en">

@livewire('head', ['name' => 'Statistic'])

<body>
    <div id='root' class='bg-slate-300'>
        <div class='min-h-screen'>
            @livewire('fregment.sidebar')
            <div class="p-4 md:ml-72">
                @livewire('fregment.header')
                <main class='overflow-x-hidden mt-8 mb-8 flex flex-col gap-8 overflow-visible min-h-screen'>                    
                    @livewire('ulti.dashboard')
                </main>
            </div>
        </div>
        <livewire:fregment.settingbutton/>
    </div>
    @livewireScripts
    @livewire('foot')
</body>
</html>
