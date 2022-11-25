@extends('layouts.app')
@section('content')
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <div class="text-center mb-4">
                <a href="{{ route('admin.home') }}"><img class="logo_default" src="{{ asset('img/logo.png') }}" alt="Challenge your Career" width="180" height="124" /></a>
            </div>

            <p>
                {{ trans('global.reset_password_instructions') }}
            </p>

            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <div class="form-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email') }}">

                        @if($errors->has('email'))
                            <span class="text-danger">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ trans('global.send_password') }}
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3">Si tienes alguna duda, puedes contactarnos por correo electrónico a: <a href="mailto:{{ env('APP_CONTACT') }}">{{ env('APP_CONTACT') }}</a>.</p>

            <div class="text-center">
                <a class="btn btn-primary ml-2" href="/login">{{ trans('global.login_title') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
