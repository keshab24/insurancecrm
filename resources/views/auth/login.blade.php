@extends('layouts.app')

@section('title')
    <title>Login | {{ env('APP_NAME') }}</title>
@endsection
<style>
    button.close.close-sm {
        display: none;
    }
    .forgot-paswd{
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
            @include('layouts.backend.alert')
            <form id="sign_in" action="{{ route('auth.login') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback mb-2">
                    <label for="phone_number">Phone Number</label>
                    <input type="phone_number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number"
                           value="{!! old('phone_number') !!}" required autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback mb-2">
                    <label for="password">Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Password">
                        <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox pad-btm text-left">
                        <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember">
                        <label for="demo-form-checkbox" class="text-sm">
                            Remember Me
                        </label>
                        <a class="forgot-paswd" href="{{route('password.request')}}">Forgot Password?</a>
                    </div>
                </div>

                <div class="row login--btn">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </form>
            <div class="forgot--password pt-2 text-center">
                <span style="color:#000000;">Need an account <a href="/register">Register</a></span>
            </div>
            <div class="back--home">
                <a href="/">Back to home</a>
            </div>
        </div>
    </section>
    <!-- </div> -->
@endsection
@section('script')
    <script>
        /** toggle password visibility */
        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-close').toggleClass(
                'glyphicon-eye-open'); // toggle our classes for the eye icon
            $('#password').togglePassword(); // activate the hideShowPassword plugin
        });
    </script>
@endsection
