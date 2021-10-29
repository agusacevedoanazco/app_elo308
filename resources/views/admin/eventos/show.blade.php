@extends('layout.admin2')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/videojs.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.eventos.index') }}">Eventos</a></li>
        @isset($evento)
            <li class="breadcrumb-item active" aria-current="page">{{$evento->titulo}}</li>
        @endisset
    </ol>
@endsection

@section('content')
    @isset($curso,$evento,$oc_event)
        <div class="text-center mb-4">
            <h1>{{$evento->titulo}}</h1>
            <h5 class="text-muted">{{$curso->nombre}} - {{$curso->oc_series_name}}</h5>
        </div>
        <div class="card">
            <div class="card-header">
                <!-- card-header-tabs -->
                <nav>
                    <div class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Estado</a>
                        @isset($publicacion)
                            <a class="nav-link" id="nav-video-tab" data-toggle="tab" href="#nav-video" aria-controls="nav-video" aria-selected="false">Video</a>
                            <a href="{{route('admin.eventos.analiticas',$evento->id)}}" class="nav-pills nav-link">Analíticas <i class="fas fa-external-link-alt"></i></a>
                        @endisset
                    </div>
                </nav>

            </div>
            <div class="card-body">
                @if($evento->publicado == false && !isset($publicacion))
                    <div class="alert alert-warning text-center">El evento aún se encuentra en proceso de publicación...</div>
                @endif
                <!-- Nav Content -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card shadow-lg">
                            <div class="card-header text-center bg-secondary text-white">Información Opencast Api</div>
                            <div class="card-body">
                                <pre id="cardbody"></pre>
                            </div>
                            <div class="card-footer text-center bg-secondary text-white">{{$evento->evento_oc}}</div>
                        </div>
                    </div>
                    @isset($publicacion)
                        <div class="tab-pane fade" id="nav-video" role="tabpanel" aria-labelledby="nav-video-tab">
                            <div class="container">
                                <video id="player" class="video-js vjs-default-skin vjs-big-play-centered vjs-show-big-play-button-on-pause">
                                    @if(!is_null($publicacion['360p-quality_url']))<source label="360P" selected="true" src="{{ $publicacion['360p-quality_url'] }}" type="{{ $publicacion->mediatype }}">@endif
                                    @if(!is_null($publicacion['480p-quality_url']))<source label="480P" src="{{ $publicacion['380p-quality_url'] }}" type="{{ $publicacion->mediatype }}">@endif
                                    @if(!is_null($publicacion['720p-quality_url']))<source label="720P" src="{{ $publicacion['720p-quality_url'] }}" type="{{ $publicacion->mediatype }}">@endif
                                    @if(!is_null($publicacion['1080p-quality_url']))<source label="1080P" src="{{ $publicacion['1080p-quality_url'] }}" type="{{ $publicacion->mediatype }}">@endif
                                    @if(!is_null($publicacion['2160p-quality_url']))<source label="2160P" src="{{ $publicacion['2160p-quality_url'] }}" type="{{ $publicacion->mediatype }}">@endif
                                </video>
                            </div>
                        </div>
                    @endisset
                    @isset($analiticas)
                        <div class="tab-pane fade" id="nav-analiticas" role="tabpanel" aria-labelledby="nav-analiticas-tab">

                        </div>
                    @endisset
                </div>
            </div>
        </div>
        <script>
            let data = eval({!! $oc_event !!});
            document.getElementById('cardbody').textContent = JSON.stringify(data,undefined,2);
        </script>
    @else
        <div class="alert alert-danger text-center">No se pudo cargar los contenidos del Evento!</div>
    @endisset
@endsection

@section('scripts')
    <script src="{{ asset('js/videojs.js') }}"></script>
@endsection
