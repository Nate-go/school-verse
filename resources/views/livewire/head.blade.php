<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ucfirst($name)}}</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- @vite('resources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @livewireChartsScripts
    <link rel="icon" type="image/png" href="{{ asset('img/icon-tab.png') }}">
    @livewireStyles
    @csrf
</head>
