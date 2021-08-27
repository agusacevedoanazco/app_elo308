@extends('layout.admin2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card m-2 text-center">
                    <h6 class="mt-2 mb-4">Total de Usuarios</h6>
                    <h4 class="mb-2"><i class="fa fa-user mr-4"></i>{{ $total_usuarios }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center m-2">
                    <h6 class="mt-2 mb-4">Total de Departamentos</h6>
                    <h4 class="mb-2"><i class="fa fa-building mr-4"></i>{{ $total_departamentos }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center m-2">
                    <h6 class="mt-2 mb-4">Total de Asignaturas</h6>
                    <h4 class="mb-2"><i class="fa fa-graduation-cap mr-4"></i>{{ $total_asignaturas }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center m-2">
                    <h6 class="mt-2 mb-4">Total de Eventos</h6>
                    <h4 class="mb-2"><i class="fab fa-elementor mr-4"></i>{{ $total_eventos }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
