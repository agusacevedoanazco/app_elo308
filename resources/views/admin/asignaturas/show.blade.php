@extends('layout.admin2')

@section('content')
    @isset($asignatura)
        <div class="text-center mb-4">
            <h1>{{$asignatura->nombre}}</h1>
            <h4>{{$asignatura->codigo}} - {{$asignatura->anio}}</h4>
            <h5>Paralelo {{$asignatura->paralelo}}</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a href="{{route('admin.asignaturas.show',$asignatura)}}" class="nav-link active">Eventos</a></li>
                    <li class="nav-item"><a href="{{route('admin.asignaturas.participantes.show',$asignatura)}}" class="nav-link">Participantes</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-lg-3 row-cols-sm-1">
                    @foreach($asignatura->eventos as $evento)
                        <div class="col mb-4">
                            <div class="card h-100 shadow bg-light">
                                <div class="card-header">{{$evento->titulo}}</div>
                                <div class="card-body">
                                    {{$evento->descripcion}}
                                </div>
                                <div class="card-footer"><a href="{{route('admin.eventos.show',$evento)}}" class="stretched-link btn btn-block btn-primary">Acceder</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">No se pudo cargar la asignatura!</div>
    @endisset
@endsection
