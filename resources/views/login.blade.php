<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Login
    <form action="" method="POST">
    @csrf

    <p>Username</p>
    <div>
        <input type="text" name="email">
    </div>
    
    <p>Password</p>
    <div>
        <input type="password" name="password">
    </div>

    <br>

    <div>
        <button type="submit">Login</button>
    </div>
</form>
</body>
</html>