@extends('layout.app2')

@section('content')
    <div class="display-4 text-center mb-4">
        <h1>Mis Asignaturas</h1>
    </div>
    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
    @endif
    @if (session()->has('warnmsg'))
        <div class="alert alert-danger text-center">{{ session('warnmsg') }}</div>
    @endif
    @if($asignaturas->count())
        <div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Sigla</th>
                    <th scope="col">Año</th>
                    <th scope="col">Semestre</th>
                    <th scope="col">Paralelo</th>
                    <th scope="col">Departamento</th>
                    <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        <tr>
                            <th scope="row">{{$asignatura->id}}</th>
                            <td>{{$asignatura->nombre}}</td>
                            <td>{{$asignatura->codigo}}</td>
                            <td>{{$asignatura->anio}}</td>
                            <td>{{$asignatura->semestre}}</td>
                            <td>{{$asignatura->paralelo}}</td>
                            <td>{{$asignatura->departamento->nombre}}</td>
                            <td class="text-center"><a href="{{ route('app.asignaturas.show',$asignatura) }}" class="btn btn-primary">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $asignaturas->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center">No se encontraron asignaturas asociadas a su usuario</div>
    @endif
@endsection
