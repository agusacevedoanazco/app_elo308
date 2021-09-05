@extends('layout.admin2')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Crear un nuevo Usuario</h1>
                        <p class="text-muted">Crea un nuevo usuario con credenciales de autenticación</p>
                        @if (session()->has('okmsg'))
                            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                        @endif
                        @if (session()->has('errmsg'))
                            <div class="alert alert-danger text-center">{{ session('errmsg') }}</div>
                        @endif
                        @if (session()->has('warnmsg'))
                            <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
                        @endif
                        <form action="{{ route('admin.usuarios.store') }}" method="post">
                            @csrf
                            <div class="row mb-3 mx-auto">
                                <div class="col form-check-inline">
                                    <input type="radio" class="form-check-input" name="radiorol" value="0" id="rol1" @isset($rol)@if($rol == 'administrador') checked @endif @endisset>
                                    <label for="rol1" class="form-check-label">Administrador</label>
                                </div>
                                <div class="col form-check-inline justify-content-center">
                                    <input type="radio" class="form-check-input" name="radiorol" value="1" id="rol2" @isset($rol)@if($rol == 'profesor') checked @endif @endisset>
                                    <label for="rol2" class="form-check-label">Profesor</label>
                                </div>
                                <div class="col form-check-inline justify-content-end">
                                    <input type="radio" class="form-check-input" name="radiorol" value="2" id="rol3" @isset($rol)@if($rol == 'estudiante') checked @endif @endisset>
                                    <label for="rol3" class="form-check-label">Estudiante</label>
                                </div>
                            </div>
                            @error('radiorol')
                                <div class="alert alert-danger" role="alert">Es necesario elegir un rol para el usuario.</div>
                            @enderror
                            <div class="row mb-3">
                                <div class="col">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ old('name') }}">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellido" value="{{ old('last_name') }}">
                                </div>
                            </div>
                            @error('name')
                            <div class="alert alert-danger" role="alert">{{$message}}</div>
                            @enderror
                            @error('last_name')
                            <div class="alert alert-danger" role="alert">{{$message}}</div>
                            @enderror
                            <div class="row mb-3 mx-auto">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <div class="alert alert-danger" role="alert">{{$message}}</div>
                            @enderror
                            <div class="row mb-3 mx-auto">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                            </div>
                            @error('password')
                            <div class="alert alert-danger" role="alert">{{$message}}</div>
                            @enderror
                            <div class="row mb-4 mx-auto">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña">
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <button class="btn btn-primary px-4" type="submit">Crear Usuario</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
