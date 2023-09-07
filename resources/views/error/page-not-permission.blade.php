<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- @vite('resources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="relative min-h-screen w-full flex justify-center">
        <img src={{ asset('img/not-permission.png') }} class="absolute inset-0 z-0 h-full w-full object-contain">
        <div
            class="flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md absolute top-3/4 left-2/4 w-full max-w-[18rem] -translate-y-2/4 -translate-x-2/4 z-20">
            <div class="p-6 flex flex-col gap-4">
                <div class="text-center">
                    <div class="inline-flex items-center">
                        <label class="text-gray-700 font-light select-none cursor-pointer mt-px" for="checkbox">
                            You have not permission to do this
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