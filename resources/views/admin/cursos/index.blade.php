@extends('layout.admin2')

@section('content')
    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
    @endif
    <div class="display-4 text-center">
        <h1>Cursos</h1>
    </div>
    <div class="btn-toolbar mb-2">
        <a href="{{ route('admin.cursos.create') }}"><button class="btn btn-success">Nuevo Curso</button></a>
    </div>
    @if($cursos->count())
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
            <tbody>
            @foreach($cursos as $curso)
                <tr>
                <th scope="row">{{$curso->id}}</th>
                <td>{{$curso->nombre}}</td>
                <td>{{$curso->oc_series_name}}</td>
                <td>{{$curso->anio}}</td>
                <td>{{$curso->semestre}}</td>
                <td>{{$curso->paralelo}}</td>
                <td>{{$curso->departamento->nombre}}</td>
                <td class="text-center"><a href="{{ route('admin.cursos.show',$curso) }}" class="btn btn-primary">Ver</a></td>
                <td class="text-center"><a href="{{ route('admin.cursos.edit',$curso) }}" class="btn btn-warning">Editar</a></td>
                <td class="text-center"><form action="{{ route('admin.cursos.destroy',$curso) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $cursos->links() }}
    @else
        <div class="alert alert-warning text-center">No se encontraron cursos en la base de datos</div>
    @endif
@endsection
