@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li>
        @isset($user)
            <li class="breadcrumb-item"><a href="{{route('admin.usuarios.show',$user->id)}}">{{$user->name}} {{$user->last_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        @endisset
    </ol>
@endsection

@section('content')
    @isset($user)
        <div class="row">
            <div class="col">
                @if(session()->has('errmsg'))
                    <div class="row alert alert-danger" role="alert">
                        <div class="col">{{session('errmsg')}}</div>
                    </div>
                @elseif(session()->has('okmsg'))
                    <div class="row alert alert-success" role="alert">
                        <div class="col">{{session('okmsg')}}</div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="row mt-1">
                            <div class="col align-middle">
                                <h4 class="align-middle d-inline">Editar Información de Usuario</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row"><div class="col"><p class="text-muted">El email e Id de usuario no pueden ser modificados.</p></div></div>
                        <form action="{{route('admin.usuarios.update',$user)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label for="id" class="col-sm-4 col-form-label">Id</label>
                                <div class="col-sm-8"><input type="number" class="form-control ml-2" id="id" value="{{$user->id}}" readonly></div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8"><input type="email" class="form-control ml-2" id="email" value="{{$user->email}}" readonly></div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label">Nombre</label>
                                <div class="col-sm-8"><input type="text" class="form-control ml-2 @error('name') border-danger @enderror" id="name" name="name" value="{{$user->name}}"></div>
                            </div>
                            @error('name')
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8"><div class="alert alert-danger ml-2">{{$message}}</div></div>
                            </div>
                            @enderror
                            <div class="form-group row">
                                <label for="last_name" class="col-sm-4 col-form-label">Apellido</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control ml-2 @error('last_name') border-danger @enderror" id="last_name" name="last_name" value="{{$user->last_name}}">
                                </div>
                            </div>
                            @error('last_name')
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8"><div class="alert alert-danger ml-2">{{$message}}</div></div>
                            </div>
                            @enderror
                            <div class="form-group row">
                                <label for="userrole" class="col-sm-4 col-form-label">Rol de Usuario</label>
                                <div class="col-sm-8">
                                    <select name="userrole" id="userrole" class="form-control ml-2">
                                        <option value="adm" @if($user->role == 0) selected @endif>Administrador</option>
                                        <option value="prf" @if($user->role == 1) selected @endif>Profesor</option>
                                        <option value="std" @if($user->role == 2) selected @endif>Estudiante</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mx-2">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8 text-center"><button type="submit" class="ml-2 btn-block mt-2 btn btn-primary">Actualizar usuario</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row mt-1">
                            <div class="col align-middle">
                                <h4 class="align-middle d-inline">Cambiar Contraseña</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.usuarios.admputpwd',$user->id) }}" method="post">
                            @csrf
                            @method('put')
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
