@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.departamentos.index') }}">Departamentos</a></li>
        @isset($departamento)
            <li class="breadcrumb-item"><a href="{{ route('admin.departamentos.show',$departamento->id) }}">{{$departamento->nombre}}</a></li>
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
                        <h1>Editar Departamento</h1>
                        <p class="text-muted">Edita los campos del departamento seleccionado</p>
                        @if (session()->has('okmsg'))
                            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                        @endif
                        @if (session()->has('errormsg'))
                            <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
                        @endif
                        @if(isset($departamento))
                            <form action="{{ route('admin.departamentos.update', $departamento) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="input-group mb-3">
                                    <input class="form-control @error('nombre') border-danger @enderror" type="text" name="nombre" id="name" placeholder="Departamento" value="{{ $departamento->nombre }}">
                                </div>
                                @error('nombre')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Actualizar Departamento</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-danger text-center">Error! Departamento no encontrado</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
