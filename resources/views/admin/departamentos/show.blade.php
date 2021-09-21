@extends('layout.admin2')

@section('content')
    @isset($departamento)
        @if (session()->has('okmsg'))
            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
        @endif
        @if (session()->has('errmsg'))
            <div class="alert alert-danger text-center">{{ session('errmsg') }}</div>
        @endif
        <div class="text-center display-4"><h1>{{$departamento->nombre}}</h1></div>
        <div class="text-center my-4"><h4>Cursos del Departamento</h4></div>
        @if($departamento->cursos->count())
        <table class="table">
            <thead class="thead-dark">
                <th scope="col">Nombre</th>
                <th scope="col">Serie Opencast</th>
                <th scope="col">Año</th>
                <th scope="col">Semestre</th>
                <th scope="col">Paralelo</th>
                <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-edit"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-trash"></i></div></th>
            </thead>
            <tbody>
                @foreach($departamento->cursos as $curso)
                    <tr>
                    <th scope="row">{{$curso->nombre}}</th>
                    <td>{{$curso->oc_series_name}}</td>
                    <td>{{$curso->anio}}</td>
                    <td>{{$curso->semestre}}</td>
                    <td>{{$curso->paralelo}}</td>
                    <td class="text-center"><a href="{{ route('admin.cursos.show',$curso) }}" class="btn btn-primary">Ver</a></td>
                    <td class="text-center"><a href="{{ route('admin.cursos.edit',['curso'=>$curso]) }}" class="btn btn-warning">Editar</a></td>
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
        @else
            <div class="alert alert-warning text-center">No hay cursos asociadas al departamento</div>
        @endif
    @else
        <div class="alert alert-danger text-center">No se pudo cargar el departamento seleccionado</div>
    @endisset
@endsection
