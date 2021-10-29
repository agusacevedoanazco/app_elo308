@extends('layout.basic')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/videojs.css') }}">
@endsection

@section('body')
    @isset($publicacion)
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <div class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                        <a href="#nav-info" class="nav-link active" data-toggle="tab" aria-controls="nav-info" aria-selected="true">Informacion</a>
                        <a href="#nav-video" class="nav-link" data-toggle="tab" aria-controls="nav-video" aria-selected="false">Video</a>
                        @isset($analiticas)
                            <a href="#nav-analytics" class="nav-link" data-toggle="tab" aria-controls="nav-analytics" aria-selected="false">Analiticas</a>
                        @endisset
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                            <div class="jumbotron">
                                <h1 class="text-center">Informacion</h1>
                                <h2 class="text-center text-muted">{{$publicacion->evento->id}}</h2>
                            </div>
                        </div>
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
                        @isset($analiticas)
                            <div class="tab-pane fade" id="nav-analytics" role="tabpanel" aria-labelledby="nav-analytics-tab">
                                <div class="jumbotron">
                                    <h1>Analiticas {{$publicacion->evento->id}}</h1>
                                    <div class="card-group">
                                        <div class="card">
                                            <pre class="card-body" id="timeseries"></pre>
                                        </div>
                                        <div class="card">
                                            <pre class="card-body" id="totalstats"></pre>
                                        </div>
                                    </div>
                                    <div class="card-group">
                                        <div class="card">
                                            <pre class="card-body" id="position"></pre>
                                        </div>
                                        <div class="card">
                                            <pre class="card-body" id="playpause"></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection

@section('scripts')
    <script src="{{ asset('js/videojs.js') }}"></script>
    <script>
        //document.getElementById('timeseries').textContent = JSON.stringify(eval({!! $timeseries !!}),undefined,2);
        //document.getElementById('totalstats').textContent = JSON.stringify(eval({!! $totalstats !!}),undefined,2);
        document.getElementById('position').textContent = JSON.stringify(eval({!! $bounce !!}),undefined,2);
    </script>
@endsection
