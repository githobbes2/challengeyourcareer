@extends('layouts.app')
@section('content')
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <div class="text-center mb-4">
                <a href="{{ route('admin.home') }}"><img class="logo_default" src="{{ asset('img/logo.png') }}" alt="Challenge your Career" width="180" height="124" /></a>
            </div>

            <p class="login-box-msg">
                {{ trans('global.new_password_instructions') }}
            </p>

            <form method="POST" action="{{ route('password.request') }}">
                @csrf
                <input name="token" value="{{ $token }}" type="hidden">

                <div>
                    <div class="form-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="{{ trans('global.login_email') }}">

                        @if($errors->has('email'))
                            <span class="text-danger">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autofocus placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                            <span class="text-danger">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{ trans('global.login_password_confirmation') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-flat btn-block">
                            {{ trans('global.reset_password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
