@extends('layout.basic')

@section('body')
    <nav class="navbar navbar-expand-md navbar-dark bg-dark justify-content-center shadow">
        <a class="navbar-brand mr-auto" href="/">Administración</a>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link @if(Request::route()->getName() == "admin.homepage") active @endif" href="{{ route('admin.homepage') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::route()->getName() == "admin.departamentos.index") active @endif" href="{{ route('admin.departamentos.index') }}">Departamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::route()->getName() == "admin.asignaturas.index") active @endif" href="{{ route('admin.asignaturas.index') }}">Asignaturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Matriculas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::route()->getName() == "admin.eventos.index") active @endif" href="{{ route('admin.eventos.index') }}">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Publicaciones</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form class="form-inline" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <main class="mt-4 container">
        @yield('content')
    </main>
@endsection
