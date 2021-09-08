@extends('layout.app2')
@section('content')
    @isset($user)
        <div class="display-4 text-center mb-4">
            <h1>Mi perfil</h1>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row mt-1">
                            <div class="col align-middle">
                                <h4 class="align-middle d-inline">Información de Usuario</h4>
                            </div>
                            <div class="col text-right align-middle">
                                @if($user->role == 0)<span class="badge badge-pill badge-primary text-right">Administrador</span>
                                @elseif($user->role == 1)<span class="badge badge-pill badge-success text-right">Profesor</span>
                                @elseif($user->role == 2)<span class="badge badge-pill badge-warning text-right">Estudiante</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Nombre</label>
                            <div class="col-sm-8"><input type="text" class="form-control ml-2" id="name" value="{{$user->name}}" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Apellido</label>
                            <div class="col-sm-8"><input type="text" class="form-control ml-2" id="name" value="{{$user->last_name}}" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8"><input type="email" class="form-control ml-2" id="name" value="{{$user->email}}" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Fecha de Creación</label>
                            <div class="col-sm-8"><input type="email" class="form-control ml-2" id="name" value="{{$user->created_at}}" readonly></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row mt-1">
                            <div class="col align-middle">
                                <h4 class="align-middle d-inline">Cambiar Contraseña</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('app.perfil.update.password',$user->id)}}" method="post">
                            @csrf
                            @method('put')
                            @if(session()->has('errormsg'))
                                <div class="row alert alert-danger" role="alert">
                                    <div class="col">{{session('errormsg')}}</div>
                                </div>
                            @elseif(session()->has('okmsg'))
                                <div class="row alert alert-success" role="alert">
                                    <div class="col">{{session('okmsg')}}</div>
                                </div>
                            @endif
                            @error('password')
                            <div class="row alert alert-danger" role="alert">
                                <div class="col">{{$message}}</div>
                            </div>
                            @enderror
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label">Nueva Contraseña</label>
                                <div class="col-sm-8"><input type="password" class="form-control ml-2 @error('password') border-danger @enderror" id="password" name="password"></div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-sm-4 col-form-label">Confirmar Contraseña</label>
                                <div class="col-sm-8"><input type="password" class="form-control ml-2" id="password_confirmation" name="password_confirmation"></div>
                            </div>
                            <div class="row mx-2">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8 text-center"><button type="submit" class="ml-2 btn-block mt-2 btn btn-primary">Cambiar contraseña</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
