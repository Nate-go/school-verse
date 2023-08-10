<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- @vite('resources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div id='root' class='bg-slate-300'>
        <div class='min-h-screen'>
            <livewire:sidebar/>
            <div class="p-4 md:ml-72">
                <livewire:header/>  
                <livewire:notifytable/>
            </div>
        </div>
        <livewire:settingbutton/>
    </div>
    @livewireScripts
</body>

</html>
