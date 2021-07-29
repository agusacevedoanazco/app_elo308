@extends('layout.public')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Iniciar sesión</h1>
                            <p class="text-muted">Inicia sesión en tu cuenta</p>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <input class="form-control" type="email" name="email" id="email" placeholder="Correo Electrónico" value="{{ old('email') }}">
                                </div>
                                <div class="input-group mb-4">
                                    <input class="form-control" type="password" placeholder="Contraseña" name="password" required>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Iniciar Sesión</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
