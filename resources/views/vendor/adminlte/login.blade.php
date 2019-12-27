{{ App\Helpers\AppSession::getSession() }}
@php $background = App\Helpers\AppUnsplash::getPhoto(); @endphp

@extends('adminlte::master')

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
@stack('css')
@yield('css')

<style type="text/css">
    .background-page {
        background: #cfcfcf url({{ $background }});
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }

    .footer-page {
        background-color: rgba(0, 0, 0, 0.5);
        border-top: solid 1px #424242;
        color: #acacac;
        left: 0px;
        right: 0px;
        margin-left: auto;
        margin-right: auto;
        bottom: 0px;
        position: fixed;
        padding-top: 15px;
        padding-bottom: 15px;
        padding-left: 7px;
        padding-right: 7px;
        border-top: 1px solid #d2d6de;
        height: 55px;
    }
</style>
@stop

@section('classes_body', 'background-page login-page ')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
@php( $login_url = $login_url ? route($login_url) : '' )
@php( $register_url = $register_url ? route($register_url) : '' )
@php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
@php( $login_url = $login_url ? url($login_url) : '' )
@php( $register_url = $register_url ? url($register_url) : '' )
@php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <a href="{{ $dashboard_url }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
            </div>
            <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
            <form action="{{ $login_url }}" method="post">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('adminlte::adminlte.password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ __('adminlte::adminlte.sign_in') }}
                        </button>
                    </div>
                </div>
            </form>
            <p class="mt-2 mb-1 text-center">
                <a href="{{ $password_reset_url }}">
                    {{ __('adminlte::adminlte.i_forgot_my_password') }}
                </a>
            </p>
            @if ($register_url && route::has('register'))
            <p class="mb-0">
                <a href="{{ $register_url }}">
                    {{ __('adminlte::adminlte.register_a_new_membership') }}
                </a>
            </p>
            @endif
        </div>
    </div>
</div>

<footer class="footer-page">
    @if(Session::get('footer_left'))
    {!! Session::get('footer_left') !!}
    @else
    <span>
        Copyright © 2019 by <a href="https://github.com/fsclaro/blackbird">
            <span class="text-bold">Black</span>bird</a>.
    </span> Todos os direitos reservados.
    @endif
    <!-- right side -->
    <div class="float-right hidden-xs">
        @if(\Session::get('footer_right'))
        {!! Session::get('footer_right') !!}
        @else
        <b>Versão: </b>1.0.0
        @endif
    </div>
</footer>

@stop

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('js')
@yield('js')
@stop
