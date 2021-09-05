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
        <div class="text-center my-4"><h4>Asignaturas del Departamento</h4></div>
        @if($departamento->asignaturas->count())
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
                @foreach($departamento->asignaturas as $asignatura)
                    <th scope="row">{{$asignatura->nombre}}</th>
                    <td>{{$asignatura->oc_series_name}}</td>
                    <td>{{$asignatura->anio}}</td>
                    <td>{{$asignatura->semestre}}</td>
                    <td>{{$asignatura->paralelo}}</td>
                    <td class="text-center"><a href="{{ route('admin.asignaturas.show',$asignatura) }}" class="btn btn-primary">Ver</a></td>
                    <td class="text-center"><a href="{{ route('admin.asignaturas.edit',['asignatura'=>$asignatura]) }}" class="btn btn-warning">Editar</a></td>
                    <td class="text-center"><form action="{{ route('admin.asignaturas.destroy',$asignatura) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-warning text-center">No hay asignaturas asociadas al departamento</div>
        @endif
    @else
        <div class="alert alert-danger text-center">No se pudo cargar el departamento seleccionado</div>
    @endisset
@endsection
