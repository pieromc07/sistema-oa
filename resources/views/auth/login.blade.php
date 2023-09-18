@extends('layouts.auth')

@section('title', 'Iniciar Sesión')
@section('auth')
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand ">
                <a href="/" class="app-brand-link w-100 d-flex flex-column gap-3">
                    <span class="app-brand-logo">
                        <img src="{{ asset('assets/img/favicon/icon.png') }}" alt="Logo" class="img-fluid" style="width: 3.5rem">
                    </span>
                    <span class="app-brand-text text-body fw-bolder text-uppercase fs-5 d-block">
                        {{ config('app.name') }}
                    </span>
                </a>
            </div>
            <!-- /Logo -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="usu_nombre" class="form-label">{{ __('Username') }}</label>

                    <input id="usu_nombre" type="text" class="form-control @error('usu_nombre') is-invalid @enderror"
                        name="usu_nombre"  autocomplete="name" autofocus
                        placeholder="Nombre de Usuario" value="ADMIN">
                        {{-- value="{{ old('name') }}" --}}
                    @error('usu_nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="usu_contraseña" class="form-label">{{ __('Password') }}</label>
                    <input id="usu_contraseña" type="password" class="form-control @error('usu_contraseña') is-invalid @enderror"
                        name="usu_contraseña" autocomplete="current-password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" value="password">
                    @error('usu_contraseña')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
