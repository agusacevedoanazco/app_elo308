@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}">Cursos</a></li>
        @isset($curso)
            <li class="breadcrumb-item active" aria-current="page">{{$curso->nombre}}</li>
        @endisset
    </ol>
@endsection

@section('content')
    @isset($curso)
        <div class="text-center mb-4">
            <h1>{{$curso->nombre}}</h1>
            <h4>{{$curso->codigo}} - {{$curso->anio}}</h4>
            <h5>Paralelo {{$curso->paralelo}}</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a href="{{route('admin.cursos.show',$curso)}}" class="nav-link">Eventos</a></li>
                    <li class="nav-item"><a href="{{route('admin.cursos.participantes.index',$curso)}}" class="nav-link active">Participantes</a></li>
                </ul>
            </div>
            <div class="card-body">
                @if (session()->has('okmsg'))
                    <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                @endif
                @if (session()->has('errormsg'))
                    <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
                @endif
                @if (session()->has('warnmsg'))
                    <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
                @endif
                @isset($profesores,$estudiantes)
                    <div class="btn-toolbar mb-2">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addParticipanteModal">Agregar Participante</button>
                    </div>
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th class="text-center" scope="col"><i class="fas fa-minus-circle"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profesores as $profesor)
                            <tr class="table-info">
                                <td class="align-middle">{{$profesor->name}}</td>
                                <td class="align-middle">{{$profesor->last_name}}</td>
                                <td class="align-middle">{{$profesor->email}}</td>
                                <td class="align-middle"><span class="badge badge-pill badge-success">Profesor</span></td>
                                <td class="text-center"><form action="{{ route('admin.cursos.participantes.destroy',['curso_id' => $curso->id, 'user_id' => $profesor->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @foreach($estudiantes as $estudiante)
                            <tr>
                                <td class="align-middle">{{$estudiante->name}}</td>
                                <td class="align-middle">{{$estudiante->last_name}}</td>
                                <td class="align-middle">{{$estudiante->email}}</td>
                                <td class="align-middle"><span class="badge badge-pill badge-warning">Estudiante</span></td>
                                <td class="text-center"><form action="{{ route('admin.cursos.participantes.destroy',['curso_id' => $curso->id, 'user_id' => $estudiante->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning text-center">No hay participantes en el curso!</div>
                @endisset
            </div>
        </div>
        <div class="modal fade" id="addParticipanteModal">
            <div class="modal-dialog">
                <form action="{{route('admin.cursos.participantes.store',$curso)}}" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar Participante</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                @csrf
                                <select class="custom-select" name="usuario" id="usuario">
                                    <optgroup label="Profesor">
                                        @foreach($agregarprofesor as $addprofesor)
                                            <option value="{{$addprofesor->id}}">{{$addprofesor->email . ' - ' . $addprofesor->name . ' ' . $addprofesor->last_name}}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Estudiante">
                                        @foreach($agregarestudiante as $addestudiante)
                                            <option value="{{$addestudiante->id}}">{{$addestudiante->email . ' - ' . $addestudiante->name . ' ' . $addestudiante->last_name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">No se pudo cargar el curso!</div>
    @endisset
@endsection
