<aside
        class="z-50 fixed overflow-hidden bg-white my-4 ml-4 h-[calc(100vh-32px)] w-64 rounded-xl transition-transform duration-300 {{ $sidebarIsDisplay ? 'translate-x-0' :  '-translate-x-80 md:translate-x-0'}}">
        <div class="border-b">
            <a class="flex py-6 px-6" href="/">
                <img
                    src={{ asset('img/logo-school-verse.png') }}
                    class="w-full h-full">
            </a>
        </div>
        <div class="m-4">
            <ul class="mb-4 flex flex-col gap-1 text-base">
                <li><a class="" href="/insistences"><button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'insistences' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                            <i class="fa-solid fa-envelope"></i>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                Insistences</p>
                        </button></a></li>
                <li><a class="" href="/rooms"><button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'rooms' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                            <i class="fa-solid fa-people-roof"></i>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                Rooms</p>
                        </button></a></li>
                @if (Auth::user()->role === $adminRole) 
                    <li><a class="" href="/users"><button
                                class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'users' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                                <i class="fa-solid fa-users"></i>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                    Users</p>
                            </button></a></li>
                    
                    <li><a class="" href="/school-years"><button
                                class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'school-years' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                                <i class="fa-solid fa-calendar"></i>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                    School Years</p>
                            </button></a></li>
                    <li><a class="" href="/grades"><button
                                class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'grades' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                    Grades</p>
                            </button></a></li>
                    <li><a class="" href="/subjects"><button
                                class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'subjects' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                                <i class="fa-solid fa-book"></i>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                    Subjects</p>
                            </button></a></li>
                    <li><a class="" href="/teachers"><button
                                class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'teachers' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                    Teachers</p>
                            </button></a></li>
                    <li><a class="" href="/students"><button
                                class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none  py-3 rounded-lg {{ $page === 'students' ? 'bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85]' : 'hover:bg-blue-300'}}  w-full flex items-center gap-4 px-4 capitalize">
                                <i class="fa-solid fa-user-graduate"></i>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                    Students</p>
                            </button></a></li>
                @endif
            </ul>
        </div>
    </aside>
