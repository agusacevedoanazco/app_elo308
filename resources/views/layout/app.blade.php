@extends('layout.basic')

@section('body')
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
    <main class="mt-4 container">
        @yield('content')
    </main>
@endsection
