@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        @if(Request::route()->getName() == "admin.usuarios.index")
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        @else
            <li class="breadcrumb-item"><a href="{{route('admin.usuarios.index')}}">Usuarios</a></li>
        @endif
        @if(Request::route()->getName() == "admin.usuarios.administradores")
            <li class="breadcrumb-item active" aria-current="page">Administradores</li>
        @elseif(Request::route()->getName() == "admin.usuarios.profesores")
            <li class="breadcrumb-item active" aria-current="page">Profesores</li>
        @elseif(Request::route()->getName() == "admin.usuarios.estudiantes")
            <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
        @endif
    </ol>
@endsection

@section('content')
    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errmsg') }}</div>
    @endif
    @if(Request::route()->getName() == "admin.usuarios.administradores")
        <div class="display-4 text-center">
            <h1>Administradores</h1>
        </div>
        <div class="btn-toolbar mb-2">
            <a href="{{ route('admin.usuarios.create',['rol'=>'administrador']) }}"><button class="btn btn-success">Nuevo Administrador</button></a>
        </div>
    @elseif(Request::route()->getName() == "admin.usuarios.profesores")
        <div class="display-4 text-center">
            <h1>Profesores</h1>
        </div>
        <div class="btn-toolbar mb-2">
            <a href="{{ route('admin.usuarios.create',['rol'=>'profesor']) }}"><button class="btn btn-success">Nuevo Profesor</button></a>
        </div>
    @elseif(Request::route()->getName() == "admin.usuarios.estudiantes")
        <div class="display-4 text-center">
            <h1>Estudiantes</h1>
        </div>
        <div class="btn-toolbar mb-2">
            <a href="{{ route('admin.usuarios.create',['rol'=>'estudiante']) }}"><button class="btn btn-success">Nuevo Estudiante</button></a>
        </div>
    @elseif(Request::route()->getName() == "admin.usuarios.index")
        <div class="display-4 text-center">
            <h1>Usuarios</h1>
        </div>
        <div class="btn-toolbar mb-2">
            <a href="{{ route('admin.usuarios.create') }}"><button class="btn btn-success">Nuevo Usuario</button></a>
        </div>
    @endif
    @isset($users)
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Email</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col" class="text-center">Rol</th>
                <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-edit"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-trash"></i></div></th>
            </tr>
            </thead>
            @foreach($users as $user)
                <tbody>
                <th scope="row">{{ $user->id }}</th>
                <td>{{$user->email}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->last_name}}</td>
                @if($user->role == 0)<td class="text-center"><span class="badge badge-pill badge-primary">Administrador</span></td>
                @elseif($user->role == 1)<td class="text-center"><span class="badge badge-pill badge-success">Profesor</span></td>
                @elseif($user->role == 2)<td class="text-center"><span class="badge badge-pill badge-warning">Estudiante</span></td>@endif
                <td class="text-center"><a href="{{ route('admin.usuarios.show',$user) }}" class="btn btn-primary">Ver</a></td>
                <td class="text-center"><a href="{{ route('admin.usuarios.edit',$user) }}" class="btn btn-warning">Editar</a></td>
                <td class="text-center"><form action="{{ route('admin.usuarios.destroy',$user) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form></td>
                </tbody>
            @endforeach
        </table>
        {{ $users->links() }}
    @else
        <div class="alert alert-danger text-center">Hubo un error al cargar la lista de usuarios, o la lista se encuentra vacía.</div>
    @endisset
@endsection()
