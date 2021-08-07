@extends('layout.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Iniciar sesión</h1>
                            <p class="text-muted">Inicia sesión en tu cuenta</p>
                            @if (session()->has('status'))
                                <div class="alert alert-danger text-center">{{ session('status') }}</div>
                            @endif
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="input-group mb-3">
                                    <input class="form-control @error('email') border-danger @enderror" type="email" name="email" id="email" placeholder="Correo Electrónico" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <div class="text-danger text-muted"><p>{{ $message }}</p></div>
                                @enderror
                                <div class="input-group mb-4">
                                    <input class="form-control @error('password') border-danger @enderror" type="password" placeholder="Contraseña" name="password" id="password" required>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <button class="btn btn-primary px-4" type="submit">Iniciar Sesión</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
