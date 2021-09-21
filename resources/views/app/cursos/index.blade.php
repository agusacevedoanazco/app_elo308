@extends('layout.app2')

@section('content')
    <div class="display-4 text-center mb-4">
        <h1>Mis Cursos</h1>
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
    @if($cursos->count())
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
                    @foreach($cursos as $curso)
                        <tr>
                            <th scope="row">{{$curso->id}}</th>
                            <td>{{$curso->nombre}}</td>
                            <td>{{$curso->codigo}}</td>
                            <td>{{$curso->anio}}</td>
                            <td>{{$curso->semestre}}</td>
                            <td>{{$curso->paralelo}}</td>
                            <td>{{$curso->departamento->nombre}}</td>
                            <td class="text-center"><a href="{{ route('app.cursos.show',$curso) }}" class="btn btn-primary">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $cursos->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center">No se encontraron cursos asociados a su usuario</div>
    @endif
@endsection
