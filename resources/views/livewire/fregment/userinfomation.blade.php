<div>
    <button
        class="hover:bg-slate-200 text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-lg hover:text-blue-400 active:text-blue-500"
        wire:click="$emit('displayUserInfo')" type="button"><i class="fa-solid fa-user"></i>
    </button>

    @if ($userInfoIsOpen)
        <div class="">
            <ul
                class="absolute top-14 right-24 bg-white min-w-[180px] p-3 border-blue-gray-50 rounded-md shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 overflow-auto focus:outline-none z-[999] w-max border-0">
                <li
                    class="w-full pt-[9px] pb-2 px-3 rounded-md text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900 flex items-center gap-3">
                    <img src="{{Auth::user()->image_url ?? ''}}"
                        class="inline-block relative object-cover object-center !rounded-full w-9 h-9">
                    <div>
                        <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 mb-1 font-normal">
                            <strong>{{Auth::user()->username}}</strong>
                        </p>
                    </div>
                </li>
                <li
                    class="hover:bg-slate-100 block w-full pt-[9px] pb-2 px-3 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900">
                    <a href="{{ $isAdmin ? '/users/' . str(Auth::user()->id) : '/users'}}">
                        <i class="fa-solid fa-address-card pr-2"></i>Account setting
                    </a>
                </li>
                
                
                <li
                    class="hover:bg-slate-100 block w-full pt-[9px] pb-2 px-3 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900">
                    <a href="/logout">
                        <i class="fa-solid fa-right-from-bracket pr-2"></i>Logout
                    </a>
                </li>
                
        
            </ul>
        </div>
    @endif
    
</div>

