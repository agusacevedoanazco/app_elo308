@extends('layout.admin2')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Crear un curso</h1>
                        <p class="text-muted">Crea un nuevo curso y lo registra en la lista de series de Opencast</p>
                        @if (session()->has('okmsg'))
                            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                        @endif
                        @if (session()->has('errormsg'))
                            <div class="alert alert-danger text-center">{{ session('errmsg') }}</div>
                        @endif
                        @if (session()->has('warnmsg'))
                            <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
                        @endif
                        @if(isset($departamentos))
                            <form action="{{ route('admin.cursos.store') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <input class="form-control @error('nombre') border-danger @enderror" type="text" name="nombre" id="nombre" placeholder="Nombre del Curso" value="{{ old('nombre') }}">
                                </div>
                                @error('nombre')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror

                                <div class="input-group mb-3 row mx-auto">
                                    <input class="form-control @error('anio') border-danger @enderror" type="number" name="anio" id="anio" placeholder="Año" value="{{ old('anio') }}">
                                    <input class="form-control @error('semestre') border-danger @enderror" type="number" name="semestre" id="semestre" placeholder="Semestre" value="{{ old('semestre') }}">
                                    <input class="form-control @error('paralelo') border-danger @enderror" type="number" name="paralelo" id="paralelo" placeholder="Paralelo" value="{{ old('paralelo') }}">
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

                                <div class="input-group mb-4 row mx-auto">
                                    <select class="form-control @error('depto') border-danger @enderror" name="departamento" id="departamento">
                                        <option value="" disabled selected>Sigla de Carrera</option>
                                        @foreach($departamentos as $dpto)
                                            <option value="{{$dpto->id}}">{{$dpto->sigla}}</option>
                                        @endforeach
                                    </select>
                                    <input class="form-control @error('codigo') border-danger @enderror" type="number" name="codigo" id="codigo" placeholder="Código Asignatura" value="{{ old('codigo') }}">
                                </div>
                                @error('depto')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                                @error('codigo')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror

                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Crear Curso</button>
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
