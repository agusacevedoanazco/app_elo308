@extends('layout.admin2')

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
                            <a class="nav-link" id="nav-360p-tab" data-toggle="tab" href="#nav-360p" role="tab" aria-controls="nav-360p" aria-selected="false">Video 360p</a>
                            @if(!is_null($publicacion['480p-quality_url']))
                            <a class="nav-link" id="nav-480p-tab" data-toggle="tab" href="#nav-480p" role="tab" aria-controls="nav-480p" aria-selected="false">Video 480p</a>
                            @endif
                            <a class="nav-link" id="nav-720p-tab" data-toggle="tab" href="#nav-720p" role="tab" aria-controls="nav-720p" aria-selected="false">Video 720p</a>
                            @if(!is_null($publicacion['1080p-quality_url']))
                            <a class="nav-link" id="nav-1080p-tab" data-toggle="tab" href="#nav-1080p" role="tab" aria-controls="nav-1080p" aria-selected="false">Video 1080p</a>
                            @endif
                            @if(!is_null($publicacion['2160p-quality_url']))
                            <a class="nav-link" id="nav-2160p-tab" data-toggle="tab" href="#nav-2160p" role="tab" aria-controls="nav-2160p" aria-selected="false">Video 2160p</a>
                            @endif
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
                        <div class="tab-pane fade" id="nav-360p" role="tabpanel" aria-labelledby="nav-360p-tab">
                            <div class="text-center">
                                <video controls src="{{$publicacion['360p-quality_url']}}" type="{{$publicacion['mediatype']}}"></video>
                            </div>
                        </div>
                        @if(!is_null($publicacion['480p-quality_url']))
                            <div class="tab-pane fade" id="nav-480p" role="tabpanel" aria-labelledby="nav-480p-tab">
                                <div class="text-center">
                                    <video controls src="{{$publicacion['480p-quality_url']}}" type="{{$publicacion['mediatype']}}"></video>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane fade" id="nav-720p" role="tabpanel" aria-labelledby="nav-720p-tab">
                            <div class="text-center">
                                <video controls src="{{$publicacion['720p-quality_url']}}" type="{{$publicacion['mediatype']}}"></video>
                            </div>
                        </div>
                        @if(!is_null($publicacion['1080p-quality_url']))
                            <div class="tab-pane fade" id="nav-1080p" role="tabpanel" aria-labelledby="nav-1080p-tab">
                                <div class="text-center">
                                    <video controls src="{{$publicacion['1080p-quality_url']}}" type="{{$publicacion['mediatype']}}"></video>
                                </div>
                            </div>
                        @endif
                        @if(!is_null($publicacion['2160p-quality_url']))
                            <div class="tab-pane fade" id="nav-2160p" role="tabpanel" aria-labelledby="nav-2160p-tab">
                                <div class="text-center">
                                    <video controls src="{{$publicacion['2160p-quality_url']}}" type="{{$publicacion['mediatype']}}"></video>
                                </div>
                            </div>
                        @endif
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
