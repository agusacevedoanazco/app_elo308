@extends('layout.admin')

@section('content')
    <div class="jumbotron">
        <div class="display-4 text-center">
            <h1>Departamentos</h1>
        </div>
        <div class="btn-toolbar mb-2">
            <a href="{{ route('admin.departamentos.create') }}"><button class="btn btn-primary">Nuevo departamento</button></a>
        </div>
        @if($departamentos->count())
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Carrera</th>
                    <th scope="col">Sigla</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                @foreach($departamentos as $dpt)
                <tbody>
                    <th scope="row">{{$dpt->id}}</th>
                    <td>{{$dpt->nombre}}</td>
                    <td>{{$dpt->carrera}}</td>
                    <td class="font-weight-bold">{{$dpt->sigla}}</td>
                    <td><a href="{{ route('admin.departamentos.edit',['departamento'=>$dpt]) }}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{ route('admin.departamentos.destroy',['departamento'=>$dpt]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tbody>
                @endforeach
            </table>
            {{ $departamentos->links() }}
        @else
            <div class="alert alert-danger text-center">No se encontraron departamentos en la base de datos</div>
        @endif
    </div>
@endsection
