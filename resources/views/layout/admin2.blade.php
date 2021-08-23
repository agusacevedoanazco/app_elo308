@extends('layout.basic')

@section('body')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow justify-content-center mb-4">
        <a class="navbar-brand mr-auto" href="{{ route('admin.homepage') }}">Admininstración</a>
        <ul class="navbar-nav ml-auto">
            <li class="dropdown nav-item form-inline text-white font-weight-bold border rounded pl-2">
                <i class="fa fa-user-circle text-white mr-2" style="font-size: 32px;"></i>@auth() {{ auth()->user()->name . ' ' . auth()->user()->last_name }} @endauth @guest() Name Surname @endguest
                <button class="ml-1 btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('admin.homepage') }}">Inicio</a>
                    <a class="dropdown-item" href="#">Mi Perfil</a>
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
                    <li class="ml-2 nav-item "><a class="nav-link bg-success text-white" href="#"><i class="fa fa-plus mr-2"></i>Agregar</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link text-dark" href="#">Administradores</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link text-dark" href="#">Profesores</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link text-dark" href="#">Estudiantes</a></li>
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
                    <li class="nav-item mb-1 container"><i class="fa fa-sign-in-alt mr-2"></i>MATRICULAS</li>
                    <li class="ml-2 nav-item "><a class="nav-link bg-success text-white" href="#"><i class="fa fa-plus mr-2"></i>Agregar</a></li>
                    <li class="ml-2 nav-item "><a class="nav-link text-dark" href="#">Todas</a></li>
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
                    <!--
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
