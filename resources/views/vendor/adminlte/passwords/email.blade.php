{{ App\Helpers\AppSession::getSession() }}

@extends('adminlte::master')

@section('adminlte_css')
    @yield('css')

    <style type="text/css">
        .background-page {
            background: #cfcfcf url({{ asset('/img/background/background02.jpg') }});
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .footer-page {
            background-color:rgba(0,0,0,0.5);
            border-top: solid 1px #424242;
            color: #acacac;
            left: 0px;
            right: 0px;
            margin-left: auto;
            margin-right: auto;
            bottom: 0px;
            position: fixed;
            padding-top:15px;
            padding-bottom: 15px;
            padding-left: 7px;
            padding-right: 7px;
            border-top: 1px solid #d2d6de;
            height: 55px;
        }
    </style>
@stop

@section('classes_body', 'login-page background-page')

@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <a href="{{ $dashboard_url }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
                </div>
                <p class="login-box-msg">{{ __('adminlte::adminlte.password_reset_message') }}</p>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ $password_email_url }}" method="post">
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
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        {{ __('adminlte::adminlte.send_password_reset_link') }}
                    </button>
                </form>

                <div class='text-center'>
                    <br>
                    <a href="{{ route('login') }}">Retornar à página de login</a>
                </div>
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
