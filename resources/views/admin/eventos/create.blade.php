@extends('layout.admin')

@section('filepondcss')
    <link rel="stylesheet" href="https://unpkg.com/filepond@^4/dist/filepond.css">
@endsection


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Crear un Evento</h1>
                        <p class="text-muted">Crea un nuevo evento, subiendo un video en espera a ser procesado</p>
                        @if (session()->has('okmsg'))
                            <div class="alert alert-success text-center">{{ session('okmsg') }}</div>
                        @endif
                        @if (session()->has('errmsg'))
                            <div class="alert alert-danger text-center">{{ session('errmsg') }}</div>
                        @endif
                        @if (session()->has('warnmsg'))
                            <div class="alert alert-warning text-center">{{ session('warnmsg') }}</div>
                        @endif
                        <form action="{{ route('admin.eventos.store') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control @error('titulo') border-danger @enderror" type="text" name="titulo" id="titulo" placeholder="Título del evento">
                            </div>
                            @error('titulo')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror

                            <div class="input-group mb-3">
                                <input class="form-control @error('descripcion') border-danger @enderror" type="text" name="descripcion" id="descripcion" placeholder="Descripción del evento">
                            </div>
                            @error('descripcion')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror

                            <div class="input-group mb-3">
                                <select class="form-control" name="asignatura" id="asignatura">
                                    <option value="{{ null }}" selected>Seleccione la asignatura</option>
                                    @isset($asignaturas)
                                        @foreach($asignaturas as $asignatura)
                                            <option value="{{ $asignatura->id }}">{{$asignatura->oc_series_name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            @error('asignatura')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror

                            <div class="mx-auto">
                                <input type="file" name="evento_video" id="evento_video">
                            </div>
                            @error('evento_video')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror

                            <div class="col-6">
                                <div class="row">
                                    <button class="btn btn-primary px-4" type="submit">Crear Evento</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('filepondjs')
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('#evento_video');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            acceptedFileTypes : ['video/mp4','video/mpeg','video/webm','video/quicktime','video/x-msvideo','video/x-flv','video/x-matroska'],
            required : true,
            maxFiles : 1,
            server : {
                url : '{{route('admin.filepond')}}',
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}',
                }
            }
        });
    </script>
@endsection
