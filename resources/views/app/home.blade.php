@extends('layout.app2')

@section('content')
    <div class="container mb-4">
        <h2 class="text-center mb-4">Bienvenido(a)</h2>
        <div class="card">
            <h2 class="text-muted text-center" style="margin-top: 10%;margin-bottom: 10%;">Analíticas de Video</h2>
        </div>
    </div>
    <div class="container">
        <h2 class="text-center">Asignaturas</h2>
    </div>
    <div class="container mt-4">
        @isset($asignaturas)
        <div class="row row-cols-1 row-cols-lg-3 row-cols-sm-1">
            @foreach($asignaturas as $asignatura)
                    <div class="col mb-4">
                        <div class="card h-100 shadow bg-light">
                            <div class="card-header">{{$asignatura->nombre}}</div>
                            <div class="card-body">
                                {{$asignatura->oc_series_name}}
                            </div>
                            <div class="card-footer"><a href="{{route('app.asignaturas.show',$asignatura)}}" class="stretched-link btn btn-block btn-primary">Acceder</a></div>
                        </div>
                    </div>
            @endforeach
        </div>
        @endisset
    </div>
@endsection
