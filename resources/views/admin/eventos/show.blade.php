@extends('layout.admin2')

@section('content')
    @isset($asignatura,$evento,$oc_event)
        <div class="text-center mb-4">
            <h1>{{$evento->titulo}}</h1>
            <h5 class="text-muted">{{$asignatura->nombre}} - {{$asignatura->oc_series_name}}</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <!-- card nav evento -->
                    <li class="nav-item"><a href="{{route('admin.eventos.show',$evento)}}" class="nav-link active">Estado</a></li>
                    <!-- li class="nav-item"><a href="#" class="nav-link">Publicación</a></li> -->
                </ul>
            </div>
            <div class="card-body">
                @if($evento->publicado == false)
                    <div class="alert alert-warning text-center">El evento aún no se encuentra publicado.</div>
                @endif
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-secondary text-white">Información Opencast Api</div>
                    <div class="card-body">
                        <pre id="cardbody"></pre>
                    </div>
                    <div class="card-footer text-center bg-secondary text-white">{{$evento->evento_oc}}</div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">No se pudo cargar la asignatura!</div>
    @endisset
@endsection

@section('scripts')
    <script>
        let data = eval({!! $oc_event !!});
        document.getElementById('cardbody').textContent = JSON.stringify(data,undefined,2);
    </script>
@endsection
