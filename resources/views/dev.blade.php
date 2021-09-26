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
@endsection

@section('scripts')
    <script src="{{ asset('js/videojs.js') }}"></script>
@endsection
