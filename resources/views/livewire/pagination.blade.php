<div class='text-4xl flex justify-center pt-2'>
    @if ($paginator->hasPages())
        <div {{ $paginator->onFirstPage() ? 'disabled' : ''}} class='flex'>
            <button
                class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click='gotoPage(1)'><i class="fa-solid fa-backward-fast"></i>
            </button>
            <button
                class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click='gotoPage({{$paginator->currentPage() - 1}})'><i class="fa-solid fa-backward-step"></i>
            </button>
        </div>
        
        @for ($i = $paginator->currentPage() - 2 >= 1 ? $paginator->currentPage() - 2 : 1; $i <= ($paginator->currentPage() + 2 <= $paginator->lastpage() ? $paginator->currentPage() + 2 : $paginator->lastpage()); $i++)
            <button
                class="{{ $i == $paginator->currentPage() ? 'bg-blue-700 text-white' : 'text-slate-600'}} hover:bg-slate-100  relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click="gotoPage({{$i}})">{{ $i }}</i>
            </button>
        @endfor
        
        <div {{ $paginator->hasMorePages() ? 'disabled' : ''}} class='flex'>
            <button
                class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click='gotoPage({{$paginator->currentPage() + 1}})'><i class="fa-solid fa-backward-step fa-rotate-180"></i></i>
            </button>
            <button
                class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                wire:click='gotoPage({{$paginator->lastpage()}})'><i class="fa-solid fa-backward-fast fa-rotate-180"></i>
            </button>
        </div>
    @endif
    
</div>
