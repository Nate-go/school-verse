<div class='text-4xl flex justify-center pt-2'>
    @if ($paginator->hasPages())
        @if ($paginator->currentPage() === 1)
            <button
                class=" bg-neutral-100 relative middle font-sans font-medium text-center uppercase transition-all w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500"
                ><i class="fa-solid fa-backward-fast"></i>
            </button>
            <button
                class=" bg-neutral-100 relative middle font-sans font-medium text-center uppercase transition-all w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500"                ><i class="fa-solid fa-backward-step"></i>
            </button>
        @else
            <button
                class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click="pageChange(1)"><i class="fa-solid fa-backward-fast"></i>
            </button>
            <button
                class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click="pageChange({{$paginator->currentPage() - 1}})"><i class="fa-solid fa-backward-step"></i>
            </button>
        @endif
        
        @for ($i = $paginator->currentPage() - 2 >= 1 ? $paginator->currentPage() - 2 : 1; $i <= ($paginator->currentPage() + 2 <= $paginator->lastpage() ? $paginator->currentPage() + 2 : $paginator->lastpage()); $i++)
            @if ($i === $paginator->currentPage())
                <button
                    class="bg-blue-700 text-white  relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    >{{ $i }}</i>
                </button>
            @else
                <button
                    class="text-slate-600 hover:bg-slate-100  relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    wire:click="pageChange({{$i}})">{{ $i }}</i>
                </button>
            @endif
        @endfor
        
        <div class='flex'>
            @if ($paginator->currentPage() !== $paginator->lastPage())
                <button
                    class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    wire:click="pageChange({{$paginator->currentPage() + 1}})"><i class="fa-solid fa-backward-step fa-rotate-180"></i></i>
                </button>
                <button
                    class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    wire:click="pageChange({{$paginator->lastpage()}})"><i class="fa-solid fa-backward-fast fa-rotate-180"></i>
                </button>
            @else
                <button
                    class="bg-neutral-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 active:bg-blue-gray-500/30"
                    ><i class="fa-solid fa-backward-step fa-rotate-180"></i></i>
                </button>
                <button
                    class="bg-neutral-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 active:bg-blue-gray-500/30"
                    ><i class="fa-solid fa-backward-fast fa-rotate-180"></i>
                </button>
            @endif
            
        </div>
    @endif
    
</div>
