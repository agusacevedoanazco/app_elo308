<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-light">
    <!-- Header Navbar -->

    <header class="navbar navbar-expand-md navbar-dark bg-dark justify-content-center shadow">
        <ul class="navbar-nav mr-auto">
            <li class="navbar-brand">Video App</li>
            @auth()
                <li class="nav-item mx-2"><a class="nav-link" href="">Link 1</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="">Link 2</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="">Link 3</a></li>
            @endauth
        </ul>
        <ul class="navbar-nav">
            @auth()
                <li class="nav-item mx-2"><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="nav-link btn btn-danger text-white">Cerrar Sesión</button></form></li>
            @endauth
            @guest()
                <li class="nav-item mx-2"><a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">Iniciar Sesión</a></li>
            @endguest
        </ul>
    </header>
    <main>
    </main>
</body>

</html>
