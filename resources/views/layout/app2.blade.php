@extends('layout.basic')

@section('body')
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow justify-content-center mb-4">
        <a class="navbar-brand mr-auto" href="{{ route('index') }}">Video App</a>
        <ul class="navbar-nav ml-auto">
            @auth()
                @if(auth()->user()->roleProfesor())
                <li class="nav-item text-white form-inline border-light mr-2"><a class="btn btn-success" href=""><i class="fa fa-video mr-1"></i>Nuevo Evento</a></li>
                @endif
                <li class="dropdown nav-item form-inline text-white font-weight-bold border rounded pl-2">
                    <i class="fa fa-user-circle text-white mr-2" style="font-size: 32px;"></i>{{ auth()->user()->name . ' ' . auth()->user()->last_name}}
                    <button class="ml-1 btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('app.homepage') }}">Inicio</a>
                        <a class="dropdown-item" href="#">Mi Perfil</a>
                        <div class="dropdown-divider"></div>
                        <form class="dropdown-item" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-block" type="submit">Cerrar Sesión</button>
                        </form>
                    </div>
                </li>
            @endauth
            @guest()
                <li class="nav-item mx-2"><a class="nav-link btn btn-primary text-white border-light" href="{{ route('login') }}">Iniciar Sesión</a></li>
            @endguest
        </ul>
    </nav>
    <div>
        <!-- Content -->
        <div class="row mx-2">
            <!-- Sidebar -->
            @auth()
            <div class="col-3 bg-light border-right">
                <ul class="nav nav-pills flex-column mb-3 border-bottom">
                    <li class="nav-item mb-1 container"><i class="fa fa-graduation-cap mr-2"></i>MIS ASIGNATURAS</li>
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
            @endauth
            @guest()
                <div class="col-9 rounded bg-light mx-auto">
                    <div class="jumbotron">
                        @yield('content')
                    </div>
                </div>
            @endguest
        </div>
    </div>
@endsection
