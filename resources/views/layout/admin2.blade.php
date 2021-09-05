@extends('layout.basic')

@section('body')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow justify-content-center mb-4">
        <a class="navbar-brand mr-auto" href="{{ route('admin.homepage') }}">Administración</a>
        <ul class="navbar-nav ml-auto">
            <li class="dropdown nav-item form-inline text-white font-weight-bold border rounded pl-2">
                <i class="fa fa-user-circle text-white mr-2" style="font-size: 32px;"></i>@auth() {{ auth()->user()->name . ' ' . auth()->user()->last_name }} @endauth @guest() Name Surname @endguest
                <button class="ml-1 btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('admin.homepage') }}">Inicio</a>
                    <a class="dropdown-item" href="{{route('admin.usuarios.show',auth()->user())}}">Mi Perfil</a>
                    <div class="dropdown-divider"></div>
                    <form class="dropdown-item" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-block" type="submit">Cerrar Sesión</button>
                    </form>

                </div>
            </li>
        </ul>
    </nav>
    <div>
        <!-- Content -->
        <div class="row mx-2">
            <!-- Sidebar -->
            <div class="col-3 bg-light border-right">
                <ul class="nav nav-pills flex-column mb-3 border-bottom">
                    <li class="nav-item mb-1 text-dark container"><i class="fa fa-user mr-2"></i>USUARIOS</li>
                    <li class="ml-2 nav-item "><a class="nav-link text-white @if(Request::route()->getName() == "admin.usuarios.create") active @else bg-success @endif" href="{{ route('admin.usuarios.create') }}"><i class="fa fa-plus mr-2"></i>Agregar</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.usuarios.index") active text-white @else text-dark @endif" href="{{ route('admin.usuarios.index') }}">Todos</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.usuarios.administradores") active text-white @else text-dark @endif" href="{{ route('admin.usuarios.administradores') }}">Administradores</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.usuarios.profesores") active text-white @else text-dark @endif" href="{{ route('admin.usuarios.profesores') }}">Profesores</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.usuarios.estudiantes") active text-white @else text-dark @endif" href="{{ route('admin.usuarios.estudiantes') }}">Estudiantes</a></li>
                </ul>
                <ul class="nav nav-pills flex-column mb-3 border-bottom">
                    <li class="nav-item mb-1 container"><i class="fa fa-building mr-2"></i>DEPARTAMENTOS</li>
                    <li class="ml-2 nav-item "><a class="nav-link text-white @if(Request::route()->getName() == "admin.departamentos.create") active @else bg-success @endif " href="{{ route('admin.departamentos.create') }}"><i class="fa fa-plus mr-2"></i>Agregar</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.departamentos.index") active text-white @else text-dark @endif" href="{{ route('admin.departamentos.index') }}">Todos</a></li>
                </ul>
                <ul class="nav nav-pills flex-column mb-3 border-bottom">
                    <li class="nav-item mb-1 container"><i class="fa fa-graduation-cap mr-2"></i>ASIGNATURAS</li>
                    <li class="ml-2 nav-item "><a class="nav-link text-white @if(Request::route()->getName() == "admin.asignaturas.create") active @else bg-success @endif" href="{{ route('admin.asignaturas.create') }}"><i class="fa fa-plus mr-2"></i>Agregar</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.asignaturas.index") active text-white @else text-dark @endif" href="{{ route('admin.asignaturas.index') }}">Todas</a></li>
                </ul>
                <ul class="nav nav-pills flex-column mb-3 border-bottom">
                    <li class="nav-item mb-1 container"><i class="fab fa-elementor mr-2"></i>EVENTOS</li>
                    <li class="ml-2 nav-item "><a class="nav-link text-white @if(Request::route()->getName() == "admin.eventos.create") active @else bg-success @endif" href="{{ route('admin.eventos.create') }}"><i class="fa fa-plus mr-2"></i>Agregar</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link @if(Request::route()->getName() == "admin.eventos.index") active text-white @else text-dark @endif" href="{{ route('admin.eventos.index') }}">Todos</a></li>
                </ul>
            </div>
            <!-- Content --->
            <div class="col-9 rounded bg-light">
                <div class="ml-1">
                    <div class="jumbotron">
                    @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
