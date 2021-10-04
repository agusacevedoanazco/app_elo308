@extends('layout.basic')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/videojs.css') }}">
@endsection

@section('body')
    <div class="container">
        @isset($publicacion)
            <video id="player" class="video-js vjs-default-skin vjs-big-play-centered vjs-show-big-play-button-on-pause">
                <source label="360P" selected="true" src="{{ $publicacion['360p-quality_url'] }}" type="{{ $publicacion->mediatype }}">
                <source label="720P" src="{{ $publicacion['720p-quality_url'] }}" type="{{ $publicacion->mediatype }}">
            </video>
        @else
        @endisset
    </div>
    <!-- en proceso -->
    <div class="card text-center">
        <div class="card-header">
            <nav>
                <div class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Información</a>
                    @isset($publicacion)
                        <a class="nav-link" id="nav-video-tab" data-toggle="tab" href="#nav-video" aria-controls="nav-video" aria-selected="false">Video</a>
                        @can('modevento')
                            <a class="nav-link" id="nav-share-tab" data-toggle="tab" href="#nav-share" role="tab" aria-controls="nav-share" aria-selected="false">Compartir</a>
                        @endcan
                    @endisset
                </div>
            </nav>
        </div>
        <div class="card-body">
            <div class="tab-content">

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/videojs.js') }}"></script>
@endsection
