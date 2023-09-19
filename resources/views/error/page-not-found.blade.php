<!DOCTYPE html>
<html lang="en">

@livewire('head', ['name' => 'Not found'])

<body>
    <div class="relative min-h-screen w-full flex justify-center">
        <img src={{ asset('img/page-not-found.png') }} class="absolute inset-0 z-0 h-full w-full object-contain">
        <div
            class="flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md absolute top-3/4 left-2/4 w-full max-w-[16rem] -translate-y-2/4 -translate-x-2/4 z-20">
                <div class="p-6 flex flex-col gap-4">
                    <div class="text-center">
                        <div class="inline-flex items-center">
                            <label class="text-gray-700 font-light select-none cursor-pointer mt-px" for="checkbox">
                                We have not found this page
                            </label>
                        </div>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <a href="/">
                        <button
                            class="middle none font-sans font-bold center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 active:opacity-[0.85] block w-full"
                            type="submit">Go back home</button>
                    </a>
                </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>