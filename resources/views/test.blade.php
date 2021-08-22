@extends('layout.basic')

@section('body')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow justify-content-center mb-4">
        <a class="navbar-brand mr-auto" href="">Admin</a>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Departamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Matriculas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Asignaturas</a></li>
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

    <div>
        <div class="row mx-2">
            <!-- Sidebar -->
            <div class="col-3 bg-light border-right">
                <ul class="nav nav-pills flex-column mb-2 border-bottom">
                    <li class="nav-item nav-link active">A</li>
                    <li class="nav-item nav-link">B</li>
                    <li class="nav-item nav-link">C</li>
                </ul>
                <ul class="nav nav-pills flex-column mb-2 border-bottom">
                    <li class="nav-item nav-link active">A</li>
                    <li class="nav-item nav-link">B</li>
                    <li class="nav-item nav-link">C</li>
                </ul>
                <ul class="nav nav-pills flex-column mb-2 border-bottom">
                    <li class="nav-item nav-link active">A</li>
                    <li class="nav-item nav-link">B</li>
                    <li class="nav-item nav-link">C</li>
                </ul>
            </div>
            <!-- Content -->
            <div class="col-9 rounded bg-light">
                <div class="ml-1">
                    <div class="jumbotron">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis condimentum velit, sit amet iaculis augue. Donec sodales diam sed nulla feugiat ultrices a ut lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras tincidunt mattis metus vitae consectetur. Nulla facilisi. Donec eleifend justo vel faucibus fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus suscipit dignissim ullamcorper. Nam blandit magna at efficitur sollicitudin. Maecenas suscipit, ante sed porttitor sagittis, lacus turpis varius augue, et bibendum libero diam et justo. Fusce et ipsum dapibus, fringilla urna sit amet, sodales justo. Ut congue nibh ut mi pulvinar, eu dictum ligula laoreet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
