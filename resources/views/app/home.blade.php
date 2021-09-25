@extends('layout.app2')

@section('content')
    <div class="container mb-4">
        <h2 class="text-center mb-4">Bienvenido(a)</h2>
        @can('modevento')
            <div class="card">
                <h2 class="text-muted text-center" style="margin-top: 10%;margin-bottom: 10%;">Analíticas de Video</h2>
            </div>
        @endcan
    </div>
    <div class="container">
        <h2 class="text-center">Mis Cursos</h2>
    </div>
    <div class="container mt-4">
        @isset($cursos)
        <div class="row row-cols-1 row-cols-lg-3 row-cols-sm-1">
            @foreach($cursos as $curso)
                    <div class="col mb-4">
                        <div class="card h-100 shadow bg-light">
                            <div class="card-header">{{$curso->nombre}}</div>
                            <div class="card-body">
                                {{$curso->oc_series_name}}
                            </div>
                            <div class="card-footer"><a href="{{route('app.cursos.show',$curso)}}" class="stretched-link btn btn-block btn-primary">Acceder</a></div>
                        </div>
                    </div>
            @endforeach
        </div>
        @endisset
    </div>
@endsection
