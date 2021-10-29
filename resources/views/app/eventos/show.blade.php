@extends('layout.app2')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('css/videojs.css') }}">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('app.homepage')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('app.cursos.index')}}">Mis Cursos</a></li>
        @isset($evento)
            <li class="breadcrumb-item"><a href="{{route('app.cursos.show',$evento->curso->id)}}">{{$evento->curso->nombre}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$evento->titulo}}</li>
        @endisset
    </ol>
@endsection

@section('content')
    @isset($curso,$evento)
        <div class="text-center mb-4">
            <h1>{{$evento->titulo}}</h1>
            <h5 class="text-muted">{{$curso->nombre}} - {{$curso->codigo}} ({{$curso->anio . 'S' . $curso->semestre}})</h5>
        </div>
        @if($evento->publicado == false)
            <div class="alert alert-warning text-center">El evento aún no ha sido publicado, consulte más tarde...</div>
        @endif
        <div class="card">
            <div class="card-header">
                <nav>
                    <div class="nav nav-tabs card-header-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Información</a>
                        @isset($publicacion)
                            <a class="nav-link" id="nav-video-tab" data-toggle="tab" href="#nav-video" aria-controls="nav-video" aria-selected="false">Video</a>
                            @can('modevento')
                                <a class="nav-link" id="nav-share-tab" data-toggle="tab" href="#nav-share" role="tab" aria-controls="nav-share" aria-selected="false">Compartir</a>
                                <a href="{{route('app.eventos.analiticas',$evento->id)}}" class="nav-pills nav-link">Analíticas <i class="fas fa-external-link-alt"></i></a>
                            @endcan
                        @endisset
                    </div>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                        <div class="jumbotron shadow">
                            <h4 class="text-center mb">{{$evento->titulo}}</h4>
                            <h5 class="text-center text-muted">{{$evento->descripcion}}</h5>
                            <h6 class="text-center mb-4">{{$evento->autor}}</h6>
                            <h6 class="text-center text-muted"><b>Fecha de subida: </b>{{$evento->created_at->format('d/m/y')}}</h6>
                            @can('modevento')
                                <h6 class="text-center text-muted mb-4"><b>Última edición: </b>{{$evento->updated_at->format('d/m/y')}}</h6>
                                @if($evento->publicado)
                                    <h6 class="text-center text-success mb-4"><b>Publicado</b></h6>
                                @else
                                    <h6 class="text-center text-secondary"><b>En proceso</b></h6>
                                @endif
                                @if($evento->pendiente)
                                    <h6 class="text-center text-secondary"><b>En cola</b></h6>
                                @endif
                                @if($evento->error)
                                    <h6 class="text-center text-danger"><b>Error!</b></h6>
                                @endif
                            @endcan
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
                        @can('modevento')
                        <div class="tab-pane fade" id="nav-share" role="tabpanel" aria-labelledby="nav-share-tab">
                            <div class="row row-cols-1 row-cols-md-2">
                                @if(!is_null($publicacion['360p-quality_url']))
                                    <div class="col mb-4">
                                        <div class="card h-100">
                                            <div class="card-header bg-secondary text-white text-center">Codigo embebido video 360p</div>
                                            <div class="card-body">
                                                <textarea style="width: 100%" rows="8" id="360p-iframe"></textarea>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button class="btn btn-primary btn-block" onclick="copytoclipboard('360p-iframe')">Copiar al portapapeles</button></div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('360p-iframe').textContent = '<iframe src="{!! $publicacion['360p-quality_url'] !!}" width="640" height="360"></iframe>';
                                    </script>
                                @endif
                                @if(!is_null($publicacion['480p-quality_url']))
                                    <div class="col mb-4">
                                        <div class="card h-100">
                                            <div class="card-header bg-secondary text-white text-center">Codigo embebido video 480p</div>
                                            <div class="card-body">
                                                <textarea style="width: 100%" rows="8" id="480p-iframe"></textarea>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button class="btn btn-primary btn-block" onclick="copytoclipboard('480p-iframe')">Copiar al portapapeles</button></div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('480p-iframe').textContent = '<iframe src="{!! $publicacion['480p-quality_url'] !!}" width="848" height="480"></iframe>';
                                    </script>
                                @endif
                                @if(!is_null($publicacion['720p-quality_url']))
                                    <div class="col mb-4">
                                        <div class="card h-100">
                                            <div class="card-header bg-secondary text-white text-center">Codigo embebido video 720p</div>
                                            <div class="card-body">
                                                <textarea style="width: 100%" rows="8" id="720p-iframe"></textarea>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button class="btn btn-primary btn-block" onclick="copytoclipboard('720p-iframe')">Copiar al portapapeles</button></div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('720p-iframe').textContent = '<iframe src="{!! $publicacion['720p-quality_url'] !!}" width="1280" height="720"></iframe>';
                                    </script>
                                @endif
                                @if(!is_null($publicacion['1080p-quality_url']))
                                    <div class="col mb-4">
                                        <div class="card h-100">
                                            <div class="card-header bg-secondary text-white text-center">Codigo embebido video 1080p</div>
                                            <div class="card-body">
                                                <textarea style="width: 100%" rows="8" id="1080p-iframe"></textarea>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button class="btn btn-primary btn-block" onclick="copytoclipboard('1080p-iframe')">Copiar al portapapeles</button></div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('1080p-iframe').textContent = '<iframe src="{!! $publicacion['2160p-quality_url'] !!}" width="1920" height="1080"></iframe>';
                                    </script>
                                @endif
                                @if(!is_null($publicacion['2160p-quality_url']))
                                    <div class="col mb-4">
                                        <div class="card h-100">
                                            <div class="card-header bg-secondary text-white text-center">Codigo embebido video 2160p</div>
                                            <div class="card-body">
                                                <textarea style="width: 100%" rows="8" id="2160p-iframe"></textarea>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button class="btn btn-primary btn-block" onclick="copytoclipboard('2160p-iframe')">Copiar al portapapeles</button></div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('2160p-iframe').textContent = '<iframe src="{!! $publicacion['2160p-quality_url'] !!}" width="3840" height="2160"></iframe>';
                                    </script>
                                @endif
                            </div>
                        </div>
                        @endcan
                    @endisset
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger text-center">No se pudo cargar el evento!</div>
    @endisset
@endsection

@section('scripts')
    <script>
        function copytoclipboard(id){
            var text = document.getElementById(id);
            text.select();
            document.execCommand('copy');
            alert('Copiado al portapapeles.');
        }
    </script>
    <script src="{{ asset('js/videojs.js') }}"></script>
@endsection
