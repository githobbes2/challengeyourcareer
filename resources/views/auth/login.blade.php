@extends('layouts.app')
@section('content')
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <div class="text-center mb-4">
                <img class="logo_default" src="{{ asset('img/logo.png') }}" alt="Challenge your Career" width="180" height="124" />
            </div>

            <p class="login-box-msg">{{ trans('global.login_title') }}</p>

            @if(session()->has('message'))
                <p class="alert alert-info">
                    {{ session()->get('message') }}
                </p>
            @endif

            @if(session()->has('error'))
                <p class="alert alert-warning">
                    {{ session()->get('error') }}
                </p>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" name="email" value="{{ old('email', null) }}">

                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ trans('global.login_password') }}">

                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">{{ trans('global.remember_me') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                    @if(Route::has('password.request'))
                        <p class="mb-1 mt-3">
                            <a href="{{ route('password.request') }}">
                                {{ trans('global.forgot_password') }}
                            </a>
                        </p>
                    @endif
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 mt-1">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ trans('global.login') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-warning text-center small" role="alert">
                                Importante: Si es tu primera vez ingresando a <em>Challenge your Career</em> y no has definido tu contraseña de acceso aún, <a href="{{ route('password.request') }}">presiona aquí</a> para solicitar un correo con las instrucciones para definir tu contraseña.
                            </div>
                        </div>
                    </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
