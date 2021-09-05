@extends('layout.admin2')

@section('content')
    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
    @endif
    @isset($asignatura,$evento,$oc_event)
        <div class="display-4 text-center">
            <h1>{{$evento->titulo}}</h1>
        </div>
        <h5 class="text-muted text-center">{{$evento->descripcion}}</h5>
        <div class="mt-4 col-md-9 mx-auto">
            <div class="card">
                <div class="card-header text-center bg-secondary text-white">{{$asignatura->oc_series_name}}<br><span class="font-weight-bold">{{$asignatura->nombre}}</span><br>{{$evento->titulo}}</div>
                <div class="card-body">{{$oc_event}}</div>
                <div class="card-footer text-center bg-secondary text-white">{{$evento->evento_oc}}</div>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">Hubo un error al intentar cargar el evento!</div>
    @endisset
@endsection
