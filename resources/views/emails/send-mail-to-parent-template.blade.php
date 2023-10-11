<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notify</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <div class="flex items-center justify-center min-h-screen p-5 bg-gray-600 min-w-screen">
        <div class="max-w-xl p-8 text-center text-gray-800 bg-white shadow-xl lg:max-w-3xl rounded-3xl lg:p-12">
            <h3 class="text-2xl">Xin chào phụ huynh của em <strong>{{$name}}</strong></h3>
            <div class="h-full w-full overflow-hidden">
                <img alt="" class="object-cover h-80 w-96"
                    src="https://img.freepik.com/free-vector/alert-concept-illustration_114360-238.jpg?w=740&t=st=1695699943~exp=1695700543~hmac=6db4dbf067c56f9c69f78c64506425e49cf5505f31611cd95c532c70b12e6e43" />
            </div>
            <div class="flex-col">
                <p>Bạn có thông báo từ <strong>{{$fromName}}</strong></p>
                <p>Học sinh <strong>{{$name}}</strong> nhận được tin: <strong>{{ $content }}</strong></p>
            </div>
        </div>
    </div>

</body>

</html>