<aside
        class="z-50 fixed overflow-hidden bg-white my-4 ml-4 h-[calc(100vh-32px)] w-64 rounded-xl transition-transform duration-300 {{ $sidebarIsDisplay ? 'translate-x-0' :  '-translate-x-80 md:translate-x-0'}}">
        <div class="border-b">
            <a class="flex py-6 px-6" href="#/">
                <img
                    src={{ asset('img/logo-school-verse.png') }}
                    class="w-full h-full">
            </a>
        </div>
        <div class="m-4">
            <ul class="mb-4 flex flex-col gap-1 text-base">
                <li><a class="" href="/home" ><button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize"
                            ><i class="fa-solid fa-house"></i>
                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                home</p>
                        </button></a></li>
                <li><a class="active" href="/change"><button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30 w-full flex items-center gap-4 px-4 capitalize"
                            ><i class="fa-solid fa-layer-group fa-xl"></i>
                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                resources</p>
                        </button></a></li>
                <li><a class="" href="#/dashboard/tables"><button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none py-3 rounded-lg text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30 w-full flex items-center gap-4 px-4 capitalize"
                            ><i class="fa-solid fa-users"></i>
                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                users</p>
                        </button></a></li>
                <li><a class="" href="#/dashboard/notifactions">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none py-3 rounded-lg text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30 w-full flex items-center gap-4 px-4 capitalize"
                            ><i class="fa-solid fa-comments"></i>
                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                notifactions</p>
                        </button></a></li>
            </ul>
        </div>
    </aside>
