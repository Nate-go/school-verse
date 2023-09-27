<div class='flex relative'>
    <button
        class="hover:bg-slate-200 text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-lg hover:text-blue-400 active:text-blue-500"
        wire:click.prevent="$emit('displayNotify')" type="button"><i class="fa-solid fa-bell"></i>
    </button>

    @if ($numberOfUnread > 0)
        <div
            class="absolute {{ $numberOfUnread > 5 ? 'top-1 -right-1' : 'top-1 right-1' }} bg-red-600 text-white rounded-full px-1 text-xs">
            {{ $numberOfUnread > 5 ? '5+' : $numberOfUnread}}
        </div>
    @endif

    @if ($notifyIsOpen)
        <div class="">
            <ul tabindex="-1"
                class="absolute top-8 right-7 bg-white min-w-[180px] p-3 border-blue-gray-50 rounded-md shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 overflow-auto focus:outline-none z-[999] w-max border-0 max-h-96">
                @if (empty($notifies))
                    <li
                        class="w-full pt-[9px] pb-2 px-3 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900 flex items-center gap-3">
                        <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 mb-1 font-normal">
                            Empty
                        </p>
                    </li>

                @else
                    @foreach ($notifies as $notify)
                    <li wire:click="readNotify({{$notify['id']}}, '{{str($notify['link'])}}')"
                        class="hover:bg-blue-200 w-72 overflow-auto pt-[9px] pb-2 px-3 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900 flex items-center gap-3">
                        <img src="{{$notify['image']}}" class="inline-block relative object-cover object-center !rounded-full w-10 h-10">
                        <div>
                            <div class="antialiased font-sans text-sm leading-normal text-blue-gray-900 mb-1 font-normal flex justify-between">
                                <p>From {{$notify['fromName']}} </p> 
                                <div class="hover:bg-slate-200 hover:text-blue-500 rounded-md py-1 px-2" wire:click.stop="changeStatus({{$notify['id']}}, {{$notify['status']}})">
                                    @if ($notify['status'] == self::UNSEEN)
                                        <i class="fa-solid fa-envelope fa-lg"></i>
                                    @else
                                        <i class="fa-solid fa-envelope-open fa-lg"></i>
                                    @endif
                                    
                                </div>
                            </div>
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 mb-1 font-normal">
                                {{ $notify['content'] }}
                            </p>
                            @php
                                $time = \Carbon\Carbon::parse($notify['created_at']);
                                $formattedTime = $time->diffForHumans();
                            @endphp
                            <div class="antialiased font-sans text-blue-gray-900 flex items-center gap-1 text-xs font-normal opacity-60">
                                <i class="fa-solid fa-clock"></i>
                                <span>{{$formattedTime}}</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                @endif
                
                
            </ul>
        </div>
    @endif
</div>

