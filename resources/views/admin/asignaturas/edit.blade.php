@extends('layout.admin2')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Editar la Asignatura</h1>
                        <p class="text-muted">Edita los parametros de la asignatura, el código de asignatura y el departamento asociado no pueden ser editado</p>
                        @if (session()->has('okmsg'))
                            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                        @endif
                        @if (session()->has('errmsg'))
                            <div class="alert alert-danger text-center">{{ session('errmsg') }}</div>
                        @endif
                        @if (session()->has('warnmsg'))
                            <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
                        @endif
                        @if(isset($asignatura))
                            <form action="{{ route('admin.asignaturas.update', $asignatura) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" placeholder="{{$asignatura->oc_series_name}}" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <input class="form-control @error('nombre') border-danger @enderror" type="text" name="nombre" id="nombre" placeholder="Nombre de la Asignatura" value="{{ $asignatura->nombre }}">
                                </div>
                                @error('nombre')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror

                                <div class="input-group mb-3 row mx-auto">
                                    <input class="form-control @error('anio') border-danger @enderror" type="number" name="anio" id="anio" placeholder="Año" value="{{ $asignatura->anio }}">
                                    <input class="form-control @error('semestre') border-danger @enderror" type="number" name="semestre" id="semestre" placeholder="Semestre" value="{{ $asignatura->semestre }}">
                                    <input class="form-control @error('paralelo') border-danger @enderror" type="number" name="paralelo" id="paralelo" placeholder="Paralelo" value="{{ $asignatura->paralelo }}">
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
                                        <button class="btn btn-primary px-4" type="submit">Actualizar Asignatura</button>
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
