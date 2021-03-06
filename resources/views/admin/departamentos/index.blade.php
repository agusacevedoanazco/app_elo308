@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Departamentos</li>
    </ol>
@endsection

@section('content')
    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
    @endif
    <div class="display-4 text-center">
        <h1>Departamentos</h1>
    </div>
    <div class="btn-toolbar mb-2">
        <a href="{{ route('admin.departamentos.create') }}"><button class="btn btn-success">Nuevo departamento</button></a>
    </div>
    @if($departamentos->count())
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Departamento</th>
                <th scope="col">Sigla</th>
                <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-edit"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-trash"></i></div></th>
            </tr>
            </thead>
            @foreach($departamentos as $dpt)
            <tbody>
                <th scope="row">{{$dpt->id}}</th>
                <td>{{$dpt->nombre}}</td>
                <td class="font-weight-bold">{{$dpt->sigla}}</td>
                <td class="text-center"><a href="{{ route('admin.departamentos.show',$dpt->id) }}" class="btn btn-primary">Ver</a></td>
                <td class="text-center"><a href="{{ route('admin.departamentos.edit',['departamento'=>$dpt]) }}" class="btn btn-warning">Editar</a></td>
                <td class="text-center"><form action="{{ route('admin.departamentos.destroy',['departamento'=>$dpt]) }}" method="post">
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
@endsection
