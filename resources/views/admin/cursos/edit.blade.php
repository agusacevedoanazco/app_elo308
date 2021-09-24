@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}">Cursos</a></li>
        @isset($curso)
            <li class="breadcrumb-item"><a href="{{route('admin.cursos.show',$curso->id)}}">{{$curso->nombre}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        @endisset
    </ol>
@endsection


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Editar el Curso</h1>
                        <p class="text-muted">Modifica los parámetros del curso, el código de asignatura y el departamento asociado no pueden ser modificados</p>
                        @if (session()->has('okmsg'))
                            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                        @endif
                        @if (session()->has('errmsg'))
                            <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
                        @endif
                        @if (session()->has('warnmsg'))
                            <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
                        @endif
                        @if(isset($curso))
                            <form action="{{ route('admin.cursos.update', $curso) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" placeholder="{{$curso->oc_series_name}}" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <input class="form-control @error('nombre') border-danger @enderror" type="text" name="nombre" id="nombre" placeholder="Nombre de la Asignatura" value="{{ $curso->nombre }}">
                                </div>
                                @error('nombre')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror

                                <div class="input-group mb-3 row mx-auto">
                                    <input class="form-control @error('anio') border-danger @enderror" type="number" name="anio" id="anio" placeholder="Año" value="{{ $curso->anio }}">
                                    <input class="form-control @error('semestre') border-danger @enderror" type="number" name="semestre" id="semestre" placeholder="Semestre" value="{{ $curso->semestre }}">
                                    <input class="form-control @error('paralelo') border-danger @enderror" type="number" name="paralelo" id="paralelo" placeholder="Paralelo" value="{{ $curso->paralelo }}">
                                </div>
                                @error('anio')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                                @error('semestre')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                                @error('paralelo')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror

                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Actualizar Curso</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
