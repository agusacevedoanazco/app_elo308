@extends('layout.admin2')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Crear un nuevo departamento</h1>
                            <p class="text-muted">Agrega un nuevo departamento al sistema</p>
                            @if (session()->has('okmsg'))
                                <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                            @endif
                            @if (session()->has('errormsg'))
                                <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
                            @endif
                            <form action="{{ route('admin.departamentos.store') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <input class="form-control @error('nombre') border-danger @enderror" type="text" name="nombre" id="name" placeholder="Departamento" value="{{ old('nombre') }}">
                                </div>
                                @error('nombre')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="input-group mb-3">
                                    <input class="form-control @error('sigla') border-danger @enderror" type="text" name="sigla" id="sigla" placeholder="Sigla (Ejemplo: ELO)" value="{{ old('sigla') }}">
                                </div>
                                @error('sigla')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Crear Departamento</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
