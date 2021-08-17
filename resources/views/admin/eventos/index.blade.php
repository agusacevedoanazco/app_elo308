@extends('layout.admin')

@section('content')
    <div class="jumbotron">
        @if (session()->has('okmsg'))
            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
        @endif
        @if (session()->has('errormsg'))
            <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
        @endif
        <div class="display-4 text-center">
            <h1>Eventos</h1>
        </div>
        <div class="btn-toolbar mb-2">
            <a href="{{ route('admin.eventos.create') }}"><button class="btn btn-primary">Nuevo evento</button></a>
        </div>
        @if($eventos->count())
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Opencast uid</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Procesado</th>
                    <th scope="col">Errores</th>
                    <th scope="col">Errores</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                @foreach($eventos as $evento)
                    <tbody>
                    <th scope="row">{{$evento->id}}</th>
                    @isset($evento->evento_oc)
                        <td>{{$evento->evento_oc}}</td>
                    @else
                        <td class="text-center"></td>
                    @endisset
                    <td>{{$evento->titulo}}</td>
                    <td>{{$evento->asignatura->oc_series_name}}</td>
                    @if($evento->pendiente)
                        <td class="text-center"><i class="far fa-hourglass"></i></td>
                    @else
                        <td class="text-center"><i class="far fa-check-circle"></i></td>
                    @endif
                    @if($evento->error)
                        <td class="text-center"><i class="far fa-exclamation-triangle"></i></td>
                    @else
                        <td class="text-center"><i class="far fa-check-circle"></i></td>
                    @endif
                    <td><a href="{{ route('admin.eventos.edit',$evento->id) }}" class="btn btn-warning">Editar</a></td>
                    <td><form action="{{ route('admin.eventos.destroy',$evento->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                    </tbody>
                @endforeach
            </table>
            {{ $eventos->links() }}
        @else
            <div class="alert alert-warning text-center">No se encontraron eventos en la base de datos.</div>
        @endif
    </div>
@endsection
