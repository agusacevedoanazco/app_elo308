@extends('layout.admin2')

@section('content')
    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
    @endif
    <div class="display-4 text-center">
        <h1>Asignaturas</h1>
    </div>
    <div class="btn-toolbar mb-2">
        <a href="{{ route('admin.asignaturas.create') }}"><button class="btn btn-success">Nueva asignatura</button></a>
    </div>
    @if($asignaturas->count())
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Serie Opencast</th>
                <th scope="col">Año</th>
                <th scope="col">Semestre</th>
                <th scope="col">Paralelo</th>
                <th scope="col">Departamento</th>
                <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-edit"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-trash"></i></div></th>
            </tr>
            </thead>
            @foreach($asignaturas as $asignatura)
                <tbody>
                <th scope="row">{{$asignatura->id}}</th>
                <td>{{$asignatura->nombre}}</td>
                <td>{{$asignatura->oc_series_name}}</td>
                <td>{{$asignatura->anio}}</td>
                <td>{{$asignatura->semestre}}</td>
                <td>{{$asignatura->paralelo}}</td>
                <td>{{$asignatura->departamento->nombre}}</td>
                <td class="text-center"><a href="{{ route('admin.asignaturas.show',$asignatura) }}" class="btn btn-primary">Ver</a></td>
                <td class="text-center"><a href="{{ route('admin.asignaturas.edit',['asignatura'=>$asignatura]) }}" class="btn btn-warning">Editar</a></td>
                <td class="text-center"><form action="{{ route('admin.asignaturas.destroy',$asignatura) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                </tbody>
            @endforeach
        </table>
        {{ $asignaturas->links() }}
    @else
        <div class="alert alert-warning text-center">No se encontraron asignaturas en la base de datos</div>
    @endif
@endsection
