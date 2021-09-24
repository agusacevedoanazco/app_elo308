@extends('layout.admin2')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Eventos</li>
    </ol>
@endsection

@section('content')
    <div class="display-4 text-center">
        <h1>Eventos</h1>
    </div>

    @if (session()->has('okmsg'))
        <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
    @endif
    @if (session()->has('errormsg'))
        <div class="alert alert-danger text-center">{{ session('errormsg') }}</div>
    @endif
    @if (session()->has('warnmsg'))
        <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
    @endif

    <div class="btn-toolbar mb-2">
        <a href="{{ route('admin.eventos.create') }}"><button class="btn btn-success">Nuevo evento</button></a>
    </div>
    @if($eventos->count())
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Opencast uid</th>
                <th scope="col">Titulo</th>
                <th scope="col">Curso</th>
                <th scope="col"><div class="text-center">Publicado</div></th>
                <th scope="col"><div class="text-center">Enviado</div></th>
                <th scope="col"><div class="text-center"><i class="fas fa-eye"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-edit"></i></div></th>
                <th scope="col"><div class="text-center"><i class="fa fa-trash"></i></div></th>
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
                <td>{{$evento->curso->oc_series_name}}</td>
                @if($evento->error)
                    <td class="text-center text-danger"><i class="fas fa-exclamation-triangle"></i></td>
                    <td class="text-center text-danger"><i class="fas fa-exclamation-triangle"></i></td>
                @else
                    @if($evento->publicado)
                        <td class="text-center text-success"><i class="far fa-check-circle"></i></td>
                    @else
                        <td class="text-center text-primary"><i class="far fa-hourglass"></i></td>
                    @endif
                    @if($evento->pendiente)
                        <td class="text-center text-primary"><i class="far fa-hourglass"></i></td>
                    @else
                        <td class="text-center text-success"><i class="far fa-check-circle"></i></td>
                    @endif
                @endif
                <td class="text-center"><a href="{{ route('admin.eventos.show',$evento->id) }}" class="btn btn-primary">Ver</a></td>
                <td class="text-center"><a href="{{ route('admin.eventos.edit',$evento->id) }}" class="btn btn-warning">Editar</a></td>
                <td class="text-center"><form action="{{ route('admin.eventos.destroy',$evento->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form></td>
                </tbody>
            @endforeach
        </table>
        {{ $eventos->links() }}
    @else
        <div class="alert alert-warning text-center">No se encontraron eventos en la base de datos.</div>
    @endif
@endsection
