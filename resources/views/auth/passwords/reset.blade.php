@extends('layouts.app')
@section('title')
    <title>Reset Password | {{ env('APP_NAME') }}</title>
@endsection
<style>
    button.close.close-sm {
        display: none;
    }

    .forgot-paswd {
        float: right;
        margin-top: 2px;
        color: #558EFF;
        font-size: 14px;
        font-weight: 500;
    }
</style>
@section('content')
    <section class="card form--wrapper" style="width: 26rem;">
        <a class="text-center" href="/">
            <img class="card-img-top text-center" src="{{ asset('frontend/img/logo.png') }}" alt="">
        </a>
        <div class="col-sm">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback">
                    <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                           autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group has-feedback">
                    <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                    <div class="input-group" id="show_hide_password">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password">
                        <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <label for="password-confirm"
                           class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                    <div class="input-group" id="show_hide_password">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required autocomplete="new-password">
                        <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Reset Password') }}
                    </button>
            </form>
            <div class="forgot--password pt-2 text-center">
                <span style="color:#000000;">Back To Login <a href="/admin">Login</a></span>
            </div>
            <div class="back--home">
                <a href="/">Back to home</a>
            </div>
        </div>
    </section>
@endsection
