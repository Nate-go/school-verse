<nav
    class="{{ $headerIsLock ? "block w-full max-w-full bg-transparent text-white shadow-none rounded-xl transition-all px-0 py-1" : 'block backdrop-saturate-200 backdrop-blur-2xl bg-opacity-80 border border-white/80 w-full px-4 bg-white rounded-xl transition-all top-4 z-40 py-3 shadow-md'}}">
    <div class="flex justify-between items-center">
        <div class="capitalize">
            <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-dark">
                home
            </h6>
        </div>
        <div class="flex">
            <div class="mr-auto md:mr-4 md:w-56">
                <div class="relative w-full min-w-[200px] h-10"><input
                        class="peer w-full h-full bg-transparent text-blue-gray-700 font-sans font-normal outline outline-0 focus:outline-0 disabled:bg-blue-gray-50 disabled:border-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 border focus:border-2 border-t-transparent focus:border-t-transparent text-sm px-3 py-2.5 rounded-[7px] border-blue-gray-200 focus:border-blue-500"
                        placeholder=" "><label
                        class="flex w-full h-full select-none pointer-events-none absolute left-0 font-normal peer-placeholder-shown:text-blue-gray-500 leading-tight peer-focus:leading-tight peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 transition-all -top-1.5 peer-placeholder-shown:text-sm text-[11px] peer-focus:text-[11px] before:content[' '] before:block before:box-border before:w-2.5 before:h-1.5 before:mt-[6.5px] before:mr-1 peer-placeholder-shown:before:border-transparent before:rounded-tl-md before:border-t peer-focus:before:border-t-2 before:border-l peer-focus:before:border-l-2 before:pointer-events-none before:transition-all peer-disabled:before:border-transparent after:content[' '] after:block after:flex-grow after:box-border after:w-2.5 after:h-1.5 after:mt-[6.5px] after:ml-1 peer-placeholder-shown:after:border-transparent after:rounded-tr-md after:border-t peer-focus:after:border-t-2 after:border-r peer-focus:after:border-r-2 after:pointer-events-none after:transition-all peer-disabled:after:border-transparent peer-placeholder-shown:leading-[3.75] text-blue-gray-400 peer-focus:text-blue-500 before:border-blue-gray-200 peer-focus:before:border-blue-500 after:border-blue-gray-200 peer-focus:after:border-blue-500">Type
                        here</label></div>
            </div>
            <button
                class="md:hidden text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400 active:text-blue-500"
                type="button"><i class="fa-solid fa-bars text-xl"></i>
            </button>
    
            <button
                class="hidden font-sans font-bold center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-base py-3 px-2 rounded-lg items-center hover:text-blue-400 active:text-blue-500"
                type="button">
                <i class="fa-solid fa-right-to-bracket"></i>
                Sign In
            </button>

            <button aria-expanded="false" aria-haspopup="menu" id=""
                class="text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400 active:text-blue-500"
                    type="button"><i class="fa-solid fa-user"></i>
            </button>

            <button aria-expanded="false" aria-haspopup="menu" id=""
                class="text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-base hover:text-blue-400 active:text-blue-500"
                type="button"><i class="fa-solid fa-bell"></i>
            </button>
        </div>
    </div>
</nav>
