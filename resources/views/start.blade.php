<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>


<body>
    <div class="rectangle">
        <img src="{{ asset('images/ellipse-green-1-4.svg') }}" alt="Deskripsi Gambar" class="ellipse-green-1-4">
        <img src="{{ asset('images/ellipse-green-2-6.svg') }}" alt="Deskripsi Gambar" class="ellipse-green-2-6">
        <img src="{{ asset('images/ellipse-green-3-5.svg') }}" alt="Deskripsi Gambar" class="ellipse-green-3-5">
        <h2 class="text-2">Selamat Datang</h2>
    </div>
    <div class="trash">
        <img src="{{ asset('images/trash.svg') }}" alt="Deskripsi Gambar">
    </div>


    <div class="container">
        <a href="{{ route('account.login') }}" class="frame-3-4 mt-20">
            <p class="text-7">Sign In</p>
        </a>
        <a href="{{ route('account.register') }}" class="frame-6-5 mt-20">
            <p class="text-6">Sign Up</p>
        </a>
    </div>




</body>

</html>
