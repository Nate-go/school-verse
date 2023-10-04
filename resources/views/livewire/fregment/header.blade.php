<div>
    <nav class="{{ $headerIsLock ? " w-full block bg-opacity-80 border bg-white border-white/80 px-4 bg-red rounded-xl
        transition-all top-4 z-40 py-3 shadow-md"
        : 'fixed top-4 md:w-[calc(100%-20rem)] w-[calc(100%-2rem)] block backdrop-saturate-200 backdrop-blur-2xl bg-opacity-80 border border-white/80 max-w-full  px-4 bg-white rounded-xl transition-all z-40 py-3 shadow-md'
        }}">
        <div class="flex justify-between">
            <div
                class="capitalize antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-dark text-center justify-content-between flex">
                @foreach ($urls as $url)
                    @if (!$loop->last)
                        <a href={{$url['url']}}><p class="pt-1.5 text-slate-400 hover:text-blue-600 cursor-pointer">{{$url['name']}}/</p></a>
                    @else
                        <p class="pt-1.5">{{$url['name']}}</p>
                    @endif
                @endforeach
            </div>
            <div class="flex items-center">
                
                <livewire:fregment.userinfomation />
    
                <button
                    class="hover:bg-slate-200 md:hidden text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xl hover:text-blue-400 active:text-blue-500"
                    wire:click="$emit('displaySidebar')" type="button">
                    @if ($sidebarIsDisplay)
                        <i class="fa-solid fa-xmark"></i>
                    @else
                        <i class="fa-solid fa-bars"></i>
                    @endif
                </button>

                <livewire:fregment.notifytable />
    
            </div>
        </div>
    </nav>
    <div {{ $headerIsLock ? 'hidden' : '' }} class='h-16 bg-transparent'>
    
    </div>

</div>


