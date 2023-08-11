<div class="group fixed bottom-5 right-4 z-10 flex flex-row items-center gap-3 p-3 text-lg">
    <div class="group relative" data-headlessui-state="open">
        <button
            class="p-4 hover:text-blue-400 flex items-center justify-center rounded-full border border-gray-200 bg-gray-50 "
            wire:click="changeSetting"
        >
            <i class="fa-solid fa-gear {{ $isActive ? 'text-blue-600 rotate-90' : ''}} "></i>
        </button>

        @if ($isActive) 
            <div class="absolute bottom-full right-0 z-20 mb-2 w-full min-w-[175px] overflow-hidden rounded-md bg-white pb-1.5 pt-1 outline-none opacity-100 translate-y-0 text-base">
                <a wire:click='scrollToTop' class="flex p-3 items-center gap-3 transition-colors duration-200 cursor-pointer hover:text-blue-600">
                    <i class="fa-solid fa-circle-up"></i>
                    <span>Back to top</span></a>
                <a wire:click="$emit('changeHeaderLock')" class="flex p-3 items-center gap-3 transition-colors duration-200 cursor-pointer hover:text-blue-400">
                    @if ($headerIsLocked)
                        <i class="fa-solid fa-unlock"></i>
                        <span>Header unlock</span>
                    @else
                        <i class="fa-solid fa-lock"></i>
                        <span>Header lock</span>
                    @endif
                </a>
            </div>
        @endif
    </div>
    <script>
        window.addEventListener('scrollToTop', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</div>
