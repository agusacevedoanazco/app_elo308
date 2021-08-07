@extends('layout.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Crear una cuenta</h1>
                            <p class="text-muted">Crea una nueva cuenta de inicio de sesión</p>
                            @if (session()->has('status'))
                                <div class="alert alert-danger text-center">{{ session('status') }}</div>
                            @endif
                            <form action="{{ route('signup') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <input class="form-control @error('name') border-danger @enderror" type="text" name="name" id="name" placeholder="Nombre" value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                @enderror
                                <div class="input-group mb-3">
                                    <input class="form-control @error('last_name') border-danger @enderror" type="text" name="last_name" id="last_name" placeholder="Apellido" value="{{ old('last_name') }}">
                                </div>
                                @error('last_name')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                @enderror
                                <div class="input-group mb-3">
                                    <input class="form-control @error('email') border-danger @enderror" type="email" name="email" id="email" placeholder="Correo Electrónico" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                @enderror
                                <div class="input-group mb-3">
                                    <input class="form-control @error('role') border-danger @enderror" type="number" name="role" id="role" placeholder="Rol de Usuario" value="{{ old('role') }}">
                                </div>
                                @error('role')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                @enderror
                                <div class="input-group mb-3">
                                    <input class="form-control @error('password') border-danger @enderror" type="password" placeholder="Contraseña" name="password" required>
                                </div>
                                @error('password')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                @enderror
                                <div class="input-group mb-4">
                                    <input class="form-control" type="password" placeholder="Repetir Contraseña" name="password_confirmation" id="password_confirmation" required>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Crear cuenta</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
