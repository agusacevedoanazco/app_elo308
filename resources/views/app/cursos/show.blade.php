@extends('layout.app2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('app.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('app.cursos.index')}}">Mis Cursos</a></li>
        @isset($curso)
            <li class="breadcrumb-item active" aria-current="page">{{$curso->nombre}}</li>
        @endisset
    </ol>
@endsection

@section('content')
    @isset($curso)
        <div class="text-center mb-4">
            <h2>{{$curso->nombre}}</h2>
            <h4 class="text-muted">{{$curso->codigo}} - {{$curso->anio . 'S' . $curso->semestre}}</h4>
        </div>
        <div class="card">
            <div class="card-header bg-light">
                <nav>
                    <div class="nav nav-pills nav-fill nav-justified card-header-pills" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-eventos-tab" data-toggle="tab" href="#nav-eventos" role="tab" aria-controls="nav-eventos" aria-selected="true">Eventos</a>
                        <a class="nav-link" id="nav-participantes-tab" data-toggle="tab" href="#nav-participantes" role="tab" aria-controls="nav-participantes" aria-selected="false">Participantes</a>
                        @can('modevento')
                            <a class="nav-link" id="nav-listado-tab" data-toggle="tab" href="#nav-listado" role="tab" aria-controls="nav-listado" aria-selected="false">Administrar</a>
                        @endcan
                        @cannot('modevento')
                            <a class="nav-link" id="nav-listado-tab" data-toggle="tab" href="#nav-listado" role="tab" aria-controls="nav-listado" aria-selected="false">Listado</a>
                        @endcan
                        @can('modevento')
                            <a href="{{route('app.eventos.create',$curso->id)}}" class="nav-link text-white bg-success"><i class="fa fa-video mr-2 align-middle"></i>Agregar Evento</a>
                        @endcan
                    </div>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-eventos" role="tabpanel" aria-labelledby="nav-eventos-tab">
                        <!-- Eventos de la curso -->
                        <div class="container">
                                @if($eventos->count())
                                    <div class="row row-cols-1 row-cols-lg-3 row-cols-sm-1">
                                        @foreach($eventos as $evento)
                                            @can('modevento')
                                                <div class="col mb-4">
                                                    <div class="card h-100 shadow bg-light">
                                                        <div class="card-header">{{$evento->titulo}}</div>
                                                        <div class="card-body">
                                                            {{$evento->descripcion}}
                                                        </div>
                                                        <div class="card-footer"><a href="{{route('app.eventos.show',$evento)}}" class="stretched-link btn btn-block btn-primary">Acceder</a></div>
                                                    </div>
                                                </div>
                                            @endcan
                                            @cannot('modevento')
                                                @if($evento->publicado)
                                                    <div class="col mb-4">
                                                        <div class="card h-100 shadow bg-light">
                                                            <div class="card-header">{{$evento->titulo}}</div>
                                                            <div class="card-body">
                                                                {{$evento->descripcion}}
                                                            </div>
                                                            <div class="card-footer"><a href="{{route('app.eventos.show',$evento)}}" class="stretched-link btn btn-block btn-primary">Acceder</a></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endcan
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center">No se encontraron eventos asociados al curso.</div>
                                @endif
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="nav-participantes" role="tabpanel" aria-labelledby="nav-participantes-tab">
                        <!-- Participantes de la curso -->
                        @isset($profesores,$estudiantes)
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rol</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($estudiantes as $estudiante)
                                    <tr>
                                        <td class="align-middle">{{$estudiante->name}}</td>
                                        <td class="align-middle">{{$estudiante->last_name}}</td>
                                        <td class="align-middle">{{$estudiante->email}}</td>
                                        <td class="align-middle"><span class="badge badge-pill badge-warning">Estudiante</span></td>
                                    </tr>
                                @endforeach
                                @foreach($profesores as $profesor)
                                    <tr class="table-info">
                                        <td class="align-middle">{{$profesor->name}}</td>
                                        <td class="align-middle">{{$profesor->last_name}}</td>
                                        <td class="align-middle">{{$profesor->email}}</td>
                                        <td class="align-middle"><span class="badge badge-pill badge-success">Profesor</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning text-center">No hay participantes en el curso!</div>
                        @endisset
                    </div>
                    <div class="tab-pane fade show" id="nav-listado" role="tabpanel" aria-labelledby="nav-listado-tab">
                        @if($eventos->count())
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Fecha</th>
                                    @can('modevento')
                                        <th scope="col" class="text-center">Publicado</th>
                                        <th scope="col" class="text-center">Enviado</th>
                                    @endcan
                                    <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                                    @can('modevento')
                                        <th scope="col"><div class="text-center"><i class="fa fa-edit"></i></div></th>
                                        <th scope="col"><div class="text-center"><i class="fa fa-trash"></i></div></th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($eventos as $evento)
                                    @can('modevento')
                                        <tr>
                                        <td>{{$evento->titulo}}</td>
                                        <td>{{$evento->created_at->format('d-m-y')}}</td>
                                        @if($evento->error)
                                            <td class="text-center text-danger"><i class="fas fa-exclamation-triangle"></i></td>
                                            <td class="text-center text-danger"><i class="fas fa-exclamation-triangle"></i></td>
                                        @else
                                            @if($evento->publicado)
                                                <td class="text-center text-success"><i class="far fa-check-circle"></i></td>
                                            @else
                                                <td class="text-center text-primary"><i class="far fa-hourglass"></i></td>
                                            @endif
                                            @if($evento->pendiente)
                                                <td class="text-center text-primary"><i class="far fa-hourglass"></i></td>
                                            @else
                                                <td class="text-center text-success"><i class="far fa-check-circle"></i></td>
                                            @endif
                                        @endif
                                        <td class="text-center"><a href="{{route('app.eventos.show',$evento)}}" class="btn btn-primary">Ver</a></td>
                                        <td class="text-center"><a href="{{route('app.eventos.edit',$evento)}}" class="btn btn-warning">Editar</a></td>
                                        <td class="text-center"><form action="{{route('app.eventos.destroy',$evento)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form></td>
                                        </tr>
                                    @endcan
                                    @cannot('modevento')
                                        @if($evento->publicado)
                                            <td>{{$evento->titulo}}</td>
                                            <td>{{$evento->created_at->format('d-m-y')}}</td>
                                            <td class="text-center"><a href="{{route('app.eventos.show',$evento)}}" class="btn btn-primary">Ver</a></td>
                                        @endif
                                    @endcan
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning text-center">No se encontraron eventos asociados a la curso.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
