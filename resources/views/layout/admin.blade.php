@extends('layout.basic')

@section('body')
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <div class="navbar-brand px-3">
            <a href="#">Company Name</a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href>Logout</a>
            </div>
        </div>
    </header>
    <div class="container-fluids">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse show">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link">Link 1</a></li>
                        <li class="nav-item"><a class="nav-link">Link 2</a></li>
                        <li class="nav-item"><a class="nav-link">Link 3</a></li>
                        <li class="nav-item"><a class="nav-link">Link 4</a></li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div><
@endsection
